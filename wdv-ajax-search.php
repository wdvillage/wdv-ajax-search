<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wdvillage.com/
 * @since             1.0.0
 * @package           Wdv_Ajax_Search
 *
 * @wordpress-plugin
 * Plugin Name:       WDV Ajax Search
 * Plugin URI:        https://wdvillage.com/product/wdv-ajax-search/
 * Description:       With this plugin you can create different search forms for different post types and put their shortcode on the corresponding page. ATTENTION! After updating to version 1.0.3, you need to open the plugin properties and click on the "Add / Edit Settings" button for each of the shortcodes you created and click on the "Save" button in the modal window that opens. If this is your first time installing this plugin, then just follow the documentation.
 * 
 * Version:           1.0.3
 * Author:            wdvillage
 * Author URI:        https://wdvillage.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wdv-ajax-search
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WDV_AJAX_SEARCH_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wdv-ajax-search-activator.php
 */
function activate_wdv_ajax_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdv-ajax-search-activator.php';
	Wdv_Ajax_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wdv-ajax-search-deactivator.php
 */
function deactivate_wdv_ajax_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdv-ajax-search-deactivator.php';
	Wdv_Ajax_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wdv_ajax_search' );
register_deactivation_hook( __FILE__, 'deactivate_wdv_ajax_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wdv-ajax-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wdv_ajax_search() {

	$plugin = new Wdv_Ajax_Search();
	$plugin->run();

}
run_wdv_ajax_search();

function wdv_ajax_search_test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;          
}