<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Cron Log
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Logs cron hooks (i.e. cron events) just before they are executed.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


add_filter( 'pre_get_ready_cron_jobs', function( $dummy) {

	static $is_first_call = true;

	if ( $is_first_call ) {

		$is_first_call = false;
		$crons = wp_get_ready_cron_jobs();

		$gmt_time = microtime( true );

		foreach ( $crons as $timestamp => $cronhooks ) {

			if ( $timestamp > $gmt_time ) {
				break;
			}

			foreach( $crons as $event => $data ) {
				error_log( "Cron hook to be called: $event" );
			}

		}

	}

	return null;

}, 9999, 1);