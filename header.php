<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
<?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?>
<?php if ( $paged < 2 ) {} else {echo ('Page ');echo ($paged ); echo (' - ');} ?>
<?php if ( is_search() ) { ?><?php _e('Search Results','wpm'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_author() ) { ?><?php _e('About user : ','wpm'); ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_single() ) { ?><?php wp_title(''); ?><?php } ?>
<?php if ( is_page() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_category() ) { ?><?php single_cat_title(); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php the_time('F Y'); ?><?php } ?>
<?php if ( is_day() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php the_time('j F Y'); ?><?php } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php  single_tag_title("", true); } } ?>
<?php if ( is_404() ) { ?><?php _e('Nothing Found','wpm'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if (is_tax()) { $URL = get_term_by('slug', get_query_var('URL'), get_query_var('taxonomy')); echo $URL->name; print ' - '; bloginfo('name');} ?>
</title>

<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php the_excerpt_rss(); ?>"/>
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php bloginfo('description'); ?>"/>
<meta name="robots" content="index,follow,noodp,noydir"/>
<meta name="keywords" content="bookmarking, wordpress, news, dofollow, articles, backlinks, dofollow bookmark, bookmarking site, media, health, lifestyle, education, sport, business, unique, internet, software, technology, entertainment, internet"/>
<?php endif; ?>

<link rel="Shortcut Icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" type="image/x-icon"/>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('feedburner_url') <> "" ) { echo get_option('feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>"/>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap.css" rel="stylesheet"/>
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet"/>
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap-wpm.css" rel="stylesheet"/>
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet"/>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    


 <script type="text/javascript">
 var RecaptchaOptions = {
    theme : '<?php echo get_option("theme_captcha");?>'
 };
 </script>
 
</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


    <div class="navbar navbar-fixed-top">
	<div class="color-lines"></div>
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
<?php if (get_option("excluded_pages") == "" ) { ?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-dashboard.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str1 = get_the_ID() ;
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-profile.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str2 = get_the_ID() ;
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-submit.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str3 = get_the_ID() ;
    endwhile;
endif;
wp_reset_query();
?>
<?php $excld_page = $str1.','.$str2.','.$str3; } else { $excld_page = get_option("excluded_pages"); } ?>
<?php wp_list_pages('sort_column=menu_order&depth=0&title_li=&exclude='.$excld_page); ?>
			</ul>
<?php global $userdata; get_currentuserinfo(); if (!$userdata) { ?>
            <form class="navbar-form pull-right" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
              <input class="span2" type="text" id="user_login" name="log" value="" placeholder="User Name">
              <input class="span2" type="password" name="pwd" id="user_pass" value="" placeholder="Password">
              <button type="submit" name="wp-submit" value="Log In" class="btn">Sign In</button>
            <?php if (get_option('users_can_register')) : ?>
		<a class="btn" href="<?php echo bloginfo('home').'/wp-login.php?action=register';?>">Sign Up</a>
	    <?php endif; ?>
            </form>
<?php } else { // is logged in ?>
            <ul class="nav pull-right">
              <li class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo "$userdata->user_login"; ?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-dashboard.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
        echo	'<li><a href="', get_permalink($str), '"><i class="icon-th-list"></i> Dashboard</a></li>';
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-profile.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
        echo	'<li><a href="', get_permalink($str), '"><i class="icon-edit"></i> Edit Profile</a></li>';
    endwhile;
endif;
wp_reset_query();
?>
<?php query_posts('meta_key=_wp_page_template&meta_value=tpl-submit.php&post_type=page&posts_per_page=1');
if (have_posts()) :
    while (have_posts()) : the_post();
        $str = get_the_ID() ;
		echo	'<li><a href="', get_permalink($str), '"><i class="icon-pencil"></i> Submit</a></li>';
    endwhile;
endif;
wp_reset_query();
?>
				<li class="divider"></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><i class="icon-off"></i> Logout</a></li>
				</ul>
			 </li>
			</ul>
<?php } ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<ul class="nav nav-pills">
			<?php wp_list_categories('depth=-1&show_count=0&hide_empty=true&orderby=name&order=asc&title_li='); ?>
    </ul>
