<?php
if ( PHP_SAPI !== 'cli' ) { exit; }
// Isolated fixtures only. No WordPress database or network calls are made.
define( 'ABSPATH', __DIR__ . '/fake-wordpress/' );
class TestDenied extends RuntimeException {}
$GLOBALS['allowed'] = true;
$GLOBALS['denied_objects'] = array();
$GLOBALS['home'] = 'https://stg-bhcraftsshop-affiliate.kinsta.cloud/';
$GLOBALS['site'] = $GLOBALS['home'];
$GLOBALS['nonce_valid'] = true;
$GLOBALS['nonce_scope'] = null;
$GLOBALS['hooks'] = array();
$GLOBALS['tests'] = 0;
$GLOBALS['reads'] = array();
function esc_html( $v ) { return htmlspecialchars( $v, ENT_QUOTES, 'UTF-8' ); }
function current_user_can( $cap, $id = null ) {
    return $GLOBALS['allowed'] && in_array( $cap, array( 'manage_options', 'edit_post' ), true ) && ! in_array( $id, $GLOBALS['denied_objects'], true );
}
function home_url( $p = '' ) { return $GLOBALS['home']; }
function site_url( $p = '' ) { return $GLOBALS['site']; }
function wp_parse_url( $url, $part = -1 ) { return parse_url( $url, $part ); }
function wp_die( $message, $title = '', $args = array() ) { throw new TestDenied( $message, isset( $args['response'] ) ? $args['response'] : 403 ); }
function add_action( $hook, $callback ) { $GLOBALS['hooks'][ $hook ] = $callback; }
function get_plugins() {
    return array(
        'woocommerce/woocommerce.php' => array( 'Version' => '11.2.2-fixture' ),
        'wordpress-seo/wp-seo.php' => array( 'Version' => '28.8-fixture' ),
        'wordpress-seo-premium/wp-seo-premium.php' => array( 'Version' => '28.8-premium-fixture' ),
        'unrelated/private.php' => array( 'Version' => 'SECRET-SENTINEL' ),
    );
}
function is_plugin_active( $file ) { return true; }
class ThemeFixture {
    function parent() { return false; }
    function get_stylesheet() { return 'flatsome'; }
    function get_template() { return 'flatsome'; }
    function get( $field ) { return '3.20.11'; }
}
function wp_get_theme() { return new ThemeFixture(); }
function rest_url() { return $GLOBALS['home'] . 'wp-json/'; }
function wp_get_environment_type() { return 'staging'; }
function get_bloginfo( $field ) { return '7.1.4-fixture'; }
function is_multisite() { return false; }
function get_option( $name ) {
    if ( 'blog_public' !== $name ) { throw new RuntimeException( 'Unexpected option read: ' . $name ); }
    return '0';
}
function wp_is_application_passwords_available() { return true; }
function wp_json_encode( $value, $flags = 0 ) { return json_encode( $value, $flags ); }
function nocache_headers() {}
function check_admin_referer( $action ) {
    if ( ! $GLOBALS['nonce_valid'] || ( $GLOBALS['nonce_scope'] !== null && $GLOBALS['nonce_scope'] !== $action ) ) { throw new TestDenied( 'Invalid nonce', 403 ); }
    return 1;
}
class WPSEO_Meta {
    public static $meta_prefix = '_yoast_wpseo_';
    public static $meta_fields = array('general' => array(
        'title'=>array('type'=>'text','default_value'=>''),
        'metadesc'=>array('type'=>'textarea','default_value'=>''),
        'focuskw'=>array('type'=>'text','default_value'=>''),
        'keywordsynonyms'=>array('type'=>'hidden','default_value'=>''),
        'focuskeywords'=>array('type'=>'hidden','default_value'=>''),
        'focus_secret'=>array('type'=>'text','default_value'=>'SECRET-SENTINEL'),
    ));
}
class WC_Product_Attribute {
    function get_id(){return 0;}
    function get_name(){return 'Color';}
    function get_options(){return array('Black','Green');}
    function get_visible(){return true;}
    function get_variation(){return true;}
}
class ProductFixture {
    public $id;
    function __construct($id){$this->id=$id;}
    function get_type(){return $this->id===2839?'variable':'variation';}
    function get_image_id($context='view'){return 2841;}
    function get_gallery_image_ids($context='view'){return $this->id===2839?array(2843,2844,2842,2845,445,357):array();}
    function get_children(){return $GLOBALS['children'];}
    function get_attributes($context='view'){return $this->id===2839?array('Color'=>new WC_Product_Attribute()):array('color'=>'');}
    function get_parent_id($context='view'){return $this->id===2839?0:$GLOBALS['variation_parent'];}
    function get_name($context='view'){return 'Knitted Bag with Three-Doll Applique';}
    function get_slug($context='view'){return $this->id===2839?'knit-handbag-with-dolls-applique':'variation-2840';}
    function get_status($context='view'){return 'publish';}
    function get_regular_price($context='view'){return 'PRIVATE-COMMERCIAL-SENTINEL';}
}
$GLOBALS['children']=array(2840);
$GLOBALS['variation_parent']=2839;
$GLOBALS['wrong_type']=false;
$GLOBALS['bad_scalar_metadata']=false;
$GLOBALS['posts']=array();
foreach(array(2839,2840,2841,2843,2844,2842,2845,445,357,577) as $id){
 $GLOBALS['posts'][$id]=(object)array(
  'ID'=>$id,'post_type'=>$id===2839?'product':($id===2840?'product_variation':'attachment'),
  'post_name'=>$id===2839?'knit-handbag-with-dolls-applique':'fixture-'.$id,
  'post_title'=>$id===2839?'Knitted Bag with Three-Doll Applique':'Image '.$id,
  'post_status'=>'publish','post_modified_gmt'=>'2026-11-10 14:15:50',
  'post_content'=>$id===2839?'<p>Čuvaj tekst i apostrophe’s. MORE INFORMATION ABOUT ARTISANS <img src="artisan-handmade-tag.jpg" alt="Tag"></p>':'Description čćž',
  'post_excerpt'=>'Caption “quoted” čćž',
 );
}
$GLOBALS['meta']=array(2839=>array(
 '_yoast_wpseo_title'=>array(''),
 '_yoast_wpseo_focuskw'=>array('knitted cotton handbag'),
 '_yoast_wpseo_keywordsynonyms'=>array('cotton knit bag, torba čćž'),
 '_yoast_wpseo_focuskeywords'=>array('[{"keyword":"doll bag","synonyms":"doll\u2019s bag"}]'),
 '_yoast_wpseo_focus_secret'=>array('SECRET-SENTINEL'),
 '_yoast_wpseo_canonical'=>array('SECRET-SENTINEL'),
 '_private_api_key'=>array('SECRET-SENTINEL'),
));
foreach(array(2841,2843,2844,2842,2845,445,357,577) as $id){$GLOBALS['meta'][$id]=array('_wp_attachment_image_alt'=>array('Alt čćž'));}
function get_post($id){return isset($GLOBALS['posts'][$id])?clone $GLOBALS['posts'][$id]:null;}
function get_permalink($id){return $GLOBALS['home'].'product/knit-handbag-with-dolls-applique/';}
function wc_get_product($id){return isset($GLOBALS['posts'][$id])?new ProductFixture($id):false;}
function wp_get_attachment_url($id){return $GLOBALS['home'].'wp-content/uploads/'.($id===577?'2020/10/artisan-handmade-tag.jpg':'2021/04/image-'.$id.'.jpg');}
function get_post_custom_keys($id){return isset($GLOBALS['meta'][$id])?array_keys($GLOBALS['meta'][$id]):array();}
function metadata_exists($type,$id,$key){return isset($GLOBALS['meta'][$id])&&array_key_exists($key,$GLOBALS['meta'][$id]);}
function get_post_meta($id,$key,$single=false){
 if($key===''||strpos($key,'secret')!==false||$key==='_private_api_key'||$key==='_yoast_wpseo_canonical'){throw new RuntimeException('Forbidden meta value read: '.$key);}
 $GLOBALS['reads'][]=array($id,$key);
 if($GLOBALS['bad_scalar_metadata'])return 'unexpected scalar';
 $v=metadata_exists('post',$id,$key)?$GLOBALS['meta'][$id][$key]:array();
 return $single?(isset($v[0])?$v[0]:''):$v;
}
function get_registered_meta_keys($type,$subtype=''){
 if($type!=='post'||!in_array($subtype,array('','product'),true)){throw new RuntimeException('Unexpected registry scope');}
 return array('_yoast_wpseo_focuskeywords'=>array('type'=>'string','single'=>true,'show_in_rest'=>false,'default'=>'SECRET-SENTINEL','sanitize_callback'=>array('ExamplePlugin','sanitize')));
}
class WP_Query {
 public $posts;
 function __construct($args){
  if($args['post_type']!=='product'||$args['post_status']!=='publish'||$args['posts_per_page']!==5||$args['fields']!=='ids'||!$args['no_found_rows']){throw new RuntimeException('Unexpected sample query scope');}
  if(!in_array($args['meta_query'][0]['key'],array('_yoast_wpseo_keywordsynonyms','_yoast_wpseo_focuskeywords'),true)){throw new RuntimeException('Unexpected sample metadata key');}
  $this->posts=array(5001,5002);
 }
}
foreach(array(5001,5002) as $id){$GLOBALS['posts'][$id]=clone $GLOBALS['posts'][2839];$GLOBALS['posts'][$id]->ID=$id;}
$GLOBALS['posts'][5002]->post_status='draft';
$GLOBALS['meta'][5001]=array('_yoast_wpseo_keywordsynonyms'=>array('PHRASE-SECRET-SENTINEL'),'_yoast_wpseo_focuskeywords'=>array('[{"keyword":"PHRASE-SECRET-SENTINEL","score":99,"synonyms":"PRIVATE-SYNONYMS"}]'));
$GLOBALS['meta'][5002]=$GLOBALS['meta'][5001];
require dirname(__DIR__).'/bhcrafts-seo-diagnostics.php';
function check($condition,$label){if(!$condition){throw new RuntimeException('FAIL: '.$label);}++$GLOBALS['tests'];}
function denies($callback,$status,$label){try{$callback();}catch(TestDenied $e){check($e->getCode()===$status,$label);return;}throw new RuntimeException('FAIL: expected denial for '.$label);}
$ns='BHcrafts\\SEO\\Diagnostics\\';
foreach($GLOBALS['hooks'] as $callback){check(is_callable($callback),'registered callback resolves');}
check(count($GLOBALS['hooks'])===3,'only admin menu and authenticated export hooks registered');
foreach(array_keys($GLOBALS['hooks']) as $hook){check(strpos($hook,'nopriv')===false,'no anonymous export hook');}
check(($ns.'is_designated_staging')(),'designated staging accepted');
$original=$GLOBALS['home'];
foreach(array('https://bhcrafts.shop/','https://stg-bhcraftsshop-affiliate.kinsta.cloud.evil.test/','http://stg-bhcraftsshop-affiliate.kinsta.cloud/','https://user:password@stg-bhcraftsshop-affiliate.kinsta.cloud/','https://stg-bhcraftsshop-affiliate.kinsta.cloud:444/') as $bad){
 $GLOBALS['home']=$bad;
 check(!($ns.'is_designated_staging')(),'reject wrong host, scheme, credentials or port');
 denies($ns.'collect_product_snapshot',403,'deny snapshot on wrong environment');
}
$GLOBALS['home']=$original;$GLOBALS['site']='https://bhcrafts.shop/';
check(!($ns.'is_designated_staging')(),'mixed live/staging URL rejected');
$GLOBALS['site']=$original;$GLOBALS['allowed']=false;
foreach(array('collect_report','render_tools_page','download_report','collect_product_snapshot','download_product_snapshot') as $f){denies($ns.$f,403,'deny non-admin '.$f);}
$GLOBALS['allowed']=true;
$GLOBALS['denied_objects']=array(2839);
denies($ns.'collect_product_snapshot',403,'deny inaccessible selected product');
$GLOBALS['denied_objects']=array(2840);
denies($ns.'collect_product_snapshot',403,'deny inaccessible variation');
$GLOBALS['denied_objects']=array(577);
denies($ns.'collect_product_snapshot',403,'deny inaccessible attachment');
$GLOBALS['denied_objects']=array();
$_SERVER['REQUEST_METHOD']='GET';$_POST=array();$_GET=array();
denies($ns.'download_product_snapshot',405,'deny GET product download');
$_SERVER['REQUEST_METHOD']='POST';$_POST=array('action'=>constant($ns.'SNAPSHOT_ACTION'),'product_id'=>999);
denies($ns.'download_product_snapshot',400,'reject arbitrary product ID input');
$_POST=array('action'=>constant($ns.'SNAPSHOT_ACTION'),'submit'=>array('unexpected'));
denies($ns.'download_product_snapshot',400,'reject array submit button input');
$_POST=array('action'=>array('bad'));
denies($ns.'download_product_snapshot',400,'reject array action input');
$_POST=array('action'=>constant($ns.'SNAPSHOT_ACTION'));$_GET=array('id'=>999);
denies($ns.'download_product_snapshot',400,'reject query inputs');
$_GET=array();$GLOBALS['nonce_valid']=false;
denies($ns.'download_product_snapshot',403,'deny invalid product nonce');
$GLOBALS['nonce_valid']=true;
$GLOBALS['nonce_scope']=constant($ns.'EXPORT_ACTION');
denies($ns.'download_product_snapshot',403,'reject environment nonce for product export');
$GLOBALS['nonce_scope']=null;
$slug=$GLOBALS['posts'][2839]->post_name;$GLOBALS['posts'][2839]->post_name='other-product';
denies($ns.'collect_product_snapshot',409,'reject reused product ID with different slug');
$GLOBALS['posts'][2839]->post_name=$slug;
$type=$GLOBALS['posts'][2839]->post_type;$GLOBALS['posts'][2839]->post_type='shop_order';
denies($ns.'collect_product_snapshot',409,'reject wrong selected post type');
$GLOBALS['posts'][2839]->post_type=$type;
$GLOBALS['variation_parent']=999;
denies($ns.'collect_product_snapshot',409,'reject unrelated variation');
$GLOBALS['variation_parent']=2839;$GLOBALS['children']=range(1,26);
denies($ns.'collect_product_snapshot',409,'reject excessive variation count');
$GLOBALS['children']=array(2840);
$report=($ns.'collect_product_snapshot')();
check($report['selection']['product_id']===2839,'fixed product exported');
check(count($report['attachments'])===8,'eight expected attachments exported');
check($report['selection']['inspection_parent_image_order_matches']===true,'gallery order preserved');
check($report['selection']['inspection_variation_ids_match']===true,'variation identity preserved');
check($report['product']['long_description_raw']===$GLOBALS['posts'][2839]->post_content,'raw HTML, Unicode and apostrophe preserved');
check($report['attachments'][0]['caption_raw']==='Caption “quoted” čćž','caption raw text preserved');
$ym=$report['yoast_evidence']['content_metadata'];
check($ym['_yoast_wpseo_title']['exists']===true&&$ym['_yoast_wpseo_title']['wordpress_values']===array(''),'present empty value retained');
check($ym['_yoast_wpseo_metadesc']['exists']===false&&$ym['_yoast_wpseo_metadesc']['wordpress_values']===array(),'absent value distinguished');
check($ym['_yoast_wpseo_focuskeywords']['wordpress_values']===$GLOBALS['meta'][2839]['_yoast_wpseo_focuskeywords'],'Premium JSON string not decoded or rewritten');
check(strpos(json_encode($report),'SECRET-SENTINEL')===false,'unrelated values and registry defaults excluded');
check(strpos(json_encode($report),'PRIVATE-COMMERCIAL-SENTINEL')===false,'protected commercial value represented only by hash');
check($report['coverage']['yoast_field_mapping_verified']===false,'mapping not fabricated');
check($report['coverage']['cloud_authenticated_connection_established']===false,'API connection not fabricated');
check($report['coverage']['any_content_writes_performed']===false,'write status accurate');
check($report['artisan_preservation_evidence']['attachment_url_path_matches']===true,'tag identity path checked');
check(strlen($report['snapshot_sha256'])===64,'snapshot hash present');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array('one','two');
$multi=($ns.'collect_product_snapshot')();
check($multi['yoast_evidence']['content_metadata']['_yoast_wpseo_focuskw']['wordpress_values']===array('one','two'),'duplicate metadata rows preserved');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array('knitted cotton handbag');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskeywords']=array((object)array('bad'=>'object'));
denies($ns.'collect_product_snapshot',409,'reject object metadata values');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskeywords']=array('[{"keyword":"doll bag","synonyms":"doll\u2019s bag"}]');
$GLOBALS['bad_scalar_metadata']=true;
denies($ns.'collect_product_snapshot',409,'reject malformed metadata filter output');
$GLOBALS['bad_scalar_metadata']=false;
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array(str_repeat('x',1048577));
denies($ns.'collect_product_snapshot',409,'reject oversized field');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array('knitted cotton handbag');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array("invalid\xFF");
denies($ns.'collect_product_snapshot',409,'reject invalid UTF-8 before WordPress JSON sanitization');
$GLOBALS['meta'][2839]['_yoast_wpseo_focuskw']=array('knitted cotton handbag');
$old=$GLOBALS['posts'][2842];unset($GLOBALS['posts'][2842]);
$missing=($ns.'collect_product_snapshot')();
check($missing['attachments'][3]['status']==='missing_or_wrong_type','missing image held explicitly');
$GLOBALS['posts'][2842]=$old;
$registry=WPSEO_Meta::$meta_fields;WPSEO_Meta::$meta_fields=array();
$unknown=($ns.'collect_product_snapshot')();
check(isset($unknown['yoast_evidence']['content_metadata']['_yoast_wpseo_focuskeywords']),'stored allowed content key found without registered definition');
WPSEO_Meta::$meta_fields=$registry;
$schema=($ns.'collect_premium_schema_evidence')();
$sample=$schema['populated_structure_samples']['_yoast_wpseo_focuskeywords'];
check(count($sample['samples'])===1&&$sample['skipped']===1,'only permitted published source sampled');
check($sample['samples'][0]['reference_product_id']===5001,'schema source ID labelled separately from target selection');
check($sample['samples'][0]['structure']['format']==='json_string','existing JSON representation identified');
$paths=array_column($sample['samples'][0]['structure']['nodes'],'path');
check(in_array('$[0].keyword',$paths,true)&&in_array('$[0].score',$paths,true)&&in_array('$[0].synonyms',$paths,true),'actual field names retained as structure evidence');
check(strpos(json_encode($schema),'PHRASE-SECRET-SENTINEL')===false&&strpos(json_encode($schema),'PRIVATE-SYNONYMS')===false,'reference phrases and synonyms excluded');
check(strpos(json_encode($schema),'SECRET-SENTINEL')===false,'registered defaults excluded');
check($schema['registered_post_meta']['product']['_yoast_wpseo_focuskeywords']['type']==='string','actual registration type retained');
check($schema['registered_post_meta']['product']['_yoast_wpseo_focuskeywords']['sanitize_callback']==='ExamplePlugin::sanitize','callback identity recorded without invocation');
check($schema['storage_contract_verified']===false&&$schema['normal_editor_save_verified']===false,'schema sample does not claim editor or write verification');
$masked=($ns.'describe_content_structure')('{"PRIVATE-PHRASE":"PRIVATE-SYNONYMS"}');
check(strpos(json_encode($masked),'PRIVATE-')===false,'unknown object keys and values redacted');
$native=($ns.'describe_content_structure')(array('keyword'=>'PRIVATE-PHRASE','synonyms'=>'PRIVATE-SYNONYMS'));
check($native['nodes'][0]['type']==='associative_array'&&in_array('$.keyword',array_column($native['nodes'],'path'),true)&&strpos(json_encode($native),'PRIVATE-')===false,'native associative-array field names retained without values');
$invalid=($ns.'describe_content_structure')('non-JSON private phrase');
check($invalid['format']==='plain_or_invalid_json_string'&&strpos(json_encode($invalid),'private phrase')===false,'non-JSON values remain redacted');
$GLOBALS['denied_objects']=array(5001);
$none=($ns.'collect_premium_schema_evidence')();
check($none['populated_structure_samples']['_yoast_wpseo_focuskeywords']['status']==='no_nonempty_sample_observed_within_limits','inaccessible sources skipped without guessing');
$GLOBALS['denied_objects']=array();
$source=file_get_contents(dirname(__DIR__).'/bhcrafts-seo-diagnostics.php').file_get_contents(dirname(__DIR__).'/includes/product-export.php');
$source.=file_get_contents(dirname(__DIR__).'/includes/premium-evidence.php');
check(!preg_match('/\\b(update_option|add_option|delete_option|wp_update_post|wp_insert_post|update_post_meta|delete_post_meta|wp_remote_get|wp_remote_post|wp_remote_request|register_rest_route|register_activation_hook|wp_delete_attachment)\\s*\\(/',$source),'no persistence, HTTP, public REST, activation or delete calls');
check(strpos($source,'do_shortcode(')===false,'stored shortcodes never executed');
if(isset($argv[1])&&'export'===$argv[1]){
 // WordPress submit_button() sends its default submit name/value with the nonce fields.
 $_POST=array('action'=>constant($ns.'SNAPSHOT_ACTION'),'_wpnonce'=>'fixture-product-nonce','_wp_http_referer'=>'/wp-admin/tools.php?page=bhcrafts-seo-diagnostics','submit'=>'Download product 2839 snapshot');
 ($ns.'download_product_snapshot')();
}
echo 'PASS: '.$GLOBALS['tests']." checks (isolated fixtures, not full WordPress integration).\n";
