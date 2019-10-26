<?php

//wpmarks admin page


function wpm_admin_info_box() { ?>

<div class="info">
	<div style="float: left; padding-top:4px;"><strong><?php _e('Need help with these options?','wpm')?></strong> <a href="http://themeshadow.biz/cs" target="blank"><?php _e('Contact me','wpm')?></a>.
	</div>
	<div style="float: right; margin:0; padding:0; " class="submit"><input name="save" type="submit" value="<?php _e('Save changes','wpm')?>" /></div>
	<div style="clear:both;"></div>
</div>	 
					
<?php

}					


function wpmarks() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){
	
		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}
		

        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    }
?>

<div class="wrap">
<h2><?php _e('WPMarks','wpm')?></h2>
<form method="post" name="wpmarks" target="_self">

<?php wpm_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('General Configuration','wpm')?></h3>
     						
<table class="maintable">

		<?php if (!get_option('users_can_register')) : ?>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Permissions','wpm')?></td>
		<td class="forminp">
			<strong style="color: #FF0000;"><?php _e('User registration is not activated.','wpm')?> <a href="options-general.php"><?php _e('Go and activate it.','wpm')?></a></strong>
		</td>
	</tr>
		<?php endif; ?>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Default New Post Status','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[post_status]" style="width: 100px;">
				<option value="draft"<?php if (get_option("post_status") == "draft") { echo ' selected="selected"'; } ?>><?php _e('Draft','wpm')?></option>
				<option value="publish"<?php if (get_option("post_status") == "publish") { echo ' selected="selected"'; } ?>><?php _e('Published','wpm')?></option>
			</select><br />
			<small><?php _e('<i>Draft</i> - You have to manually approve and publish each post','wpm')?><br />
			<?php _e('<i>Published</i> - Post goes live immediately without any approvals','wpm')?><br />
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Exclude Pages from Nav','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[excluded_pages]" type="text" style="width: 200px;" value="<?php if (get_option("excluded_pages") == "" ) { ?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-dashboard.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
        echo $str.',';
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-profile.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
        echo $str.',';
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-submit.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
		echo $str;
    endwhile;
endif;
wp_reset_query();
?>
<?php } else { echo get_option("excluded_pages"); } ?>" /><?php _e(' Change default excluded.','wpm')?><br />
			<small><?php _e('Enter a comma-separated list of your user "dashboard page", "submit page" and "profile page" page IDs so they are excluded from the navigation ( i.e. 44,45 ). To find the Page ID, go to Pages->All Pages->Edit and hover over the title of the page. The status bar of your browser will display a URL with a numeric ID at the after "post=...". This is the page ID.','wpm')?></a></small>
				
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Include Post in Highlight','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[include_post]" type="text" style="width: 200px;" value="<?php echo get_option("include_post"); ?>" /><br />
			<small><?php _e('Enter a comma-separated list of your highlight post IDs so they are include from the highlight ( i.e. 6,7,8 ). To find the Post ID, go to Post->All Post->Edit and hover over the title of the post. The status bar of your browser will display a URL with a numeric ID at the after "post=...". This is the post ID.','wpm')?></a></small>
				
		</td>
	</tr>
	
</table>

<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','wpm')?>" /></p>

<div style="clear: both;"></div>

</div>

<?php  } 

// process new post
function wpmarks_settings() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){

		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}

	echo "<div id=\"message\" class=\"updated fade\"><p><strong>" . __('Your settings have been saved.','wpm') . "</strong></p></div>";

	}
?>


<div class="wrap">
<h2><?php _e('WPMarks','wpm')?></h2>
<form method="post" name="wpmarks" target="_self">

<?php wpm_admin_info_box(); ?>
	 
<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Settings','wpm')?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Max image upload','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[upload]" style="width: 50px;">
				<option value="0"<?php if (get_option("upload") == "0") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
				<option value="1"<?php if (get_option("upload") == "1") { echo ' selected="selected"'; } ?>><?php _e('1','wpm')?></option>
				<option value="2"<?php if (get_option("upload") == "2") { echo ' selected="selected"'; } ?>><?php _e('2','wpm')?></option>
				<option value="3"<?php if (get_option("upload") == "3") { echo ' selected="selected"'; } ?>><?php _e('3','wpm')?></option>
				<option value="4"<?php if (get_option("upload") == "4") { echo ' selected="selected"'; } ?>><?php _e('4','wpm')?></option>
				<option value="5"<?php if (get_option("upload") == "5") { echo ' selected="selected"'; } ?>><?php _e('5','wpm')?></option>
				<option value="6"<?php if (get_option("upload") == "6") { echo ' selected="selected"'; } ?>><?php _e('6','wpm')?></option>
				<option value="7"<?php if (get_option("upload") == "7") { echo ' selected="selected"'; } ?>><?php _e('7','wpm')?></option>
				<option value="8"<?php if (get_option("upload") == "8") { echo ' selected="selected"'; } ?>><?php _e('8','wpm')?></option>
				<option value="9"<?php if (get_option("upload") == "9") { echo ' selected="selected"'; } ?>><?php _e('9','wpm')?></option>
				<option value="10"<?php if (get_option("upload") == "10") { echo ' selected="selected"'; } ?>><?php _e('10','wpm')?></option>
			</select><br />
			<small><?php _e('Max image to upload.','wpm')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Max Image Size','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[size]" style="width: 100px;">
				<option value="1"<?php if (get_option("size") == "1") { echo ' selected="selected"'; } ?>><?php _e('100kB','wpm')?></option>
				<option value="2"<?php if (get_option("size") == "2") { echo ' selected="selected"'; } ?>><?php _e('200kB','wpm')?></option>
				<option value="4"<?php if (get_option("size") == "4") { echo ' selected="selected"'; } ?>><?php _e('400kB','wpm')?></option>
				<option value="8"<?php if (get_option("size") == "8") { echo ' selected="selected"'; } ?>><?php _e('800kB','wpm')?></option>
				<option value="10"<?php if (get_option("size") == "10") { echo ' selected="selected"'; } ?>><?php _e('1MB','wpm')?></option>
				<option value="20"<?php if (get_option("size") == "20") { echo ' selected="selected"'; } ?>><?php _e('2MB','wpm')?></option>
				<option value="40"<?php if (get_option("size") == "40") { echo ' selected="selected"'; } ?>><?php _e('4MB','wpm')?></option>
			</select><br />
			<small><?php _e('Max image size to upload.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Email Notifications','wpm')?></td>
		<td class="forminp">
			
			<select name="adminArray[notif_ad]" style="width: 100px;">
				<option value="yes"<?php if (get_option("notif_ad") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("notif_ad") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Send an email once a new post is posted','wpm')?></small> 
			
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Allow HTML Code','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[filter_html]" style="width: 100px;">
				<option value="yes"<?php if (get_option("filter_html") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("filter_html") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Gives users the ability to use html code in their post.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Show Report Button','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[report_button]" style="width: 100px;">
				<option value="yes"<?php if (get_option("report_button") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("report_button") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Makes the red flag "Report" button visible in the sidebar on individual post. Allows visitors to report inappropriate listings.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Show Slider Home','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[show_slider]" style="width: 100px;">
				<option value="yes"<?php if (get_option("show_slider") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("show_slider") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Show the slider visible in the home.','wpm')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Show Breadcrumbs Post','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[breadcrumbs]" style="width: 100px;">
				<option value="yes"<?php if (get_option("breadcrumbs") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("breadcrumbs") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Show the breadcrumbs visible in the single post.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Sidebar Social Share','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[share]" style="width: 100px;">
				<option value="yes"<?php if (get_option("share") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("share") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small><?php _e('Show social share in sidebar.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Link a rel Attribute','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[rel]" style="width: 100px;">
				<option value=""<?php if (get_option("rel") == "") { echo ' selected="selected"'; } ?>><?php _e('None','wpm')?></option>
				<option value="nofollow"<?php if (get_option("rel") == "nofollow") { echo ' selected="selected"'; } ?>><?php _e('Nofollow','wpm')?></option>
				<option value="bookmark"<?php if (get_option("rel") == "bookmark") { echo ' selected="selected"'; } ?>><?php _e('Bookmark','wpm')?></option>
			</select><br />
			<small>
				<?php _e('Search engines can use this attribute to get more information about a link. ( Choose wisely ).','wpm')?><br />
				<?php _e('Nofollow - Is used by Google, to specify that the Google search spider should not follow that link.','wpm')?><br />
				<?php _e('Bookmark - Permanent URL used for bookmarking.','wpm')?>
			</small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Link a terget Attribute','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[target]" style="width: 100px;">
				<option value=""<?php if (get_option("target") == "") { echo ' selected="selected"'; } ?>><?php _e('None','wpm')?></option>
				<option value="_blank"<?php if (get_option("target") == "_blank") { echo ' selected="selected"'; } ?>><?php _e('Blank','wpm')?></option>
				<option value="_top"<?php if (get_option("target") == "_top") { echo ' selected="selected"'; } ?>><?php _e('Top','wpm')?></option>
			</select><br />
			<small>
				<?php _e('The target attribute specifies where to open the linked URL.','wpm')?><br />
				<?php _e('Blank - Opens the linked URL in a new window or tab.','wpm')?><br />
				<?php _e('Top - Opens the linked URL in the full body of the window.','wpm')?>
			</small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Comment With','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[comment]" style="width: 200px;">
				<option value="none"<?php if (get_option("comment") == "none") { echo ' selected="selected"'; } ?>><?php _e('None','wpm')?></option>
				<option value="default"<?php if (get_option("comment") == "default") { echo ' selected="selected"'; } ?>><?php _e('Default Comment','wpm')?></option>
				<option value="facebook"<?php if (get_option("comment") == "facebook") { echo ' selected="selected"'; } ?>><?php _e('Facebook Comment','wpm')?></option>
			</select><br />
			<small><?php _e('Choose comment by default or facebook comment.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Default Thumbnail','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[thumbnail]" style="width: 200px;">
				<option value="up"<?php if (get_option("thumbnail") == "up") { echo ' selected="selected"'; } ?>><?php _e('Image Upload','wpm')?></option>
				<option value="wp"<?php if (get_option("thumbnail") == "wp") { echo ' selected="selected"'; } ?>><?php _e('Snap Shoot','wpm')?></option>
			</select><br />
			<small><?php _e('Default thumbnail home.','wpm')?></small>
		</td>
	</tr>

</table>

<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','wpm')?>" /></p>

</div>

<?php }
function wpmarks_spam_filter() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){
	
		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}
		

        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    }
?>

<div class="wrap">
<h2><?php _e('WPMarks','wpm')?></h2>
<form method="post" name="wpmarks" target="_self">

<?php wpm_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('reCAPTCHA Filter','wpm')?></h3>
     						
<table class="maintable">

	<tr class="mainrow">
		<td class="titledesc"><? _e('What is reCaptcha?','wpm')?></td>
		<td class="forminp">
		<?php _e("A CAPTCHA is a program that can tell whether its user is a human or a computer. You've probably seen them — colorful images with distorted text at the bottom of Web registration forms. CAPTCHAs are used by many websites to prevent abuse from 'bots', or automated programs usually written to generate spam.", 'wpm')?><br /><br />
		<?php _e("To get The Public Key & Private Key, visit <a href='https://www.google.com/recaptcha/admin/create'> https://www.google.com/recaptcha/admin/create</a>.",'wpm')?>
		</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Public Key','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[pub_key]" type="text" style="width: 250px;" value="<?php echo get_option("pub_key"); ?>" /><br />
			<small><?php _e('Public key of reCAPTCHA.','wpm')?></a></small>	
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Private Key','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[pvt_key]" type="text" style="width: 250px;" value="<?php echo get_option("pvt_key"); ?>" /><br />
			<small><?php _e('Private key of reCAPTCHA.','wpm')?></a></small>	
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('reCaptcha Submit Form','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[captcha_submit]" style="width: 100px;">
				<option value="yes"<?php if (get_option("captcha_submit") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("captcha_submit") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small>
			<?php _e('Display reCaptcha filter on form submission.','wpm')?><br />
			</small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('reCaptcha Register Form','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[captcha_register]" style="width: 100px;">
				<option value="yes"<?php if (get_option("captcha_register") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("captcha_register") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small>
			<?php _e('Display reCaptcha filter on form registration.','wpm')?><br />
			</small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Custom Theming reCaptcha','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[theme_captcha]" style="width: 200px;">
				<option value="red"<?php if (get_option("theme_captcha") == "red") { echo ' selected="selected"'; } ?>><?php _e('Red','wpm')?></option>
				<option value="white"<?php if (get_option("theme_captcha") == "white") { echo ' selected="selected"'; } ?>><?php _e('White','wpm')?></option>
				<option value="blackglass"<?php if (get_option("theme_captcha") == "blackglass") { echo ' selected="selected"'; } ?>><?php _e('Blackglass','wpm')?></option>
				<option value="clean"<?php if (get_option("theme_captcha") == "clean") { echo ' selected="selected"'; } ?>><?php _e('Clean','wpm')?></option>
			</select><br />
			<small>
			<?php _e("Customizing the Look and Feel of reCAPTCHA. <a target='_blank' href='https://developers.google.com/recaptcha/docs/customization#Standard_Themes'>Standard reCAPTCHA themes</a>.",'wpm')?><br />
			</small>
		</td>
	</tr>
	
</table>
<h3 class="title"><?php _e('Spam Filter','wpm')?></h3>

<table class="maintable">

	<tr class="mainrow">
		<td class="titledesc"><?php _e('URL not allowed in Title','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[filter_title_url]" style="width: 100px;">
				<option value="yes"<?php if (get_option("filter_title_url") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("filter_title_url") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small>
			<?php _e('Not allowed submit url in The Title.','wpm')?><br />
			</small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('URL not allowed in Description','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[filter_content_url]" style="width: 100px;">
				<option value="yes"<?php if (get_option("filter_content_url") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm') ?></option>
				<option value="no"<?php if (get_option("filter_content_url") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm') ?></option>
			</select><br />
			<small>
			<?php _e('Not allowed submit URL in The Description.','wpm')?><br />
			</small>
		</td>
	</tr>

</table>
<h3 class="title"><?php _e('Duplicate Filter','wpm')?></h3>
     						
<table class="maintable">

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Duplicate Title','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[dup_title]" style="width: 100px;">
				<option value="yes"<?php if (get_option("dup_title") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("dup_title") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small>
			<?php _e('Not allowed duplicate in The Title.','wpm')?><br />
			</small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Duplicate Description','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[dup_desc]" style="width: 100px;">
				<option value="yes"<?php if (get_option("dup_desc") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm')?></option>
				<option value="no"<?php if (get_option("dup_desc") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm')?></option>
			</select><br />
			<small>
			<?php _e('Not allowed duplicate in The Description.','wpm')?><br />
			</small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Duplicate URL','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[dup_url]" style="width: 100px;">
				<option value="yes"<?php if (get_option("dup_url") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','wpm') ?></option>
				<option value="no"<?php if (get_option("dup_url") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','wpm') ?></option>
			</select><br />
			<small>
			<?php _e('Not allowed duplicate in The URL.','wpm')?><br />
			</small>
		</td>
	</tr>
</table>

<h3 class="title"><?php _e('Characters The Title','wpm')?></h3>

<table class="maintable">

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Max characters The Title','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[max_title]" style="width: 200px;">
				<option value="30"<?php if (get_option("max_title") == "30") { echo ' selected="selected"'; } ?>><?php _e('30 Characters','wpm')?></option>
				<option value="40"<?php if (get_option("max_title") == "40") { echo ' selected="selected"'; } ?>><?php _e('40 Characters','wpm')?></option>
				<option value="50"<?php if (get_option("max_title") == "50") { echo ' selected="selected"'; } ?>><?php _e('50 Characters','wpm')?></option>
				<option value="60"<?php if (get_option("max_title") == "60") { echo ' selected="selected"'; } ?>><?php _e('60 Characters','wpm')?></option>
				<option value="70"<?php if (get_option("max_title") == "70") { echo ' selected="selected"'; } ?>><?php _e('70 Characters','wpm')?></option>
				<option value="80"<?php if (get_option("max_title") == "80") { echo ' selected="selected"'; } ?>><?php _e('80 Characters','wpm')?></option>
			</select><br />
			<small><?php _e('Choose the characters maximum in The Title.','wpm')?></a></small>
		</td>
	</tr>
	
</table>

<h3 class="title"><?php _e('Characters The Description','wpm')?></h3>

<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Min characters The Description','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[min_des]" style="width: 200px;">
				<option value="300"<?php if (get_option("min_des") == "300") { echo ' selected="selected"'; } ?>><?php _e('300 Characters','wpm')?></option>
				<option value="400"<?php if (get_option("min_des") == "400") { echo ' selected="selected"'; } ?>><?php _e('400 Characters','wpm')?></option>
				<option value="500"<?php if (get_option("min_des") == "500") { echo ' selected="selected"'; } ?>><?php _e('500 Characters','wpm')?></option>
			</select><br />
			<small><?php _e('Choose the characters minimum in The Description.','wpm')?></a></small>	
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Max characters The Description','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[max_des]" style="width: 200px;">
				<option value="1000"<?php if (get_option("max_des") == "1000") { echo ' selected="selected"'; } ?>><?php _e('1000 Characters','wpm')?></option>
				<option value="1500"<?php if (get_option("max_des") == "1500") { echo ' selected="selected"'; } ?>><?php _e('1500 Characters','wpm')?></option>
				<option value="2000"<?php if (get_option("max_des") == "2000") { echo ' selected="selected"'; } ?>><?php _e('2000 Characters','wpm')?></option>
			</select><br />
			<small><?php _e('Choose the characters maximum in The Description.','wpm')?></a></small>
		</td>
	</tr>
	
</table>

<h3 class="title"><?php _e('Banned Domain','wpm')?></h3>

<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Domain banned','wpm')?></td>
		<td class="forminp">
			<textarea name="adminArray[ban]" rows="8" cols="94"><?php echo stripslashes(get_option("ban")); ?></textarea><br />
			<small><?php _e('Enter the special Domain separated with commas will banned in submission. Example ( example1.com, example2.com, example3.com ).','wpm')?></a></small>	
		</td>
	</tr>
	
</table>

<h3 class="title"><?php _e('Bad Words','wpm')?></h3>

<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Bad words filter','wpm')?></td>
		<td class="forminp">
			<textarea name="adminArray[bad]" rows="8" cols="94"><?php echo stripslashes(get_option("bad")); ?></textarea><br />
			<small><?php _e('Eenter bad words separated with commas will you ban. Example ( fuck, drugs, porn ).','wpm')?></a></small>	
		</td>
	</tr>
	
</table>

<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','wpm')?>" /></p>

<div style="clear: both;"></div>

</div>

<?php  }
function wpmarks_slider() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){
	
		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}
		

        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    }
?>
<div class="wrap">
<h2><?php _e('WPMarks','wpm')?></h2>
<form method="post" name="wpmarks" target="_self">

<?php wpm_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e("Slider Setting","wpm")?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Max Slider','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[slidercount]" onchange="this.form.submit()" style="width: 50px;">
				<option value="0"<?php if (get_option("slidercount") == "0") { echo ' selected="selected"'; } ?>><?php _e('0','wpm')?></option>
				<option value="1"<?php if (get_option("slidercount") == "1") { echo ' selected="selected"'; } ?>><?php _e('1','wpm')?></option>
				<option value="2"<?php if (get_option("slidercount") == "2") { echo ' selected="selected"'; } ?>><?php _e('2','wpm')?></option>
				<option value="3"<?php if (get_option("slidercount") == "3") { echo ' selected="selected"'; } ?>><?php _e('3','wpm')?></option>
				<option value="4"<?php if (get_option("slidercount") == "4") { echo ' selected="selected"'; } ?>><?php _e('4','wpm')?></option>
				<option value="5"<?php if (get_option("slidercount") == "5") { echo ' selected="selected"'; } ?>><?php _e('5','wpm')?></option>
				<option value="6"<?php if (get_option("slidercount") == "6") { echo ' selected="selected"'; } ?>><?php _e('6','wpm')?></option>
				<option value="7"<?php if (get_option("slidercount") == "7") { echo ' selected="selected"'; } ?>><?php _e('7','wpm')?></option>
				<option value="8"<?php if (get_option("slidercount") == "8") { echo ' selected="selected"'; } ?>><?php _e('8','wpm')?></option>
				<option value="9"<?php if (get_option("slidercount") == "9") { echo ' selected="selected"'; } ?>><?php _e('9','wpm')?></option>
				<option value="10"<?php if (get_option("slidercount") == "10") { echo ' selected="selected"'; } ?>><?php _e('10','wpm')?></option>
			</select><br />
			<small><?php _e('Max slider show.','wpm')?></small>
		</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Font Color Title Slider','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[slidercolortitle]" style="width: 250px;">
				<option value="White"<?php if (get_option("slidercolortitle") == "White") { echo ' selected="selected"'; } ?>><?php _e('White','wpm')?></option>
				<option value="AntiqueWhite"<?php if (get_option("slidercolortitle") == "AntiqueWhite") { echo ' selected="selected"'; } ?>><?php _e('AntiqueWhite','wpm')?></option>
				<option value="Aqua"<?php if (get_option("slidercolortitle") == "Aqua") { echo ' selected="selected"'; } ?>><?php _e('Aqua','wpm')?></option>
				<option value="Aquamarine"<?php if (get_option("slidercolortitle") == "Aquamarine") { echo ' selected="selected"'; } ?>><?php _e('Aquamarine','wpm')?></option>
				<option value="Azure"<?php if (get_option("slidercolortitle") == "Azure") { echo ' selected="selected"'; } ?>><?php _e('Azure','wpm')?></option>
				<option value="Beige"<?php if (get_option("slidercolortitle") == "Beige") { echo ' selected="selected"'; } ?>><?php _e('Beige','wpm')?></option>
				<option value="Bisque"<?php if (get_option("slidercolortitle") == "Bisque") { echo ' selected="selected"'; } ?>><?php _e('Bisque','wpm')?></option>
				<option value="Black"<?php if (get_option("slidercolortitle") == "Black") { echo ' selected="selected"'; } ?>><?php _e('Black','wpm')?></option>
				<option value="BlanchedAlmond"<?php if (get_option("slidercolortitle") == "BlanchedAlmond") { echo ' selected="selected"'; } ?>><?php _e('BlanchedAlmond','wpm')?></option>
				<option value="Blue"<?php if (get_option("slidercolortitle") == "Blue") { echo ' selected="selected"'; } ?>><?php _e('Blue','wpm')?></option>
				<option value="BlueViolet"<?php if (get_option("slidercolortitle") == "BlueViolet") { echo ' selected="selected"'; } ?>><?php _e('BlueViolet','wpm')?></option>
				<option value="Brown"<?php if (get_option("slidercolortitle") == "Brown") { echo ' selected="selected"'; } ?>><?php _e('Brown','wpm')?></option>
				<option value="BurlyWood"<?php if (get_option("slidercolortitle") == "BurlyWood") { echo ' selected="selected"'; } ?>><?php _e('BurlyWood','wpm')?></option>
				<option value="CadetBlue"<?php if (get_option("slidercolortitle") == "CadetBlue") { echo ' selected="selected"'; } ?>><?php _e('CadetBlue','wpm')?></option>
				<option value="Chartreuse"<?php if (get_option("slidercolortitle") == "Chartreuse") { echo ' selected="selected"'; } ?>><?php _e('Chartreuse','wpm')?></option>
				<option value="Chocolate"<?php if (get_option("slidercolortitle") == "Chocolate") { echo ' selected="selected"'; } ?>><?php _e('Chocolate','wpm')?></option>
				<option value="Coral"<?php if (get_option("slidercolortitle") == "Coral") { echo ' selected="selected"'; } ?>><?php _e('Coral','wpm')?></option>
				<option value="CornflowerBlue"<?php if (get_option("slidercolortitle") == "CornflowerBlue") { echo ' selected="selected"'; } ?>><?php _e('CornflowerBlue','wpm')?></option>
				<option value="Cornsilk"<?php if (get_option("slidercolortitle") == "Cornsilk") { echo ' selected="selected"'; } ?>><?php _e('Cornsilk','wpm')?></option>
				<option value="Crimson"<?php if (get_option("slidercolortitle") == "Crimson") { echo ' selected="selected"'; } ?>><?php _e('Crimson','wpm')?></option>
				<option value="Cyan"<?php if (get_option("slidercolortitle") == "Cyan") { echo ' selected="selected"'; } ?>><?php _e('Cyan','wpm')?></option>
				<option value="DarkBlue"<?php if (get_option("slidercolortitle") == "DarkBlue") { echo ' selected="selected"'; } ?>><?php _e('DarkBlue','wpm')?></option>
				<option value="DarkCyan"<?php if (get_option("slidercolortitle") == "DarkCyan") { echo ' selected="selected"'; } ?>><?php _e('DarkCyan','wpm')?></option>
				<option value="DarkGoldenRod"<?php if (get_option("slidercolortitle") == "DarkGoldenRod") { echo ' selected="selected"'; } ?>><?php _e('DarkGoldenRod','wpm')?></option>
				<option value="DarkGray"<?php if (get_option("slidercolortitle") == "DarkGray") { echo ' selected="selected"'; } ?>><?php _e('DarkGray','wpm')?></option>
				<option value="DarkGrey"<?php if (get_option("slidercolortitle") == "DarkGrey") { echo ' selected="selected"'; } ?>><?php _e('DarkGrey','wpm')?></option>
				<option value="DarkGreen"<?php if (get_option("slidercolortitle") == "DarkGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkGreen','wpm')?></option>
				<option value="DarkKhaki"<?php if (get_option("slidercolortitle") == "DarkKhaki") { echo ' selected="selected"'; } ?>><?php _e('DarkKhaki','wpm')?></option>
				<option value="DarkMagenta"<?php if (get_option("slidercolortitle") == "DarkMagenta") { echo ' selected="selected"'; } ?>><?php _e('DarkMagenta','wpm')?></option>
				<option value="DarkOliveGreen"<?php if (get_option("slidercolortitle") == "DarkOliveGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkOliveGreen','wpm')?></option>
				<option value="Darkorange"<?php if (get_option("slidercolortitle") == "Darkorange") { echo ' selected="selected"'; } ?>><?php _e('Darkorange','wpm')?></option>
				<option value="DarkOrchid"<?php if (get_option("slidercolortitle") == "DarkOrchid") { echo ' selected="selected"'; } ?>><?php _e('DarkOrchid','wpm')?></option>
				<option value="DarkRed"<?php if (get_option("slidercolortitle") == "DarkRed") { echo ' selected="selected"'; } ?>><?php _e('DarkRed','wpm')?></option>
				<option value="DarkSalmon"<?php if (get_option("slidercolortitle") == "DarkSalmon") { echo ' selected="selected"'; } ?>><?php _e('DarkSalmon','wpm')?></option>
				<option value="DarkSeaGreen"<?php if (get_option("slidercolortitle") == "DarkSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkSeaGreen','wpm')?></option>
				<option value="DarkSlateBlue"<?php if (get_option("slidercolortitle") == "DarkSlateBlue") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateBlue','wpm')?></option>
				<option value="DarkSlateGray"<?php if (get_option("slidercolortitle") == "DarkSlateGray") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateGray','wpm')?></option>
				<option value="DarkSlateGrey"<?php if (get_option("slidercolortitle") == "DarkSlateGrey") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateGrey','wpm')?></option>
				<option value="DarkTurquoise"<?php if (get_option("slidercolortitle") == "DarkTurquoise") { echo ' selected="selected"'; } ?>><?php _e('DarkTurquoise','wpm')?></option>
				<option value="DarkViolet"<?php if (get_option("slidercolortitle") == "DarkViolet") { echo ' selected="selected"'; } ?>><?php _e('DarkViolet','wpm')?></option>
				<option value="DeepPink"<?php if (get_option("slidercolortitle") == "DeepPink") { echo ' selected="selected"'; } ?>><?php _e('DeepPink','wpm')?></option>
				<option value="DeepSkyBlue"<?php if (get_option("slidercolortitle") == "DeepSkyBlue") { echo ' selected="selected"'; } ?>><?php _e('DeepSkyBlue','wpm')?></option>
				<option value="DimGray"<?php if (get_option("slidercolortitle") == "DimGray") { echo ' selected="selected"'; } ?>><?php _e('DimGray','wpm')?></option>
				<option value="DimGrey"<?php if (get_option("slidercolortitle") == "DimGrey") { echo ' selected="selected"'; } ?>><?php _e('DimGrey','wpm')?></option>
				<option value="DodgerBlue"<?php if (get_option("slidercolortitle") == "DodgerBlue") { echo ' selected="selected"'; } ?>><?php _e('DodgerBlue','wpm')?></option>
				<option value="FireBrick"<?php if (get_option("slidercolortitle") == "FireBrick") { echo ' selected="selected"'; } ?>><?php _e('FireBrick','wpm')?></option>
				<option value="FloralWhite"<?php if (get_option("slidercolortitle") == "FloralWhite") { echo ' selected="selected"'; } ?>><?php _e('FloralWhite','wpm')?></option>
				<option value="ForestGreen"<?php if (get_option("slidercolortitle") == "ForestGreen") { echo ' selected="selected"'; } ?>><?php _e('ForestGreen','wpm')?></option>
				<option value="Fuchsia"<?php if (get_option("slidercolortitle") == "Fuchsia") { echo ' selected="selected"'; } ?>><?php _e('Fuchsia','wpm')?></option>
				<option value="Gainsboro"<?php if (get_option("slidercolortitle") == "Gainsboro") { echo ' selected="selected"'; } ?>><?php _e('Gainsboro','wpm')?></option>
				<option value="GhostWhite"<?php if (get_option("slidercolortitle") == "GhostWhite") { echo ' selected="selected"'; } ?>><?php _e('GhostWhite','wpm')?></option>
				<option value="Gold"<?php if (get_option("slidercolortitle") == "Gold") { echo ' selected="selected"'; } ?>><?php _e('Gold','wpm')?></option>
				<option value="GoldenRod"<?php if (get_option("slidercolortitle") == "GoldenRod") { echo ' selected="selected"'; } ?>><?php _e('GoldenRod','wpm')?></option>
				<option value="Gray"<?php if (get_option("slidercolortitle") == "Gray") { echo ' selected="selected"'; } ?>><?php _e('Gray','wpm')?></option>
				<option value="Grey"<?php if (get_option("slidercolortitle") == "Grey") { echo ' selected="selected"'; } ?>><?php _e('Grey','wpm')?></option>
				<option value="Green"<?php if (get_option("slidercolortitle") == "Green") { echo ' selected="selected"'; } ?>><?php _e('Green','wpm')?></option>
				<option value="GreenYellow"<?php if (get_option("slidercolortitle") == "GreenYellow") { echo ' selected="selected"'; } ?>><?php _e('GreenYellow','wpm')?></option>
				<option value="HoneyDew"<?php if (get_option("slidercolortitle") == "HoneyDew") { echo ' selected="selected"'; } ?>><?php _e('HoneyDew','wpm')?></option>
				<option value="HotPink"<?php if (get_option("slidercolortitle") == "HotPink") { echo ' selected="selected"'; } ?>><?php _e('HotPink','wpm')?></option>
				<option value="IndianRed"<?php if (get_option("slidercolortitle") == "IndianRed") { echo ' selected="selected"'; } ?>><?php _e('IndianRed','wpm')?></option>
				<option value="Indigo"<?php if (get_option("slidercolortitle") == "Indigo") { echo ' selected="selected"'; } ?>><?php _e('Indigo','wpm')?></option>
				<option value="Ivory"<?php if (get_option("slidercolortitle") == "Ivory") { echo ' selected="selected"'; } ?>><?php _e('Ivory','wpm')?></option>
				<option value="Khaki"<?php if (get_option("slidercolortitle") == "Khaki") { echo ' selected="selected"'; } ?>><?php _e('Khaki','wpm')?></option>
				<option value="Lavender"<?php if (get_option("slidercolortitle") == "Lavender") { echo ' selected="selected"'; } ?>><?php _e('Lavender','wpm')?></option>
				<option value="LavenderBlush"<?php if (get_option("slidercolortitle") == "LavenderBlush") { echo ' selected="selected"'; } ?>><?php _e('LavenderBlush','wpm')?></option>
				<option value="LawnGreen"<?php if (get_option("slidercolortitle") == "LawnGreen") { echo ' selected="selected"'; } ?>><?php _e('LawnGreen','wpm')?></option>
				<option value="LemonChiffon"<?php if (get_option("slidercolortitle") == "LemonChiffon") { echo ' selected="selected"'; } ?>><?php _e('LemonChiffon','wpm')?></option>
				<option value="LightBlue"<?php if (get_option("slidercolortitle") == "LightBlue") { echo ' selected="selected"'; } ?>><?php _e('LightBlue','wpm')?></option>
				<option value="LightCoral"<?php if (get_option("slidercolortitle") == "LightCoral") { echo ' selected="selected"'; } ?>><?php _e('LightCoral','wpm')?></option>
				<option value="LightCyan"<?php if (get_option("slidercolortitle") == "LightCyan") { echo ' selected="selected"'; } ?>><?php _e('LightCyan','wpm')?></option>
				<option value="LightGoldenRodYellow"<?php if (get_option("slidercolortitle") == "LightGoldenRodYellow") { echo ' selected="selected"'; } ?>><?php _e('LightGoldenRodYellow','wpm')?></option>
				<option value="LightGray"<?php if (get_option("slidercolortitle") == "LightGray") { echo ' selected="selected"'; } ?>><?php _e('LightGray','wpm')?></option>
				<option value="LightGrey"<?php if (get_option("slidercolortitle") == "LightGrey") { echo ' selected="selected"'; } ?>><?php _e('LightGrey','wpm')?></option>
				<option value="LightGreen"<?php if (get_option("slidercolortitle") == "LightGreen") { echo ' selected="selected"'; } ?>><?php _e('LightGreen','wpm')?></option>
				<option value="LightPink"<?php if (get_option("slidercolortitle") == "LightPink") { echo ' selected="selected"'; } ?>><?php _e('LightPink','wpm')?></option>
				<option value="LightSalmon"<?php if (get_option("slidercolortitle") == "LightSalmon") { echo ' selected="selected"'; } ?>><?php _e('LightSalmon','wpm')?></option>
				<option value="LightSeaGreen"<?php if (get_option("slidercolortitle") == "LightSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('LightSeaGreen','wpm')?></option>
				<option value="LightSkyBlue"<?php if (get_option("slidercolortitle") == "LightSkyBlue") { echo ' selected="selected"'; } ?>><?php _e('LightSkyBlue','wpm')?></option>
				<option value="LightSlateGray"<?php if (get_option("slidercolortitle") == "LightSlateGray") { echo ' selected="selected"'; } ?>><?php _e('LightSlateGray','wpm')?></option>
				<option value="LightSlateGrey"<?php if (get_option("slidercolortitle") == "LightSlateGrey") { echo ' selected="selected"'; } ?>><?php _e('LightSlateGrey','wpm')?></option>
				<option value="LightSteelBlue"<?php if (get_option("slidercolortitle") == "LightSteelBlue") { echo ' selected="selected"'; } ?>><?php _e('LightSteelBlue','wpm')?></option>
				<option value="LightYellow"<?php if (get_option("slidercolortitle") == "LightYellow") { echo ' selected="selected"'; } ?>><?php _e('LightYellow','wpm')?></option>
				<option value="Lime"<?php if (get_option("slidercolortitle") == "Lime") { echo ' selected="selected"'; } ?>><?php _e('Lime','wpm')?></option>
				<option value="LimeGreen"<?php if (get_option("slidercolortitle") == "LimeGreen") { echo ' selected="selected"'; } ?>><?php _e('LimeGreen','wpm')?></option>
				<option value="Linen"<?php if (get_option("slidercolortitle") == "Linen") { echo ' selected="selected"'; } ?>><?php _e('Linen','wpm')?></option>
				<option value="Magenta"<?php if (get_option("slidercolortitle") == "Magenta") { echo ' selected="selected"'; } ?>><?php _e('Magenta','wpm')?></option>
				<option value="Maroon"<?php if (get_option("slidercolortitle") == "Maroon") { echo ' selected="selected"'; } ?>><?php _e('Maroon','wpm')?></option>
				<option value="MediumAquaMarine"<?php if (get_option("slidercolortitle") == "MediumAquaMarine") { echo ' selected="selected"'; } ?>><?php _e('MediumAquaMarine','wpm')?></option>
				<option value="MediumBlue"<?php if (get_option("slidercolortitle") == "MediumBlue") { echo ' selected="selected"'; } ?>><?php _e('MediumBlue','wpm')?></option>
				<option value="MediumOrchid"<?php if (get_option("slidercolortitle") == "MediumOrchid") { echo ' selected="selected"'; } ?>><?php _e('MediumOrchid','wpm')?></option>
				<option value="MediumPurple"<?php if (get_option("slidercolortitle") == "MediumPurple") { echo ' selected="selected"'; } ?>><?php _e('MediumPurple','wpm')?></option>
				<option value="MediumSeaGreen"<?php if (get_option("slidercolortitle") == "MediumSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('MediumSeaGreen','wpm')?></option>
				<option value="MediumSlateBlue"<?php if (get_option("slidercolortitle") == "MediumSlateBlue") { echo ' selected="selected"'; } ?>><?php _e('MediumSlateBlue','wpm')?></option>
				<option value="MediumSpringGreen"<?php if (get_option("slidercolortitle") == "MediumSpringGreen") { echo ' selected="selected"'; } ?>><?php _e('MediumSpringGreen','wpm')?></option>
				<option value="MediumTurquoise"<?php if (get_option("slidercolortitle") == "MediumTurquoise") { echo ' selected="selected"'; } ?>><?php _e('MediumTurquoise','wpm')?></option>
				<option value="MediumVioletRed"<?php if (get_option("slidercolortitle") == "MediumVioletRed") { echo ' selected="selected"'; } ?>><?php _e('MediumVioletRed','wpm')?></option>
				<option value="MidnightBlue"<?php if (get_option("slidercolortitle") == "MidnightBlue") { echo ' selected="selected"'; } ?>><?php _e('MidnightBlue','wpm')?></option>
				<option value="MintCream"<?php if (get_option("slidercolortitle") == "MintCream") { echo ' selected="selected"'; } ?>><?php _e('MintCream','wpm')?></option>
				<option value="MistyRose"<?php if (get_option("slidercolortitle") == "MistyRose") { echo ' selected="selected"'; } ?>><?php _e('MistyRose','wpm')?></option>
				<option value="Moccasin"<?php if (get_option("slidercolortitle") == "Moccasin") { echo ' selected="selected"'; } ?>><?php _e('Moccasin','wpm')?></option>
				<option value="NavajoWhite"<?php if (get_option("slidercolortitle") == "NavajoWhite") { echo ' selected="selected"'; } ?>><?php _e('NavajoWhite','wpm')?></option>
				<option value="Navy"<?php if (get_option("slidercolortitle") == "Navy") { echo ' selected="selected"'; } ?>><?php _e('Navy','wpm')?></option>
				<option value="OldLace"<?php if (get_option("slidercolortitle") == "OldLace") { echo ' selected="selected"'; } ?>><?php _e('OldLace','wpm')?></option>
				<option value="Olive"<?php if (get_option("slidercolortitle") == "Olive") { echo ' selected="selected"'; } ?>><?php _e('Olive','wpm')?></option>
				<option value="OliveDrab"<?php if (get_option("slidercolortitle") == "OliveDrab") { echo ' selected="selected"'; } ?>><?php _e('OliveDrab','wpm')?></option>
				<option value="Orange"<?php if (get_option("slidercolortitle") == "Orange") { echo ' selected="selected"'; } ?>><?php _e('Orange','wpm')?></option>
				<option value="OrangeRed"<?php if (get_option("slidercolortitle") == "OrangeRed") { echo ' selected="selected"'; } ?>><?php _e('OrangeRed','wpm')?></option>
				<option value="Orchid"<?php if (get_option("slidercolortitle") == "Orchid") { echo ' selected="selected"'; } ?>><?php _e('Orchid','wpm')?></option>
				<option value="PaleGoldenRod"<?php if (get_option("slidercolortitle") == "PaleGoldenRod") { echo ' selected="selected"'; } ?>><?php _e('PaleGoldenRod','wpm')?></option>
				<option value="PaleGreen"<?php if (get_option("slidercolortitle") == "PaleGreen") { echo ' selected="selected"'; } ?>><?php _e('PaleGreen','wpm')?></option>
				<option value="PaleTurquoise"<?php if (get_option("slidercolortitle") == "PaleTurquoise") { echo ' selected="selected"'; } ?>><?php _e('PaleTurquoise','wpm')?></option>
				<option value="PaleVioletRed"<?php if (get_option("slidercolortitle") == "PaleVioletRed") { echo ' selected="selected"'; } ?>><?php _e('PaleVioletRed','wpm')?></option>
				<option value="PapayaWhip"<?php if (get_option("slidercolortitle") == "PapayaWhip") { echo ' selected="selected"'; } ?>><?php _e('PapayaWhip','wpm')?></option>
				<option value="PeachPuff"<?php if (get_option("slidercolortitle") == "PeachPuff") { echo ' selected="selected"'; } ?>><?php _e('PeachPuff','wpm')?></option>
				<option value="Peru"<?php if (get_option("slidercolortitle") == "Peru") { echo ' selected="selected"'; } ?>><?php _e('Peru','wpm')?></option>
				<option value="Pink"<?php if (get_option("slidercolortitle") == "Pink") { echo ' selected="selected"'; } ?>><?php _e('Pink','wpm')?></option>
				<option value="Plum"<?php if (get_option("slidercolortitle") == "Plum") { echo ' selected="selected"'; } ?>><?php _e('Plum','wpm')?></option>
				<option value="PowderBlue"<?php if (get_option("slidercolortitle") == "PowderBlue") { echo ' selected="selected"'; } ?>><?php _e('PowderBlue','wpm')?></option>
				<option value="Purple"<?php if (get_option("slidercolortitle") == "Purple") { echo ' selected="selected"'; } ?>><?php _e('Purple','wpm')?></option>
				<option value="Red"<?php if (get_option("slidercolortitle") == "Red") { echo ' selected="selected"'; } ?>><?php _e('Red','wpm')?></option>
				<option value="RosyBrown"<?php if (get_option("slidercolortitle") == "RosyBrown") { echo ' selected="selected"'; } ?>><?php _e('RosyBrown','wpm')?></option>
				<option value="RoyalBlue"<?php if (get_option("slidercolortitle") == "RoyalBlue") { echo ' selected="selected"'; } ?>><?php _e('RoyalBlue','wpm')?></option>
				<option value="SaddleBrown"<?php if (get_option("slidercolortitle") == "SaddleBrown") { echo ' selected="selected"'; } ?>><?php _e('SaddleBrown','wpm')?></option>
				<option value="Salmon"<?php if (get_option("slidercolortitle") == "Salmon") { echo ' selected="selected"'; } ?>><?php _e('Salmon','wpm')?></option>
				<option value="SandyBrown"<?php if (get_option("slidercolortitle") == "SandyBrown") { echo ' selected="selected"'; } ?>><?php _e('SandyBrown','wpm')?></option>
				<option value="SeaGreen"<?php if (get_option("slidercolortitle") == "SeaGreen") { echo ' selected="selected"'; } ?>><?php _e('SeaGreen','wpm')?></option>
				<option value="SeaShell"<?php if (get_option("slidercolortitle") == "SeaShell") { echo ' selected="selected"'; } ?>><?php _e('SeaShell','wpm')?></option>
				<option value="Sienna"<?php if (get_option("slidercolortitle") == "Sienna") { echo ' selected="selected"'; } ?>><?php _e('Sienna','wpm')?></option>
				<option value="Silver"<?php if (get_option("slidercolortitle") == "Silver") { echo ' selected="selected"'; } ?>><?php _e('Silver','wpm')?></option>
				<option value="SkyBlue"<?php if (get_option("slidercolortitle") == "SkyBlue") { echo ' selected="selected"'; } ?>><?php _e('SkyBlue','wpm')?></option>
				<option value="SlateBlue"<?php if (get_option("slidercolortitle") == "SlateBlue") { echo ' selected="selected"'; } ?>><?php _e('SlateBlue','wpm')?></option>
				<option value="SlateGray"<?php if (get_option("slidercolortitle") == "SlateGray") { echo ' selected="selected"'; } ?>><?php _e('SlateGray','wpm')?></option>
				<option value="SlateGrey"<?php if (get_option("slidercolortitle") == "SlateGrey") { echo ' selected="selected"'; } ?>><?php _e('SlateGrey','wpm')?></option>
				<option value="Snow"<?php if (get_option("slidercolortitle") == "Snow") { echo ' selected="selected"'; } ?>><?php _e('Snow','wpm')?></option>
				<option value="SpringGreen"<?php if (get_option("slidercolortitle") == "SpringGreen") { echo ' selected="selected"'; } ?>><?php _e('SpringGreen','wpm')?></option>
				<option value="SteelBlue"<?php if (get_option("slidercolortitle") == "SteelBlue") { echo ' selected="selected"'; } ?>><?php _e('SteelBlue','wpm')?></option>
				<option value="Tan"<?php if (get_option("slidercolortitle") == "Tan") { echo ' selected="selected"'; } ?>><?php _e('Tan','wpm')?></option>
				<option value="Teal"<?php if (get_option("slidercolortitle") == "Teal") { echo ' selected="selected"'; } ?>><?php _e('Teal','wpm')?></option>
				<option value="Thistle"<?php if (get_option("slidercolortitle") == "Thistle") { echo ' selected="selected"'; } ?>><?php _e('Thistle','wpm')?></option>
				<option value="Tomato"<?php if (get_option("slidercolortitle") == "Tomato") { echo ' selected="selected"'; } ?>><?php _e('Tomato','wpm')?></option>
				<option value="Turquoise"<?php if (get_option("slidercolortitle") == "Turquoise") { echo ' selected="selected"'; } ?>><?php _e('Turquoise','wpm')?></option>
				<option value="Violet"<?php if (get_option("slidercolortitle") == "Violet") { echo ' selected="selected"'; } ?>><?php _e('Violet','wpm')?></option>
				<option value="Wheat"<?php if (get_option("slidercolortitle") == "Wheat") { echo ' selected="selected"'; } ?>><?php _e('Wheat','wpm')?></option>
				<option value="WhiteSmoke"<?php if (get_option("slidercolortitle") == "WhiteSmoke") { echo ' selected="selected"'; } ?>><?php _e('WhiteSmoke','wpm')?></option>
				<option value="Yellow"<?php if (get_option("slidercolortitle") == "Yellow") { echo ' selected="selected"'; } ?>><?php _e('Yellow','wpm')?></option>
				<option value="YellowGreen"<?php if (get_option("slidercolortitle") == "YellowGreen") { echo ' selected="selected"'; } ?>><?php _e('YellowGreen','wpm')?></option>
			</select><br />
			<small><?php _e("Choose font color title slider. <a href='http://www.w3schools.com/tags/ref_color_tryit.asp'>Tryit</a> on www.w3schools.com",'wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Font Color Description Slider','wpm')?></td>
		<td class="forminp">
			<select name="adminArray[slidercolordes]" style="width: 250px;">
				<option value="White"<?php if (get_option("slidercolordes") == "White") { echo ' selected="selected"'; } ?>><?php _e('White','wpm')?></option>
				<option value="AntiqueWhite"<?php if (get_option("slidercolordes") == "AntiqueWhite") { echo ' selected="selected"'; } ?>><?php _e('AntiqueWhite','wpm')?></option>
				<option value="Aqua"<?php if (get_option("slidercolordes") == "Aqua") { echo ' selected="selected"'; } ?>><?php _e('Aqua','wpm')?></option>
				<option value="Aquamarine"<?php if (get_option("slidercolordes") == "Aquamarine") { echo ' selected="selected"'; } ?>><?php _e('Aquamarine','wpm')?></option>
				<option value="Azure"<?php if (get_option("slidercolordes") == "Azure") { echo ' selected="selected"'; } ?>><?php _e('Azure','wpm')?></option>
				<option value="Beige"<?php if (get_option("slidercolordes") == "Beige") { echo ' selected="selected"'; } ?>><?php _e('Beige','wpm')?></option>
				<option value="Bisque"<?php if (get_option("slidercolordes") == "Bisque") { echo ' selected="selected"'; } ?>><?php _e('Bisque','wpm')?></option>
				<option value="Black"<?php if (get_option("slidercolordes") == "Black") { echo ' selected="selected"'; } ?>><?php _e('Black','wpm')?></option>
				<option value="BlanchedAlmond"<?php if (get_option("slidercolordes") == "BlanchedAlmond") { echo ' selected="selected"'; } ?>><?php _e('BlanchedAlmond','wpm')?></option>
				<option value="Blue"<?php if (get_option("slidercolordes") == "Blue") { echo ' selected="selected"'; } ?>><?php _e('Blue','wpm')?></option>
				<option value="BlueViolet"<?php if (get_option("slidercolordes") == "BlueViolet") { echo ' selected="selected"'; } ?>><?php _e('BlueViolet','wpm')?></option>
				<option value="Brown"<?php if (get_option("slidercolordes") == "Brown") { echo ' selected="selected"'; } ?>><?php _e('Brown','wpm')?></option>
				<option value="BurlyWood"<?php if (get_option("slidercolordes") == "BurlyWood") { echo ' selected="selected"'; } ?>><?php _e('BurlyWood','wpm')?></option>
				<option value="CadetBlue"<?php if (get_option("slidercolordes") == "CadetBlue") { echo ' selected="selected"'; } ?>><?php _e('CadetBlue','wpm')?></option>
				<option value="Chartreuse"<?php if (get_option("slidercolordes") == "Chartreuse") { echo ' selected="selected"'; } ?>><?php _e('Chartreuse','wpm')?></option>
				<option value="Chocolate"<?php if (get_option("slidercolordes") == "Chocolate") { echo ' selected="selected"'; } ?>><?php _e('Chocolate','wpm')?></option>
				<option value="Coral"<?php if (get_option("slidercolordes") == "Coral") { echo ' selected="selected"'; } ?>><?php _e('Coral','wpm')?></option>
				<option value="CornflowerBlue"<?php if (get_option("slidercolordes") == "CornflowerBlue") { echo ' selected="selected"'; } ?>><?php _e('CornflowerBlue','wpm')?></option>
				<option value="Cornsilk"<?php if (get_option("slidercolordes") == "Cornsilk") { echo ' selected="selected"'; } ?>><?php _e('Cornsilk','wpm')?></option>
				<option value="Crimson"<?php if (get_option("slidercolordes") == "Crimson") { echo ' selected="selected"'; } ?>><?php _e('Crimson','wpm')?></option>
				<option value="Cyan"<?php if (get_option("slidercolordes") == "Cyan") { echo ' selected="selected"'; } ?>><?php _e('Cyan','wpm')?></option>
				<option value="DarkBlue"<?php if (get_option("slidercolordes") == "DarkBlue") { echo ' selected="selected"'; } ?>><?php _e('DarkBlue','wpm')?></option>
				<option value="DarkCyan"<?php if (get_option("slidercolordes") == "DarkCyan") { echo ' selected="selected"'; } ?>><?php _e('DarkCyan','wpm')?></option>
				<option value="DarkGoldenRod"<?php if (get_option("slidercolordes") == "DarkGoldenRod") { echo ' selected="selected"'; } ?>><?php _e('DarkGoldenRod','wpm')?></option>
				<option value="DarkGray"<?php if (get_option("slidercolordes") == "DarkGray") { echo ' selected="selected"'; } ?>><?php _e('DarkGray','wpm')?></option>
				<option value="DarkGrey"<?php if (get_option("slidercolordes") == "DarkGrey") { echo ' selected="selected"'; } ?>><?php _e('DarkGrey','wpm')?></option>
				<option value="DarkGreen"<?php if (get_option("slidercolordes") == "DarkGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkGreen','wpm')?></option>
				<option value="DarkKhaki"<?php if (get_option("slidercolordes") == "DarkKhaki") { echo ' selected="selected"'; } ?>><?php _e('DarkKhaki','wpm')?></option>
				<option value="DarkMagenta"<?php if (get_option("slidercolordes") == "DarkMagenta") { echo ' selected="selected"'; } ?>><?php _e('DarkMagenta','wpm')?></option>
				<option value="DarkOliveGreen"<?php if (get_option("slidercolordes") == "DarkOliveGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkOliveGreen','wpm')?></option>
				<option value="Darkorange"<?php if (get_option("slidercolordes") == "Darkorange") { echo ' selected="selected"'; } ?>><?php _e('Darkorange','wpm')?></option>
				<option value="DarkOrchid"<?php if (get_option("slidercolordes") == "DarkOrchid") { echo ' selected="selected"'; } ?>><?php _e('DarkOrchid','wpm')?></option>
				<option value="DarkRed"<?php if (get_option("slidercolordes") == "DarkRed") { echo ' selected="selected"'; } ?>><?php _e('DarkRed','wpm')?></option>
				<option value="DarkSalmon"<?php if (get_option("slidercolordes") == "DarkSalmon") { echo ' selected="selected"'; } ?>><?php _e('DarkSalmon','wpm')?></option>
				<option value="DarkSeaGreen"<?php if (get_option("slidercolordes") == "DarkSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('DarkSeaGreen','wpm')?></option>
				<option value="DarkSlateBlue"<?php if (get_option("slidercolordes") == "DarkSlateBlue") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateBlue','wpm')?></option>
				<option value="DarkSlateGray"<?php if (get_option("slidercolordes") == "DarkSlateGray") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateGray','wpm')?></option>
				<option value="DarkSlateGrey"<?php if (get_option("slidercolordes") == "DarkSlateGrey") { echo ' selected="selected"'; } ?>><?php _e('DarkSlateGrey','wpm')?></option>
				<option value="DarkTurquoise"<?php if (get_option("slidercolordes") == "DarkTurquoise") { echo ' selected="selected"'; } ?>><?php _e('DarkTurquoise','wpm')?></option>
				<option value="DarkViolet"<?php if (get_option("slidercolordes") == "DarkViolet") { echo ' selected="selected"'; } ?>><?php _e('DarkViolet','wpm')?></option>
				<option value="DeepPink"<?php if (get_option("slidercolordes") == "DeepPink") { echo ' selected="selected"'; } ?>><?php _e('DeepPink','wpm')?></option>
				<option value="DeepSkyBlue"<?php if (get_option("slidercolordes") == "DeepSkyBlue") { echo ' selected="selected"'; } ?>><?php _e('DeepSkyBlue','wpm')?></option>
				<option value="DimGray"<?php if (get_option("slidercolordes") == "DimGray") { echo ' selected="selected"'; } ?>><?php _e('DimGray','wpm')?></option>
				<option value="DimGrey"<?php if (get_option("slidercolordes") == "DimGrey") { echo ' selected="selected"'; } ?>><?php _e('DimGrey','wpm')?></option>
				<option value="DodgerBlue"<?php if (get_option("slidercolordes") == "DodgerBlue") { echo ' selected="selected"'; } ?>><?php _e('DodgerBlue','wpm')?></option>
				<option value="FireBrick"<?php if (get_option("slidercolordes") == "FireBrick") { echo ' selected="selected"'; } ?>><?php _e('FireBrick','wpm')?></option>
				<option value="FloralWhite"<?php if (get_option("slidercolordes") == "FloralWhite") { echo ' selected="selected"'; } ?>><?php _e('FloralWhite','wpm')?></option>
				<option value="ForestGreen"<?php if (get_option("slidercolordes") == "ForestGreen") { echo ' selected="selected"'; } ?>><?php _e('ForestGreen','wpm')?></option>
				<option value="Fuchsia"<?php if (get_option("slidercolordes") == "Fuchsia") { echo ' selected="selected"'; } ?>><?php _e('Fuchsia','wpm')?></option>
				<option value="Gainsboro"<?php if (get_option("slidercolordes") == "Gainsboro") { echo ' selected="selected"'; } ?>><?php _e('Gainsboro','wpm')?></option>
				<option value="GhostWhite"<?php if (get_option("slidercolordes") == "GhostWhite") { echo ' selected="selected"'; } ?>><?php _e('GhostWhite','wpm')?></option>
				<option value="Gold"<?php if (get_option("slidercolordes") == "Gold") { echo ' selected="selected"'; } ?>><?php _e('Gold','wpm')?></option>
				<option value="GoldenRod"<?php if (get_option("slidercolordes") == "GoldenRod") { echo ' selected="selected"'; } ?>><?php _e('GoldenRod','wpm')?></option>
				<option value="Gray"<?php if (get_option("slidercolordes") == "Gray") { echo ' selected="selected"'; } ?>><?php _e('Gray','wpm')?></option>
				<option value="Grey"<?php if (get_option("slidercolordes") == "Grey") { echo ' selected="selected"'; } ?>><?php _e('Grey','wpm')?></option>
				<option value="Green"<?php if (get_option("slidercolordes") == "Green") { echo ' selected="selected"'; } ?>><?php _e('Green','wpm')?></option>
				<option value="GreenYellow"<?php if (get_option("slidercolordes") == "GreenYellow") { echo ' selected="selected"'; } ?>><?php _e('GreenYellow','wpm')?></option>
				<option value="HoneyDew"<?php if (get_option("slidercolordes") == "HoneyDew") { echo ' selected="selected"'; } ?>><?php _e('HoneyDew','wpm')?></option>
				<option value="HotPink"<?php if (get_option("slidercolordes") == "HotPink") { echo ' selected="selected"'; } ?>><?php _e('HotPink','wpm')?></option>
				<option value="IndianRed"<?php if (get_option("slidercolordes") == "IndianRed") { echo ' selected="selected"'; } ?>><?php _e('IndianRed','wpm')?></option>
				<option value="Indigo"<?php if (get_option("slidercolordes") == "Indigo") { echo ' selected="selected"'; } ?>><?php _e('Indigo','wpm')?></option>
				<option value="Ivory"<?php if (get_option("slidercolordes") == "Ivory") { echo ' selected="selected"'; } ?>><?php _e('Ivory','wpm')?></option>
				<option value="Khaki"<?php if (get_option("slidercolordes") == "Khaki") { echo ' selected="selected"'; } ?>><?php _e('Khaki','wpm')?></option>
				<option value="Lavender"<?php if (get_option("slidercolordes") == "Lavender") { echo ' selected="selected"'; } ?>><?php _e('Lavender','wpm')?></option>
				<option value="LavenderBlush"<?php if (get_option("slidercolordes") == "LavenderBlush") { echo ' selected="selected"'; } ?>><?php _e('LavenderBlush','wpm')?></option>
				<option value="LawnGreen"<?php if (get_option("slidercolordes") == "LawnGreen") { echo ' selected="selected"'; } ?>><?php _e('LawnGreen','wpm')?></option>
				<option value="LemonChiffon"<?php if (get_option("slidercolordes") == "LemonChiffon") { echo ' selected="selected"'; } ?>><?php _e('LemonChiffon','wpm')?></option>
				<option value="LightBlue"<?php if (get_option("slidercolordes") == "LightBlue") { echo ' selected="selected"'; } ?>><?php _e('LightBlue','wpm')?></option>
				<option value="LightCoral"<?php if (get_option("slidercolordes") == "LightCoral") { echo ' selected="selected"'; } ?>><?php _e('LightCoral','wpm')?></option>
				<option value="LightCyan"<?php if (get_option("slidercolordes") == "LightCyan") { echo ' selected="selected"'; } ?>><?php _e('LightCyan','wpm')?></option>
				<option value="LightGoldenRodYellow"<?php if (get_option("slidercolordes") == "LightGoldenRodYellow") { echo ' selected="selected"'; } ?>><?php _e('LightGoldenRodYellow','wpm')?></option>
				<option value="LightGray"<?php if (get_option("slidercolordes") == "LightGray") { echo ' selected="selected"'; } ?>><?php _e('LightGray','wpm')?></option>
				<option value="LightGrey"<?php if (get_option("slidercolordes") == "LightGrey") { echo ' selected="selected"'; } ?>><?php _e('LightGrey','wpm')?></option>
				<option value="LightGreen"<?php if (get_option("slidercolordes") == "LightGreen") { echo ' selected="selected"'; } ?>><?php _e('LightGreen','wpm')?></option>
				<option value="LightPink"<?php if (get_option("slidercolordes") == "LightPink") { echo ' selected="selected"'; } ?>><?php _e('LightPink','wpm')?></option>
				<option value="LightSalmon"<?php if (get_option("slidercolordes") == "LightSalmon") { echo ' selected="selected"'; } ?>><?php _e('LightSalmon','wpm')?></option>
				<option value="LightSeaGreen"<?php if (get_option("slidercolordes") == "LightSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('LightSeaGreen','wpm')?></option>
				<option value="LightSkyBlue"<?php if (get_option("slidercolordes") == "LightSkyBlue") { echo ' selected="selected"'; } ?>><?php _e('LightSkyBlue','wpm')?></option>
				<option value="LightSlateGray"<?php if (get_option("slidercolordes") == "LightSlateGray") { echo ' selected="selected"'; } ?>><?php _e('LightSlateGray','wpm')?></option>
				<option value="LightSlateGrey"<?php if (get_option("slidercolordes") == "LightSlateGrey") { echo ' selected="selected"'; } ?>><?php _e('LightSlateGrey','wpm')?></option>
				<option value="LightSteelBlue"<?php if (get_option("slidercolordes") == "LightSteelBlue") { echo ' selected="selected"'; } ?>><?php _e('LightSteelBlue','wpm')?></option>
				<option value="LightYellow"<?php if (get_option("slidercolordes") == "LightYellow") { echo ' selected="selected"'; } ?>><?php _e('LightYellow','wpm')?></option>
				<option value="Lime"<?php if (get_option("slidercolordes") == "Lime") { echo ' selected="selected"'; } ?>><?php _e('Lime','wpm')?></option>
				<option value="LimeGreen"<?php if (get_option("slidercolordes") == "LimeGreen") { echo ' selected="selected"'; } ?>><?php _e('LimeGreen','wpm')?></option>
				<option value="Linen"<?php if (get_option("slidercolordes") == "Linen") { echo ' selected="selected"'; } ?>><?php _e('Linen','wpm')?></option>
				<option value="Magenta"<?php if (get_option("slidercolordes") == "Magenta") { echo ' selected="selected"'; } ?>><?php _e('Magenta','wpm')?></option>
				<option value="Maroon"<?php if (get_option("slidercolordes") == "Maroon") { echo ' selected="selected"'; } ?>><?php _e('Maroon','wpm')?></option>
				<option value="MediumAquaMarine"<?php if (get_option("slidercolordes") == "MediumAquaMarine") { echo ' selected="selected"'; } ?>><?php _e('MediumAquaMarine','wpm')?></option>
				<option value="MediumBlue"<?php if (get_option("slidercolordes") == "MediumBlue") { echo ' selected="selected"'; } ?>><?php _e('MediumBlue','wpm')?></option>
				<option value="MediumOrchid"<?php if (get_option("slidercolordes") == "MediumOrchid") { echo ' selected="selected"'; } ?>><?php _e('MediumOrchid','wpm')?></option>
				<option value="MediumPurple"<?php if (get_option("slidercolordes") == "MediumPurple") { echo ' selected="selected"'; } ?>><?php _e('MediumPurple','wpm')?></option>
				<option value="MediumSeaGreen"<?php if (get_option("slidercolordes") == "MediumSeaGreen") { echo ' selected="selected"'; } ?>><?php _e('MediumSeaGreen','wpm')?></option>
				<option value="MediumSlateBlue"<?php if (get_option("slidercolordes") == "MediumSlateBlue") { echo ' selected="selected"'; } ?>><?php _e('MediumSlateBlue','wpm')?></option>
				<option value="MediumSpringGreen"<?php if (get_option("slidercolordes") == "MediumSpringGreen") { echo ' selected="selected"'; } ?>><?php _e('MediumSpringGreen','wpm')?></option>
				<option value="MediumTurquoise"<?php if (get_option("slidercolordes") == "MediumTurquoise") { echo ' selected="selected"'; } ?>><?php _e('MediumTurquoise','wpm')?></option>
				<option value="MediumVioletRed"<?php if (get_option("slidercolordes") == "MediumVioletRed") { echo ' selected="selected"'; } ?>><?php _e('MediumVioletRed','wpm')?></option>
				<option value="MidnightBlue"<?php if (get_option("slidercolordes") == "MidnightBlue") { echo ' selected="selected"'; } ?>><?php _e('MidnightBlue','wpm')?></option>
				<option value="MintCream"<?php if (get_option("slidercolordes") == "MintCream") { echo ' selected="selected"'; } ?>><?php _e('MintCream','wpm')?></option>
				<option value="MistyRose"<?php if (get_option("slidercolordes") == "MistyRose") { echo ' selected="selected"'; } ?>><?php _e('MistyRose','wpm')?></option>
				<option value="Moccasin"<?php if (get_option("slidercolordes") == "Moccasin") { echo ' selected="selected"'; } ?>><?php _e('Moccasin','wpm')?></option>
				<option value="NavajoWhite"<?php if (get_option("slidercolordes") == "NavajoWhite") { echo ' selected="selected"'; } ?>><?php _e('NavajoWhite','wpm')?></option>
				<option value="Navy"<?php if (get_option("slidercolordes") == "Navy") { echo ' selected="selected"'; } ?>><?php _e('Navy','wpm')?></option>
				<option value="OldLace"<?php if (get_option("slidercolordes") == "OldLace") { echo ' selected="selected"'; } ?>><?php _e('OldLace','wpm')?></option>
				<option value="Olive"<?php if (get_option("slidercolordes") == "Olive") { echo ' selected="selected"'; } ?>><?php _e('Olive','wpm')?></option>
				<option value="OliveDrab"<?php if (get_option("slidercolordes") == "OliveDrab") { echo ' selected="selected"'; } ?>><?php _e('OliveDrab','wpm')?></option>
				<option value="Orange"<?php if (get_option("slidercolordes") == "Orange") { echo ' selected="selected"'; } ?>><?php _e('Orange','wpm')?></option>
				<option value="OrangeRed"<?php if (get_option("slidercolordes") == "OrangeRed") { echo ' selected="selected"'; } ?>><?php _e('OrangeRed','wpm')?></option>
				<option value="Orchid"<?php if (get_option("slidercolordes") == "Orchid") { echo ' selected="selected"'; } ?>><?php _e('Orchid','wpm')?></option>
				<option value="PaleGoldenRod"<?php if (get_option("slidercolordes") == "PaleGoldenRod") { echo ' selected="selected"'; } ?>><?php _e('PaleGoldenRod','wpm')?></option>
				<option value="PaleGreen"<?php if (get_option("slidercolordes") == "PaleGreen") { echo ' selected="selected"'; } ?>><?php _e('PaleGreen','wpm')?></option>
				<option value="PaleTurquoise"<?php if (get_option("slidercolordes") == "PaleTurquoise") { echo ' selected="selected"'; } ?>><?php _e('PaleTurquoise','wpm')?></option>
				<option value="PaleVioletRed"<?php if (get_option("slidercolordes") == "PaleVioletRed") { echo ' selected="selected"'; } ?>><?php _e('PaleVioletRed','wpm')?></option>
				<option value="PapayaWhip"<?php if (get_option("slidercolordes") == "PapayaWhip") { echo ' selected="selected"'; } ?>><?php _e('PapayaWhip','wpm')?></option>
				<option value="PeachPuff"<?php if (get_option("slidercolordes") == "PeachPuff") { echo ' selected="selected"'; } ?>><?php _e('PeachPuff','wpm')?></option>
				<option value="Peru"<?php if (get_option("slidercolordes") == "Peru") { echo ' selected="selected"'; } ?>><?php _e('Peru','wpm')?></option>
				<option value="Pink"<?php if (get_option("slidercolordes") == "Pink") { echo ' selected="selected"'; } ?>><?php _e('Pink','wpm')?></option>
				<option value="Plum"<?php if (get_option("slidercolordes") == "Plum") { echo ' selected="selected"'; } ?>><?php _e('Plum','wpm')?></option>
				<option value="PowderBlue"<?php if (get_option("slidercolordes") == "PowderBlue") { echo ' selected="selected"'; } ?>><?php _e('PowderBlue','wpm')?></option>
				<option value="Purple"<?php if (get_option("slidercolordes") == "Purple") { echo ' selected="selected"'; } ?>><?php _e('Purple','wpm')?></option>
				<option value="Red"<?php if (get_option("slidercolordes") == "Red") { echo ' selected="selected"'; } ?>><?php _e('Red','wpm')?></option>
				<option value="RosyBrown"<?php if (get_option("slidercolordes") == "RosyBrown") { echo ' selected="selected"'; } ?>><?php _e('RosyBrown','wpm')?></option>
				<option value="RoyalBlue"<?php if (get_option("slidercolordes") == "RoyalBlue") { echo ' selected="selected"'; } ?>><?php _e('RoyalBlue','wpm')?></option>
				<option value="SaddleBrown"<?php if (get_option("slidercolordes") == "SaddleBrown") { echo ' selected="selected"'; } ?>><?php _e('SaddleBrown','wpm')?></option>
				<option value="Salmon"<?php if (get_option("slidercolordes") == "Salmon") { echo ' selected="selected"'; } ?>><?php _e('Salmon','wpm')?></option>
				<option value="SandyBrown"<?php if (get_option("slidercolordes") == "SandyBrown") { echo ' selected="selected"'; } ?>><?php _e('SandyBrown','wpm')?></option>
				<option value="SeaGreen"<?php if (get_option("slidercolordes") == "SeaGreen") { echo ' selected="selected"'; } ?>><?php _e('SeaGreen','wpm')?></option>
				<option value="SeaShell"<?php if (get_option("slidercolordes") == "SeaShell") { echo ' selected="selected"'; } ?>><?php _e('SeaShell','wpm')?></option>
				<option value="Sienna"<?php if (get_option("slidercolordes") == "Sienna") { echo ' selected="selected"'; } ?>><?php _e('Sienna','wpm')?></option>
				<option value="Silver"<?php if (get_option("slidercolordes") == "Silver") { echo ' selected="selected"'; } ?>><?php _e('Silver','wpm')?></option>
				<option value="SkyBlue"<?php if (get_option("slidercolordes") == "SkyBlue") { echo ' selected="selected"'; } ?>><?php _e('SkyBlue','wpm')?></option>
				<option value="SlateBlue"<?php if (get_option("slidercolordes") == "SlateBlue") { echo ' selected="selected"'; } ?>><?php _e('SlateBlue','wpm')?></option>
				<option value="SlateGray"<?php if (get_option("slidercolordes") == "SlateGray") { echo ' selected="selected"'; } ?>><?php _e('SlateGray','wpm')?></option>
				<option value="SlateGrey"<?php if (get_option("slidercolordes") == "SlateGrey") { echo ' selected="selected"'; } ?>><?php _e('SlateGrey','wpm')?></option>
				<option value="Snow"<?php if (get_option("slidercolordes") == "Snow") { echo ' selected="selected"'; } ?>><?php _e('Snow','wpm')?></option>
				<option value="SpringGreen"<?php if (get_option("slidercolordes") == "SpringGreen") { echo ' selected="selected"'; } ?>><?php _e('SpringGreen','wpm')?></option>
				<option value="SteelBlue"<?php if (get_option("slidercolordes") == "SteelBlue") { echo ' selected="selected"'; } ?>><?php _e('SteelBlue','wpm')?></option>
				<option value="Tan"<?php if (get_option("slidercolordes") == "Tan") { echo ' selected="selected"'; } ?>><?php _e('Tan','wpm')?></option>
				<option value="Teal"<?php if (get_option("slidercolordes") == "Teal") { echo ' selected="selected"'; } ?>><?php _e('Teal','wpm')?></option>
				<option value="Thistle"<?php if (get_option("slidercolordes") == "Thistle") { echo ' selected="selected"'; } ?>><?php _e('Thistle','wpm')?></option>
				<option value="Tomato"<?php if (get_option("slidercolordes") == "Tomato") { echo ' selected="selected"'; } ?>><?php _e('Tomato','wpm')?></option>
				<option value="Turquoise"<?php if (get_option("slidercolordes") == "Turquoise") { echo ' selected="selected"'; } ?>><?php _e('Turquoise','wpm')?></option>
				<option value="Violet"<?php if (get_option("slidercolordes") == "Violet") { echo ' selected="selected"'; } ?>><?php _e('Violet','wpm')?></option>
				<option value="Wheat"<?php if (get_option("slidercolordes") == "Wheat") { echo ' selected="selected"'; } ?>><?php _e('Wheat','wpm')?></option>
				<option value="WhiteSmoke"<?php if (get_option("slidercolordes") == "WhiteSmoke") { echo ' selected="selected"'; } ?>><?php _e('WhiteSmoke','wpm')?></option>
				<option value="Yellow"<?php if (get_option("slidercolordes") == "Yellow") { echo ' selected="selected"'; } ?>><?php _e('Yellow','wpm')?></option>
				<option value="YellowGreen"<?php if (get_option("slidercolordes") == "YellowGreen") { echo ' selected="selected"'; } ?>><?php _e('YellowGreen','wpm')?></option>
			</select><br />
			<small><?php _e("Choose font color description slider. <a href='http://www.w3schools.com/tags/ref_color_tryit.asp'>Tryit</a> on www.w3schools.com",'wpm')?></small>
		</td>
	</tr>

</table>

<?php $i = 1;
while ($i <= get_option("slidercount")) {
?>
<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e("Slider $i","wpm")?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Title slider','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[title_slider_<?php echo $i;?>]" type="text" style="width: 600px;" value="<?php echo get_option("title_slider_$i"); ?>" /><br />
			<small><?php _e('This will show in the title slider of your site.','wpm')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Content slider','wpm')?></td>
		<td class="forminp">
		<textarea name="adminArray[content_slider_<?php echo $i;?>]" rows="8" cols="60"><?php echo stripslashes(get_option("content_slider_$i")); ?></textarea><br />
		<small><?php _e('Paste your content here. This will show in the slider of your site.','wpm')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Image URL','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[img_slider_<?php echo $i;?>]" type="text" style="width: 600px;" value="<?php echo get_option("img_slider_$i"); ?>" /><br />
			<small><?php _e('Paste the URL of your custom 600x300 slider image here. (i.e. http://www.yoursite.com/600x300slider.jpg)','wpm')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Destination','wpm')?></td>
		<td class="forminp">
			<input name="adminArray[url_slider_<?php echo $i;?>]" type="text" style="width: 600px;" value="<?php echo get_option("url_slider_$i"); ?>" /><br />
			<small><?php _e('Paste the destination URL you want people going to after they click on your slider. (i.e. http://www.anothersite.com/)','wpm')?></small>
		</td>
	</tr>
<?php $i++; } ?>
</table>


<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','wpm')?>" /></p>

<div style="clear: both;"></div>

</div>

<?php  } // process new ads
function wpmarks_images() {
?>

<div class="wrap">
<h2><?php _e('WPMarks','wpm')?></h2>

<?php wpm_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Images','wpm')?></h3> <p>&nbsp;<?php _e('Below you can view and delete the images users have uploaded.','wpm')?></p>
     						
<table class="maintable">

	<?php 
	$delete_file = strip_tags($_GET['delete']);
	if ( $delete_file != "" ) {
		$delete_file = "../wp-content/uploads/wpmarks/".$delete_file;
		unlink($delete_file);
		echo "<div class='del_image'>" . __('The image has been deleted','wpm') . "</div>";
	} ?>

<div class="wpmarks_images">
<?php
$image_url = get_template_directory_uri()."/includes/img_resize.php?width=100&height=100&url=";
$image_url2 = get_option('home');

if ($handle = opendir('../wp-content/uploads/wpmarks')) {
    // List all the files
    while (false !== ($file = readdir($handle))) {
        if ( $file == "." || $file == ".." ) {
        } else {
        	$size = filesize("../wp-content/uploads/wpmarks/".$file);
        	$size = $size / 1024;
        	$size = round($size)."Kb";
        ?>
        	<div class="oneimage-box">
        		<?php echo $file; ?><br />
        		<b><?php echo $size; ?></b>
        		<div class="oneimage" style="background: #EAF3FA url(<?php echo $image_url."$file"; ?>) center no-repeat; max-width: 100px;">
        			<a href="<?php echo "admin.php?page=images&delete=".$file; ?>#images"><img src="<?php bloginfo('template_url'); ?>/images/delete.png" align="right" title="<?php _e('Delete Image','wpm')?>" alt="<?php _e('Delete Image','wpm')?>" /></a>
        			<div style="clear: both; height: 5px;"></div>
					<a target="_blank" href="../wp-content/uploads/wpmarks/<?php echo $file; ?>"><img src="<?php bloginfo('template_url'); ?>/images/bullet_go.png" align="right" title="<?php _e('View Image','wpm')?>" alt="<?php _e('View Image','wpm')?>" /></a>
        		<div style="clear: both;"></div>
        		</div>
        	</div>
        	<?php
        }
    }

    closedir($handle);
}
?>
</div>

</table>


<?php  } ?>