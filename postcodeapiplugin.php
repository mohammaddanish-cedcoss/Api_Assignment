<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Postcodeapiplugin
 *
 * @wordpress-plugin
 * Plugin Name:       postcodeapiplugin
 * Plugin URI:        https://makewebbetter.com/product/postcodeapiplugin/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       postcodeapiplugin
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_postcodeapiplugin_constants() {

	postcodeapiplugin_constants( 'POSTCODEAPIPLUGIN_VERSION', '1.0.0' );
	postcodeapiplugin_constants( 'POSTCODEAPIPLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
	postcodeapiplugin_constants( 'POSTCODEAPIPLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
	postcodeapiplugin_constants( 'POSTCODEAPIPLUGIN_SERVER_URL', 'https://makewebbetter.com' );
	postcodeapiplugin_constants( 'POSTCODEAPIPLUGIN_ITEM_REFERENCE', 'postcodeapiplugin' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function postcodeapiplugin_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-postcodeapiplugin-activator.php
 */
function activate_postcodeapiplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcodeapiplugin-activator.php';
	Postcodeapiplugin_Activator::postcodeapiplugin_activate();
	$mwb_p_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_p_active_plugin ) && ! empty( $mwb_p_active_plugin ) ) {
		$mwb_p_active_plugin['postcodeapiplugin'] = array(
			'plugin_name' => __( 'postcodeapiplugin', 'postcodeapiplugin' ),
			'active' => '1',
		);
	} else {
		$mwb_p_active_plugin = array();
		$mwb_p_active_plugin['postcodeapiplugin'] = array(
			'plugin_name' => __( 'postcodeapiplugin', 'postcodeapiplugin' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_p_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-postcodeapiplugin-deactivator.php
 */
function deactivate_postcodeapiplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcodeapiplugin-deactivator.php';
	Postcodeapiplugin_Deactivator::postcodeapiplugin_deactivate();
	$mwb_p_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_p_deactive_plugin ) && ! empty( $mwb_p_deactive_plugin ) ) {
		foreach ( $mwb_p_deactive_plugin as $mwb_p_deactive_key => $mwb_p_deactive ) {
			if ( 'postcodeapiplugin' === $mwb_p_deactive_key ) {
				$mwb_p_deactive_plugin[ $mwb_p_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_p_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_postcodeapiplugin' );
register_deactivation_hook( __FILE__, 'deactivate_postcodeapiplugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-postcodeapiplugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_postcodeapiplugin() {
	define_postcodeapiplugin_constants();

	$p_plugin_standard = new Postcodeapiplugin();
	$p_plugin_standard->p_run();
	$GLOBALS['p_mwb_p_obj'] = $p_plugin_standard;

}
run_postcodeapiplugin();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 'p_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function p_add_default_endpoint() {
	register_rest_route(
		'p-route',
		'/p-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_p_default_callback',
			'permission_callback' => 'mwb_p_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_p_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_p_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_p_default_callback( $request ) {
	require_once POSTCODEAPIPLUGIN_DIR_PATH . 'includes/class-postcodeapiplugin-api-process.php';
	$mwb_p_api_obj = new Postcodeapiplugin_Api_Process();
	$mwb_p_resultsdata = $mwb_p_api_obj->mwb_p_default_process( $request );
	if ( is_array( $mwb_p_resultsdata ) && isset( $mwb_p_resultsdata['status'] ) && 200 == $mwb_p_resultsdata['status'] ) {
		unset( $mwb_p_resultsdata['status'] );
		$mwb_p_response = new WP_REST_Response( $mwb_p_resultsdata, 200 );
	} else {
		$mwb_p_response = new WP_Error( $mwb_p_resultsdata );
	}
	return $mwb_p_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'postcodeapiplugin_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function postcodeapiplugin_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=postcodeapiplugin_menu' ) . '">' . __( 'Settings', 'postcodeapiplugin' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
