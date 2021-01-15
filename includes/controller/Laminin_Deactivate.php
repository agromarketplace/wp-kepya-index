<?php
/**
 * @version 1.0
 *
 * @see Laminin_BaseController
 */

defined('ABSPATH') || exit;


class Laminin_Deactivate
{
    public static function lum_deactivate()
    {	
    	$timestamp = wp_next_scheduled ('mycronjob');
	// unschedule previous laminin if any
	wp_unschedule_event ($timestamp, 'mycronjob');

        flush_rewrite_rules();
    }
}