<?php
/*
Template Name: Profile
*/


$wpdb->hide_errors(); 
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars


// check to see if the form has been posted. If so, validate the fields
if(!empty($_POST['submit']))
{

require_once(ABSPATH . 'wp-admin/includes/user.php');
require_once(ABSPATH . WPINC . '/registration.php');

check_admin_referer('update-profile_' . $user_ID);


$errors = edit_user($user_ID);

if ( is_wp_error( $errors ) ) {
	foreach( $errors->get_error_messages() as $message )
		$errmsg = "$message";
	//exit;
}


// if there are no errors, then process the ad updates
if($errmsg == '')
	{

	do_action('personal_options_update');
	$d_url = $_POST['dashboard_url'];
	wp_redirect( './?updated=true&d='. $d_url );

	} else {

	  $errmsg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>**  ' . $errmsg . ' **</strong></div>'; 
	}

}	

wp_enqueue_script('jquery');

get_header(); 
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
		<h2><?php _e('Profile for ','wpm')?><?php echo(ucfirst($userdata->user_login)); ?><?php _e('\'s','wpm')?></h2>
		<?php 
		if(function_exists('userphoto_exists')){
		  echo "<div id='user-photo'>";
			if(userphoto_exists($user_ID))
				userphoto_thumbnail($user_ID);
			else
				echo get_avatar($userdata->user_email, 96);
		  echo "</div><br /><br />";
		}	
		 ?>

<?php if ( isset($_GET['updated']) ) { 
	  $d_url = $_GET['d'];?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-dashboard.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong><?php _e('Your profile has been updated.','wpm')?></strong><br /><br /><a class="btn" href="<?php echo get_permalink($str); ?>"><?php _e('My Dashboard','wpm')?></a>
	</div>
<?php
endwhile;
endif;
wp_reset_query();
?>
<?php  } ?>


<?php echo $errmsg; ?>	


		<form name="profile" id="your-profile" action="" method="post">
		<?php wp_nonce_field('update-profile_' . $user_ID) ?>
		
		<input type="hidden" name="from" value="profile" />
		<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
		<input type="hidden" name="dashboard_url" value="<?php echo wpm_dashboard_url; ?>" />


              <div class="accordion" id="profile">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#profile" href="#collapseOne">
                      Name Info
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse in">
                    <div class="accordion-inner">
<label for="first_name"><?php _e('First Name','wpm') ?></label>
<input type="text" name="first_name" class="input-xlarge" id="first_name" value="<?php echo $userdata->first_name ?>" size="35" maxlength="100" />

<label for="last_name"><?php _e('Last Name','wpm') ?></label>
<input type="text" name="last_name" class="input-xlarge" id="last_name" value="<?php echo $userdata->last_name ?>" size="35" maxlength="100" />

<label for="display_name"><?php _e('Display Name','wpm') ?></label>
					<select name="display_name" class="mid2" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_displayname'] = $userdata->display_name;
						$public_display['display_nickname'] = $userdata->nickname;
						$public_display['display_username'] = $userdata->user_login;
						$public_display['display_firstname'] = $userdata->first_name;
						$public_display['display_firstlast'] = $userdata->first_name.' '.$userdata->last_name;
						$public_display['display_lastfirst'] = $userdata->last_name.' '.$userdata->first_name;
						$public_display = array_unique(array_filter(array_map('trim', $public_display)));
						foreach($public_display as $id => $item) {
					?>
						<option id="<?php echo $id; ?>" value="<?php echo $item; ?>"><?php echo $item; ?></option>
					<?php
						}
					?>
					</select>
					</div>
                  </div>
                </div>
                
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#profile" href="#collapseTwo">
                      Contact Info
                    </a>
                  </div>
                  <div id="collapseTwo" class="accordion-body collapse">
                    <div class="accordion-inner">
<label for="email"><?php _e('Email','wpm') ?></label>
<input type="text" name="email" class="input-xlarge" id="email" value="<?php echo $userdata->user_email ?>" size="35" maxlength="100" />

<label for="url"><?php _e('Website','wpm') ?></label>
<input type="text" name="url" class="input-xlarge" id="url" value="<?php echo $userdata->user_url ?>" size="35" maxlength="100" />

<label for="twitter"><?php _e('Twitter','wpm') ?></label>
<input type="text" name="twitter" class="input-xlarge" id="twitter" value="<?php echo $userdata->twitter ?>" size="35" maxlength="100" />

<label for="gplus"><?php _e('Google+','wpm') ?></label>
<input type="text" name="gplus" class="input-xlarge" id="gplus" value="<?php echo $userdata->gplus ?>" size="35" maxlength="100" />

<label for="facebook"><?php _e('Facebook','wpm') ?></label>
<input type="text" name="facebook" class="input-xlarge" id="facebook" value="<?php echo $userdata->facebook ?>" size="35" maxlength="100" />
                    </div>
                  </div>
                </div>
                
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#profile" href="#collapseThree">
                      About Yourself
                    </a>
                  </div>
                  <div id="collapseThree" class="accordion-body collapse">
                    <div class="accordion-inner">
<label for="description"><?php _e('About Me','wpm'); ?></label>
<textarea name="description" class="span12" id="description" rows="7" cols="30"><?php echo $userdata->description ?></textarea>


		<?php
		$show_password_fields = apply_filters('show_password_fields', true);
		if ( $show_password_fields ) :
		?>

<label><?php _e('New Password','wpm'); ?></label>
<input type="password" name="pass1" class="input-xlarge" id="pass1" size="35" maxlength="50" value="" /> <span for="pass1">If you would like to change the password type a new one.</span>
<input type="password" name="pass2" class="input-xlarge" id="pass2" size="35" maxlength="50" value="" /> <span for="pass2">Type your new password again.</span>
                    </div>
                  </div>
                </div>
              </div>

		<?php endif; ?>
		<?php
			do_action('profile_personal_options');
			do_action('show_user_profile');
		?>
		<?php if($userdata->userphoto_image_file): ?>

		<input type="checkbox" name="userphoto_delete" id="userphoto_delete" /> <?php _e('Delete existing photo?','wpm') ?>
		<br /><br />
		<?php endif; ?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
			<input type="submit" id="cpsubmit" class="btn btn-primary" value="<?php _e('Update Profile &raquo;', 'wpm')?>" name="submit" />

		</form>

</div>
<?php include (TEMPLATEPATH . '/sidebar-page.php'); ?>
</div>
</div>

<?php get_footer(); ?>
