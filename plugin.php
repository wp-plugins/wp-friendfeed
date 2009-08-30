<?php
/*
Plugin Name: WP Friend Feed
Plugin URI: http://mr.hokya.com/wp-friendfeed/
Description: Tracks your friends's activities and show them on your dashboard to help you get in touch with them better.
Version: 1.08
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/


function register_db_friendfeed () {
	wp_add_dashboard_widget("Friend Feed","Friend Feed","friendfeed_dashboard");
}

function register_page_friendfeed () {
	add_dashboard_page("Friend Feed","Friend Feed","manage_options","wp-friendfeed/options.php");
}

function friendfeed_dashboard () {
	echo "<p>Here is your friend's recent activity</p>";
	wp_friendfeed();
}

function wp_friendfeed () {
	global $wpdb;
	$db = $wpdb->get_results("select * from $wpdb->links");
	$url = array();
	foreach ($db as $db) {
		array_push($url,$db->link_url);
	}
	$rss = fetch_feed($url);
	wp_widget_rss_output($rss,"show_date=1&show_summary=1&show_author=1");
}

add_action('wp_dashboard_setup','register_db_friendfeed');
add_action('admin_head','register_page_friendfeed');

?>