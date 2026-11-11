<?php
namespace BHcrafts\SEO\WorkBridge;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const TITLE_DESCRIPTION_ACTION = 'bhcrafts_seo_yoast_title_description_test';

function title_description_proposal( array $proposal ): array {
    $repaired = indexable_repair_proposal( $proposal );
    return array(
        'id' => 'bhcrafts-stg-2839-yoast-title-description-test-v0.1',
        'site' => $proposal['site'],
        'product_id' => PRODUCT_ID,
        'yoast_version' => $proposal['yoast_version'],
        'permalink' => $repaired['permalink'],
        'source_snapshot_sha256' => '72e441277b1b398a2096afd5cc8b16623215ca5bd4ca592526a3ef0bdd6b978c',
        'before' => $repaired['after'],
        'after' => array(
            'permalink_hash' => $repaired['after']['permalink_hash'],
            'title' => 'Knitted Cotton Handbag with Three Doll Appliqués | BHcrafts',
            'description' => 'This knitted cotton handbag has three doll appliqués and striped handles. Handmade by BHcrafts women artisans and available in black or green.',
        ),
    );
}

function render_title_description_test( array $proposal, ?array $rows ): void {
    $test = title_description_proposal( $proposal );
    $hash = staging_proposal_hash( $test );
    echo '<h2>Staging SEO title and description test</h2>';
    echo '<p>Product 2839. The two values below apply to both the saved Yoast fields and the existing indexable.</p>';
    echo '<p>Proposal <code>' . esc_html( $test['id'] ) . '</code> · SHA-256 <code>' . esc_html( $hash ) . '</code></p>';
    foreach ( array( 'apply' => 'Approve SEO title and description test', 'restore' => 'Approve and restore previous SEO title and description' ) as $operation => $label ) {
        $from = $test[$operation === 'apply' ? 'before' : 'after'];
        $to = $test[$operation === 'apply' ? 'after' : 'before'];
        echo '<h3>' . esc_html( $label ) . '</h3>';
        echo '<table class="widefat striped"><thead><tr><th>Field</th><th>Expected current value</th><th>Proposed value</th></tr></thead><tbody>';
        foreach ( array( 'title' => 'SEO title', 'description' => 'Meta description' ) as $field => $name ) {
            echo '<tr><th scope="row">' . esc_html( $name ) . '</th><td>' . esc_html( $from[$field] ) . '</td><td>' . esc_html( $to[$field] ) . '</td></tr>';
        }
        echo '</tbody></table>';
        if ( ! check_indexable_baseline( $test, $from, $rows, $from ) ) {
            echo '<p>Unavailable for the current baseline. Download the read-only indexable report to review the saved values.</p>';
            continue;
        }
        render_staging_approval( TITLE_DESCRIPTION_ACTION, $operation, $hash, $label );
    }
    echo '<hr>';
}

/** Require a transactional storage engine for both tables and the ordinary WordPress autocommit mode. */
function supports_atomic_metadata_test(): bool {
    global $wpdb;
    $indexable_table = $wpdb->prefix . 'yoast_indexable';
    $query = $wpdb->prepare(
        'SELECT TABLE_NAME AS table_name, ENGINE AS table_engine, @@session.autocommit AS session_autocommit FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME IN (%s, %s)',
        $indexable_table, $wpdb->postmeta
    );
    $previous_suppression = $wpdb->suppress_errors( true );
    try {
        $rows = $wpdb->get_results( $query, ARRAY_A );
        if ( $wpdb->last_error !== '' || ! is_array( $rows ) || count( $rows ) !== 2 ) {
            return false;
        }
    } finally {
        $wpdb->suppress_errors( $previous_suppression );
    }
    $tables = array_column( $rows, null, 'table_name' );
    foreach ( array( $indexable_table, $wpdb->postmeta ) as $table ) {
        if ( strcasecmp( $tables[$table]['table_engine'] ?? '', 'InnoDB' ) !== 0 || (string) ( $tables[$table]['session_autocommit'] ?? '' ) !== '1' ) {
            return false;
        }
    }
    return true;
}

/** A single guarded statement updates two existing postmeta rows and one existing derived row together. */
function update_title_description( int $id, array $test, array $from, array $to ) {
    global $wpdb;
    $table = $wpdb->prefix . 'yoast_indexable';
    $query = $wpdb->prepare(
        "UPDATE %i AS target
         INNER JOIN %i AS source_title ON source_title.post_id = target.object_id AND source_title.meta_key = '_yoast_wpseo_title'
             AND CAST(source_title.meta_key AS BINARY) = CAST('_yoast_wpseo_title' AS BINARY)
             AND CAST(source_title.meta_value AS BINARY) = CAST(%s AS BINARY)
         INNER JOIN %i AS source_description ON source_description.post_id = target.object_id AND source_description.meta_key = '_yoast_wpseo_metadesc'
             AND CAST(source_description.meta_key AS BINARY) = CAST('_yoast_wpseo_metadesc' AS BINARY)
             AND CAST(source_description.meta_value AS BINARY) = CAST(%s AS BINARY)
         LEFT JOIN %i AS extra_source ON extra_source.post_id = target.object_id
             AND ((extra_source.meta_key = source_title.meta_key AND extra_source.meta_id <> source_title.meta_id)
               OR (extra_source.meta_key = source_description.meta_key AND extra_source.meta_id <> source_description.meta_id))
         LEFT JOIN %i AS other_row ON other_row.object_id = target.object_id AND other_row.object_type = 'post' AND other_row.id <> target.id
         LEFT JOIN %i AS url_row ON url_row.permalink_hash = %s AND url_row.permalink = %s AND url_row.id <> target.id
         SET source_title.meta_value = %s, source_description.meta_value = %s, target.title = %s, target.description = %s
         WHERE target.id = %d AND target.object_id = %d AND target.object_type = 'post' AND target.object_sub_type = 'product'
           AND CAST(target.permalink AS BINARY) = CAST(%s AS BINARY)
           AND CAST(target.permalink_hash AS BINARY) = CAST(%s AS BINARY)
           AND CAST(target.title AS BINARY) = CAST(%s AS BINARY)
           AND CAST(target.description AS BINARY) = CAST(%s AS BINARY)
           AND extra_source.meta_id IS NULL AND other_row.id IS NULL AND url_row.id IS NULL",
        $table, $wpdb->postmeta, $from['title'], $wpdb->postmeta, $from['description'], $wpdb->postmeta,
        $table, $table, $from['permalink_hash'], $test['permalink'],
        $to['title'], $to['description'], $to['title'], $to['description'],
        $id, PRODUCT_ID, $test['permalink'], $from['permalink_hash'], $from['title'], $from['description']
    );
    $previous_suppression = $wpdb->suppress_errors( true );
    try {
        return $wpdb->query( $query );
    } finally {
        $wpdb->suppress_errors( $previous_suppression );
    }
}

function submit_title_description_test(): void {
    $proposal = proposal();
    assert_staging( $proposal );
    $test = title_description_proposal( $proposal );
    $hash = staging_proposal_hash( $test );
    [ $operation, $backup ] = read_staging_approval( TITLE_DESCRIPTION_ACTION, 'apply', $hash );
    $from = $test[$operation === 'apply' ? 'before' : 'after'];
    $to = $test[$operation === 'apply' ? 'after' : 'before'];

    wp_cache_delete( PRODUCT_ID, 'post_meta' );
    $rows = read_indexable_rows();
    if ( ! check_indexable_baseline( $test, $from, $rows, $from ) ) {
        stop_test( 'The saved fields or indexable differ from the reviewed baseline. No write was attempted.' );
    }
    if ( ! supports_atomic_metadata_test() ) {
        stop_test( 'Could not confirm InnoDB and autocommit for the two staging tables. No write was attempted.' );
    }

    $approved_at = gmdate( 'c' );
    $id = (int) $rows[0]['id'];
    $changed = update_title_description( $id, $test, $from, $to );
    wp_cache_delete( PRODUCT_ID, 'post_meta' );
    $readback = read_indexable_rows();
    $verified = $changed === 3 && check_indexable_baseline( $test, $to, $readback, $to ) && (int) $readback[0]['id'] === $id;

    nocache_headers();
    header( 'Content-Disposition: attachment; filename="BHcrafts_Yoast_Title_Description_2839_' . $operation . '_receipt.json"' );
    wp_send_json( array(
        'proposal_id' => $test['id'], 'proposal_sha256' => $hash, 'site' => $test['site'], 'product_id' => PRODUCT_ID,
        'operation' => $operation, 'approved_by_user_id' => get_current_user_id(), 'approved_at_utc' => $approved_at,
        'administrator_attested_backup_reference' => $backup, 'administrator_attested_outbound_isolation' => true,
        'indexable_row_id' => $id, 'before' => $from, 'proposed' => $to, 'affected_rows' => $changed,
        'saved_title_values' => get_post_meta( PRODUCT_ID, '_yoast_wpseo_title', false ),
        'saved_description_values' => get_post_meta( PRODUCT_ID, '_yoast_wpseo_metadesc', false ),
        'indexable_readback' => $readback, 'status' => $verified ? 'verified' : 'review_required',
    ), $verified ? 200 : 409, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

add_action( 'admin_post_' . TITLE_DESCRIPTION_ACTION, __NAMESPACE__ . '\\submit_title_description_test' );
