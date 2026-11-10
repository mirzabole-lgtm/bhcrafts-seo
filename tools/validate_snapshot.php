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
    echo json_encode( array( 'status' => 'verified', 'producer_version' => $report->diagnostics_plugin_version,
        'snapshot_sha256' => $expected, 'product_id' => 2839, 'attachments_verified' => count( $ids ),
        'yoast_states' => $states, 'checksums_are_not_a_signature' => true ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) . "\n";
} catch ( Throwable $error ) {
    fwrite( STDERR, 'Snapshot validation failed: ' . $error->getMessage() . "\n" );
    exit( 1 );
}
