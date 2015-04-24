<?php
/**
 * Plugin Name:		Shapla Google AdSense
 * Plugin URI:		https://wordpress.org/plugins/shapla-google-adsense/
 * Description:		A simple plugin for displaying Google AdSense ads for multiple authors. 
 * Version:			1.0.0
 * Author:			Sayful Islam
 * Author URI:		http://sayful.net
 * License:			GPL-2.0+
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @author     Sayful Islam
 */
class Shapla_Google_Adsense {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'shapla-google-adsense';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Shapla_Google_Adsense_Loader. Orchestrates the hooks of the plugin.
	 * - Shapla_Google_Adsense_Admin. Defines all hooks for the dashboard.
	 * - Shapla_Google_Adsense_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path( __FILE__ )  . 'widget/widget-google-adsense.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __FILE__ )  . 'includes/Shapla_Google_Adsense_Loader.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( __FILE__ )  . 'admin/Shapla_Google_Adsense_Admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __FILE__ )  . 'public/Shapla_Google_Adsense_Public.php';

		$this->loader = new Shapla_Google_Adsense_Loader();

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Shapla_Google_Adsense_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'shapla_profile_adsense_show' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'shapla_profile_adsense_show' );
		$this->loader->add_action('personal_options_update', $plugin_admin, 'shapla_profile_adsense_save' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'shapla_profile_adsense_save' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Shapla_Google_Adsense_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'the_content', $plugin_public, 'auto_insert_adsense' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'shapla_gad_enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shapla_google_adsense() {

	$plugin = new Shapla_Google_Adsense();
	$plugin->run();

}
run_shapla_google_adsense();