<?php
/*
Plugin Name: CFS - Google Maps
Description: Adds a Google Maps field type.
Version: 2.0
Author: Matt Gibbs, adapted by Felipe Elia
Author URI: http://felipeelia.com.br/
Text Domain: cfs-google-maps
Domain Path: /languages
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

load_plugin_textdomain( 'cfs-google-maps', false, basename( dirname( __FILE__ ) ) . '/languages' );

function cfs_google_maps_add_field_type( $types ) {
    include( 'cfs_google_maps.php' );
	$types['google_maps'] = dirname( __FILE__ ) . '/cfs_google_maps.php';
	return $types;
}
add_filter( 'cfs_field_types', 'cfs_google_maps_add_field_type' );
