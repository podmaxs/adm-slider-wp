<?php 
/*
Plugin Name: Slider Manager
Pligin URI: https://github.com/podmaxs/adm-slider-wp
Description: Es un plugin para generar una sliders
Author: podmaxs
Version: 1.0
Author URI: wwww.draweb.cloud
*/

	add_action('admin_menu','slidersMenu');
	
	add_action('init', 'flush_new_rule');

	add_action( 'init', 'initPLugin', 10, 0 );
	
	add_action('rewrite_rules_array', 'new_rewrite_rules');
	
	
	function slidersMenu(){
		$pluginFolder = basename(__DIR__);
		add_menu_page('ADM Slider','ADM Slider',2,__FILE__,'sliderManager', plugins_url( $pluginFolder.'/drawable/icon.svg' ), 6 );
	}
	
	function sliderManager(){
		include_once "siliderManager.php";
	}

	function initPLugin(){
		global $wp_rewrite; // Global WP_Rewrite class object
	    $wp_rewrite->flush_rules();
	    $pluginFolder = basename(__DIR__);
    	$nRoute = 'wp-banners/?$';
    	$action = 'wp-content/plugins/'.$pluginFolder.'/exe.php?ACTION=get_banners';
         add_rewrite_rule( 
	       $nRoute, 
	       $action, 
	       'top' 
	    );
        //print_r( $wp_rewrite->rewrite_rules() );
	}


	function new_rewrite_rules($rules){
    	$pluginFolder = basename(__DIR__);
    	$nRoute = '^wp-banners/?$';
    	$action = 'wp-content/plugins/'.$pluginFolder.'/exe.php?ACTION=get_banners';
        $newrules = array();
        $newrules[ $nRoute ] = $action;
        $newrules[ '^index.php/wp-banners/?$'] = $action;
        return  $rules + $newrules;
	}


	function flush_new_rule(){
 	    global $wp_rewrite;
 	    if( is_array(get_option('rewrite_rules')) && !array_key_exists('^wp-banners/?$', get_option('rewrite_rules')) ){
   			$wp_rewrite->flush_rules( true );
   		}
   	}




 

	// Do not continue processing if no REQUEST_URI has been set.
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$url = $_SERVER['REQUEST_URI'];

	// Check if the URL contains cottage-details
	if ( false !== strpos( $url, 'wp-banners') or false !== strpos( $url, 'wp-content/plugins/slider-ds/exe.php' ) ) {
		include_once(__DIR__.'/exe.php');
		$exe->get_banners_void();
		die();
	}

 ?>
