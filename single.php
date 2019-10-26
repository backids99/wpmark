<?php
get_header( );
?>
    <div class="container-fluid">
      <div class="row-fluid">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="span8">
<?php setPostViews(get_the_ID());?>
<?php if (get_option('breadcrumbs') == "yes" || get_option('breadcrumbs') == "") { ?>
<?php the_breadcrumb(); ?>
<?php } ?>

<h1 style="font-size:30px;"><?php the_title(); ?></h1>
<hr>
<div class="span7">
<?php the_content(); ?>
<div class="row-fluid">
  <div class="span3">
<div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false" data-font="verdana"></div>
  </div>
  <div class="span3">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo get_permalink(); ?>" data-via="your_screen_name" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  </div>
  <div class="span3">
<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo get_permalink(); ?>"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
  </div>
</div>
</div>
<div class="span4">
	<?php voting($post->ID); ?>
	<div class="well sidebar-nav">
              <ul class="nav nav-list">
                <li class="nav-header">Created by:</li>
                <li><i class="icon-user"></i> <strong>
                			<?php if (get_the_author() != "") { ?>
				<a href="<?php bloginfo('url'); ?>/author/<?php echo strtolower(the_author_login()); ?>"><?php echo get_post_meta($post->ID, "name", true); ?></a>
			<?php } else { 
				echo get_post_meta($post->ID, "name", true); 
			} ?></strong>
                </li>
                <li><i class="icon-time"></i> <?php the_time(get_option('date_format')) ?></li>
                <li><i class="icon-eye-open"></i> <?php echo getPostViews(get_the_ID());?></li>
                <li class="divider"></li>
                <li class="nav-header"><i class="icon-pencil"></i> Author Submited:</li>
                <li><?php the_author_posts(); ?> Article</li>
                <li class="nav-header"><i class="icon-globe"></i> Author Website:</li>
                <li><?php echo get_the_author_meta('user_url'); ?></li>
                <li class="divider"></li>
<?php if (get_option('report_button') == "yes" || get_option('report_button') == "") { 

if (isset($_POST['action']) && $_POST['action'] == 'report') {
    $subject2 = __('URL reported for:') . get_the_title();
    $condiment = strip_tags($_POST['condiment']);
    $report_url = strip_tags($_POST['page_url']);

	if ( $condiment != "") {
		exit;
	}

	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$ip = getenv("REMOTE_ADDR");

	$body = __('Someone has reported the following wpmarks ad on your site: ','wpm') . $report_url . "\n\n IP Address: " . $ip . "\n Server: " . $hostname ;
	$admin_email = get_bloginfo('admin_email');
	$email2 = $admin_email;
	// $admin_email = "tester2@localhost";	// uncomment this for local testing
    wp_mail($admin_email,$subject2,$body,"From: $email2");
    $email_ok = "ok";
    unset($admin_email, $email2, $body, $subject2);
    echo "<span style='color: red;'><b>" . __('The report has been sent!','wpm') . "</b></span>";
}
?>
		<form style="padding:0px;margin:0px;" action="<?php echo selfURL(); ?>" method="post">
			<input type="hidden" class="condiment" name="condiment" value="" />
			<input type="hidden" name="page_url" value="<?php echo selfURL(); ?>" />
			<button type="submit" class="btn btn-danger btn-block" name="submit" value=""><i class="icon-ban-circle icon-white"></i> Report</button>
			<input type="hidden" name="action" value="report" />
		</form>
<?php } ?>
              </ul>
</div></div>
<div class="row-fluid" style="padding-bottom:20px;margin-bottom:20px;">
	<ul class="thumbnails">
<?php if(function_exists('wpmarks_lightbox_single')) {wpmarks_lightbox_single(get_post_meta($post->ID, 'images', true)); } ?>
	</ul>
</div>

<ul class="pager">
 <li class="previous">
<?php previous_post('%', '&larr; Previous', 'no'); ?>
 </li>
 <li class="next">
<?php next_post('%', 'Next &rarr;', 'no'); ?>
 </li>
</ul>

    <div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Information</a></li>
    <li><a href="#tab2" data-toggle="tab">Related</a></li>
<?php if (get_option('comment') == "none" || get_option('comment') == "") { ?>
<?php } else if (get_option('comment') == "default") { ?>
	<li><a href="#tab3" data-toggle="tab"><?php comments_number( '0 Responses', '1 Response', '% Responses' ); ?></a></li>
<?php } else { ?>
    <li><a href="#tab3" data-toggle="tab"><?php echo get_fb_comment_count();?></a></li>
<?php } ?>
    <li><a href="#tab4" data-toggle="tab">Who Voted</a></li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="tab1">
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td width="30%" rowspan="4">
						<img class="thumbnail" style="max-width:250px; min-width: 50px;" alt="<?php the_title(); ?>" src="http://s.wordpress.com/mshots/v1/<?php echo urlencode (get_post_meta($post->ID, "wpm_adURL", true)); ?>?w=250" />
					</td>
					<td width="70%">
						<strong><?php _e('Tag','wpm'); ?> :</strong> <?php the_tags( '<span class="badge badge-warning">', '</span> <span class="badge badge-warning">', '</span>'); ?>
					</td>
				</tr>
				<tr>
					<td width="70%">
						<strong><?php _e('Category :','wpm'); ?></strong> <span class="label label-info"><?php the_category('</span> &bull; <span class="label label-info">'); ?></span>
					</td>
				</tr>
<?php if (get_post_meta($post->ID, "wpm_adURL", true) != "") { ?>
				<tr>
					<td width="70%" style="word-wrap:break-word;">
						<strong><?php _e('Visit website :','wpm'); ?></strong>
						<a rel="<?php echo get_option('rel');?>" target="<?php echo get_option('target');?>" href="<?php echo get_post_meta($post->ID, "wpm_adURL", true); ?>"><?php echo get_post_meta($post->ID, "wpm_adURL", true); ?></a>
					</td>
				</tr>
<?php } ?>
				<tr>
					<td width="70%">
						<strong><?php _e('In website :','wpm'); ?></strong> <?php the_terms( $post->ID, 'URL'); ?>
					</td>
				</tr>
			</tbody>
		</table>
    </div>
    <div class="tab-pane" id="tab2">
			<ul class="related_post" style="visibility: visible;">
			<?php
			//for use in the loop, list 5 post titles related to first tag on current post
			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
			$first_tag = $tags[0]->term_id;
			$args=array(
			'tag__in' => array($first_tag),
			'post__not_in' => array($post->ID),
			'showposts'=>5,
			'caller_get_posts'=>1
			);
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) {
			while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li>
				<a class="thumbnail" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img width="75" alt="<?php the_title(); ?>" src="http://s.wordpress.com/mshots/v1/<?php echo urlencode (get_post_meta($post->ID, "wpm_adURL", true)); ?>?w=75"></a>
				<a class="title" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><br />
				<small><?php echo substr(strip_tags($post->post_content), 0, 200)."...";?></small></li>
			<?php
			endwhile;
			}
			wp_reset_query();
			}
			?>
			</ul>
    </div>
    <div class="tab-pane" id="tab3">
<?php if (get_option('comment') == "none" || get_option('comment') == "") { ?>
<?php } else if (get_option('comment') == "default") { ?>
<?php comments_template('',true); ?>
<?php } else { ?>
<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" mobile="false"></div>
<style>.fb-comments, .fb-comments iframe[style], .fb-like-box, .fb-like-box iframe[style] {width: 100% !important;}
.fb-comments span, .fb-comments iframe span[style], .fb-like-box span, .fb-like-box iframe span[style] {width: 100% !important;}
</style>
<?php } ?>
	</div>
	<div class="tab-pane" id="tab4">
<?php
$key_1 = get_post_meta($post->ID, 'thevoters', true);
if($key_1 != '') {
	$args = array( 'include' => $key_1 );
    $blogusers = get_users( $args );
    foreach ($blogusers as $user) {
        echo '<span class="label label-success"><a href="'. home_url() .'/author/' . $user->user_login . '"';
        echo '>' . $user->display_name . '</a></span> ';
    }
}
?>
	</div>
    </div>
    </div>

			</div>
	<?php endwhile; endif; ?>
<?php get_sidebar(); ?>
      </div><!--/row-->
	</div>
<?php get_footer(); ?>
