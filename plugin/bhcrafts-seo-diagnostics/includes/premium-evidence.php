<?php
/** Installed registration and redacted structure evidence. No metadata writes. */
namespace BHcrafts\SEO\Diagnostics;
if ( ! defined( 'ABSPATH' ) ) { exit; }

function schema_callback_label( $callback ) {
    if ( is_string( $callback ) ) { return $callback; }
    if ( is_array( $callback ) && count( $callback ) === 2 && isset( $callback[0], $callback[1] ) && is_string( $callback[1] ) ) {
        $class = is_object( $callback[0] ) ? get_class( $callback[0] ) : $callback[0];
        if ( is_string( $class ) && strpos( $class, '@anonymous' ) === false ) { return $class . '::' . $callback[1]; }
    }
    return $callback ? 'callable_or_unrecognized' : null;
}

/** Flatten type information. Never return a phrase, synonym, score or unknown key text. */
function schema_shape_nodes( $value, $path = '$', $depth = 0, &$nodes = array() ) {
    if ( count( $nodes ) >= 80 ) { return; }
    $object = $value instanceof \stdClass;
    $array = is_array( $value );
    $associative = $array && $value !== array() && array_keys( $value ) !== range( 0, count( $value ) - 1 );
    $node = array( 'path' => $path, 'type' => $object ? 'object' : ( $associative ? 'associative_array' : gettype( $value ) ) );
    if ( $array || $object ) { $node['count'] = count( $object ? get_object_vars( $value ) : $value ); }
    $nodes[] = $node;
    if ( $depth >= 6 || ( ! $array && ! $object ) ) { return; }
    if ( $object || $associative ) {
        $index = 0;
        foreach ( ( $object ? get_object_vars( $value ) : $value ) as $key => $item ) {
            $index++;
            if ( $index > 16 ) { break; }
            $safe_keys = array( 'keyword', 'keyphrase', 'synonyms', 'score', 'id', 'value', 'results', 'relatedKeyphrases', 'analysis', 'assessments' );
            $label = in_array( $key, $safe_keys, true ) ? $key : '[unrecognized_field_' . $index . ']';
            schema_shape_nodes( $item, $path . '.' . $label, $depth + 1, $nodes );
        }
    } else {
        $index = 0;
        foreach ( $value as $item ) {
            if ( $index >= 3 ) { break; }
            schema_shape_nodes( $item, $path . '[' . $index . ']', $depth + 1, $nodes );
            $index++;
        }
    }
}

function describe_content_structure( $value ) {
    $format = gettype( $value );
    if ( is_string( $value ) ) {
        $parsed = json_decode( $value, false, 16 );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            $format = 'json_string';
            $value = $parsed;
        } else {
            return array( 'format' => 'plain_or_invalid_json_string', 'nodes' => array( array( 'path' => '$', 'type' => 'string' ) ) );
        }
    }
    $nodes = array();
    schema_shape_nodes( $value, '$', 0, $nodes );
    return array( 'format' => $format, 'nodes' => $nodes, 'shape_is_bounded' => true );
}

function collect_premium_schema_evidence() {
    authorize_snapshot();
    $aliases = array( 'title', 'metadesc', 'focuskw', 'keywordsynonyms', 'focuskeywords' );
    $prefix = '_yoast_wpseo_';
    $out = array(
        'purpose' => 'Read-only schema evidence; not a target selection or write contract.',
        'registered_post_meta' => array(), 'populated_structure_samples' => array(),
        'phrase_text_values_exported' => false, 'normal_editor_save_verified' => false,
        'storage_contract_verified' => false,
        'limits' => array( 'published_candidates_per_key' => 5, 'metadata_keys_sampled' => 2, 'shape_nodes' => 80 ),
    );
    if ( function_exists( 'get_registered_meta_keys' ) ) {
        foreach ( array( '', 'product' ) as $subtype ) {
            $registered = get_registered_meta_keys( 'post', $subtype );
            $selected = array();
            foreach ( $aliases as $alias ) {
                $key = $prefix . $alias;
                if ( ! isset( $registered[ $key ] ) || ! is_array( $registered[ $key ] ) ) { continue; }
                $definition = $registered[ $key ]; $record = array();
                foreach ( array( 'type', 'single', 'object_subtype' ) as $name ) {
                    if ( array_key_exists( $name, $definition ) ) { $record[ $name ] = checked_value( $definition[ $name ] ); }
                }
                if ( isset( $definition['show_in_rest'] ) ) {
                    $record['show_in_rest'] = (bool) $definition['show_in_rest'];
                    if ( is_array( $definition['show_in_rest'] ) && isset( $definition['show_in_rest']['schema'] ) ) {
                        // Schema contents might include examples/defaults. Return their structure only.
                        $record['rest_schema_structure'] = describe_content_structure( wp_json_encode( $definition['show_in_rest']['schema'] ) );
                    }
                }
                foreach ( array( 'sanitize_callback', 'auth_callback' ) as $name ) {
                    if ( isset( $definition[ $name ] ) ) { $record[ $name ] = schema_callback_label( $definition[ $name ] ); }
                }
                $selected[ $key ] = $record;
            }
            $out['registered_post_meta'][ $subtype === '' ? 'all_post_subtypes' : $subtype ] = $selected;
        }
    } else { $out['registration_api_available'] = false; }
    if ( ! class_exists( 'WP_Query' ) ) {
        $out['sample_status'] = 'WordPress query API unavailable'; return $out;
    }
    foreach ( array( 'keywordsynonyms', 'focuskeywords' ) as $alias ) {
        $key = $prefix . $alias;
        $query = new \WP_Query( array(
            'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 5,
            'fields' => 'ids', 'orderby' => 'ID', 'order' => 'ASC', 'no_found_rows' => true,
            'update_post_meta_cache' => false, 'update_post_term_cache' => false, 'cache_results' => false,
            'meta_query' => array( array( 'key' => $key, 'value' => '', 'compare' => '!=' ) ),
        ) );
        $ids = array_slice( array_map( 'intval', $query->posts ), 0, 5 );
        $samples = array(); $skipped = 0;
        foreach ( $ids as $id ) {
            $post = get_post( $id );
            if ( ! current_user_can( 'edit_post', $id ) || ! $post || $post->post_type !== 'product' || $post->post_status !== 'publish' ) { $skipped++; continue; }
            $values = checked_value( get_post_meta( $id, $key, false ) );
            if ( ! is_array( $values ) ) { $skipped++; continue; }
            foreach ( array_slice( $values, 0, 1 ) as $value ) {
                if ( $value === '' || $value === null ) { continue; }
                $samples[] = array( 'reference_product_id' => $id, 'modified_gmt' => $post->post_modified_gmt,
                    'metadata_row_count' => count( $values ), 'structure' => describe_content_structure( $value ) );
            }
        }
        $out['populated_structure_samples'][ $key ] = array( 'candidates_returned' => count( $ids ),
            'skipped' => $skipped, 'samples' => $samples,
            'status' => $samples ? 'bounded_samples_found' : 'no_nonempty_sample_observed_within_limits' );
    }
    return $out;
}
