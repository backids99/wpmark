<?php
get_header( );
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span8">
			<div class="span4">
				<br /><br /><br />
			<center><p style="font-size: 800%;"><b>404</b></p></center>
				<br /><br /><br />
			</div>
			<div class="span8">
					<h2><?php _e('Page Not Found','cp')?></h2>

			<p><?php _e('The page you are looking for has been moved or does not exist. Please try another url or use our search to find what you are looking for.','cp')?></p>
			    <div class="input-append">
		<form method="get" id="searchform" class="searchform" action="<?php bloginfo('url'); ?>/">
    <input class="span9" placeholder="Search" id="appendedInputButton" type="text" name="s" id="s" onclick="this.value=''" value="<?php _e('Search...','cp'); ?>" onfocus="if (this.value == '<?php _e('Search...','cp'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...','cp'); ?>';}">
    <button class="btn" type="submit" value="Go!">Go!</button>
		</form>
    </div>
				</div>
			</div>
<?php get_sidebar(); ?>			
		</div>
	</div>


<?php get_footer(); ?>
