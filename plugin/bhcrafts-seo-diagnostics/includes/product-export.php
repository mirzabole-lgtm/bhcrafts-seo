<?php
/** Fixed-scope read-only product snapshot. No public endpoint or content writer. */
namespace BHcrafts\SEO\Diagnostics;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const PRODUCT_ID = 2839;
const PRODUCT_SLUG = 'knit-handbag-with-dolls-applique';
const SNAPSHOT_ACTION = 'bhcrafts_seo_product_2839_export';
const MAX_VARIATIONS = 25;
const MAX_ATTACHMENTS = 30;
const MAX_META_KEYS = 1024;
const MAX_TEXT_BYTES = 1048576;
const MAX_REPORT_BYTES = 8388608;

function snapshot_error( $message, $status = 409 ) {
    wp_die( esc_html( $message ), '', array( 'response' => $status ) );
}

function authorize_snapshot() {
    if ( ! current_user_can( 'manage_options' ) || ! is_designated_staging()
        || ! current_user_can( 'edit_post', PRODUCT_ID ) ) {
        snapshot_error( 'This export requires an authorized administrator on the designated staging site.', 403 );
    }
}

/** Reject objects and resource values; keep strings and array shapes unchanged. */
function checked_value( $value, $depth = 0 ) {
    if ( $depth > 12 || is_object( $value ) || is_resource( $value ) ) {
        snapshot_error( 'The selected record contains an unsupported value shape.' );
    }
    if ( is_string( $value ) && preg_match( '//u', $value ) !== 1 ) {
        snapshot_error( 'A selected string is not valid UTF-8.' );
    }
    if ( is_string( $value ) && strlen( $value ) > MAX_TEXT_BYTES ) {
        snapshot_error( 'The selected field exceeds the export size limit.' );
    }
    if ( is_array( $value ) ) {
        if ( count( $value ) > 2048 ) {
            snapshot_error( 'The selected array exceeds the export size limit.' );
        }
        foreach ( $value as $key => $item ) {
            checked_value( $key, $depth + 1 );
            checked_value( $item, $depth + 1 );
        }
    }
    return $value;
}

function value_hash( $value ) {
    $encoded = wp_json_encode( checked_value( $value ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    if ( false === $encoded ) {
        snapshot_error( 'A selected value could not be encoded as UTF-8 JSON.' );
    }
    return hash( 'sha256', $encoded );
}

function text_value( $value ) {
    if ( ! is_string( $value ) ) {
        snapshot_error( 'A saved text field has an unexpected type.' );
    }
    return checked_value( $value );
}

function metadata_record( $id, $key ) {
    $exists = metadata_exists( 'post', $id, $key );
    $values = $exists ? checked_value( get_post_meta( $id, $key, false ) ) : array();
    if ( ! is_array( $values ) ) {
        snapshot_error( 'A metadata API read returned an unexpected value type.' );
    }
    return array(
        'exists' => (bool) $exists,
        'wordpress_values' => $values,
        'value_types' => array_map( 'gettype', $values ),
        'sha256' => value_hash( array( 'exists' => (bool) $exists, 'wordpress_values' => $values ) ),
        'read_semantics' => 'WordPress metadata API values, including its normal type conversion; not raw database bytes.',
    );
}

function content_field_name( $name ) {
    return is_string( $name ) && in_array( $name, array( 'title', 'metadesc', 'focuskw', 'keywordsynonyms', 'focuskeywords' ), true );
}

/** Inspect the installed public field registry and saved Yoast content keys. */
function collect_yoast_evidence() {
    $evidence = array(
        'storage_contract_verified' => false,
        'write_adapter_present' => false,
        'registry_class_loaded' => class_exists( 'WPSEO_Meta', false ),
        'installed_registry_fields' => array(),
        'installed_registry_field_names' => array(),
        'value_read_alias_allowlist' => array( 'title', 'metadesc', 'focuskw', 'keywordsynonyms', 'focuskeywords' ),
        'observed_vendor_key_names' => array(),
        'content_metadata' => array(),
        'notes' => array(
            'The five value-read aliases are candidates only. Their presence, absence and installed definitions are reported without assuming a Premium layout.',
            'Unknown installed field names are listed without values and require explicit adapter review.',
            'Scores, canonical values, robots values and social values are not exported.',
            'No JSON or serialized content value is rewritten, default-filled or double-encoded.',
        ),
    );
    $prefix = '_yoast_wpseo_';
    $candidate_keys = array();
    if ( $evidence['registry_class_loaded'] ) {
        $vars = get_class_vars( 'WPSEO_Meta' );
        $evidence['runtime_prefix_matches_vendor'] = isset( $vars['meta_prefix'] ) && $vars['meta_prefix'] === $prefix;
        if ( $evidence['runtime_prefix_matches_vendor'] && isset( $vars['meta_fields'] ) && is_array( $vars['meta_fields'] ) ) {
            foreach ( $vars['meta_fields'] as $group => $fields ) {
                if ( ! is_array( $fields ) ) {
                    continue;
                }
                foreach ( $fields as $name => $definition ) {
                    $evidence['installed_registry_field_names'][] = checked_value( (string) $name );
                    if ( count( $evidence['installed_registry_field_names'] ) > 512 ) {
                        snapshot_error( 'The installed Yoast registry exceeds the field-name limit.' );
                    }
                    if ( ! content_field_name( $name ) || ! is_array( $definition ) ) {
                        continue;
                    }
                    $key = $prefix . $name;
                    if ( strlen( $key ) > 191 || ! preg_match( '/^_yoast_wpseo_[A-Za-z0-9_-]+$/', $key ) ) {
                        snapshot_error( 'A Yoast content field has an unsupported name.' );
                    }
                    $safe_definition = array();
                    foreach ( array( 'type', 'title', 'default_value' ) as $property ) {
                        if ( array_key_exists( $property, $definition ) ) {
                            $safe_definition[ $property ] = checked_value( $definition[ $property ] );
                        }
                    }
                    $evidence['installed_registry_fields'][ $key ] = array(
                        'group' => (string) $group,
                        'field_name' => $name,
                        'selected_definition_properties' => $safe_definition,
                    );
                    $candidate_keys[ $key ] = true;
                }
            }
        }
        $reflection = new \ReflectionClass( 'WPSEO_Meta' );
        $file = $reflection->getFileName();
        $evidence['registry_source_file_basename'] = $file ? basename( $file ) : null;
        $evidence['registry_source_sha256'] = $file && is_readable( $file ) ? hash_file( 'sha256', $file ) : null;
    }
    // Names only. Never fetch arbitrary meta values or accept a caller-supplied key.
    $names = get_post_custom_keys( PRODUCT_ID );
    $names = is_array( $names ) ? $names : array();
    if ( count( $names ) > MAX_META_KEYS ) {
        snapshot_error( 'The selected product has too many metadata keys for this bounded export.' );
    }
    foreach ( $names as $key ) {
        if ( ! is_string( $key ) || strpos( $key, $prefix ) !== 0 ) {
            continue;
        }
        $evidence['observed_vendor_key_names'][] = $key;
        $name = substr( $key, strlen( $prefix ) );
        if ( content_field_name( $name ) ) {
            if ( ! preg_match( '/^_yoast_wpseo_[A-Za-z0-9_-]+$/', $key ) || strlen( $key ) > 191 ) {
                snapshot_error( 'A saved Yoast content key has an unsupported name.' );
            }
            $candidate_keys[ $key ] = true;
        }
    }
    sort( $evidence['observed_vendor_key_names'], SORT_STRING );
    if ( count( $candidate_keys ) > 32 ) {
        snapshot_error( 'Too many Yoast content candidates were found for this export.' );
    }
    ksort( $candidate_keys );
    foreach ( $candidate_keys as $key => $ignored ) {
        $evidence['content_metadata'][ $key ] = metadata_record( PRODUCT_ID, $key );
    }
    return $evidence;
}

function attribute_values( $product ) {
    $values = array();
    foreach ( $product->get_attributes( 'edit' ) as $key => $attribute ) {
        if ( $attribute instanceof \WC_Product_Attribute ) {
            $values[ $key ] = array(
                'id' => $attribute->get_id(),
                'name' => $attribute->get_name(),
                'options' => checked_value( $attribute->get_options() ),
                'visible' => $attribute->get_visible(),
                'variation' => $attribute->get_variation(),
            );
        } else {
            $values[ $key ] = checked_value( $attribute );
        }
    }
    return $values;
}

/** Hash selected protected properties. No restore or update operation exists. */
function protected_hashes( $product ) {
    $mapping = array(
        'name' => 'get_name', 'slug' => 'get_slug', 'status' => 'get_status',
        'parent_id' => 'get_parent_id', 'sku' => 'get_sku', 'price' => 'get_price',
        'regular_price' => 'get_regular_price', 'sale_price' => 'get_sale_price',
        'manage_stock' => 'get_manage_stock', 'stock_quantity' => 'get_stock_quantity',
        'stock_status' => 'get_stock_status', 'backorders' => 'get_backorders',
        'sold_individually' => 'get_sold_individually', 'image_id' => 'get_image_id',
        'gallery_image_ids' => 'get_gallery_image_ids', 'category_ids' => 'get_category_ids',
        'tag_ids' => 'get_tag_ids', 'default_attributes' => 'get_default_attributes',
        'weight' => 'get_weight', 'length' => 'get_length', 'width' => 'get_width',
        'height' => 'get_height', 'tax_status' => 'get_tax_status',
        'tax_class' => 'get_tax_class', 'shipping_class_id' => 'get_shipping_class_id',
        'virtual' => 'get_virtual', 'downloadable' => 'get_downloadable',
    );
    $result = array();
    foreach ( $mapping as $name => $method ) {
        $result[ $name ] = method_exists( $product, $method )
            ? array( 'supported' => true, 'sha256' => value_hash( $product->$method( 'edit' ) ) )
            : array( 'supported' => false );
    }
    $result['attributes'] = array( 'supported' => true, 'sha256' => value_hash( attribute_values( $product ) ) );
    $result['type'] = array( 'supported' => true, 'sha256' => value_hash( $product->get_type() ) );
    return $result;
}

function attachment_snapshot( $id ) {
    if ( ! current_user_can( 'edit_post', $id ) ) {
        snapshot_error( 'An attachment is outside the current administrator’s permitted scope.', 403 );
    }
    $post = get_post( $id );
    if ( ! $post || 'attachment' !== $post->post_type ) {
        return array( 'id' => $id, 'status' => 'missing_or_wrong_type', 'preservation_check' => 'hold' );
    }
    $alt = metadata_record( $id, '_wp_attachment_image_alt' );
    return array(
        'id' => $id,
        'status' => 'read',
        'source_url' => wp_get_attachment_url( $id ),
        'modified_gmt' => $post->post_modified_gmt,
        'title_raw' => text_value( $post->post_title ),
        'caption_raw' => text_value( $post->post_excerpt ),
        'description_raw' => text_value( $post->post_content ),
        'alt_text_metadata' => $alt,
        'baseline_sha256' => value_hash( array( $post->post_title, $post->post_excerpt, $post->post_content,
            $alt ) ),
    );
}

function collect_product_snapshot() {
    authorize_snapshot();
    if ( ! function_exists( 'wc_get_product' ) ) {
        snapshot_error( 'WooCommerce is unavailable for the selected product.' );
    }
    $post = get_post( PRODUCT_ID );
    if ( ! $post || 'product' !== $post->post_type || PRODUCT_SLUG !== $post->post_name ) {
        snapshot_error( 'Product 2839 no longer matches the selected product identity.' );
    }
    $product = wc_get_product( PRODUCT_ID );
    if ( ! $product || 'variable' !== $product->get_type() ) {
        snapshot_error( 'The selected product type differs from the inspected variable product.' );
    }
    $expected = array( 2841, 2843, 2844, 2842, 2845, 445, 357, 577 );
    $parent_images = array_values( array_unique( array_filter( array_merge(
        array( (int) $product->get_image_id( 'edit' ) ),
        array_map( 'intval', $product->get_gallery_image_ids( 'edit' ) )
    ) ) ) );
    $attachment_ids = array_values( array_unique( array_merge( $expected, $parent_images ) ) );
    $children = array_values( array_map( 'intval', $product->get_children() ) );
    if ( count( $children ) > MAX_VARIATIONS ) {
        snapshot_error( 'This product exceeds the bounded variation limit.' );
    }
    $variations = array();
    foreach ( $children as $id ) {
        if ( ! current_user_can( 'edit_post', $id ) ) {
            snapshot_error( 'A variation is outside the current administrator’s permitted scope.', 403 );
        }
        $variation_post = get_post( $id );
        $variation = wc_get_product( $id );
        if ( ! $variation_post || 'product_variation' !== $variation_post->post_type || ! $variation
            || PRODUCT_ID !== (int) $variation->get_parent_id( 'edit' ) ) {
            snapshot_error( 'A variation no longer belongs to the selected product.' );
        }
        $image_id = (int) $variation->get_image_id( 'edit' );
        if ( $image_id ) {
            $attachment_ids[] = $image_id;
        }
        $variations[] = array(
            'id' => $id, 'parent_id' => PRODUCT_ID, 'image_id' => $image_id,
            'attributes' => attribute_values( $variation ),
            'description_raw' => text_value( $variation_post->post_content ),
            'modified_gmt' => $variation_post->post_modified_gmt,
            'protected_field_hashes' => protected_hashes( $variation ),
        );
    }
    $attachment_ids = array_values( array_unique( $attachment_ids ) );
    if ( count( $attachment_ids ) > MAX_ATTACHMENTS ) {
        snapshot_error( 'This product exceeds the bounded attachment limit.' );
    }
    $attachments = array();
    foreach ( $attachment_ids as $id ) {
        $attachments[] = attachment_snapshot( $id );
    }
    $tag = get_post( 577 );
    $tag_url = wp_get_attachment_url( 577 );
    $environment_report = collect_report();
    $environment_report['coverage_scope'] = 'This nested report covers environment diagnostics only; selected product reads are recorded in the parent report.';
    $snapshot = array(
        'report_schema' => 'bhcrafts-seo-product-snapshot/1',
        'diagnostics_plugin_version' => VERSION,
        'generated_at_utc' => gmdate( 'c' ),
        'mode' => 'read_only',
        'environment_report' => $environment_report,
        'selection' => array(
            'product_id' => PRODUCT_ID, 'expected_slug' => PRODUCT_SLUG,
            'actual_permalink' => get_permalink( PRODUCT_ID ),
            'actual_parent_image_order' => $parent_images,
            'inspection_parent_image_order_matches' => $parent_images === array_slice( $expected, 0, 7 ),
            'observed_variation_ids' => $children,
            'inspection_variation_ids_match' => $children === array( 2840 ),
            'attachment_ids_read' => $attachment_ids,
        ),
        'product' => array(
            'id' => PRODUCT_ID, 'name' => text_value( $post->post_title ), 'slug' => $post->post_name,
            'status' => $post->post_status, 'type' => $product->get_type(),
            'modified_gmt' => $post->post_modified_gmt,
            'long_description_raw' => text_value( $post->post_content ),
            'short_description_raw' => text_value( $post->post_excerpt ),
            'raw_content_sha256' => value_hash( array( $post->post_content, $post->post_excerpt ) ),
            'attributes' => attribute_values( $product ),
            'protected_field_hashes' => protected_hashes( $product ),
        ),
        'variations' => $variations,
        'attachments' => $attachments,
        'artisan_preservation_evidence' => array(
            'expected_attachment_id' => 577,
            'attachment_type_matches' => (bool) ( $tag && 'attachment' === $tag->post_type ),
            'attachment_url_path_matches' => is_string( $tag_url ) && wp_parse_url( $tag_url, PHP_URL_PATH ) === '/wp-content/uploads/2020/10/artisan-handmade-tag.jpg',
            'raw_description_contains_tag_filename' => strpos( $post->post_content, 'artisan-handmade-tag.jpg' ) !== false,
            'raw_description_contains_artisan_heading' => strpos( $post->post_content, 'MORE INFORMATION ABOUT ARTISANS' ) !== false,
        ),
        'yoast_evidence' => collect_yoast_evidence(),
        'premium_schema_evidence' => collect_premium_schema_evidence(),
        'coverage' => array(
            'selected_product_raw_fields_read' => true,
            'sitewide_media_usage_complete' => false,
            'yoast_field_mapping_verified' => false,
            'yoast_normal_editor_save_tested' => false,
            'yoast_writes_performed' => false,
            'any_content_writes_performed' => false,
            'cloud_authenticated_connection_established' => false,
            'protected_hashes_are_not_a_restore_payload' => true,
            'notes' => array( 'Fixed product only. No arbitrary ID/key/URL request inputs.',
                'This report is not a full protected-field inventory or a full sitewide media audit.',
                'A successful export does not prove Premium field mapping, save/indexation lifecycle or browser layout.' ),
        ),
    );
    $snapshot['snapshot_sha256'] = value_hash( $snapshot );
    return $snapshot;
}

function download_product_snapshot() {
    authorize_snapshot();
    if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
        snapshot_error( 'Use the product snapshot download form.', 405 );
    }
    foreach ( array_keys( $_POST ) as $name ) {
        if ( ! in_array( $name, array( 'action', '_wpnonce', '_wp_http_referer', 'submit' ), true ) ) {
            snapshot_error( 'Unexpected form field. Product scope is fixed.', 400 );
        }
        if ( ! is_string( $_POST[ $name ] ) ) {
            snapshot_error( 'Form fields must contain single text values.', 400 );
        }
    }
    if ( ! isset( $_POST['action'] ) || $_POST['action'] !== SNAPSHOT_ACTION || ! empty( $_GET ) ) {
        snapshot_error( 'Use the fixed-scope product snapshot form.', 400 );
    }
    check_admin_referer( SNAPSHOT_ACTION );
    $json = wp_json_encode( collect_product_snapshot(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    if ( false === $json || strlen( $json ) > MAX_REPORT_BYTES ) {
        snapshot_error( 'The report could not be encoded within its bounded size limit.', 500 );
    }
    nocache_headers();
    header( 'Content-Type: application/json; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="BHcrafts_Product_2839_ReadOnly_Snapshot.json"' );
    header( 'X-Content-Type-Options: nosniff' );
    echo $json;
    exit;
}
