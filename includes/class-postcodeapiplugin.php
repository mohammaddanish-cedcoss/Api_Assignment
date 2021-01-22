<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Postcodeapiplugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Postcodeapiplugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'POSTCODEAPIPLUGIN_VERSION' ) ) {

			$this->version = POSTCODEAPIPLUGIN_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'postcodeapiplugin';

		$this->postcodeapiplugin_dependencies();
		$this->postcodeapiplugin_locale();
		$this->postcodeapiplugin_admin_hooks();
		$this->postcodeapiplugin_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Postcodeapiplugin_Loader. Orchestrates the hooks of the plugin.
	 * - Postcodeapiplugin_i18n. Defines internationalization functionality.
	 * - Postcodeapiplugin_Admin. Defines all hooks for the admin area.
	 * - Postcodeapiplugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function postcodeapiplugin_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-postcodeapiplugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-postcodeapiplugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-postcodeapiplugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-postcodeapiplugin-public.php';

		$this->loader = new Postcodeapiplugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Postcodeapiplugin_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function postcodeapiplugin_locale() {

		$plugin_i18n = new Postcodeapiplugin_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function postcodeapiplugin_admin_hooks() {

		$p_plugin_admin = new Postcodeapiplugin_Admin( $this->p_get_plugin_name(), $this->p_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $p_plugin_admin, 'p_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $p_plugin_admin, 'p_admin_enqueue_scripts' );

		// Add settings menu for postcodeapiplugin.
		$this->loader->add_action( 'admin_menu', $p_plugin_admin, 'p_options_page' );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $p_plugin_admin, 'p_admin_submenu_page', 15 );
		$this->loader->add_filter( 'p_general_settings_array', $p_plugin_admin, 'p_admin_general_settings_page', 10 );

		// Register our wporg_settings_init to the admin_init action hook.
		$this->loader->add_action( 'admin_init', $p_plugin_admin, 'pincode_settings_init' );

		/**
		 * Register our wporg_options_page to the admin_menu action hook.
		 */
		$this->loader->add_action( 'admin_menu', $p_plugin_admin, 'pincode_options_page' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function postcodeapiplugin_public_hooks() {

		$p_plugin_public = new Postcodeapiplugin_Public( $this->p_get_plugin_name(), $this->p_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $p_plugin_public, 'p_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $p_plugin_public, 'p_public_enqueue_scripts' );

		// Incldue my custom template onto page['Check Postcode'] .
		$this->loader->add_action( 'template_include', $p_plugin_public, 'check_availability_view' );

		$this->loader->add_action( 'wp_ajax_check_availability', $p_plugin_public, 'check_availability' );
		$this->loader->add_action( 'wp_ajax_nopriv_check_availability', $p_plugin_public, 'check_availability' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function p_run() {
		$this->loader->p_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function p_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Postcodeapiplugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function p_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function p_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_p_plug tabs.
	 *
	 * @return  Array       An key=>value pair of postcodeapiplugin tabs.
	 */
	public function mwb_p_plug_default_tabs() {

		$p_default_tabs = array();

		$p_default_tabs['postcodeapiplugin-general'] = array(
			'title'       => esc_html__( 'General Setting', 'postcodeapiplugin' ),
			'name'        => 'postcodeapiplugin-general',
		);
		$p_default_tabs = apply_filters( 'mwb_p_plugin_standard_admin_settings_tabs', $p_default_tabs );

		$p_default_tabs['postcodeapiplugin-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'postcodeapiplugin' ),
			'name'        => 'postcodeapiplugin-system-status',
		);

		return $p_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_p_plug_load_template( $path, $params = array() ) {

		$p_file_path = POSTCODEAPIPLUGIN_DIR_PATH . $path;

		if ( file_exists( $p_file_path ) ) {

			include $p_file_path;
		} else {

			/* translators: %s: file path */
			$p_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'postcodeapiplugin' ), $p_file_path );
			$this->mwb_p_plug_admin_notice( $p_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $p_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_p_plug_admin_notice( $p_message, $type = 'error' ) {

		$p_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$p_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$p_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$p_classes .= 'notice-success is-dismissible';
				break;

			default:
				$p_classes .= 'notice-error is-dismissible';
		}

		$p_notice  = '<div class="' . esc_attr( $p_classes ) . '">';
		$p_notice .= '<p>' . esc_html( $p_message ) . '</p>';
		$p_notice .= '</div>';

		echo wp_kses_post( $p_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $p_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_p_plug_system_status() {
		global $wpdb;
		$p_system_status = array();
		$p_wordpress_status = array();
		$p_system_data = array();

		// Get the web server.
		$p_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$p_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'postcodeapiplugin' );

		// Get the server's IP address.
		$p_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$p_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$p_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'postcodeapiplugin' );

		// Get the server path.
		$p_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'postcodeapiplugin' );

		// Get the OS.
		$p_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'postcodeapiplugin' );

		// Get WordPress version.
		$p_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'postcodeapiplugin' );

		// Get and count active WordPress plugins.
		$p_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'postcodeapiplugin' );

		// See if this site is multisite or not.
		$p_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'postcodeapiplugin' ) : __( 'No', 'postcodeapiplugin' );

		// See if WP Debug is enabled.
		$p_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'postcodeapiplugin' ) : __( 'No', 'postcodeapiplugin' );

		// See if WP Cache is enabled.
		$p_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'postcodeapiplugin' ) : __( 'No', 'postcodeapiplugin' );

		// Get the total number of WordPress users on the site.
		$p_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'postcodeapiplugin' );

		// Get the number of published WordPress posts.
		$p_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'postcodeapiplugin' );

		// Get PHP memory limit.
		$p_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'postcodeapiplugin' );

		// Get the PHP error log path.
		$p_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'postcodeapiplugin' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$p_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'postcodeapiplugin' );

		// Get PHP max post size.
		$p_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'postcodeapiplugin' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$p_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$p_system_status['php_architecture'] = '64-bit';
		} else {
			$p_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$p_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'postcodeapiplugin' );

		// Show the number of processes currently running on the server.
		$p_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'postcodeapiplugin' );

		// Get the memory usage.
		$p_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$p_system_status['is_windows'] = true;
			$p_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'postcodeapiplugin' );
		}

		// Get the memory limit.
		$p_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'postcodeapiplugin' );

		// Get the PHP maximum execution time.
		$p_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'postcodeapiplugin' );

		// Get outgoing IP address.
		$p_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'postcodeapiplugin' );

		$p_system_data['php'] = $p_system_status;
		$p_system_data['wp'] = $p_wordpress_status;

		return $p_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $p_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_p_plug_generate_html( $p_components = array() ) {
		if ( is_array( $p_components ) && ! empty( $p_components ) ) {
			foreach ( $p_components as $p_component ) {
				switch ( $p_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'password':
					case 'email':
					case 'text':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $p_component['id'] ); ?>"><?php echo esc_html( $p_component['title'] ); // WPCS: XSS ok. ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $p_component['type'] ) ); ?>">
								<input
								name="<?php echo esc_attr( $p_component['id'] ); ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								type="<?php echo esc_attr( $p_component['type'] ); ?>"
								value="<?php echo esc_attr( $p_component['value'] ); ?>"
								class="<?php echo esc_attr( $p_component['class'] ); ?>"
								placeholder="<?php echo esc_attr( $p_component['placeholder'] ); ?>"
								/>
								<p class="p-descp-tip"><?php echo esc_html( $p_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'textarea':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $p_component['id'] ); ?>"><?php echo esc_html( $p_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $p_component['type'] ) ); ?>">
								<textarea
								name="<?php echo esc_attr( $p_component['id'] ); ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								class="<?php echo esc_attr( $p_component['class'] ); ?>"
								rows="<?php echo esc_attr( $p_component['rows'] ); ?>"
								cols="<?php echo esc_attr( $p_component['cols'] ); ?>"
								placeholder="<?php echo esc_attr( $p_component['placeholder'] ); ?>"
								><?php echo esc_textarea( $p_component['value'] ); // WPCS: XSS ok. ?></textarea>
								<p class="p-descp-tip"><?php echo esc_html( $p_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $p_component['id'] ); ?>"><?php echo esc_html( $p_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $p_component['type'] ) ); ?>">
								<select
								name="<?php echo esc_attr( $p_component['id'] ); ?><?php echo ( 'multiselect' === $p_component['type'] ) ? '[]' : ''; ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								class="<?php echo esc_attr( $p_component['class'] ); ?>"
								<?php echo 'multiselect' === $p_component['type'] ? 'multiple="multiple"' : ''; ?>
								>
								<?php
								foreach ( $p_component['options'] as $p_key => $p_val ) {
									?>
									<option value="<?php echo esc_attr( $p_key ); ?>"
										<?php
										if ( is_array( $p_component['value'] ) ) {
											selected( in_array( (string) $p_key, $p_component['value'], true ), true );
										} else {
											selected( $p_component['value'], (string) $p_key );
										}
										?>
										>
										<?php echo esc_html( $p_val ); ?>
									</option>
									<?php
								}
								?>
								</select> 
								<p class="p-descp-tip"><?php echo esc_html( $p_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc"><?php echo esc_html( $p_component['title'] ); ?></th>
							<td class="forminp forminp-checkbox">
								<label for="<?php echo esc_attr( $p_component['id'] ); ?>"></label>
								<input
								name="<?php echo esc_attr( $p_component['id'] ); ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								type="checkbox"
								class="<?php echo esc_attr( isset( $p_component['class'] ) ? $p_component['class'] : '' ); ?>"
								value="1"
								<?php checked( $p_component['value'], '1' ); ?>
								/> 
								<span class="p-descp-tip"><?php echo esc_html( $p_component['description'] ); // WPCS: XSS ok. ?></span>

							</td>
						</tr>
						<?php
						break;

					case 'radio':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $p_component['id'] ); ?>"><?php echo esc_html( $p_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $p_component['type'] ) ); ?>">
								<fieldset>
									<span class="p-descp-tip"><?php echo esc_html( $p_component['description'] ); // WPCS: XSS ok. ?></span>
									<ul>
										<?php
										foreach ( $p_component['options'] as $p_radio_key => $p_radio_val ) {
											?>
											<li>
												<label><input
													name="<?php echo esc_attr( $p_component['id'] ); ?>"
													value="<?php echo esc_attr( $p_radio_key ); ?>"
													type="radio"
													class="<?php echo esc_attr( $p_component['class'] ); ?>"
												<?php checked( $p_radio_key, $p_component['value'] ); ?>
													/> <?php echo esc_html( $p_radio_val ); ?></label>
											</li>
											<?php
										}
										?>
									</ul>
								</fieldset>
							</td>
						</tr>
						<?php
						break;

					case 'button':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="button" class="button button-primary" 
								name="<?php echo esc_attr( $p_component['id'] ); ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								value="<?php echo esc_attr( $p_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					case 'submit':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo esc_attr( $p_component['id'] ); ?>"
								id="<?php echo esc_attr( $p_component['id'] ); ?>"
								value="<?php echo esc_attr( $p_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
