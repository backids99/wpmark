<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( );
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	
					<h1 style="font-size:30px;"><?php the_title(); ?></h1>
					<hr>
					<?php the_content(__('Read more &raquo;','wpm')); ?>
					<?php edit_post_link(__('Edit Page','wpm'), '<span>', '</span>'); ?>
			
		<?php endwhile; endif; ?>		
			
        </div><!--/span-->
<?php include (TEMPLATEPATH . '/sidebar-page.php'); ?>
      </div><!--/row-->
	</div>

<?php get_footer(); ?>
