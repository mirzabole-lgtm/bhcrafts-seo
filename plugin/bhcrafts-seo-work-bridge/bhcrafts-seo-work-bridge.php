<?php
/**
 * Plugin Name: BHcrafts SEO Work Bridge
 * Description: Yoast diagnostics and fixed-proposal staging tests for product 2839.
 * Version: 0.1.3
 * Requires at least: 6.2
 * Requires PHP: 8.0
 * Author: BHcrafts
 * License: GPL-2.0-or-later
 */

namespace BHcrafts\SEO\WorkBridge;

use BHcrafts\SEO\Diagnostics;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const ACTION = 'bhcrafts_seo_yoast_staging_test';
const INDEXABLE_ACTION = 'bhcrafts_seo_yoast_indexable_report';
const PRODUCT_ID = 2839;
const SYNONYMS_KEY = '_yoast_wpseo_keywordsynonyms';
const PROPOSAL_SHA256 = '51894bdd9415e611dc4984cdf56389395aaa0b075e2866fe22407f9fa894d60d';

require_once __DIR__ . '/indexable-repair.php';
require_once __DIR__ . '/title-description-test.php';

function stop_test( string $message, int $status = 409 ): void {
    wp_die( esc_html( $message ), '', array( 'response' => $status ) );
}

function proposal(): array {
    $json = require __DIR__ . '/proposal.php';
    if ( ! is_string( $json ) || ! hash_equals( PROPOSAL_SHA256, hash( 'sha256', $json ) ) ) {
        stop_test( 'The bundled proposal checksum does not match.' );
    }
    return json_decode( $json, true, 16, JSON_THROW_ON_ERROR );
}

function administrator(): bool {
    return current_user_can( 'manage_options' ) && current_user_can( 'edit_post', PRODUCT_ID );
}

function assert_staging( array $proposal ): void {
    if ( ! administrator() || home_url( '/' ) !== $proposal['site'] || site_url( '/' ) !== $proposal['site']
        || 'staging' !== wp_get_environment_type() || is_multisite() || '0' !== (string) get_option( 'blog_public' ) ) {
        stop_test( 'The test requires an authorized administrator on the designated non-indexed staging site.', 403 );
    }
    if ( ! defined( 'BHcrafts\\SEO\\Diagnostics\\VERSION' ) || Diagnostics\VERSION !== '0.3.1' ) {
        stop_test( 'Activate BHcrafts SEO Staging Diagnostics 0.3.1 on staging first.' );
    }
    $plugins = Diagnostics\collect_report()['plugins'];
    foreach ( array( 'yoast_seo', 'yoast_premium' ) as $name ) {
        if ( ! $plugins[$name]['active'] || $plugins[$name]['version'] !== $proposal['yoast_version'] ) {
            stop_test( 'The test requires active Yoast SEO and Yoast SEO Premium 28.8.' );
        }
    }
    $post = get_post( PRODUCT_ID );
    if ( ! $plugins['woocommerce']['active'] || ! $post || $post->post_type !== 'product'
        || $post->post_status !== 'publish' || $post->post_name !== $proposal['product_slug'] ) {
        stop_test( 'The staging product or WooCommerce no longer matches this proposal.' );
    }
}

function read_rows( array $proposal ): array {
    wp_cache_delete( PRODUCT_ID, 'post_meta' );
    $rows = array();
    foreach ( array_keys( $proposal['before'] ) as $key ) {
        $rows[$key] = get_post_meta( PRODUCT_ID, $key, false );
    }
    return $rows;
}

function plan( array $proposal, array $rows, string $operation ): array {
    $before = $proposal['before'][SYNONYMS_KEY];
    $after = $proposal['proposed_value'];
    if ( 'restore' === $operation ) {
        // Other fields may change during the separate editor resave test.
        return array( $after, $before, $rows[SYNONYMS_KEY] === array( $after ) );
    }
    $post = get_post( PRODUCT_ID );
    $content_hash = Diagnostics\value_hash( array( $post->post_content, $post->post_excerpt ) );
    $baseline = array_map( static fn( $value ) => array( $value ), $proposal['before'] );
    return array( $before, $after, $rows === $baseline && $content_hash === $proposal['raw_content_sha256'] );
}

function nonce_action( string $operation ): string {
    return ACTION . ':' . $operation . ':' . PROPOSAL_SHA256;
}

function register_page(): void {
    if ( administrator() && home_url( '/' ) === proposal()['site'] ) {
        add_management_page( 'BHcrafts Yoast Staging Test', 'BHcrafts Yoast Staging Test', 'manage_options', ACTION, __NAMESPACE__ . '\\render_page' );
    }
}

/** Read the stored Yoast rows directly so the check cannot build or upgrade an indexable. */
function download_indexable_report(): void {
    $proposal = proposal();
    assert_staging( $proposal );
    if ( ( $_SERVER['REQUEST_METHOD'] ?? '' ) !== 'POST' ) {
        stop_test( 'Submit the Yoast report form.', 405 );
    }
    $fields = array( 'action', '_wpnonce', '_wp_http_referer', 'submit' );
    if ( ! empty( $_GET ) || array_diff( array_keys( $_POST ), $fields ) || count( array_filter( $_POST, 'is_string' ) ) !== count( $_POST )
        || ( $_POST['action'] ?? '' ) !== INDEXABLE_ACTION ) {
        stop_test( 'Unexpected form input. The report covers product 2839 only.', 400 );
    }
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', INDEXABLE_ACTION ) ) {
        stop_test( 'Refresh the staging test page and download the report again.', 403 );
    }

    $permalink = get_permalink( PRODUCT_ID );
    $permalink = is_string( $permalink ) && $permalink !== '' ? $permalink : null;
    // Yoast 28.8 looks up the full permalink and its length-prefixed MD5 together.
    $permalink_hash = $permalink === null ? null : strlen( $permalink ) . ':' . md5( $permalink );
    $saved_title = get_post_meta( PRODUCT_ID, '_yoast_wpseo_title', false );
    $saved_description = get_post_meta( PRODUCT_ID, '_yoast_wpseo_metadesc', false );
    $rows = read_indexable_rows();
    if ( $rows === null ) {
        $rows = array();
        $status = 'query_failed';
    } else {
        $status = array( 'missing', 'found' )[count( $rows )] ?? 'multiple';
        foreach ( $rows as &$row ) {
            unset( $row['id'] );
            $row['matches_current_permalink'] = $permalink !== null && $row['permalink'] === $permalink;
            $row['matches_current_permalink_hash'] = $permalink_hash !== null && $row['permalink_hash'] === $permalink_hash;
            $row['matches_saved_title'] = $saved_title === array( $row['title'] );
            $row['matches_saved_description'] = $saved_description === array( $row['description'] );
        }
        unset( $row );
    }

    nocache_headers();
    header( 'Content-Disposition: attachment; filename="BHcrafts_Yoast_Indexable_2839.json"' );
    wp_send_json( array(
        'report_schema' => 'bhcrafts-yoast-indexable/1',
        'status' => $status,
        'site' => $proposal['site'],
        'product_id' => PRODUCT_ID,
        'yoast_version' => $proposal['yoast_version'],
        'generated_at_utc' => gmdate( 'c' ),
        'current_permalink' => $permalink,
        'saved_title_values' => $saved_title,
        'saved_description_values' => $saved_description,
        'indexable_rows' => $rows,
        'row_limit' => 3,
    ), 200, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

function render_page(): void {
    $proposal = proposal();
    assert_staging( $proposal );
    $rows = read_rows( $proposal );
    echo '<div class="wrap"><h1>BHcrafts Yoast Staging Test</h1>';
    echo '<h2>Read-only indexable report</h2><p>Compare the saved Yoast title and description with the stored indexable for product 2839.</p>';
    echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
    echo '<input type="hidden" name="action" value="' . esc_attr( INDEXABLE_ACTION ) . '">';
    wp_nonce_field( INDEXABLE_ACTION );
    submit_button( 'Download Yoast indexable report', 'secondary' );
    echo '</form><hr>';
    $indexable_rows = read_indexable_rows();
    render_title_description_test( $proposal, $indexable_rows );
    render_indexable_repair( $proposal, $indexable_rows );
    echo '<p>Product 2839. The test changes one Yoast metadata field. Compare the values below before approving.</p>';
    echo '<p>Proposal <code>' . esc_html( $proposal['id'] ) . '</code> · SHA-256 <code>' . esc_html( PROPOSAL_SHA256 ) . '</code></p>';
    foreach ( array( 'apply' => 'Approve and remove trailing comma', 'restore' => 'Approve and restore original synonyms' ) as $operation => $label ) {
        list( $before, $after, $ready ) = plan( $proposal, $rows, $operation );
        echo '<h2>' . esc_html( $label ) . '</h2>';
        echo '<p>Expected current value</p><pre style="white-space:pre-wrap">' . esc_html( $before ) . '</pre>';
        echo '<p>Proposed value</p><pre style="white-space:pre-wrap">' . esc_html( $after ) . '</pre>';
        if ( ! $ready ) {
            echo '<p>Unavailable for the current baseline. Export a fresh diagnostics snapshot if the current values are unexpected.</p>';
            continue;
        }
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
        echo '<input type="hidden" name="action" value="' . esc_attr( ACTION ) . '">';
        echo '<input type="hidden" name="operation" value="' . esc_attr( $operation ) . '">';
        wp_nonce_field( nonce_action( $operation ) );
        echo '<p><label>Verified Kinsta staging backup reference <input type="text" name="backup_reference" maxlength="120" required></label></p>';
        echo '<p><label><input type="checkbox" name="staging_checked" value="yes" required> I verified the staging backup and outbound integration isolation.</label></p>';
        submit_button( $label );
        echo '</form>';
    }
    echo '</div>';
}

/** Prevent WordPress's update API from inserting a row if the reviewed row disappeared. */
function prevent_insert( $check, $id, $key ) {
    return PRODUCT_ID === (int) $id && SYNONYMS_KEY === $key ? false : $check;
}

function submit_test(): void {
    $proposal = proposal();
    assert_staging( $proposal );
    if ( ( $_SERVER['REQUEST_METHOD'] ?? '' ) !== 'POST' ) {
        stop_test( 'Submit the staging test form.', 405 );
    }
    $fields = array( 'action', 'operation', '_wpnonce', '_wp_http_referer', 'backup_reference', 'staging_checked', 'submit' );
    if ( ! empty( $_GET ) || array_diff( array_keys( $_POST ), $fields ) || count( array_filter( $_POST, 'is_string' ) ) !== count( $_POST ) ) {
        stop_test( 'Unexpected form input. The product and proposal are fixed.', 400 );
    }
    $operation = $_POST['operation'] ?? '';
    $backup = trim( wp_unslash( $_POST['backup_reference'] ?? '' ) );
    if ( ( $_POST['action'] ?? '' ) !== ACTION || ! in_array( $operation, array( 'apply', 'restore' ), true )
        || ( $_POST['staging_checked'] ?? '' ) !== 'yes' || ! preg_match( '/\A[A-Za-z0-9][A-Za-z0-9 .:_-]{0,119}\z/', $backup ) ) {
        stop_test( 'Confirm staging isolation and enter the verified backup reference.', 400 );
    }
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', nonce_action( $operation ) ) ) {
        stop_test( 'Refresh the preview and approve the exact proposal again.', 403 );
    }
    $rows = read_rows( $proposal );
    list( $before, $after, $ready ) = plan( $proposal, $rows, $operation );
    if ( ! $ready ) {
        stop_test( 'The saved baseline differs from the expected value. No write was attempted.' );
    }

    $approved_at = gmdate( 'c' );
    add_filter( 'add_post_metadata', __NAMESPACE__ . '\\prevent_insert', PHP_INT_MAX, 3 );
    try {
        $updated = update_post_meta( PRODUCT_ID, SYNONYMS_KEY, wp_slash( $after ), $before );
    } catch ( \Throwable $error ) {
        // A vendor hook may fail after a write. Read back and report uncertainty.
        $updated = false;
    } finally {
        remove_filter( 'add_post_metadata', __NAMESPACE__ . '\\prevent_insert', PHP_INT_MAX );
    }
    $expected = $rows;
    $expected[SYNONYMS_KEY] = array( $after );
    $readback = read_rows( $proposal );
    $verified = $updated === true && $readback === $expected;

    nocache_headers();
    header( 'Content-Disposition: attachment; filename="BHcrafts_Yoast_Staging_Test_' . $operation . '.json"' );
    wp_send_json( array(
        'proposal_id' => $proposal['id'],
        'proposal_sha256' => PROPOSAL_SHA256,
        'site' => $proposal['site'],
        'product_id' => PRODUCT_ID,
        'operation' => $operation,
        'approved_by_user_id' => get_current_user_id(),
        'approved_at_utc' => $approved_at,
        'administrator_attested_backup_reference' => $backup,
        'administrator_attested_outbound_isolation' => true,
        'key' => SYNONYMS_KEY,
        'before' => $before,
        'proposed' => $after,
        'readback' => $readback[SYNONYMS_KEY],
        'update_reported_success' => $updated === true,
        'all_five_rows_verified' => $verified,
        'status' => $verified ? 'verified' : 'review_required',
    ), $verified ? 200 : 409, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

add_action( 'admin_menu', __NAMESPACE__ . '\\register_page' );
add_action( 'admin_post_' . ACTION, __NAMESPACE__ . '\\submit_test' );
add_action( 'admin_post_' . INDEXABLE_ACTION, __NAMESPACE__ . '\\download_indexable_report' );
