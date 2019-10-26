<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', 'wpm'));

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'wpm'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('No Responses', 'wpm'), __('One Response', 'wpm'), __('% Responses', 'wpm') );?> <?php _e('to', 'wpm'); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<ul class="pager">
		<li class="previous"><?php previous_comments_link() ?></li>
		<li class="next"><?php next_comments_link() ?></li>
	</ul>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.', 'wpm'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h3 class="respond"><?php comment_form_title( __('Leave a Reply', 'wpm'), __('Leave a Reply to %s', 'wpm') ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be', 'wpm'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in', 'wpm'); ?></a> <?php _e('to post a comment.', 'wpm'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as', 'wpm'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title='<?php _e('Log out of this account', 'wpm'); ?>'><?php _e('Log out', 'wpm'); ?> &raquo;</a></p>

<?php else : ?>

<div class="input-prepend">
	<label for="author"><small><?php _e('Name', 'wpm'); ?> <?php if ($req) echo _e('(required)', 'wpm'); ?></small></label>
	<span class="add-on"><i class="icon-user"></i></span>
	<input type="text" placeholder="Your Name" name="author" id="author" class="mid" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
</div>

<div class="input-prepend">
	<label for="email"><small><?php _e('Email (will not be published)', 'wpm'); ?> <?php if ($req) echo _e('(required)', 'wpm'); ?></small></label>
	<span class="add-on"><i class="icon-envelope"></i></span>
	<input type="text" name="email" placeholder="Your Email" id="email" class="mid" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
</div>

<div class="input-prepend">
	<label for="url"><small><?php _e('Website', 'wpm'); ?></small></label>
	<span class="add-on"><i class="icon-globe"></i></span>
	<input type="text" name="url" placeholder="Website" id="url" class="mid" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
</div>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

<p>
	<label for="comment"><small><?php _e('Comment ', 'wpm'); ?></small><i class="icon-comment"></i></label>
	<textarea name="comment" class="span12" id="comment" cols="58" rows="7" tabindex="4"></textarea>
</p>

<p><input name="submit" type="submit" class="btn btn-primary" tabindex="5" value="<?php _e('Submit Comment', 'wpm'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
