<?php
/*
Template Name: Dashboard
*/


$wpdb->hide_errors(); 
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars
get_header( ); 
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">

<?php

// retreive all the ads for the current user
$sql_statement = "SELECT * FROM $wpdb->posts WHERE post_author = $userdata->ID AND post_type = 'post' AND (post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft') ORDER BY ID DESC";	
$pageposts = $wpdb->get_results($sql_statement, OBJECT);

// calculate the total count of live ads for current user
$post_count = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts WHERE post_author = $userdata->ID AND post_type = 'post' AND post_status = 'publish'");
if ($post_count) { $post_count = $post_count; } else { $post_count = '0'; }

$row_num = 1; 

?>

<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-profile.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;?>
		<a class="btn pull-right" type="button" href="<?php echo get_permalink($str); ?>"><?php _e('My Profile','wpm'); ?></a>
<?php
    endwhile;
endif;
wp_reset_query();
?>
		
<?php if ($pageposts): ?>		

					<h2><?php _e('Dashboard for','wpm');?> <?php echo($userdata->user_login . "\n"); ?></h2>


				<strong><?php echo($userdata->user_identity . "\n"); ?></strong>
				

<p><?php _e('Below you will find all of your submissions. You currently have','wpm');?> <strong><?php echo $post_count; ?></strong> <?php _e('submissions.','wpm');?></p>

<table class="table table-bordered table-striped">
<thead>
<tr>
<th>#</th>
<th><?php _e('ID','wpm');?></th>
<th><?php _e('Title','wpm');?></th>
<th width="120px"><?php _e('Submitted','wpm');?></th>
<th width="70px"><?php _e('Status','wpm');?></th>
</tr>
</thead>
<tbody>



  <?php foreach ($pageposts as $post): 
  
  if ($class == 'standard') { $class = 'alternate';} else { $class = 'standard';} 
  ?>
  
    <?php setup_postdata($post); ?>
	
<?php 
	if ($post->post_status == 'publish') { 	
			$poststatus = "<b>" . __('live','wpm') . "</b>";
			$fontcolor = "#33CC33";

		} elseif ($post->post_status == 'draft') {
			$poststatus = __('draft','wpm');
			$fontcolor = "#C00202";

		} elseif ($post->post_status == 'pending') {
			$poststatus = __('offline','wpm');
			$fontcolor = "#bbbbbb";

		} else { 
			$poststatus = "-";
		}
?>

<tr class='<?php echo $class ?>'>
<td align="center"><?php echo $row_num ?></td>
<td align="center"><?php echo the_id(); ?></td>

<?php 
if ($post->post_status == 'draft' || $poststatus == 'ended' || $poststatus == 'offline') { ?>
	<td><?php the_title(); ?></td>	
<?php } else { ?>
	<td><a target="_new" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
<?php } ?>
<td align="center"><?php the_time(get_option('date_format'))?><br /><?php the_time(get_option('time_format')) ?></td>
<td align="center"><span style="color:<?php echo $fontcolor ?>;"><?php echo $poststatus ?></span></td>
</tr>
<?php $row_num = $row_num + 1; 
	endforeach; ?>
</tbody>
</table>				
<?php else : ?>
    <p class="center"><?php _e('You currently have no submissions. Your dashboard will automatically be setup once you submit your first submission.','wpm');?><br /></p>
 <?php endif; ?>
 	
		</div>
<?php include (TEMPLATEPATH . '/sidebar-page.php'); ?>
      </div><!--/row-->						
	</div>
<?php get_footer(); ?>
