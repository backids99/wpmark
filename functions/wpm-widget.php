<?php
/**
 * Display search form.
 *
 * Will first attempt to locate the searchform.php file in either the child or
 * the parent, then load it. If it doesn't exist, then the default search form
 * will be displayed. The default search form is HTML, which will be displayed.
 * There is a filter applied to the search form HTML in order to edit or replace
 * it. The filter is 'get_search_form'.
 *
 * This function is primarily used by themes which want to hardcode the search
 * form into the sidebar and also by the search widget in WordPress.
 *
 * There is also an action that is called whenever the function is run called,
 * 'get_search_form'. This can be useful for outputting JavaScript that the
 * search relies on or various formatting that applies to the beginning of the
 * search. To give a few examples of what it can be used for.
 *
 * @since 2.7.0
 * @param boolean $echo Default to echo and not return the form.
 * @return string|null String when retrieving, null when displaying or if searchform.php exists.
 */
function wpm_get_search_form($echo = true) {
	do_action( 'get_search_form' );

	$search_form_template = locate_template('searchform.php');
	if ( '' != $search_form_template ) {
		require($search_form_template);
		return;
	}

	$form = '<center>
			<div class="input-append">
			<form method="get" role="search" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
					<input class="span9" placeholder="Search" id="appendedInputButton" type="text" name="s" id="s" value="' . get_search_query() . '">
					<button class="btn" type="submit" value="'. esc_attr__('Search') .'">Go!</button>
			</form>
			</div>
			</center>';

	if ( $echo )
		echo apply_filters('wpm_get_search_form', $form);
	else
		return apply_filters('wpm_get_search_form', $form);
}

/**
 * Display calendar with days that have posts as links.
 *
 * The calendar is cached, which will be retrieved, if it exists. If there are
 * no posts for the month, then it will not be displayed.
 *
 * @since 1.0.0
 * @uses calendar_week_mod()
 *
 * @param bool $initial Optional, default is true. Use initial calendar names.
 * @param bool $echo Optional, default is true. Set to false for return.
 * @return string|null String when retrieving, null when displaying.
 */
function wpm_get_calendar($initial = true, $echo = true) {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'wpm_get_calendar', 'wpm_calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo apply_filters( 'wpm_get_calendar',  $cache[$key] );
				return;
			} else {
				return apply_filters( 'wpm_get_calendar',  $cache[$key] );
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'wpm_get_calendar', $cache, 'wpm_calendar' );
			return;
		}
	}

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		$thisyear = gmdate('Y', current_time('timestamp'));
		$thismonth = gmdate('m', current_time('timestamp'));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
	$last_day = date('t', $unixmonth);

	// Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = 'post' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
		AND post_type = 'post' AND post_status = 'publish'
			ORDER BY post_date ASC
			LIMIT 1");

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	$calendar_caption = _x('%1$s %2$s', 'calendar caption');
	$calendar_output = '<center><table class="table table-condensed table-bordered table-striped">
	<thead>
	<tr>
	<th colspan="7">
	<a style="display:block;" class="btn btn-primary"><i class="icon-calendar icon-white"></i> ' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</a>
	</th>
	</tr>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	$calendar_output .= '
	</tr>
	</thead>

	<tfoot>
	<tr>';

	if ( $previous ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev"><center><a href="' . get_month_link($previous->year, $previous->month) . '" class="btn btn-warning" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($previous->month), date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year)))) . '"><i class="icon-chevron-left icon-white"></i> ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></center></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
	}

	$calendar_output .= "\n\t\t".'<td class="pad">&nbsp;</td>';

	if ( $next ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next"><center><a href="' . get_month_link($next->year, $next->month) . '" class="btn btn-warning" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($next->month), date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) ) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' <i class="icon-chevron-right icon-white"></i></a></center></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
	}

	$calendar_output .= '
	</tr>
	</tfoot>

	<tbody>
	<tr>';

	// Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00'
		AND post_type = 'post' AND post_status = 'publish'
		AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' "
		."AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' "
		."AND post_type = 'post' AND post_status = 'publish'"
	);
	if ( $ak_post_titles ) {
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

				if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
					$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
				if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
					$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
				else
					$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
		}
	}

	// See how much we should pad in the beginning
	$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;

		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else
			$calendar_output .= '<td>';

		if ( in_array($day, $daywithpost) ) // any posts today?
				$calendar_output .= '<a href="' . get_day_link( $thisyear, $thismonth, $day ) . '" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
		else
			$calendar_output .= $day;
		$calendar_output .= '</td>';

		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
			$newrow = true;
	}

	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>\n\t</center>";

	$cache[ $key ] = $calendar_output;
	wp_cache_set( 'wpm_get_calendar', $cache, 'wpm_calendar' );

	if ( $echo )
		echo apply_filters( 'wpm_get_calendar',  $calendar_output );
	else
		return apply_filters( 'wpm_get_calendar',  $calendar_output );

}

/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
		parent::__construct('wpm_recent-posts', __('WPM: Recent Posts'), $widget_ops);
		$this->alt_option_name = 'wpm_widget_recent_entries';


	}

	function widget($args, $instance) {
		$cache = wp_cache_get('wpm_widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('WPM: Recent Posts') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('wpm_widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (bool) $new_instance['show_date'];

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['wpm_widget_recent_posts']) )
			delete_option('wpm_widget_recent_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('wpm_widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}
	add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_Recent_Posts");'));

/**
 * Search widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_Search extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'wpm_widget_search', 'description' => __( "A search form for your site") );
		parent::__construct('wpm_search', __('WPM: Search'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		// Use current theme search form if it exists
		wpm_get_search_form();

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_Search");'));

/**
 * Calendar widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_Calendar extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'wpm_widget_calendar', 'description' => __( 'A calendar of your site&#8217;s posts') );
		parent::__construct('wpm_calendar', __('WPM: Calendar'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		wpm_get_calendar();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_Calendar");'));

/**
 * Top URL widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_URL extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'wpm_widget_url', 'description' => __( "List top URL.") );
		parent::__construct('wpm_url', __('WPM: Top URL'), $widget_ops);
		$this->alt_option_name = 'wpm_widget_url';
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('wpm_widget_url', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('WPM: Top URL') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['listurl'] ) || ! $listurl = absint( $instance['listurl'] ) )
 			$listurl = 10;

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

    $tags = wp_tag_cloud('format=array&orderby=count&order=DESC&taxonomy=URL&number='.$listurl.'');
    if ($tags == ""){
	} else {

    // loop through each tag in the array
    foreach ($tags as $tag)
    {
        // convert our string into an xml object
        $xml = simplexml_load_string($tag);

        // use our xml object's attributes to output a new anchor tag
        echo '<li><a href="'.$xml->attributes()->href.'">'.$xml.' ('.$xml->attributes()->title.')</a></li>';
    }
	}

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		$listurl    = isset( $instance['listurl'] ) ? absint( $instance['listurl'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'listurl' ); ?>"><?php _e( 'Number of url to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'listurl' ); ?>" name="<?php echo $this->get_field_name( 'listurl' ); ?>" type="text" value="<?php echo $listurl; ?>" size="3" /></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['listurl'] = (int) $new_instance['listurl'];
		return $instance;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_URL");'));

/**
 * Top Author widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_author extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'wpm_widget_author', 'description' => __( "List top Author.") );
		parent::__construct('wpm_author', __('WPM: Top Author'), $widget_ops);
		$this->alt_option_name = 'wpm_widget_author';


	}

	function widget($args, $instance) {
		$cache = wp_cache_get('wpm_widget_author', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('WPM: Top Author') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['listauthor'] ) || ! $listauthor = absint( $instance['listauthor'] ) )
 			$listauthor = 10;

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$author_list = wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC&style=none&exclude_admin=0&echo=0&number='.$listauthor.'');
		$rep_author = str_replace( array("<a","</a>",","), array("<li><a","","</a></li>"), $author_list);
			echo $rep_author;
			echo '</li>';

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		$listauthor    = isset( $instance['listauthor'] ) ? absint( $instance['listauthor'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'listauthor' ); ?>"><?php _e( 'Number of author to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'listauthor' ); ?>" name="<?php echo $this->get_field_name( 'listauthor' ); ?>" type="text" value="<?php echo $listauthor; ?>" size="3" /></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['listauthor'] = (int) $new_instance['listauthor'];
		return $instance;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_author");'));

/**
 * Top Vote widget class
 *
 * @since 2.8.0
 */
class WPM_Widget_vote extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'wpm_widget_vote', 'description' => __( "List top vote.") );
		parent::__construct('wpm_vote', __('WPM: Top Vote'), $widget_ops);
		$this->alt_option_name = 'wpm_widget_vote';


	}

	function widget($args, $instance) {
		$cache = wp_cache_get('wpm_widget_vote', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('WPM: Top Vote') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['listvote'] ) || ! $listvote = absint( $instance['listvote'] ) )
 			$listvote = 10;

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
					global $post;
					$args = array( 
						'posts_per_page' => $listvote,
						'post_type' => 'post',
						'meta_key' => 'votes',
						'orderby' => 'meta_value',
						'order' => 'DESC'
					);
					$rand_posts = get_posts( $args );
					foreach( $rand_posts as $post ) : setup_postdata($post);
					echo '<li><a href="';
					echo the_permalink();
					echo '" title="';
					echo the_title();
					echo '">';
					echo the_title();
					echo ' ';
					echo count_vote($post->ID);
					echo '</a></li>';
					endforeach;
		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		$listvote    = isset( $instance['listvote'] ) ? absint( $instance['listvote'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'listvote' ); ?>"><?php _e( 'Number of top vote to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'listvote' ); ?>" name="<?php echo $this->get_field_name( 'listvote' ); ?>" type="text" value="<?php echo $listvote; ?>" size="3" /></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['listvote'] = (int) $new_instance['listvote'];
		return $instance;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WPM_Widget_vote");'));

?>
