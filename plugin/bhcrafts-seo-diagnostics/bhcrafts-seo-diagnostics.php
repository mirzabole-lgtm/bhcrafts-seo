<?php
/**
 * Plugin Name: BHcrafts SEO Staging Diagnostics
 * Description: Administrator-only, read-only environment report for the designated BHcrafts staging site.
 * Version: 0.2.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: BHcrafts
 * License: GPL-2.0-or-later
 */

namespace BHcrafts\SEO\Diagnostics;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const VERSION = '0.2.1';
const STAGING_HOST = 'stg-bhcraftsshop-affiliate.kinsta.cloud';
const EXPORT_ACTION = 'bhcrafts_seo_staging_diagnostics_export';

require_once __DIR__ . '/includes/product-export.php';

/** Both WordPress URLs must identify the designated HTTPS staging host. */
function is_designated_staging() {
    foreach ( array( home_url( '/' ), site_url( '/' ) ) as $url ) {
        $parts = wp_parse_url( $url );
        if ( ! is_array( $parts )
            || ! isset( $parts['host'], $parts['scheme'] )
            || strtolower( $parts['host'] ) !== STAGING_HOST
            || strtolower( $parts['scheme'] ) !== 'https'
            || isset( $parts['user'] ) || isset( $parts['pass'] )
            || ( isset( $parts['port'] ) && 443 !== $parts['port'] ) ) {
            return false;
        }
    }
    return true;
}

/** No remote requests, product queries, secret exports or settings writes. */
function collect_report() {
    if ( ! current_user_can( 'manage_options' ) || ! is_designated_staging() ) {
        wp_die( 'This report requires an administrator on the designated staging site.', '', array( 'response' => 403 ) );
    }

    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $installed = get_plugins();
    $known = array(
        'woocommerce'   => 'woocommerce/woocommerce.php',
        'yoast_seo'     => 'wordpress-seo/wp-seo.php',
        'yoast_premium' => 'wordpress-seo-premium/wp-seo-premium.php',
    );
    $plugins = array();
    foreach ( $known as $label => $file ) {
        $found = isset( $installed[ $file ] );
        $plugins[ $label ] = array(
            'standard_entry_file_found' => $found,
            'version' => $found ? (string) $installed[ $file ]['Version'] : null,
            'active'  => $found ? (bool) is_plugin_active( $file ) : null,
        );
    }
    $theme = wp_get_theme();
    $parent = $theme->parent();

    return array(
        'report_schema' => 'bhcrafts-seo-staging-diagnostics/1',
        'diagnostics_plugin_version' => VERSION,
        'generated_at_utc' => gmdate( 'c' ),
        'mode' => 'read_only',
        'environment' => array(
            'home_url' => home_url( '/' ),
            'site_url' => site_url( '/' ),
            'rest_url' => rest_url(),
            'designated_staging_match' => true,
            'wordpress_environment_type' => wp_get_environment_type(),
            'wordpress_version' => get_bloginfo( 'version' ),
            'php_version' => PHP_VERSION,
            'multisite' => is_multisite(),
            'blog_public' => (string) get_option( 'blog_public' ),
        ),
        'theme' => array(
            'stylesheet' => $theme->get_stylesheet(),
            'version' => (string) $theme->get( 'Version' ),
            'parent_template' => $parent ? $parent->get_template() : null,
            'parent_version' => $parent ? (string) $parent->get( 'Version' ) : null,
        ),
        'plugins' => $plugins,
        'authentication' => array(
            'application_passwords_available' => function_exists( 'wp_is_application_passwords_available' )
                ? (bool) wp_is_application_passwords_available() : null,
            'current_administrator_authorized' => true,
            'cloud_authenticated_connection_tested' => false,
        ),
        'coverage' => array(
            'raw_products_read' => false,
            'images_inspected' => false,
            'yoast_premium_storage_verified' => false,
            'yoast_write_adapter_available' => false,
            'outbound_integrations_isolated_verified' => false,
            'backup_verified' => false,
            'notes' => array(
                'A missing standard plugin entry file does not rule out an alternative installation path.',
                'This report does not establish a cloud API connection or authorize content writes.',
            ),
        ),
    );
}

function register_tools_page() {
    if ( current_user_can( 'manage_options' ) && is_designated_staging() ) {
        add_management_page(
            'BHcrafts SEO Diagnostics', 'BHcrafts SEO Diagnostics', 'manage_options',
            'bhcrafts-seo-diagnostics', __NAMESPACE__ . '\\render_tools_page'
        );
    }
}

function render_tools_page() {
    if ( ! current_user_can( 'manage_options' ) || ! is_designated_staging() ) {
        wp_die( 'This page requires an administrator on the designated staging site.', '', array( 'response' => 403 ) );
    }
    echo '<div class="wrap"><h1>BHcrafts SEO Staging Diagnostics</h1>';
    echo '<p>Download the installed WordPress, WooCommerce, Yoast and theme versions for this staging site.</p>';
    echo '<p>The environment report contains no product content. Neither export includes orders, customers, passwords or API keys.</p>';
    echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
    echo '<input type="hidden" name="action" value="' . esc_attr( EXPORT_ACTION ) . '">';
    wp_nonce_field( EXPORT_ACTION );
    submit_button( 'Download diagnostics JSON' );
    echo '</form>';
    echo '<hr><h2>Product 2839: read-only snapshot</h2>';
    echo '<p>Export saved descriptions, attachment metadata and installed Yoast field evidence for the selected handbag.</p>';
    echo '<p>This action reads product 2839 and its observed variations and images. It performs no content updates.</p>';
    echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
    echo '<input type="hidden" name="action" value="' . esc_attr( SNAPSHOT_ACTION ) . '">';
    wp_nonce_field( SNAPSHOT_ACTION );
    submit_button( 'Download product 2839 snapshot' );
    echo '</form></div>';
}

function download_report() {
    if ( ! current_user_can( 'manage_options' ) || ! is_designated_staging() ) {
        wp_die( 'This export requires an administrator on the designated staging site.', '', array( 'response' => 403 ) );
    }
    if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
        wp_die( 'Use the diagnostics download form.', '', array( 'response' => 405 ) );
    }
    check_admin_referer( EXPORT_ACTION );
    $json = wp_json_encode( collect_report(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    if ( false === $json ) {
        wp_die( 'The diagnostics report could not be encoded.', '', array( 'response' => 500 ) );
    }
    nocache_headers();
    header( 'Content-Type: application/json; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="BHcrafts_Staging_Diagnostics.json"' );
    header( 'X-Content-Type-Options: nosniff' );
    echo $json; // Fixed report schema, encoded as a downloadable JSON document.
    exit;
}

add_action( 'admin_menu', __NAMESPACE__ . '\\register_tools_page' );
add_action( 'admin_post_' . EXPORT_ACTION, __NAMESPACE__ . '\\download_report' );

add_action( 'admin_post_' . SNAPSHOT_ACTION, __NAMESPACE__ . '\\download_product_snapshot' );
