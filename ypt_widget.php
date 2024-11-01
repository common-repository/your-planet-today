<?php
/*
Plugin Name: Your Planet Today widget
Plugin URI: http://www.wronkiewicz.net/earth/map.html
Description: Displays an interactive map of the Earth generated from recent satellite photos
Author: Matt Wronkiewicz
Version: 1.1
Author URI: http://matt.wronkiewicz.net
*/

function widget_ypt_init() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain( 'your-planet-today', null, $plugin_dir );

	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_ypt($args) {
		extract($args);

		$options = get_option('widget_ypt');
		$lat = $options['lat'];
		$lon = $options['lon'];
		$zoom = $options['zoom'];

		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo '<div style="margin-top:5px;text-align:center; border-width: 1px; border-style: solid; border-color: lightgrey;">';
		echo '<a href="http://www.wronkiewicz.net/earth/map.html" style="text-align: center;">' . __('Your Planet Today', 'your-planet-today') . '</a>';
		echo '<iframe src="http://www.wronkiewicz.net/earth/gadget.php?up_refresh=1&amp;up_labels=1&amp;up_controls=0&amp;up_latitude='.$lat.'&amp;up_longitude='.$lon.'&amp;up_zoom='.$zoom.'&amp;wp=1" width="100%" height="200" scrolling="no" frameborder="0"></iframe>';
		echo '</div>';
		echo $after_widget;
	}

	function widget_ypt_control() {
		$options = get_option('widget_ypt');
		if ( !is_array($options) )
			$options = array('lat'=>'0', 'lon'=>'0', 'zoom'=>'0');
		if ( $_POST['ypt-submit'] ) {
			$options['lat'] = $_POST['ypt-lat'];
			$options['lon'] = $_POST['ypt-lon'];
			$options['zoom'] = $_POST['ypt-zoom'];
			update_option('widget_ypt', $options);
		}

		$lat = $options['lat'];
		$lon = $options['lon'];
		$zoom = $options['zoom'];
		
		echo '<p style="text-align:right;"><label for="ypt-lat">' . __('Center latitude:', 'your-planet-today') . ' <input style="width: 150px;" id="ypt-lat" name="ypt-lat" type="text" value="'.$lat.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="ypt-lon">' . __('Center longitude:', 'your-planet-today') . ' <input style="width: 150px;" id="ypt-lon" name="ypt-lon" type="text" value="'.$lon.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="ypt-zoom">' . __('Zoom level:', 'your-planet-today') . ' <select style="width: 150px;" id="ypt-zoom" name="ypt-zoom" type="text">';
		echo '<option value="0"';
		if ($zoom == 0)
		    echo ' selected="selected"';
		echo '>0 (' . __('Zoomed out', 'your-planet-today') . ')</option>';
		echo '<option value="1"';
		if ($zoom == 1)
		    echo ' selected="selected"';
		echo '>1</option>';
		echo '<option value="2"';
		if ($zoom == 2)
		    echo ' selected="selected"';
		echo '>2</option>';
		echo '<option value="3"';
		if ($zoom == 3)
		    echo ' selected="selected"';
		echo '>3 (' . __('Zoomed in', 'your-planet-today') . ')</option>';
		echo '</select></label></p>';
		echo '<input type="hidden" id="ypt-submit" name="ypt-submit" value="1" />';
	}
	
	register_sidebar_widget(array(__('Your Planet Today', 'your-planet-today'), 'widgets'), 'widget_ypt');
	register_widget_control(array(__('Your Planet Today', 'your-planet-today'), 'widgets'), 'widget_ypt_control', 300, 100);
}

add_action('widgets_init', 'widget_ypt_init');
?>
