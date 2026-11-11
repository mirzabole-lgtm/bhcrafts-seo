<?php
namespace BHcrafts\SEO\WorkBridge;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const INDEXABLE_REPAIR_ACTION = 'bhcrafts_seo_yoast_indexable_repair';

/** This fixed SELECT avoids Yoast lookup methods that can upgrade or build rows. */
function read_indexable_rows(): ?array {
    global $wpdb;
    $query = $wpdb->prepare(
        'SELECT id, object_sub_type, permalink, permalink_hash, title, description FROM %i WHERE object_id = %d AND object_type = %s ORDER BY id LIMIT 3',
        $wpdb->prefix . 'yoast_indexable', PRODUCT_ID, 'post'
    );
    $previous_suppression = $wpdb->suppress_errors( true );
    try {
        $rows = $wpdb->get_results( $query, ARRAY_A );
        return $wpdb->last_error === '' && is_array( $rows ) ? $rows : null;
    } finally {
        $wpdb->suppress_errors( $previous_suppression );
    }
}

function indexable_repair_proposal( array $proposal ): array {
    $permalink = $proposal['site'] . 'product/' . $proposal['product_slug'] . '/';
    return array(
        'id' => 'bhcrafts-stg-2839-yoast-indexable-repair-v0.1',
        'site' => $proposal['site'],
        'product_id' => PRODUCT_ID,
        'yoast_version' => $proposal['yoast_version'],
        'permalink' => $permalink,
        'before' => array( 'permalink_hash' => '63:db0d112a7674b4ec88ad6862008d062a', 'title' => null, 'description' => null ),
        'after' => array(
            'permalink_hash' => strlen( $permalink ) . ':' . md5( $permalink ),
            'title' => $proposal['before']['_yoast_wpseo_title'],
            'description' => $proposal['before']['_yoast_wpseo_metadesc'],
        ),
    );
}

function indexable_repair_hash( array $repair ): string {
    $encoded = wp_json_encode( $repair, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    if ( ! is_string( $encoded ) ) {
        stop_test( 'The indexable proposal could not be encoded.' );
    }
    return hash( 'sha256', $encoded );
}

function indexable_repair_nonce( string $operation, string $hash ): string {
    return INDEXABLE_REPAIR_ACTION . ':' . $operation . ':' . $hash;
}

function check_indexable_baseline( array $repair, array $expected, ?array $rows ): bool {
    return is_array( $rows ) && count( $rows ) === 1 && (int) $rows[0]['id'] > 0
        && $rows[0]['object_sub_type'] === 'product' && $rows[0]['permalink'] === $repair['permalink']
        && get_permalink( PRODUCT_ID ) === $repair['permalink']
        && array_intersect_key( $rows[0], $expected ) === $expected
        && get_post_meta( PRODUCT_ID, '_yoast_wpseo_title', false ) === array( $repair['after']['title'] )
        && get_post_meta( PRODUCT_ID, '_yoast_wpseo_metadesc', false ) === array( $repair['after']['description'] );
}

function render_indexable_repair( array $proposal ): void {
    $repair = indexable_repair_proposal( $proposal );
    $hash = indexable_repair_hash( $repair );
    $rows = read_indexable_rows();
    echo '<h2>Staging indexable repair</h2><p>Product 2839. Review the three changes to the existing Yoast indexable.</p>';
    echo '<p>Proposal <code>' . esc_html( $repair['id'] ) . '</code> · SHA-256 <code>' . esc_html( $hash ) . '</code></p>';
    foreach ( array( 'repair' => 'Approve and repair staging indexable', 'restore' => 'Approve and restore original indexable' ) as $operation => $label ) {
        $from = $repair[$operation === 'repair' ? 'before' : 'after'];
        $to = $repair[$operation === 'repair' ? 'after' : 'before'];
        echo '<h3>' . esc_html( $label ) . '</h3>';
        echo '<table class="widefat striped"><thead><tr><th>Field</th><th>Expected current value</th><th>Proposed value</th></tr></thead><tbody>';
        foreach ( array( 'permalink_hash' => 'Permalink hash', 'title' => 'SEO title', 'description' => 'Meta description' ) as $field => $name ) {
            echo '<tr><th scope="row">' . esc_html( $name ) . '</th><td>' . esc_html( $from[$field] ?? 'NULL' ) . '</td><td>' . esc_html( $to[$field] ?? 'NULL' ) . '</td></tr>';
        }
        echo '</tbody></table>';
        if ( ! check_indexable_baseline( $repair, $from, $rows ) ) {
            echo '<p>Unavailable for the current baseline. Download the read-only indexable report to review the saved values.</p>';
            continue;
        }
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
        echo '<input type="hidden" name="action" value="' . esc_attr( INDEXABLE_REPAIR_ACTION ) . '">';
        echo '<input type="hidden" name="operation" value="' . esc_attr( $operation ) . '">';
        wp_nonce_field( indexable_repair_nonce( $operation, $hash ) );
        echo '<p><label>Verified Kinsta staging backup reference <input type="text" name="backup_reference" maxlength="120" required></label></p>';
        echo '<p><label><input type="checkbox" name="staging_checked" value="yes" required> I verified the staging backup and outbound integration isolation.</label></p>';
        submit_button( $label );
        echo '</form>';
    }
    echo '<hr>';
}

/** Only the three derived columns are assigned. The joins freeze the source rows and exclude conflicts. */
function update_indexable_row( int $id, array $repair, array $from, array $to ) {
    global $wpdb;
    $table = $wpdb->prefix . 'yoast_indexable';
    $query = $wpdb->prepare(
        "UPDATE %i AS target
         INNER JOIN %i AS source_title ON source_title.post_id = target.object_id AND source_title.meta_key = '_yoast_wpseo_title'
             AND CAST(source_title.meta_value AS BINARY) = CAST(%s AS BINARY)
         INNER JOIN %i AS source_description ON source_description.post_id = target.object_id AND source_description.meta_key = '_yoast_wpseo_metadesc'
             AND CAST(source_description.meta_value AS BINARY) = CAST(%s AS BINARY)
         LEFT JOIN %i AS extra_source ON extra_source.post_id = target.object_id
             AND ((extra_source.meta_key = source_title.meta_key AND extra_source.meta_id <> source_title.meta_id)
               OR (extra_source.meta_key = source_description.meta_key AND extra_source.meta_id <> source_description.meta_id))
         LEFT JOIN %i AS other_row ON other_row.object_id = target.object_id AND other_row.object_type = 'post' AND other_row.id <> target.id
         LEFT JOIN %i AS url_row ON url_row.permalink_hash = %s AND url_row.permalink = %s AND url_row.id <> target.id
         SET target.permalink_hash = %s, target.title = NULLIF(%s, ''), target.description = NULLIF(%s, '')
         WHERE target.id = %d AND target.object_id = %d AND target.object_type = 'post' AND target.object_sub_type = 'product'
           AND CAST(target.permalink AS BINARY) = CAST(%s AS BINARY)
           AND CAST(target.permalink_hash AS BINARY) = CAST(%s AS BINARY)
           AND CAST(target.title AS BINARY) <=> CAST(NULLIF(%s, '') AS BINARY)
           AND CAST(target.description AS BINARY) <=> CAST(NULLIF(%s, '') AS BINARY)
           AND extra_source.meta_id IS NULL AND other_row.id IS NULL AND url_row.id IS NULL",
        $table, $wpdb->postmeta, $repair['after']['title'], $wpdb->postmeta, $repair['after']['description'], $wpdb->postmeta,
        $table, $table, $to['permalink_hash'], $repair['permalink'], $to['permalink_hash'], $to['title'] ?? '', $to['description'] ?? '',
        $id, PRODUCT_ID, $repair['permalink'], $from['permalink_hash'], $from['title'] ?? '', $from['description'] ?? ''
    );
    $previous_suppression = $wpdb->suppress_errors( true );
    try {
        return $wpdb->query( $query );
    } finally {
        $wpdb->suppress_errors( $previous_suppression );
    }
}

function submit_indexable_repair(): void {
    $proposal = proposal();
    assert_staging( $proposal );
    if ( ( $_SERVER['REQUEST_METHOD'] ?? '' ) !== 'POST' ) {
        stop_test( 'Submit the staging indexable repair form.', 405 );
    }
    $fields = array( 'action', 'operation', '_wpnonce', '_wp_http_referer', 'backup_reference', 'staging_checked', 'submit' );
    if ( ! empty( $_GET ) || array_diff( array_keys( $_POST ), $fields ) || count( array_filter( $_POST, 'is_string' ) ) !== count( $_POST ) ) {
        stop_test( 'Unexpected form input. The indexable proposal is fixed.', 400 );
    }
    $operation = $_POST['operation'] ?? '';
    $backup = trim( wp_unslash( $_POST['backup_reference'] ?? '' ) );
    if ( ( $_POST['action'] ?? '' ) !== INDEXABLE_REPAIR_ACTION || ! in_array( $operation, array( 'repair', 'restore' ), true )
        || ( $_POST['staging_checked'] ?? '' ) !== 'yes' || ! preg_match( '/\A[A-Za-z0-9][A-Za-z0-9 .:_-]{0,119}\z/', $backup ) ) {
        stop_test( 'Confirm staging isolation and enter the verified backup reference.', 400 );
    }
    $repair = indexable_repair_proposal( $proposal );
    $hash = indexable_repair_hash( $repair );
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', indexable_repair_nonce( $operation, $hash ) ) ) {
        stop_test( 'Refresh the preview and approve the exact indexable proposal again.', 403 );
    }
    $from = $repair[$operation === 'repair' ? 'before' : 'after'];
    $to = $repair[$operation === 'repair' ? 'after' : 'before'];
    $rows = read_indexable_rows();
    if ( ! check_indexable_baseline( $repair, $from, $rows ) ) {
        stop_test( 'The indexable or saved source fields differ from the reviewed baseline. No write was attempted.' );
    }

    $approved_at = gmdate( 'c' );
    $id = (int) $rows[0]['id'];
    $changed = update_indexable_row( $id, $repair, $from, $to );
    $readback = read_indexable_rows();
    $verified = $changed === 1 && check_indexable_baseline( $repair, $to, $readback ) && (int) $readback[0]['id'] === $id;

    nocache_headers();
    header( 'Content-Disposition: attachment; filename="BHcrafts_Yoast_Indexable_2839_' . $operation . '_receipt.json"' );
    wp_send_json( array(
        'proposal_id' => $repair['id'], 'proposal_sha256' => $hash, 'site' => $repair['site'], 'product_id' => PRODUCT_ID,
        'operation' => $operation, 'approved_by_user_id' => get_current_user_id(), 'approved_at_utc' => $approved_at,
        'administrator_attested_backup_reference' => $backup, 'administrator_attested_outbound_isolation' => true,
        'indexable_row_id' => $id, 'before' => $from, 'proposed' => $to, 'affected_rows' => $changed,
        'readback' => $readback, 'status' => $verified ? 'verified' : 'review_required',
    ), $verified ? 200 : 409, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

add_action( 'admin_post_' . INDEXABLE_REPAIR_ACTION, __NAMESPACE__ . '\\submit_indexable_repair' );
