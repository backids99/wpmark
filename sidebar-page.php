<div class="span4">

<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-submit.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;?>
<a class="btn btn-large btn-block btn-primary" href="<?php echo get_permalink($str); ?>"><i class="icon-plus icon-white"></i> Submit Article</a>
<?php
    endwhile;
endif;
wp_reset_query();
?>

	<div class="well sidebar-nav">
<ul class="nav nav-list">
		<li class="divider"></li>
		<center>
			<div class="input-append">
				<form style="padding:0;margin:0;" method="get" id="searchform" class="searchform" action="<?php bloginfo('url'); ?>/">
					<input class="span9" placeholder="Search" id="appendedInputButton" type="text" name="s" onclick="this.value=''" value="<?php _e('Search...','wpm'); ?>" onfocus="if (this.value == '<?php _e('Search...','wpm'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...','wpm'); ?>';}">
					<button class="btn" type="submit" value="Go!">Go!</button>
				</form>
			</div>
		</center>
		<li class="divider"></li>
<?php if (get_option('share') == "yes" || get_option('share') == "") { include (TEMPLATEPATH . '/social.php'); } ?>
</ul>
		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Page')) : else : ?>
		<ul class="nav nav-list">
		
			<li class="divider"></li>
			<li class="nav-header">Recent Article</li>
			<li class="divider"></li>
<?php
	$args = array( 'numberposts' => '10', 'post_status' => 'publish' );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'">' .   $recent["post_title"].'</a> </li> ';
	}
?>
		</ul>

		<!-- no dynamic sidebar so don't do anything -->
	<?php endif; ?>
	</div><!--/.well -->
</div><!--/span-->
