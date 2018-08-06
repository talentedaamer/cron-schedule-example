<?php

function wptc_add_intervals( $schedules ) {

	// add a '5min' interval
	if( ! isset( $schedules['5min'] ) ) {
		$schedules['5min'] = array(
			'interval' => 300, // seconds in minute
			'display' => __('Once Every 5 minutes')
		);
	}

	return $schedules;
}
add_filter( 'cron_schedules', 'wptc_add_intervals' );