<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              localhost
 * @since             1.0.0
 * @package           Authores
 *
 * @wordpress-plugin
 * Plugin Name:       Authores
 * Plugin URI:        http://localhost
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Suchyman
 * Author URI:        localhost
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       authores
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
define( 'AUTHORES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-authores-activator.php
 */
function activate_authores() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-authores-activator.php';
	Authores_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-authores-deactivator.php
 */
function deactivate_authores() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-authores-deactivator.php';
	Authores_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_authores' );
register_deactivation_hook( __FILE__, 'deactivate_authores' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-authores.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_authores() {

	$plugin = new Authores();
	$plugin->run();

}
run_authores();


add_action('wp_dashboard_setup', 'authorsWidget');
  
function authorsWidget() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Liczba postów na autora', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {


global $wpdb;

$query = "SELECT ID, user_nicename from $wpdb->users ORDER BY user_nicename";
$author_ids = $wpdb->get_results($query);

foreach($author_ids as $author) :
$curauth = get_userdata($author->ID);
$user_link = get_author_posts_url($curauth->ID);

		 echo 'Autor <b>' . $curauth->nickname . '</b>, liczba wpisów: <a href="/author/'.$curauth->nickname.'/">' . count_user_posts( $curauth->id ) . '</a><br>';
		
 endforeach; 


}