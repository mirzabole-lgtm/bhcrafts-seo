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
            if ( $index >= 4 ) { break; }
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
        'purpose' => 'Read-only evidence for the selected Yoast reference product.',
        'registered_post_meta' => array(),
        'phrase_text_values_exported' => false, 'normal_editor_save_verified' => false,
        'storage_contract_verified' => false,
        'limits' => array( 'reference_products' => 1, 'metadata_keys_sampled' => 5, 'shape_nodes' => 80 ),
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
    $reference_id = 616;
    $reference_slug = 'christmas-stocking-personalized';
    $reference = array( 'product_id' => $reference_id, 'slug' => $reference_slug, 'fields' => array() );
    if ( ! current_user_can( 'edit_post', $reference_id ) ) {
        $reference['status'] = 'access_denied';
    } else {
        $post = get_post( $reference_id );
        if ( ! $post || $post->post_type !== 'product' || $post->post_status !== 'publish' || $post->post_name !== $reference_slug ) {
            $reference['status'] = 'product_identity_not_verified';
        } else {
            $reference['status'] = 'read';
            $reference['modified_gmt'] = $post->post_modified_gmt;
            foreach ( $aliases as $alias ) {
                $key = $prefix . $alias;
                $exists = metadata_exists( 'post', $reference_id, $key );
                $values = $exists ? checked_value( get_post_meta( $reference_id, $key, false ) ) : array();
                if ( ! is_array( $values ) ) {
                    $reference['fields'][ $key ] = array( 'exists' => $exists, 'status' => 'unexpected_metadata_response' );
                    continue;
                }
                $field = array( 'exists' => $exists, 'row_count' => count( $values ) );
                if ( $values ) {
                    $value = reset( $values );
                    $field['first_row_empty'] = $value === '' || $value === null || $value === array();
                    $field['structure'] = describe_content_structure( $value );
                }
                $reference['fields'][ $key ] = $field;
            }
        }
    }
    $out['selected_reference'] = $reference;
    return $out;
}
