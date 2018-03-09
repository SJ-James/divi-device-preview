<?php

/*
Plugin Name: Divi Device Preview
Version: 1.0
Author: Stephen James
*/

//Load The Device Preview Module

define( 'DEVICE_PREVIEW_PLUGIN', plugin_dir_url( __FILE__ ) );

include_once ( ABSPATH . 'wp-admin/includes/plugin.php' );

// Enqueue front end scripts

function device_preview_enqueue() {
    wp_enqueue_style('device-preview-css', DEVICE_PREVIEW_PLUGIN . 'scripts/device-preview.css');
    wp_enqueue_script( 'device-preview-js', DEVICE_PREVIEW_PLUGIN . 'scripts/device-preview.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'device_preview_enqueue' );

// Admin Scripts

function device_preview_enqueue_admin() {
    wp_enqueue_style('device-preview-admin-css', DEVICE_PREVIEW_PLUGIN . 'scripts/device-preview-admin.css');
}
add_action('admin_enqueue_scripts', 'device_preview_enqueue_admin');

// Load all modules

function device_preview_load_module(){
	if(class_exists("ET_Builder_Module")){
		include('device-preview-module.php');
	}
}

add_action('et_builder_modules_load', 'device_preview_load_module');