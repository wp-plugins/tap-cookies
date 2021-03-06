<?php
/**
 *
 * @package   TAP_Cookies
 * @author    Alain Sanchez <luka.ghost@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.linkedin.com/in/mrbrazzi/
 * @copyright 2014 Alain Sanchez
 *
 * @wordpress-plugin
 * Plugin Name:       TAP Cookies
 * Plugin URI:       http://www.todoapuestas.org
 * Description:       Display a information message about Europe Cookies Law
 * Version:           1.2.1
 * Author:       Alain Sanchez
 * Author URI:       http://www.linkedin.com/in/mrbrazzi/
 * Text Domain:       tap-cookies
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-tap-cookies.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'TAP_Cookies', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'TAP_Cookies', 'deactivate' ) );

/*
 */
add_action( 'plugins_loaded', array( 'TAP_Cookies', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/settings/load-plugin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-tap-cookies-admin.php' );
    add_action( 'plugins_loaded', array( 'TAP_Cookies_Admin', 'get_instance' ) );
    require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/settings/options/configurations.php' );
}
