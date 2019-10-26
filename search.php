<?php
get_header( );
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
			<h3><center><em><?php _e('Search Results for ','wpm') ?> <strong>"<?php printf(('%s'), $s) ?>"</strong></em></center></h3><br /> 
					<?php if (have_posts()) : ?>
					
					<?php while (have_posts()) : the_post(); ?>
					
				<div class="media">
					<a class="pull-left thumbnail span2" style="min-width: 110px;" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if (get_option('thumbnail') == "up" || get_option('thumbnail') == "") { ?>
					<?php if ( get_option('main_page_img') != "no" ) { ?>	
							<?php $images = get_post_meta($post->ID, "images", true);
								if (empty($images)) {?>
								<img class="media-object" src="<?php bloginfo('template_url'); ?>/images/no-pic.jpg" alt="" border="0" />
								<?php } else { ?>
													<img class="media-object" src="<?php echo get_bloginfo('template_url')."/includes/img_resize.php?width=100&amp;height=100&amp;url=";?><?php
										  if ( strstr($images, ',')) {  
											$matches = explode(",", $images);
											$img_single = $matches[0];
											$img_single = explode(trailingslashit(get_option('siteurl')) . "wp-content/uploads/wpmarks/", $img_single);
											echo $img_single[1];
										  } else {
											$img_single2 = $images;
											echo $img_single2;
												}?>"/>
								<?php } } ?>
					<?php } else { ?>
						<img class="media-object" style="max-width:100px;" alt="<?php the_title(); ?>" src="http://s.wordpress.com/mshots/v1/<?php echo urlencode (get_post_meta($post->ID, "wpm_adURL", true)); ?>?w=100" />
					<?php } ?>
					</a>
				<div class="media-body">
				<h4 class="media-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<i class="icon-time"></i> <?php echo wpmarks_time($post->post_date); ?>
									<i class="icon-user"></i> <a href="<?php bloginfo('url'); ?>/author/<?php echo strtolower(the_author_login()); ?>"><?php if ( strlen(get_post_meta($post->ID, "name", true)) > 10 ) { echo substr(get_post_meta($post->ID, "name", true), 0, 10)."..."; } else { the_author(); } ?></a>
									<br />
								<?php echo substr(strip_tags($post->post_content), 0, 140)."...";?>
									<br />
									<i class="icon-tag"></i> <?php the_category(', ') ?>
<?php if (get_option('comment') == "none" || get_option('comment') == "") { ?>
<?php } else if (get_option('comment') == "default") { ?>
									<i class="icon-comment"></i> 
<?php comments_number( '0 Responses', '1 Response', '% Responses' ); ?></a>
<?php } else { ?>
									<i class="icon-comment"></i> 
<?php echo get_fb_comment_count();?>
<?php } ?>
									<i class="icon-eye-open"></i> <?php echo getPostViews(get_the_ID());?></div>
				</div>
		<?php $i++; unset($alt); ?>
					
		<?php endwhile; ?>
	
<ul class="pager">
						<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else {  ?>
<li class="previous">
								<?php next_posts_link() ?>
</li>
<li class="next">
								<?php previous_posts_link() ?>
</li>
</ul>						
						<?php  } ?>
                    <?php else: ?>
					<p>&nbsp;</p>
                    <p style="text-align:center;"><?php _e('Nothing found, please search again.','wpm');?></p>
					<p>&nbsp;</p>
					
					<?php endif; ?>


	</div>
<?php include (TEMPLATEPATH . '/sidebar-home.php'); ?>
		</div>
	</div>
<?php get_footer(); ?>

