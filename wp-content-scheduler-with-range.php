<?php
/**
 * Plugin Name: WP Content Scheduler With Range
 * Plugin URI: http://cedcommerce.com
 * Description: Show or hide your posts in a range of date
 * Version: 1.1
 * Author: CedCommerce <plugins@cedcommerce.com>
 * Author URI: http://cedcommerce.com
 * Requires at least: 3.8
 * Tested up to: 5.2.0
 * Text Domain: wp-content-scheduler-with-range
 * Domain Path: /language
 */
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}

define ( 'CED_WCSWR_PREFIX', 'ced_wcswr' );
define ( 'CED_WCSWR_ORDER', plugin_dir_path ( __FILE__ ) );
define ( 'CED_WCSWR_FILE_URL', plugin_dir_url ( __FILE__ ) );
define ( 'CED_WCSWR_PLUGIN_URL', plugin_dir_url ( __FILE__ ) );
define ( 'CED_WCSWR_VER', '1.1');

if (function_exists ( 'is_multisite' ) && is_multisite ()) {
	
	include_once (ABSPATH . 'wp-admin/includes/plugin.php');
}

include_once CED_WCSWR_ORDER . 'includes/wp-content-scheduler-with-range-class.php';

add_filter ( 'plugin_action_links', CED_WCSWR_PREFIX . '_doc_settings', 10, 5 );
function ced_wcswr_doc_settings($actions, $plugin_file) {
	static $plugin;
	if (! isset ( $plugin )) {
		
		$plugin = plugin_basename ( __FILE__ );
	}
	if ($plugin == $plugin_file) {
		
		$settings = array (
				'settings' => '<a href="' . home_url ( '/wp-admin/admin.php?page=wp-content-scheduler-with-range' ) . '">' . __ ( 'Settings', 'wp-content-scheduler-with-range' ) . '</a>' 
		);
		$actions = array_merge ( $settings, $actions );
	}
	return $actions;
}

if (! function_exists ( 'ced_wcswr_custom_plugin_row_meta' )) {
	/**
	 * Add links of demo and documentation
	 *
	 * @param array $links        	
	 * @param string $file        	
	 * @author CedCommerce <http://cedcommerce.com>
	 */
	function ced_wcswr_custom_plugin_row_meta($links, $file) {
		if (strpos ( $file, 'wp-content-scheduler-with-range/wp-content-scheduler-with-range.php' ) !== false) {
			$new_links = array (
					'doc' => '<a href="http://demo.cedcommerce.com/wordpress/content-scheduler/doc/index.html" target="_blank">' . __ ( 'Docs', 'wp-content-scheduler-with-range' ) . '</a>',
					'demo' => '<a href="http://demo.cedcommerce.com/wordpress/content-scheduler/wp-admin/admin.php?page=wp-content-scheduler-with-range" target="_blank">' . __ ( 'Live Demo', 'wp-content-scheduler-with-range' ) . '</a>' 
			);
			
			$links = array_merge ( $links, $new_links );
		}
		
		return $links;
	}
}
add_filter ( 'plugin_row_meta', 'ced_wcswr_custom_plugin_row_meta', 10, 2 );

/**
 * This function is used to load language'.
 * 
 * @name ced_wuoh_load_text_domain()
 * @author CedCommerce<plugins@cedcommerce.com>
 * @link http://cedcommerce.com/
 */
function ced_wcswr_load_text_domain() {
	$domain = "wp-content-scheduler-with-range";
	$locale = apply_filters ( 'plugin_locale', get_locale (), $domain );
	load_textdomain ( $domain, CED_WCSWR_ORDER . 'language/' . $domain . '-' . $locale . '.mo' );
	$var = load_plugin_textdomain ( 'wp-content-scheduler-with-range', false, plugin_basename ( dirname ( __FILE__ ) ) . '/language' );
}
add_action ( 'plugins_loaded', 'ced_wcswr_load_text_domain' );?>