<?php 
/*
Plugin Name: Slider Manager
Pligin URI: www.developmentsoft.com.ar/plugins
Description: Es un plugin para generar una sliders
Author: podmaxs
Version: 1.0
Author URI: wwww.podmaxs.developmentsoft.com.ar
*/


add_action('admin_menu','slidersMenu');
function slidersMenu(){
	add_menu_page('ADM Slider','ADM Slider',2,__FILE__,'sliderManager', plugins_url( 'slider-ds/drawable/icon.svg' ), 6 );
}
function sliderManager(){
include_once "siliderManager.php";
}
 ?>
