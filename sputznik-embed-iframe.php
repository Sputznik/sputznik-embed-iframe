<?php
	/*
	Plugin Name: Sputznik Embed Iframe
	Plugin URI: https://sputznik.com/
	Description: Allows administrators to embed iframes.
	Version: 1.0.0
	Author: Stephen Anil (Sputznik)
	Author URI: https://sputznik.com/
	*/


	if( ! defined( 'ABSPATH' ) ){
		exit;
	}

// MODIFIES ADMINISTRATOR CAPABILITY
if ( ! function_exists( 'allow_unfiltered_html_multisite' ) ) {
	function allow_unfiltered_html_multisite( $caps, $cap, $user_id, $args ) {
	  if( $user_id !== 0 && $cap === 'unfiltered_html' ) {
	    $user_meta = get_userdata( $user_id );
			if ( in_array( 'administrator', $user_meta->roles, true ) ) {
	        // Re-add the cap
	        unset( $caps );
	        $caps[] = $cap;
	    }
	  }
	  return $caps;
	}
	add_filter( 'map_meta_cap', 'allow_unfiltered_html_multisite', 10, 4 );
}

if ( ! function_exists( 'sp_change_mce_options' ) ) {
	function sp_change_mce_options( $initArray ) {

	    // Comma separated string od extendes tags.
	    // Command separated string of extended elements.
	    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';

	    if ( isset( $initArray['extended_valid_elements'] ) ) {
	        $ext = ',' . $ext;
	    }
	    $initArray['extended_valid_elements'] = $ext;

	    return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'sp_change_mce_options' );
}
