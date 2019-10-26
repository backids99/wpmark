<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( );
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
			
			<?php
			$ok = wpm_filter($_GET['ok']);
			if ($ok == "ok") {
			if ( get_option("post_status") == "draft" ) { 
				echo "<div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><strong>" . __('Thank you!','wpm') . "</strong>" . __(' Your article has been drafted succesfully.','wpm') . "</div>";
				} else {
				echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><strong>" . __('Thank you!','wpm') . "</strong>" . __(' Your article has been published succesfully.','wpm') . "</div>";
				}
			}
			?>
			
<?php if (get_option('show_slider') == "yes" || get_option('show_slider') == "") { ?>

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <img src="<?php echo get_option('img_slider_1');?>" alt="<?php echo get_option('title_slider_1');?>">
          <div class="container">
            <div class="carousel-caption">
              <h1 style="font-size:28px;"><font color="<?php echo get_option("slidercolortitle");?>"><?php echo get_option('title_slider_1');?></font></h1>
              <p class="lead"><font color="<?php echo get_option("slidercolordes");?>"><?php echo get_option('content_slider_1');?></font></p>
              <a class="btn btn-primary" href="<?php echo get_option('url_slider_1');?>">Read more <i class="icon-chevron-right icon-white"></i></a>
            </div>
          </div>
        </div>
<?php $i = 2;
while ($i <= get_option("slidercount")) {
?>
        <div class="item">
          <img src="<?php echo get_option("img_slider_$i");?>" alt="<?php echo get_option("title_slider_$i");?>">
          <div class="container">
            <div class="carousel-caption">
              <h1 style="font-size:28px;"><font color="<?php echo get_option("slidercolortitle");?>"><?php echo get_option("title_slider_$i");?></font></h1>
              <p class="lead"><font color="<?php echo get_option("slidercolordes");?>"><?php echo get_option("content_slider_$i");?></font></p>
              <a class="btn btn-primary" href="<?php echo get_option("url_slider_$i");?>">Read more <i class="icon-chevron-right icon-white"></i></a>
            </div>
          </div>
        </div>
<?php $i++; } ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div><!-- /.carousel -->
<?php } ?>

            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#highlight" data-toggle="tab">Highlight</a></li>
              <li><a href="#recent" data-toggle="tab">Recent</a></li>
              <li><a href="#random" data-toggle="tab">Random</a></li>
              <li><a href="#toptoday" data-toggle="tab">Top Today</a></li>
              <li><a href="#topweek" data-toggle="tab">Top Week</a></li>
			  <li><a href="#topmonth" data-toggle="tab">Top Month</a></li>
			  <li><a href="#topyear" data-toggle="tab">Top Year</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="highlight">
				<?php
				if ( !get_option('include_post') == "" || !get_option('include_post') == "0" ) {


				$include_post = get_option('include_post');
				$args = array( 'numberposts' => get_option('posts_per_page'), 'post_type' => 'post', 'include' => $include_post );
				$rand_posts = get_posts( $args );
				foreach( $rand_posts as $post ) : ?>
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
									<i class="icon-user"></i> <?php if (get_the_author() == "") { ?><a href="<?php bloginfo('url'); ?>/author/<?php echo get_post_meta($post->ID, "name", true); ?>"><?php echo get_post_meta($post->ID, "name", true); ?></a><?php } else { echo get_post_meta($post->ID, "name", true); } ?>
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
				<?php endforeach; 
			} ?>
              </div>

              <div class="tab-pane fade" id="recent">
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
<?php endwhile; endif; ?>			  
              </div>
              
              <div class="tab-pane fade" id="random">
<?php
    $args=array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'orderby' => 'rand'
      );
$my_query=new WP_Query($args);

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
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
     <?php
    endwhile;
  } //if ($my_query)
wp_reset_query(); //just in case
?>			  
			  </div>
			  
			  <div class="tab-pane fade" id="toptoday">
<?php
function filter_day($where = '') { 
  $where .= " AND post_date > '" . date('Y-m-d H:i:s', strtotime('-24 hours')) . "'"; 
  return $where; 
} 
add_filter('posts_where', 'filter_day');

    $args=array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'meta_key' => 'post_views',
      'orderby' => 'meta_value_num'
      );
$my_query=new WP_Query($args);
remove_filter('posts_where', 'filter_day');

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
    
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
     <?php
    endwhile;
  } //if ($my_query)
wp_reset_query(); //just in case
?>			  
				</div>
				
		  <div class="tab-pane fade" id="topweek">
<?php
function filter_week($where = '') { 
  $where .= " AND post_date > '" . date('Y-m-d H:i:s', strtotime('-7 days')) . "'"; 
  return $where; 
} 
add_filter('posts_where', 'filter_week');

    $args=array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'meta_key' => 'post_views',
      'orderby' => 'meta_value_num'
      );
$my_query=new WP_Query($args);
remove_filter('posts_where', 'filter_week');

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
    
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
     <?php
    endwhile;
  } //if ($my_query)
wp_reset_query(); //just in case
?>				  
				</div>

		  <div class="tab-pane fade" id="topmonth">
<?php
function filter_month($where = '') { 
  $where .= " AND post_date > '" . date('Y-m-d H:i:s', strtotime('-30 days')) . "'"; 
  return $where; 
} 
add_filter('posts_where', 'filter_month');

    $args=array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'meta_key' => 'post_views',
      'orderby' => 'meta_value_num'
      );
$my_query=new WP_Query($args);
remove_filter('posts_where', 'filter_month');

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
    
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
<?php } else if (get_option('comment') == "default" ) { ?>
									<i class="icon-comment"></i> 
<?php comments_number( '0 Responses', '1 Response', '% Responses' ); ?></a>
<?php } else { ?>
									<i class="icon-comment"></i> 
<?php echo get_fb_comment_count();?>
<?php } ?>
									<i class="icon-eye-open"></i> <?php echo getPostViews(get_the_ID());?></div>
				</div>
     <?php
    endwhile;
  } //if ($my_query)
wp_reset_query(); //just in case
?>					  
				</div>

		  <div class="tab-pane fade" id="topyear">
<?php
function filter_year($where = '') { 
  $where .= " AND post_date > '" . date('Y-m-d H:i:s', strtotime('-12 months')) . "'"; 
  return $where; 
} 
add_filter('posts_where', 'filter_year');

    $args=array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'meta_key' => 'post_views',
      'orderby' => 'meta_value_num'
      );
$my_query=new WP_Query($args);
remove_filter('posts_where', 'filter_year');

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
    
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
     <?php
    endwhile;
  } //if ($my_query)
wp_reset_query(); //just in case
?>					  
				</div>
            </div>
        </div><!--/span-->
<?php include (TEMPLATEPATH . '/sidebar-home.php'); ?>
      </div><!--/row-->
</div>
<?php get_footer(); ?>
