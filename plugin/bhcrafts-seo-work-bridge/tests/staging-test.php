<?php
/** Isolated request and metadata fixtures. Run from the repository with PHP CLI. */
if ( PHP_SAPI !== 'cli' ) {
    exit;
}

use BHcrafts\SEO\WorkBridge as Bridge;

define( 'ABSPATH', __DIR__ . '/' );
define( 'ARRAY_A', 'ARRAY_A' );
class RequestStopped extends RuntimeException {}
class Receipt extends RuntimeException {
    public array $data;
    public function __construct( array $data, int $status ) {
        parent::__construct( $data['status'], $status );
        $this->data = $data;
    }
}

function add_action( $name, $callback ) { $GLOBALS['hooks'][$name] = $callback; }
function add_filter( $name, $callback, $priority, $args ) { $GLOBALS['filters'][$name] = $callback; }
function remove_filter( $name, $callback, $priority ) { unset( $GLOBALS['filters'][$name] ); }
function esc_html( $value ) { return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $value ) { return esc_html( $value ); }
function esc_url( $value ) { return esc_html( $value ); }
function current_user_can( $cap, $id = null ) {
    return ( 'manage_options' === $cap && $GLOBALS['administrator'] ) || ( 'edit_post' === $cap && $id === 2839 && $GLOBALS['can_edit'] );
}
function home_url( $path ) { return $GLOBALS['home']; }
function site_url( $path ) { return $GLOBALS['site']; }
function wp_parse_url( $url ) { return parse_url( $url ); }
function rest_url() { return $GLOBALS['home'] . 'wp-json/'; }
function wp_get_environment_type() { return $GLOBALS['environment']; }
function is_multisite() { return false; }
function get_option( $name ) { return $name === 'blog_public' ? $GLOBALS['blog_public'] : null; }
function get_bloginfo( $name ) { return 'fixture'; }
function get_plugins() {
    return array(
        'woocommerce/woocommerce.php' => array( 'Version' => 'fixture' ),
        'wordpress-seo/wp-seo.php' => array( 'Version' => '28.8' ),
        'wordpress-seo-premium/wp-seo-premium.php' => array( 'Version' => $GLOBALS['premium_version'] ),
    );
}
function is_plugin_active( $plugin ) { return $plugin !== $GLOBALS['inactive_plugin']; }
function wp_get_theme() {
    return new class {
        function parent() { return false; }
        function get_stylesheet() { return 'flatsome'; }
        function get( $key ) { return 'fixture'; }
    };
}
function get_post( $id ) { return $id === 2839 ? (object) $GLOBALS['post'] : null; }
function get_permalink( $id ) {
    if ( $id !== 2839 ) { throw new LogicException( 'Unexpected permalink read.' ); }
    return $GLOBALS['home'] . 'product/' . $GLOBALS['post']['post_name'] . '/';
}
function get_post_meta( $id, $key, $single ) {
    if ( 2839 !== $id || ! array_key_exists( $key, $GLOBALS['proposal']['before'] ) || $single ) {
        throw new LogicException( 'Unexpected metadata read.' );
    }
    return $GLOBALS['rows'][$key] ?? array();
}
function wp_cache_delete( $key, $group ) {}
function wp_json_encode( $data, $flags ) { return json_encode( $data, $flags ); }
function wp_die( $message, $title, $args ) { throw new RequestStopped( $message, $args['response'] ); }
function wp_slash( $value ) { return addslashes( $value ); }
function wp_unslash( $value ) { return stripslashes( $value ); }
function wp_verify_nonce( $nonce, $action ) { return hash_equals( hash( 'sha256', $action ), $nonce ); }
function wp_nonce_field( $action ) {
    echo '<input type="hidden" name="_wpnonce" value="' . hash( 'sha256', $action ) . '">';
    echo '<input type="hidden" name="_wp_http_referer" value="/wp-admin/tools.php">';
}
function submit_button( $label ) { echo '<input type="submit" name="submit" value="' . esc_attr( $label ) . '">'; }
function admin_url( $path ) { return $GLOBALS['site'] . 'wp-admin/' . $path; }
function nocache_headers() {}
function get_current_user_id() { return 19; }
function wp_send_json( $data, $status, $flags ) { throw new Receipt( $data, $status ); }
function update_post_meta( $id, $key, $value, $previous ) {
    $GLOBALS['attempts'][] = array( $id, $key, stripslashes( $value ), $previous );
    if ( 'disappears' === $GLOBALS['fault'] ) {
        unset( $GLOBALS['rows'][$key] );
        return $GLOBALS['filters']['add_post_metadata']( null, $id, $key );
    }
    if ( $GLOBALS['rows'][$key] !== array( $previous ) ) {
        return false;
    }
    $GLOBALS['rows'][$key] = array( stripslashes( $value ) );
    if ( 'hook_fails' === $GLOBALS['fault'] ) {
        throw new RuntimeException( 'Simulated third-party hook failure after saving.' );
    }
    return true;
}

require dirname( __DIR__, 2 ) . '/bhcrafts-seo-diagnostics/bhcrafts-seo-diagnostics.php';
require dirname( __DIR__ ) . '/bhcrafts-seo-work-bridge.php';

function check( $condition, $message ) {
    if ( ! $condition ) { throw new LogicException( $message ); }
    ++$GLOBALS['checks'];
}
function form( string $operation ): array {
    return array(
        'action' => Bridge\ACTION, 'operation' => $operation,
        '_wpnonce' => hash( 'sha256', Bridge\nonce_action( $operation ) ),
        '_wp_http_referer' => '/wp-admin/tools.php', 'backup_reference' => 'backup-test-001',
        'staging_checked' => 'yes', 'submit' => 'Approve reviewed change',
    );
}
function request( int $status, ?callable $handler = null ): array {
    try {
        ( $handler ?? 'BHcrafts\\SEO\\WorkBridge\\submit_test' )();
    } catch ( RequestStopped | Receipt $result ) {
        check( $result->getCode() === $status, 'Unexpected request status: ' . $result->getMessage() );
        return $result instanceof Receipt ? $result->data : array();
    }
    throw new LogicException( 'No request result.' );
}

$GLOBALS['checks'] = 0;
$GLOBALS['hooks'] ??= array();
$GLOBALS['filters'] = array();
$GLOBALS['attempts'] = array();
$GLOBALS['fault'] = '';
$GLOBALS['proposal'] = $proposal = Bridge\proposal();
$GLOBALS['home'] = $GLOBALS['site'] = $proposal['site'];
$GLOBALS['environment'] = 'staging';
$GLOBALS['blog_public'] = '0';
$GLOBALS['administrator'] = $GLOBALS['can_edit'] = true;
$GLOBALS['premium_version'] = '28.8';
$GLOBALS['inactive_plugin'] = '';
$path = dirname( __DIR__, 3 ) . '/docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Editor_Correction_2026-11-11.json';
$snapshot = json_decode( file_get_contents( $path ), true, 64, JSON_THROW_ON_ERROR );
$GLOBALS['post'] = array( 'post_type' => 'product', 'post_status' => 'publish', 'post_name' => $proposal['product_slug'],
    'post_content' => $snapshot['product']['long_description_raw'], 'post_excerpt' => $snapshot['product']['short_description_raw'] );
$baseline = array_column( $snapshot['yoast_evidence']['content_metadata'], 'wordpress_values' );
$GLOBALS['rows'] = $original = array_combine( array_keys( $snapshot['yoast_evidence']['content_metadata'] ), $baseline );
$key = Bridge\SYNONYMS_KEY;
check( $proposal['source_snapshot_sha256'] === $snapshot['snapshot_sha256'], 'Wrong proposal baseline.' );
check( $GLOBALS['rows'] === array_map( static fn( $value ) => array( $value ), $proposal['before'] ), 'Exact saved rows are required.' );
$before = json_decode( $original[$key][0], true, 16, JSON_THROW_ON_ERROR );
$after = json_decode( $proposal['proposed_value'], true, 16, JSON_THROW_ON_ERROR );
check( $before[0] === $after[0] . ',' && array_slice( $before, 1 ) === array_slice( $after, 1 ), 'Only the trailing comma should differ.' );
check( ! isset( $GLOBALS['hooks']['admin_post_nopriv_' . Bridge\ACTION] ), 'No unauthenticated action.' );
ob_start();
Bridge\render_page();
$preview = ob_get_clean();
check( strpos( $preview, 'name="submit"' ) !== false && strpos( $preview, 'name="backup_reference"' ) !== false, 'Preview contains the actual submit fields.' );
check( $GLOBALS['attempts'] === array(), 'Preview is read-only.' );

$_POST = form( 'apply' );
$_GET = array();
$_SERVER['REQUEST_METHOD'] = 'GET';
request( 405 );
$_SERVER['REQUEST_METHOD'] = 'POST';
foreach ( array( 'home' => 'https://bhcrafts.shop/', 'site' => 'https://bhcrafts.shop/', 'environment' => 'production',
    'blog_public' => '1', 'administrator' => false, 'can_edit' => false, 'premium_version' => '28.9',
    'inactive_plugin' => 'wordpress-seo-premium/wp-seo-premium.php' ) as $setting => $invalid ) {
    $saved = $GLOBALS[$setting];
    $GLOBALS[$setting] = $invalid;
    request( in_array( $setting, array( 'premium_version', 'inactive_plugin' ), true ) ? 409 : 403 );
    $GLOBALS[$setting] = $saved;
}
foreach ( array( 'id' => '616', 'submit' => array( 'injected' ), 'backup_reference' => '', 'staging_checked' => 'no' ) as $field => $invalid ) {
    $_POST = array_replace( form( 'apply' ), array( $field => $invalid ) );
    request( 400 );
}
$_POST = array_replace( form( 'apply' ), array( '_wpnonce' => form( 'restore' )['_wpnonce'] ) );
request( 403 );
$_POST = form( 'apply' );
$GLOBALS['rows'][$key][] = $original[$key][0];
request( 409 );
unset( $GLOBALS['rows'][$key] );
request( 409 );
$GLOBALS['rows'] = $original;
$GLOBALS['post']['post_content'] .= 'changed';
request( 409 );
$GLOBALS['post']['post_content'] = $snapshot['product']['long_description_raw'];
$GLOBALS['rows']['_yoast_wpseo_title'] = array( 'Concurrent title change' );
request( 409 );
$GLOBALS['rows'] = $original;
check( $GLOBALS['attempts'] === array(), 'Rejected requests must not attempt writes.' );

$receipt = request( 200 );
check( $receipt['all_five_rows_verified'] && $receipt['approved_by_user_id'] === 19 && $receipt['operation'] === 'apply', 'Verified approval receipt.' );
check( $GLOBALS['attempts'] === array( array( 2839, $key, $proposal['proposed_value'], $original[$key][0] ) ), 'Exactly one allowlisted write.' );
request( 409 );
check( count( $GLOBALS['attempts'] ) === 1, 'Replay must not write again.' );
$_POST = form( 'restore' );
$GLOBALS['rows'][$key] = array( 'New editor synonyms' );
request( 409 );
check( count( $GLOBALS['attempts'] ) === 1, 'Rollback rejects an intervening synonym change.' );
$GLOBALS['rows'][$key] = array( $proposal['proposed_value'] );
$GLOBALS['rows']['_yoast_wpseo_focuskeywords'] = array( 'Different editor-generated scores' );
request( 200 );
check( $GLOBALS['rows'][$key] === $original[$key] && $GLOBALS['rows']['_yoast_wpseo_focuskeywords'] === array( 'Different editor-generated scores' ), 'Restore only the prior synonym value.' );

$_POST = form( 'apply' );
$GLOBALS['rows'] = $original;
$GLOBALS['fault'] = 'disappears';
$failed = request( 409 );
check( ! isset( $GLOBALS['rows'][$key] ) && ! $failed['all_five_rows_verified'], 'Missing row during update is never inserted.' );
$GLOBALS['rows'] = $original;
$GLOBALS['fault'] = 'hook_fails';
$failed = request( 409 );
check( ! $failed['all_five_rows_verified'] && $failed['readback'] === array( $proposal['proposed_value'] ), 'Hook failure reports actual read-back and uncertainty.' );
check( $GLOBALS['filters'] === array(), 'Temporary insert guard is removed.' );

class IndexableDatabaseFixture {
    public string $prefix = 'custom_';
    public string $last_error = '';
    public bool $suppressed = false;
    public array $rows = array();
    public int $reads = 0;
    public bool $fail = false;
    public function prepare( $query, ...$params ) {
        if ( $params !== array( 'custom_yoast_indexable', 2839, 'post' )
            || $query !== 'SELECT object_sub_type, permalink, permalink_hash, title, description FROM %i WHERE object_id = %d AND object_type = %s ORDER BY id LIMIT 3' ) {
            throw new LogicException( 'Unexpected indexable query or scope.' );
        }
        return 'prepared-select';
    }
    public function get_results( $query, $format ) {
        if ( $query !== 'prepared-select' || $format !== ARRAY_A || ! $this->suppressed ) {
            throw new LogicException( 'Unexpected indexable query execution.' );
        }
        ++$this->reads;
        $this->last_error = $this->fail ? 'Fixture database error' : '';
        return $this->rows;
    }
    public function suppress_errors( bool $suppress ): bool {
        $previous = $this->suppressed;
        $this->suppressed = $suppress;
        return $previous;
    }
}

$GLOBALS['wpdb'] = $wpdb = new IndexableDatabaseFixture();
$download_report = $GLOBALS['hooks']['admin_post_' . Bridge\INDEXABLE_ACTION];
check( ! isset( $GLOBALS['hooks']['admin_post_nopriv_' . Bridge\INDEXABLE_ACTION] ), 'Report has no unauthenticated action.' );
check( strpos( $preview, 'value="' . Bridge\INDEXABLE_ACTION . '"' ) !== false && strpos( $preview, 'Download Yoast indexable report' ) !== false, 'Preview contains the report form.' );
$report_form = array( 'action' => Bridge\INDEXABLE_ACTION, '_wpnonce' => hash( 'sha256', Bridge\INDEXABLE_ACTION ),
    '_wp_http_referer' => '/wp-admin/tools.php', 'submit' => 'Download Yoast indexable report' );
$_POST = $report_form;
$_SERVER['REQUEST_METHOD'] = 'GET';
request( 405, $download_report );
$_SERVER['REQUEST_METHOD'] = 'POST';
$GLOBALS['environment'] = 'production';
request( 403, $download_report );
$GLOBALS['environment'] = 'staging';
$GLOBALS['can_edit'] = false;
request( 403, $download_report );
$GLOBALS['can_edit'] = true;
$_POST['_wpnonce'] = form( 'apply' )['_wpnonce'];
request( 403, $download_report );
$_POST = $report_form + array( 'product_id' => '616' );
request( 400, $download_report );
$_POST = array_replace( $report_form, array( 'submit' => array( 'unexpected' ) ) );
request( 400, $download_report );
check( $wpdb->reads === 0, 'Rejected requests do not read the indexable table.' );
$_POST = $report_form;
$writes_before = $GLOBALS['attempts'];
$missing = request( 200, $download_report );
check( $missing['status'] === 'missing' && $missing['indexable_rows'] === array(), 'Missing indexable is reported.' );
check( $missing['saved_title_values'] === $original['_yoast_wpseo_title'] && $missing['saved_description_values'] === $original['_yoast_wpseo_metadesc'], 'Saved values stay separate from indexable data.' );
$old = 'https://bhcrafts.shop/product/' . $proposal['product_slug'] . '/';
$wpdb->rows = array( array( 'object_sub_type' => 'product', 'permalink' => $old,
    'permalink_hash' => strlen( $old ) . ':' . md5( $old ), 'title' => 'Old title', 'description' => null ) );
$found = request( 200, $download_report );
check( $found['status'] === 'found' && $found['indexable_rows'][0]['permalink'] === $old, 'The exact stored permalink is returned.' );
check( array_filter( $found['indexable_rows'][0], 'is_bool' ) === array_fill_keys( array( 'matches_current_permalink', 'matches_current_permalink_hash', 'matches_saved_title', 'matches_saved_description' ), false ), 'Each mismatch is reported independently.' );
$url = $found['current_permalink'];
$matching = array( 'object_sub_type' => 'product', 'permalink' => $url, 'permalink_hash' => strlen( $url ) . ':' . md5( $url ),
    'title' => $original['_yoast_wpseo_title'][0], 'description' => $original['_yoast_wpseo_metadesc'][0] );
$wpdb->rows[] = $matching;
$multiple = request( 200, $download_report );
check( $multiple['status'] === 'multiple' && count( $multiple['indexable_rows'] ) === 2, 'Multiple records are distinguished.' );
check( count( array_filter( $multiple['indexable_rows'][1], static fn( $value ) => $value === true ) ) === 4, 'All exact matches are detected.' );
$wpdb->fail = true;
$failed = request( 200, $download_report );
check( $failed['status'] === 'query_failed' && $failed['indexable_rows'] === array(), 'Failed reads are distinct from missing records.' );
check( strpos( json_encode( $failed ), 'Fixture database error' ) === false && ! $wpdb->suppressed, 'Raw database error stays private and suppression is restored.' );
check( $GLOBALS['attempts'] === $writes_before, 'Report never attempts a metadata write.' );
echo 'PASS: ' . $GLOBALS['checks'] . " staging test fixture checks.\n";
