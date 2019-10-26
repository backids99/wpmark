<?php
/*
Template Name: Submit
*/

$wpdb->hide_errors();
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars

require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
?>
 
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">

			<?php
			$ok = wpm_filter($_GET['ok']);
			if ($err != "") { echo "<div id=\"err\" class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>$err</div>"; }
			if ($err2 != "") { echo "<div id=\"err\" class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>$err2</div>"; }
			?>

    	<script type="text/javascript">
			function textCounter(field,cntfield,maxlimit) { if (field.value.length > maxlimit) field.value = field.value.substring(0, maxlimit); else cntfield.value = maxlimit - field.value.length; }
		</script>
			<form action="" method="post" enctype="multipart/form-data" id="new_post2" name="new_post2">
				<input type="hidden" name="action" value="post" />
				<?php wp_nonce_field( 'new-post' ); ?>
				<label for="cat"><?php _e('Choose a Category','wpm'); ?> <span>*</span></label>

				<?php wp_dropdown_categories('show_option_none=Select One&orderby=name&order=ASC&hide_empty=0&hierarchical=1'); ?>

				<label for="title"><?php _e('Title','wpm'); ?> <span>*</span></label>
				<input type="text" id="title" class="span12" name="post_title" size="60" maxlength="<?php if (get_option("max_title") == "") { echo '30'; } else { echo get_option("max_title"); }?>" value="<?php echo stripslashes($_POST['post_title']);?>" />
				<label for="description"><?php _e('Description','wpm'); ?> <span>* (<?php if (get_option("min_des") == ""){ echo '300'; } else { echo get_option("min_des");	} ?> characters minimum, max <?php if (get_option("max_des") == ""){ echo '1000'; } else {	echo get_option("max_des");	} ?>)</span></label>
						
				<textarea name="description" id="description" class="span12 description" rows="10" cols="46" onkeydown="textCounter(document.new_post2.description,document.new_post2.remLen1,<?php if (get_option("max_des") == ""){ echo '1000'; } else {	echo get_option("max_des");	}?>)"
				onkeyup="textCounter(document.new_post2.description,document.new_post2.remLen1,<?php if (get_option("max_des") == ""){ echo '1000'; } else {	echo get_option("max_des");	};?>)"><?php echo stripslashes($_POST['description']); ?></textarea><br />
				<div class="limit">
					<br /><input disabled="disabled" readonly="readonly" type="text" name="remLen1" size="4" maxlength="4" value="<?php if (get_option("max_des") == ""){ echo '1000'; } else {	echo get_option("max_des");	} ?>" style="width: 40px;" /><span style="font-size:11px;"> <?php _e('characters left','wpm'); ?></span>
				</div>
				<label for="post_tags"><?php _e('Tags','cp'); ?> <small><?php _e('(separate with commas)','cp'); ?></small></label>
				<input type="text" id="post_tags" class="span12 tagManager" name="post_tags" size="60" maxlength="100" value="<?php echo $_POST['hidden-post_tags']; ?>" />
				<label for="wpm_adURL"><?php _e('URL','wpm'); ?> <span>*</span> <small><?php _e('(i.e. http://www.mysite.com)','wpm'); ?></small></label>
				<input type="text" id="wpm_adURL" class="span12" name="wpm_adURL" size="60" maxlength="250" value="<?php echo stripslashes($_POST['wpm_adURL']); ?>" />
<?php if (get_option('upload') == "0" || get_option('upload') == "") { } else {?>
				<?php if ( get_option('size') == "" ) {
	   $img_size_2 = 100*1;
   } else {
	   $img_size_2 = 100*get_option('size');
   } ?>
				<label for="images"><?php _e('Add images','wpm'); ?> <small>(<?php _e("images must be under $img_size_2 kB",'wpm'); ?>)</small></label>
<?php
}
$img_upload = 
'				<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="input-append">
					<div class="uneditable-input span3">
						<i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
					</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change</span>
					<input type="file" id="images" name="images[]" />
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
				</div>';
?>
<?php
$img_result = str_repeat($img_upload, get_option('upload'));
echo $img_result;
?>

<br />
		<br />
				<center>
					<?php if (get_option('captcha_submit') == "yes" || get_option('captcha_submit') == "") { 
						echo recaptcha_get_html($publickey, $error);
						echo '<br /><br />';
						} ?>
					<button id="submit" value="" type="submit" class="submit btn btn-large btn-block btn-primary"><i class="icon-plus icon-white"></i> <?php _e('Submit Now!','wpm'); ?></button>
				</center>

	</form>
<?php // } //if the form is ok don't display the form anymore ?>
</div>
<?php include (TEMPLATEPATH . '/sidebar-page.php'); ?>
      </div><!--/row-->
      </div>
<?php get_footer(); ?>
