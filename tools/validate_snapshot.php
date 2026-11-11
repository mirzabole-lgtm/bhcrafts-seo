<?php
/** Offline integrity/scope validation. Reads one local JSON file; never writes WordPress. */
if ( PHP_SAPI !== 'cli' ) { exit; }
function require_snapshot_condition( $condition, $message ) {
    if ( ! $condition ) { throw new RuntimeException( $message ); }
}
function snapshot_digest( $value ) {
    $json = json_encode( $value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    require_snapshot_condition( $json !== false, 'Invalid JSON encoding.' );
    return hash( 'sha256', $json );
}
function read_yoast_string( $metadata, $alias ) {
    $row = $metadata->{'_yoast_wpseo_' . $alias} ?? null;
    require_snapshot_condition( $row && $row->exists === true && is_array( $row->wordpress_values ) &&
        count( $row->wordpress_values ) === 1 && is_string( $row->wordpress_values[0] ),
        'Expected one saved string for Yoast ' . $alias . '.' );
    return $row->wordpress_values[0];
}
function compare_yoast_proposal( $report, $path ) {
    require_snapshot_condition( is_file( $path ) && filesize( $path ) <= 10485760, 'Supply a local proposal JSON file of at most 10 MiB.' );
    $proposal = json_decode( file_get_contents( $path ), false, 512, JSON_THROW_ON_ERROR );
    $manifest = $proposal->manifest ?? null;
    require_snapshot_condition( ( $manifest->product_id ?? null ) === $report->product->id &&
        is_string( $manifest->environment ?? null ) && rtrim( $manifest->environment, '/' ) === rtrim( $report->environment_report->environment->home_url, '/' ),
        'The proposal targets a different product or environment.' );
    $plugins = $report->environment_report->plugins;
    require_snapshot_condition( $plugins->yoast_seo->version === '28.8' && $plugins->yoast_premium->version === '28.8' &&
        $plugins->yoast_seo->active === true && $plugins->yoast_premium->active === true,
        'This comparison covers active Yoast SEO and Premium 28.8 only.' );

    $metadata = $report->yoast_evidence->content_metadata;
    $related = json_decode( read_yoast_string( $metadata, 'focuskeywords' ), false, 512, JSON_THROW_ON_ERROR );
    $synonyms = json_decode( read_yoast_string( $metadata, 'keywordsynonyms' ), false, 512, JSON_THROW_ON_ERROR );
    require_snapshot_condition( is_array( $related ) && count( $related ) === 4 && is_array( $synonyms ) && count( $synonyms ) === 5,
        'Expected four saved related keyphrases and five synonym slots.' );

    $actual = array( 'SEO title' => read_yoast_string( $metadata, 'title' ), 'Meta description' => read_yoast_string( $metadata, 'metadesc' ) );
    $draft = $proposal->proposed ?? null;
    $expected = array( 'SEO title' => $draft->seo_title ?? null, 'Meta description' => $draft->meta_description ?? null );
    $phrases = $draft->keyphrases ?? null;
    require_snapshot_condition( is_string( $expected['SEO title'] ) && is_string( $expected['Meta description'] ) &&
        is_array( $phrases ) && count( $phrases ) === 5, 'The proposal must contain the two SEO text fields and five keyphrase entries.' );
    // Compare the proposed positional mapping. Yoast's related-phrase scores are outside the proposal.
    foreach ( $phrases as $index => $entry ) {
        $label = $index === 0 ? 'Primary' : 'Related ' . $index;
        $phrase = $index === 0 ? read_yoast_string( $metadata, 'focuskw' ) : ( $related[$index - 1]->keyword ?? null );
        require_snapshot_condition( is_string( $phrase ) && is_string( $synonyms[$index] ), 'Invalid saved values for ' . $label . '.' );
        require_snapshot_condition( ( $entry->role ?? null ) === $label && is_string( $entry->phrase ?? null ) &&
            is_array( $entry->synonyms ?? null ) && count( array_filter( $entry->synonyms, 'is_string' ) ) === count( $entry->synonyms ),
            'Invalid proposal values for ' . $label . '.' );
        $actual[$label . ' keyphrase'] = $phrase;
        $actual[$label . ' synonyms'] = $synonyms[$index];
        $expected[$label . ' keyphrase'] = $entry->phrase;
        $expected[$label . ' synonyms'] = implode( ', ', $entry->synonyms );
    }

    $differences = array();
    foreach ( $expected as $field => $value ) {
        if ( $actual[$field] !== $value ) {
            $differences[$field] = array( 'expected' => $value, 'saved' => $actual[$field] );
        }
    }
    return array( 'status' => $differences ? 'mismatch' : 'match', 'differences' => (object) $differences );
}
try {
    require_snapshot_condition( isset( $argv[1] ) && is_file( $argv[1] ) && filesize( $argv[1] ) <= 10485760, 'Supply one local snapshot JSON file of at most 10 MiB.' );
    $report = json_decode( file_get_contents( $argv[1] ) );
    require_snapshot_condition( $report instanceof stdClass && json_last_error() === JSON_ERROR_NONE, 'Invalid snapshot JSON.' );
    require_snapshot_condition( isset( $report->report_schema, $report->snapshot_sha256 ) && $report->report_schema === 'bhcrafts-seo-product-snapshot/1', 'Unexpected report schema.' );
    $expected = $report->snapshot_sha256;
    unset( $report->snapshot_sha256 );
    require_snapshot_condition( snapshot_digest( $report ) === $expected, 'Snapshot checksum mismatch.' );
    require_snapshot_condition( $report->mode === 'read_only' && $report->coverage->any_content_writes_performed === false, 'Snapshot is outside the read-only workflow.' );
    $environment = $report->environment_report->environment;
    require_snapshot_condition( $environment->home_url === 'https://stg-bhcraftsshop-affiliate.kinsta.cloud/' && $environment->site_url === $environment->home_url, 'Wrong environment.' );
    require_snapshot_condition( $report->product->id === 2839 && $report->product->slug === 'knit-handbag-with-dolls-applique', 'Wrong product identity.' );
    require_snapshot_condition( $report->selection->actual_parent_image_order === array(2841,2843,2844,2842,2845,445,357), 'Gallery baseline drift requires review.' );
    require_snapshot_condition( $report->selection->observed_variation_ids === array(2840), 'Variation baseline drift requires review.' );
    require_snapshot_condition( snapshot_digest( array( $report->product->long_description_raw, $report->product->short_description_raw ) ) === $report->product->raw_content_sha256, 'Raw content checksum mismatch.' );
    $ids = array();
    foreach ( $report->attachments as $attachment ) {
        require_snapshot_condition( $attachment->status === 'read', 'An attachment baseline is incomplete.' );
        $ids[] = $attachment->id;
        require_snapshot_condition( snapshot_digest( array( $attachment->title_raw, $attachment->caption_raw, $attachment->description_raw, $attachment->alt_text_metadata ) ) === $attachment->baseline_sha256, 'Attachment checksum mismatch.' );
    }
    require_snapshot_condition( $ids === array(2841,2843,2844,2842,2845,445,357,577), 'Attachment scope drift requires review.' );
    $states = array();
    foreach ( $report->yoast_evidence->content_metadata as $key => $record ) {
        require_snapshot_condition( snapshot_digest( array( 'exists' => $record->exists, 'wordpress_values' => $record->wordpress_values ) ) === $record->sha256, 'Yoast metadata checksum mismatch.' );
        $states[ $key ] = ! $record->exists ? 'absent' : ( $record->wordpress_values === array('') ? 'present_empty' : 'present_with_values' );
    }
    require_snapshot_condition( count( $states ) === 5, 'The selected five Yoast baseline records are incomplete.' );
    $result = array( 'status' => 'verified', 'producer_version' => $report->diagnostics_plugin_version,
        'snapshot_sha256' => $expected, 'product_id' => 2839, 'attachments_verified' => count( $ids ),
        'yoast_states' => $states, 'checksums_are_not_a_signature' => true );
    if ( isset( $argv[2] ) ) {
        require_snapshot_condition( $argc === 4 && $argv[2] === '--yoast-proposal', 'Use --yoast-proposal followed by one proposal JSON file.' );
        $result['yoast_proposal_comparison'] = compare_yoast_proposal( $report, $argv[3] );
    }
    echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n";
    exit( ( $result['yoast_proposal_comparison']['status'] ?? '' ) === 'mismatch' ? 1 : 0 );
} catch ( Throwable $error ) {
    fwrite( STDERR, 'Snapshot validation failed: ' . $error->getMessage() . "\n" );
    exit( 1 );
}
