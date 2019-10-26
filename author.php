<?php
get_header( ); 
?>


<?php
	//This sets the $curauth variable
	if(isset($_GET['author_name'])) :
		$curauth = get_userdatabylogin($author_name);
	else :
		$curauth = get_userdata(intval($author));
	endif;
	
$sql_statement = "SELECT * FROM $wpdb->posts WHERE post_author = $curauth->ID AND post_type = 'post' AND post_status = 'publish' ORDER BY ID DESC";	
$authorposts = $wpdb->get_results($sql_statement, OBJECT);
	
?>
	
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
					<h2><?php _e('About','wpm')?> <?php echo($curauth->display_name); ?></h2>
					
					
					<?php 
					if(function_exists('userphoto_exists')){
					  echo "<div class='span3 pull-right'>";
						if(userphoto_exists($curauth->ID))
							userphoto($curauth->ID);
						else
							echo get_avatar($userdata->user_email, 96);
					  echo "</div>";
					}	
					 ?>
					
				
				<div class="span8">
					
					<p>
					<strong><?php _e('Website :','wpm'); ?></strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a>
					<br />
					<strong><?php _e('Description :','wpm'); ?> </strong> <?php echo $curauth->user_description; ?>
					</p>

					<h3><?php _e('Articles submitted :','wpm'); ?></h3>

					<ul id="author-ads">
					
					<?php if ($authorposts): ?>
					
						<?php foreach ($authorposts as $post): ?>
						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</li>
						
						<?php endforeach; ?>
					
					<?php else: ?>
					
						<p><?php _e('No ads by this poster yet.','wpm'); ?></p>
					
					<?php endif; ?>
					</ul>	
				</div>
			</div>
<?php include (TEMPLATEPATH . '/sidebar-home.php'); ?>
		</div>
	</div>
<?php get_footer(); ?>
