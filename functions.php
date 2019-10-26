<?php
ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );

// VARIABLES
$functions_path = TEMPLATEPATH . '/functions/';
$version_number = "1.0";
define("FAVICON", get_bloginfo('template_directory') . '/images/' .'favicon.ico');

// Options panel settings
require_once ($functions_path . '/admin-options.php');
require_once ($functions_path . '/custom-options.php');
require_once ($functions_path . '/wpm-widget.php');

if (!get_page_by_title('Dashboard', 'OBJECT', 'page')) {
$dash = wp_insert_post( array(
  'post_author' => 1,
  'post_name' => 'dashboard',
  'post_status' => 'publish',
  'post_title' => 'Dashboard',
  'post_type' => 'page'
)); 
update_post_meta($dash, '_wp_page_template', 'tpl-dashboard.php');
}
if (!get_page_by_title('Profile', 'OBJECT', 'page')) {
$pro = wp_insert_post( array(
  'post_author' => 1,
  'post_name' => 'profile',
  'post_status' => 'publish',
  'post_title' => 'Profile',
  'post_type' => 'page'
));
update_post_meta($pro, '_wp_page_template', 'tpl-profile.php');
}
if (!get_page_by_title('Submit', 'OBJECT', 'page')) {
$submit = wp_insert_post( array(
  'post_author' => 1,
  'post_name' => 'submit',
  'post_status' => 'publish',
  'post_title' => 'Submit',
  'post_type' => 'page'
));
update_post_meta($submit, '_wp_page_template', 'tpl-submit.php');
}

function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = "http".$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

function email_spam($addy) { 
	$email = str_replace("@", "gd6j83ksl", $addy);
	$email = str_replace(".", "m3gd0374h", $addy);
	echo $email;
}

function wpm_filter($text) {
	$text = strip_tags($text);
	$text = trim($text);
	if (get_option("max_des") == ""){
		$char_limit = 1000;
	} else {
		$char_limit = get_option("max_des");
	}
	if( strlen( $text ) > $char_limit ) {
		$text = substr( $text, 0, $char_limit );
	}
	return $text;
}

function alphanumericAndSpace( $string )
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }

function wpm_check_email($email) {
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		return false;
	}
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function wpmarks_time($m_time) {
	$t_time = get_the_time(__('Y/m/d g:i:s A'));
	$time = get_post_time('G', true, $post);
	$time_diff = time() - $time;
	
	if ( $time_diff > 0 && $time_diff < 24*60*60 )
			$h_time = sprintf( __('%s ago', 'wpm'), human_time_diff( $time ) );
		else
			//$h_time = mysql2date(__('n/j/Y'), $m_time);	
			$h_time = mysql2date(get_option('date_format'), $m_time);
			echo $h_time;
}

function wpmarks_lightbox ($images) {
  $matches = explode(",", $images);
	foreach($matches as $var) {
		if ($var != "") {
			$thumb_var = str_replace(get_option('home')."/wp-content/uploads/wpmarks/", "", $var);
			$single_thumb_img_url = get_bloginfo('template_url')."/includes/img_resize.php?width=100&amp;height=100&amp;url=".$thumb_var;
			echo "<img style=\"margin: 0 auto; padding: 0 auto;\" src=\"$single_thumb_img_url\" class=\"media-object\" alt=\"".get_the_title()."\" title=\"".get_the_title()."\" /></a>"."\n";
		}
	}
}

function wpmarks_lightbox_single ($images) {
  $matches = explode(",", $images);
	foreach($matches as $var) {
		if ($var != "") {
			$thumb_var = str_replace(get_option('home')."/wp-content/uploads/wpmarks/", "", $var);
			$rep_img = array(".gif",".png",".jpg",".jpeg");
			$thumb_var_ni = str_replace($rep_img, "", $thumb_var);
			$thumb_var_ku = substr($thumb_var_ni, -9);
			$single_thumb_img_url = get_bloginfo('template_url')."/includes/img_resize.php?width=100&amp;height=100&amp;url=".$thumb_var;
			echo "<li style=\"margin-bottom:10px; margin-left: 10px;\"><a href=\"#$thumb_var_ku\" data-toggle=\"modal\" class=\"thumbnail\"><img src=\"$single_thumb_img_url\" alt=\"".get_the_title()."\" title=\"".get_the_title()."\" /></a></li>
			<div id=\"$thumb_var_ku\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
			<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button><h4>".get_the_title()."</h4></div>
			<div class=\"modal-body\"><center><img src=\"$var\" alt=\"".get_the_title()."\" title=\"".get_the_title()."\" /></center></div>
			<div class=\"modal-footer\"></div></div>"."\n";
		}
	}
}

// Checks if a user is logged in, if not redirects them to the login page
function auth_redirect_login() {
	$user = wp_get_current_user();
	if ( $user->id == 0 ) {
		nocache_headers();
		wp_redirect(get_option('siteurl') . '/wp-login.php');
		exit();
	}
}

add_action('wp_logout','go_home');
function go_home(){
  wp_redirect( home_url() );
  exit();
}

function validLink($link) {
    if(preg_match("/http:\/\//", $link)) {
        return true;
    } else {
        return false;
    } }

function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = stripos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
}

// injects custom stylesheet into the wpmarks options page in WordPress
function admin_head() { 
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/functions/admin-style.css" media="screen" />';
}

function wpmarks_options() {
	add_menu_page(__('WPMarks'), __('WPMarks','wpm'), 8, basename(__FILE__), 'wpmarks', FAVICON);
	add_submenu_page(basename(__FILE__), __('General Configuration','wpm'), __('Configure','wpm'), '10', basename(__FILE__), 'wpmarks');
	add_submenu_page(basename(__FILE__), __('Settings','wpm'), __('Settings','wpm'), '10', 'settings', 'wpmarks_settings');
	add_submenu_page(basename(__FILE__), __('Spam Filter','wpm'), __('Spam Filter','wpm'), '10', 'spam_filter', 'wpmarks_spam_filter');
	add_submenu_page(basename(__FILE__), __('Slider','wpm'), __('Slider','wpm'), '10', 'slider', 'wpmarks_slider');	
	add_submenu_page(basename(__FILE__), __('Images','wpm'), __('Images','wpm'), '10', 'images', 'wpmarks_images');

}


if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __('Sidebar Post','wpm'), 
        'before_widget' => '<ul class="nav nav-list">',
        'after_widget' => '</ul>',
        'before_title' => '<li class="divider"></li> <h4 class="nav-header">',
        'after_title' => '</h4> <li class="divider"></li>',
    ));
	
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __('Sidebar Home','wpm'), 
        'before_widget' => '<ul class="nav nav-list">',
        'after_widget' => '</ul>',
        'before_title' => '<li class="divider"></li> <h4 class="nav-header">',
        'after_title' => '</h4> <li class="divider"></li>',
    ));
	
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __('Sidebar Page','wpm'), 
        'before_widget' => '<ul class="nav nav-list">',
        'after_widget' => '</ul>',
        'before_title' => '<li class="divider"></li> <h4 class="nav-header">',
        'after_title' => '</h4> <li class="divider"></li>',
    ));
    
function new_contactmethods( $contactmethods ) {
  $contactmethods['twitter'] = 'Twitter'; // Add Twitter
  $contactmethods['gplus'] = 'Google+'; // Add Facebook
  $contactmethods['facebook'] = 'Facebook'; // Add Facebook
  unset($contactmethods['yim']); // Remove Yahoo IM
  unset($contactmethods['aim']); // Remove AIM
  unset($contactmethods['jabber']); // Remove Jabber

return $contactmethods;
}
add_filter('user_contactmethods','new_contactmethods',10,1);

function the_breadcrumb() {
	$separator = '&rsaquo;';
	$home = 'Home';
		echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumb">';
	global $post;
		echo 	'<span typeof="v:Breadcrumb"><i class="icon-home"></i>
				<a rel="v:url" property="v:title" href="';
		echo 	bloginfo('url');
		echo 	'">Home</a></span> ';
	$category = get_the_category();
	if ($category) {
		foreach($category as $category) {
			echo $separator . "<span typeof=\"v:Breadcrumb\">
			<a rel=\"v:url\" property=\"v:title\" href=\"".get_category_link($category->term_id)."\">$category->name</a></span> ";
		}
	}
	echo $separator . "<span typeof=\"v:Breadcrumb\"> ";
	echo the_title() . "</span>";
	echo '</div>';
}

// injects WPM version number in the header of the site. Used for troubleshooting and anonymous stats
function wpm_version($version_number) { 
global $version_number;
	echo "\n" .'<meta name="template" content="WPMarks '.$version_number.'" />' . "\n";
}
	
// hook into WordPress
add_action('wp_head', 'wpm_version');
add_action('admin_head', 'admin_head');
add_action('admin_menu', 'wpmarks_options');
add_filter('show_admin_bar', '__return_false'); 

add_action( 'init', 'create_url_taxonomies', 10);
function create_url_taxonomies() 
{
  $labels = array(
    'name'                         => _x( 'URL', 'taxonomy general name' ),
    'singular_name'                => _x( 'URL', 'taxonomy singular name' ),
    'search_items'                 => __( 'Search URL' ),
    'popular_items'                => __( 'Popular URL' ),
    'all_items'                    => __( 'All URL' ),
    'parent_item'                  => null,
    'parent_item_colon'            => null,
    'edit_item'                    => __( 'Edit URL' ), 
    'update_item'                  => __( 'Update URL' ),
    'add_new_item'                 => __( 'Add New URL' ),
    'new_item_name'                => __( 'New URL Name' ),
    'separate_items_with_commas'   => null,
    'add_or_remove_items'          => __( 'Add or remove URL' ),
    'choose_from_most_used'        => null,
    'not_found'                    => __( 'No URL found.' ),
    'menu_name'                    => __( 'URL' )
  ); 

  $args = array(
    'hierarchical'            => false,
    'labels'                  => $labels,
    'show_ui'                 => true,
    'show_admin_column'       => true,
    'update_count_callback'   => '_update_post_term_count',
    'query_var'               => true,
    'rewrite'                 => array( 'slug' => 'URL' )
  );

  register_taxonomy( 'URL', 'post', $args );
}

// voting function
function voting($id) {
global $user_ID;
$currentvotes = get_post_meta($id, 'votes', true);
$voters = get_post_meta($id, 'thevoters', true);
$voters = explode(",", $voters);
foreach($voters as $voter) {
	if($voter == $user_ID) $alreadyVoted = true;
}

if(!$currentvotes) $currentvotes = 0;
echo '<div class="vote span12 vote'.$id.'"><span class="vote_count">'.$currentvotes.'</span>';
if($user_ID && !$alreadyVoted) echo '<br /><a class="btn btn-primary" post="'.$id.'" user="'.$user_ID.'"><i class="icon-thumbs-up icon-white"></i> '.__("Vote").'</a>';
if($user_ID && $alreadyVoted) echo '<br /><a class="btn btn-success"><i class="icon-thumbs-up icon-white"></i> '.__("Voted").'</a>';
if(!$user_ID) echo '<a class="btn btn-primary" title="Register to vote this Article." href="'.get_bloginfo('url').'/wp-login.php?action=register"><i class="icon-thumbs-up icon-white"></i> '.__("Vote").'</a>';
echo '</div>';
}

function count_vote ($id) {
	global $user_ID;
	$countvotes = get_post_meta($id, 'votes', true);
	
	if(!$countvotes) $countvotes = 0;
	echo ' ('.$countvotes.' Votes)';
}

function add_markup($output) {
$patterns = array();
$patterns[0] = '/current-cat/';
$replacements = array();
$replacements[0] = 'active';
    return preg_replace($patterns, $replacements, $output);
}
add_filter('wp_list_categories', 'add_markup');

function add_nofollow_cat( $rel_cat ) { 
$rel_cat = str_replace('rel="category tag"', "", $rel_cat); 
    return $rel_cat; 
}
add_filter( 'the_category', 'add_nofollow_cat' );

/* Return object of shared counts */
function get_social_count( $link ) {
$r = (object)array();
$r->facebook = get_social_count_facebook($link);
$r->twitter = get_social_count_twitter($link);
$r->gplus = get_social_count_gplus($link);
return $r;
}
 
/* Return shared counts */
function get_social_count_facebook( $link ) {
$link = urlencode($link);
$data = file_get_contents("http://graph.facebook.com/?id=$link");
$json = json_decode($data, true);
$count = $json["shares"];
return $count ? $count : 0;
}
 
/* Return retweet counts */
function get_social_count_twitter( $link ) {
$link = urlencode($link);
$data = file_get_contents("http://urls.api.twitter.com/1/urls/count.json?url={$link}");
$json = json_decode($data, true);
$count = $json["count"];
return $count ? $count : 0;
}
 
/* Return shared counts */
function get_social_count_gplus( $link ) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.$link.'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
$data = curl_exec ($ch);
curl_close ($ch);
$json = json_decode($data, true);
$count = $json[0]['result']['metadata']['globalCounts']['count'];
return $count ? $count : 0;
}

/* Facebook comment */
function get_fb_comment_count() {
     global $post;
     $url = get_permalink($post->ID);
     $filecontent = file_get_contents('https://graph.facebook.com/?ids=' . $url);
     $json = json_decode($filecontent);
     $count = $json->$url->comments;
     if ($count == 0 || !isset($count)) {
          $count = '0 Response';
     } elseif ( $count == 1 ) {
          $count = '1 Response';
     } else {
          $count .= ' Response';
     }
     echo $count;
}

function getPostViews($postID){
    $count_key = 'post_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
   }
   return $count.' Views';
}
 
function setPostViews($postID) {
    $count_key = 'post_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
?>