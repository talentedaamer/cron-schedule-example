<?php
/**
 * Plugin Name: Schedule Cron
 * Plugin URI: #
 * Description: Test plugin for scheduling cron jobs.
 * Author: Aamer Shahzad
 * Version: 1.0
 * Author URI: http://wpthemecraft.com/code-snippets/create-new-schedule-times-via-cron_schedules/
 *
 * @package schedule-cron
 * @version 1.0
 */

/**
 * Plugin Activaion
 */
register_activation_hook(__FILE__, 'wptc_schedule_cron_activation');
function wptc_schedule_cron_activation() {

	$args = array( false );
	if ( ! wp_next_scheduled( 'wptc_5min_cron_event', $args ) ) {
		wp_schedule_event( time(), '5min', 'wptc_5min_cron_event', $args );
	}
}


add_action('wptc_5min_cron_event', 'wptc_add_posts_every_5min');
function wptc_add_posts_every_5min() {
	$post_id = -1;

	$post_author = 1;
	$content = file_get_contents('http://loripsum.net/api');
	$title = mb_strimwidth( $content, 100, 40, "" );
	$title = str_replace( ',', '', $title );
	$title = str_replace( '.', '', $title );

	 //Create post object
	$post_data = array(
		'post_title'    => wp_strip_all_tags( ucwords($title) ),
		'post_content'  => $content,
		'post_status'   => 'publish',
		'post_author'   => $post_author,
	);

	$count_posts = wp_count_posts();

	// if posts are less than 10
	if ( $count_posts->publish < 10 ) {
		// add new random post
		$post_id = wp_insert_post( $post_data );
	} else {
		// delete the cron event
		wp_clear_scheduled_hook('wptc_5min_cron_event');
	}
}

/**
 * Plugin Deactivation
 */
register_deactivation_hook(__FILE__, 'wptc_schedule_cron_deactivation');
function wptc_schedule_cron_deactivation() {
	wp_clear_scheduled_hook('wptc_5min_cron_event');
}

/**
 * create custom cron times
 */
include( plugin_dir_path( __FILE__ ) . 'inc/cron-custom-times.php');