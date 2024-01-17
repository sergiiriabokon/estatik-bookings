<?php
/**
 * @package EstaticBookings
 * @version 0.7.0
 * @author Sergii Riabokon
 */
/*
Plugin Name: Estatic Bookings
Plugin URI: http://github.com/sergiiriabokon/estatik-bookings
Description: Adds custom booking post type with start/end date and address
Author: Serge Riabokon
Version: 0.7.0
Author URI: http://sergiiriabokon.medium.com
*/

require_once( __DIR__ . '/estatik-bookings.class.php' );

Estatik_Bookings::init();