<hr>
<footer>			
<p class="pull-left">&copy; <?php echo date("Y"); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></p>
<p class="pull-right"><?php _e('Theme : ','wpm');?><a href="http://bakhtiar.web.id/">WPM</a> | <a href="#"><i class="icon-arrow-up"></i> <?php _e('Go to Top','wpm');?></a></p>
</footer>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/jquery.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-transition.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-alert.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-modal.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-tab.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-popover.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-button.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-collapse.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-carousel.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-typeahead.js"></script>
<?php if (is_page_template('tpl-submit.php')) { ?>
<?php if ( get_option('filter_html') == "yes" ) { ?>
	<script src="<?php bloginfo('template_url'); ?>/bootstrap/js/wysihtml5-0.3.0.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/wysihtml5.js"></script>
	<script>$('.description').wysihtml5();</script>
<?php } ?>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-fileupload.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap-tag.js"></script>
	<script> jQuery(".tagManager").tagsManager(); </script>
<?php } ?>

    <script>
      !function ($) {
        $(function(){
          // carousel demo
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    </script>

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery(".vote a").click(
function() {
var some = jQuery(this);
var thepost = jQuery(this).attr("post");
var theuser = jQuery(this).attr("user");
jQuery.post("<?php bloginfo('template_url'); ?>/vote.php", {user: theuser, post: thepost}, 
function(data) {
var votebox = ".vote"+thepost+" span";
jQuery(votebox).text(data);
jQuery(some).replaceWith('<a class="btn btn-success"><i class="icon-thumbs-up icon-white"></i> Voted</a>');
});
});
});	
</script>

<?php wp_footer(); ?>
</body>
</html>
