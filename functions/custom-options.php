<?php

//wpmarks register, login, and forgot password themed pages

// $error = sprintf(__("Unable to place the user photo at: %s", 'user-photo'), $imagepath);

function wpm_login_init() {
	require( ABSPATH . '/wp-load.php' );
		
	if (isset($_REQUEST["action"])) {
		$action = $_REQUEST["action"];
	} else {
		$action = 'login';
	}
	
	switch($action) {
		case 'lostpassword' :
		case 'retrievepassword' :
			wpm_password();
			break;
		case 'register':
			wpm_show_register();
			break;
		case 'login':
		default:
			wpm_show_login();
			break;
	}
	die();
}


function wpm_head($wpm_msg) {
	global $wpm_options;
	include(TEMPLATEPATH . '/header.php');
	
	echo "<div class='container-fluid'><div class='row-fluid'><div class='span8'>";
	echo "<legend>".__($wpm_msg)."</legend>";
}

function wpm_title($title) {
	global $pagenow;
	if ($pagenow == "wp-login.php") {
		switch($_GET['action']) {
			case 'register':
				$title = __('Sign Up at ','wpm');
				break;
			case 'lostpassword':
				$title = __('Retrieve your lost password for ','wpm');
				break;
			case 'login':
			default:
				$title = __('Sign In at ','wpm');
				break;
		}
	} else if ($pagenow == "profile.php") {
		$title = __('Your Profile at ','wpm');
	}
	$title .= get_bloginfo('name');
	return $title;
}


function wpm_show_login() {
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	else
		$redirect_to = admin_url();

	if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;
	else
		$secure_cookie = '';

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();

	wpm_head(__('Sign In','wpm'));	

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a>.",'wpm'));		
	if	( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )			$errors->add('loggedout', __('You are now logged out.','wpm'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	$errors->add('registerdisabled', __('User registration is currently not allowed.','wpm'), 'message');
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	$errors->add('confirm', __('Check your e-mail for the confirmation link.','wpm'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	$errors->add('newpass', __('Check your e-mail for your new password.','wpm'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	$errors->add('registered', __('Registration complete. Please check your e-mail.','wpm'), 'message');

?>
	
				
		<?php echo wpm_show_errors($errors); ?>
			
		<form class="loginform" action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post">
		<div class="input-prepend">
			<label for="user_login"><?php _e('Username:','wpm') ?></label>
			<span class="add-on"><i class="icon-user"></i></span>
			<input name="log" value="<?php echo attribute_escape(stripslashes($_POST['log'])); ?>" class="span4" placeholder="Username" id="user_login" type="text" />
		</div>
		<div class="input-prepend">
			<label for="user_pass"><?php _e('Password:','wpm') ?></label>
			<span class="add-on"><i class="icon-lock"></i></span>
			<input name="pwd" class="span4" id="user_pass" placeholder="Password" type="password" />
		</div>
		
		<div style="max-width: 250px;">
			<input name="rememberme" class="checkbox" id="rememberme" value="forever" type="checkbox" checked="checked"/>
			<label for="rememberme"><?php _e('Remember me','wpm'); ?></label>
			<input type="submit" class="btn btn-primary btn-block" name="wp-submit" id="wp-submit" value="<?php _e('Sign In','wpm'); ?>" />
			<input type="hidden" name="testcookie" value="1" />
		</div>
	</form>
			
<?php	
	wpm_footer();
}


function wpm_show_errors($wp_error) {
	global $error;
	
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( !empty($wp_error) ) {
		if ( $wp_error->get_error_code() ) {
			$errors = '';
			$messages = '';
			foreach ( $wp_error->get_error_codes() as $code ) {
				$severity = $wp_error->get_error_data($code);
				foreach ( $wp_error->get_error_messages($code) as $error ) {
					if ( 'message' == $severity )
						$messages .= '	' . $error . "<br />\n";
					else
						$errors .= '	' . $error . "<br />\n";
				}
			}
			if ( !empty($errors) )
				echo '<p id="login_error">' . apply_filters('login_errors', $errors) . "</p>\n";
			if ( !empty($messages) )
				echo '<p class="message">' . apply_filters('login_messages', $messages) . "</p>\n";
		}
	}
}

function wpm_footer() {
	global $pagenow, $user_ID, $wpm_options;

	if ($pagenow == "wp-login.php") {
			// Show the appropriate options
			echo '<div id="cpnav">'."\n";
			if (isset($_GET['action']) && $_GET['action'] != 'login') 
				echo '<a href="'.site_url('wp-login.php', 'login').'">'.__('Sign In','wpm').'</a><br />'."\n";
			if (get_option('users_can_register') && $_GET['action'] != 'register')
				echo '<a href="'.site_url('wp-login.php?action=register', 'login').'">'.__('Sign Up','wpm').'</a><br />'."\n";
			if ($_GET['action'] != 'lostpassword')
				echo '<a href="'.site_url('wp-login.php?action=lostpassword', 'login').'" title="'.__('Password Lost and Found','wpm').'">'.__('Lost your password?','wpm').'</a></li>'."\n";		
			echo '</div>'."\n";

			// autofocus the username field  ?>
			<script type="text/javascript">try{document.getElementById('user_login').focus();}catch(e){}</script>
		<?php		
	} else if (isset($user_ID)){
		//echo '<div id="wpmnav">'."\n";
		//if (function_exists('wp_logout_url')) {
		//	echo '<a href="'.wp_logout_url().'">'.__('Log out','wpm').'</a><br />'."\n";
		//} else {
		//	echo '<a href="'.site_url('wp-login.php?action=logout', 'logout').'">'.__('Log out','wpm').'</a>'."\n";			
		//}
		//echo '</div>'."\n";
	}
	// this is the end of page code before the sidebar
	echo "</div>";
	
	
?>
<?php include (TEMPLATEPATH . '/sidebar-page.php'); ?>
		</div>
	</div>
	<?php
	get_footer();
}
function wpm_show_register() {
	global $wpm_pluginpath, $wpm_options;
	if ( !get_option('users_can_register') ) {
		wp_redirect(get_bloginfo('wpurl').'/wp-login.php?registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';
	if (get_option('captcha_register') == "yes" || get_option('captcha_register') == "") {
	include(TEMPLATEPATH . '/includes/recaptchalib.php');
		// Get a key from http://recaptcha.net/api/getkey
	$publickey = get_option("pub_key");
	$privatekey = get_option("pvt_key");
	
    $response = recaptcha_check_answer($privatekey,
	    $_SERVER["REMOTE_ADDR"],
	    $_POST["recaptcha_challenge_field"],
	    $_POST["recaptcha_response_field"]);
	}
	    
	if ( isset($_POST['user_login']) ) {
			require_once( ABSPATH . WPINC . '/registration.php');

			$user_login = $_POST['user_login'];
			$user_email = $_POST['user_email'];
			$errors = register_new_user($user_login, $user_email);
			if (get_option('captcha_register') == "yes" || get_option('captcha_register') == "") {
			if (!$response->is_valid) {
			$errors = new WP_error();
			$errors->add('captcha', __("<strong>ERROR</strong>: You didn't correctly enter the captcha, please try again.",'wpm'));	
			}
			}
			if ( !is_wp_error($errors) ) {
				wp_redirect('wp-login.php?checkemail=registered');
				exit();
			}
	}
	
	wpm_head(__('Sign Up','wpm'));	
?>
		<?php wpm_show_errors($errors); ?>
	<form class="loginform" name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
		<div class="input-prepend">
			<label><?php _e('Username','wpm') ?>:</label>
			<span class="add-on"><i class="icon-user"></i></span>
			<input tabindex="1" type="text" name="user_login" id="user_login" placeholder="Username" class="span4" value="<?php echo attribute_escape(stripslashes($user_login)); ?>" size="20" tabindex="10" />
		</div>
		<div class="input-prepend">
			<label><?php _e('E-mail','wpm') ?>:</label>
			<span class="add-on"><i class="icon-envelope"></i></span>
			<input tabindex="2" type="text" name="user_email" id="user_email" placeholder="Email" class="span4" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="25" tabindex="20" />
		</div>
		<?php _e('A password will be e-mailed to you.','wpm') ?> <br />
<?php if (get_option('captcha_register') == "yes" || get_option('captcha_register') == "") {
	echo recaptcha_get_html($publickey);
	echo '<br />';
	} ?>
		<div style="max-width: 250px;">
		<?php do_action('register_form'); ?>
		<input tabindex="4" class="btn btn-primary btn-block" type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Sign Up','wpm'); ?>" tabindex="100" />
		</div>
	</form>
<?php
	wpm_footer();
}
function wpm_password() {
	$errors = new WP_Error();
	if ( $_POST['user_login'] ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			wp_redirect('wp-login.php?checkemail=confirm');
			exit();
		}
	}
	
	if ( 'invalidkey' == $_GET['error'] ) 
		$errors->add('invalidkey', __('Sorry, that key does not appear to be valid.','wpm'));

	$errors->add('registermsg', __('Please enter your e-mail address. You will receive a new password via e-mail.','wpm'), 'message');
	do_action('lost_password');
	do_action('lostpassword_post');
	wpm_head("Lost Password");	
?>
		<?php echo wpm_show_errors($errors); ?>
	<form class="loginform" name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
		<div class="input-prepend">
			<label><?php _e('Email:','wpm') ?></label>
			<span class="add-on"><i class="icon-envelope"></i></span>
			<input type="text" placeholder="Email" name="user_login" id="user_login" class="span4" value="<?php echo attribute_escape(stripslashes($_POST['user_login'])); ?>" size="20" tabindex="10" />
		</div>
		<div style="max-width: 250px;">
		<?php do_action('lostpassword_form'); ?>
		<input type="submit" class="btn btn-primary btn-block" name="wp-submit" id="wp-submit" value="<?php _e('Get New Password','wpm'); ?>" tabindex="100" />
		</div>
	</form>
<?php
	wpm_footer();
}
function wpm_login_css ( ) {
?>
<style type="text/css">
p.message, p#login_error{padding:3px 5px}
p.message{background-color:lightyellow; border:1px solid yellow}
p#login_error{background-color:#FFEBE8; border:1px solid #CC0000; color:#000}
</style>
<?php
}

function wpm_redirect($redirect_to, $request_redirect_to, $user) {
	if (is_a($user, 'WP_User') && $user->has_cap('level_3') === false) {
		return get_bloginfo('url'); 
	}
	return $redirect_to;
}

global $pagenow; 

if ( $pagenow == "wp-login.php"  && $_GET['action'] != 'logout' && !isset($_GET['key']) ) {
	add_action('init', 'wpm_login_init', 98);
	add_action('wp_title','wpm_title');
	add_action('wp_head', 'wpm_login_css');
}

/*
Main Plugin call for Profile Page:
Init the script when current page is profile.php, but don't init it when:
- a form has been submitted (the original PHP file should take care of form submissions)
- user has write and/or edit rights on the blog, he/she can see the backend anyway, so why not for this page?
*/

if ( !isset($_POST['from']) && $_POST['from'] != 'profile' ) {
	//add_action('load-profile.php', 'wpm_profile_init', 98);
}


// If the current user has no edit rights, redirect them to their dashboard page
add_filter('login_redirect', 'wpm_redirect', 10, 3);

?>
