<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace postcodeapiplugin_public.
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Postcodeapiplugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function p_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, POSTCODEAPIPLUGIN_DIR_URL . 'public/css/postcodeapiplugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function p_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, POSTCODEAPIPLUGIN_DIR_URL . 'public/js/postcodeapiplugin-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'p_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'nonce_verify' ) ) );
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Redirect away from the availabilty page for Check Postcode page.
	 * If the user is not logged in.
	 */
	public function check_availability_view( $template ) {
		if ( is_page( 'Check Postcode' ) ) :
			// Search for the new template file either within the parent
			// or child themes.
			$new_template = plugin_dir_path( __FILE__ ) . 'my-template.php';
			if ( '' !== $new_template ) {
				return $new_template;
			}
		endif;
		return $template; // if the template doesn't exist, WordPress will load the default template instead.
	}

	/**
	 * This function to check postcode availability.
	 *
	 * @return void
	 */
	public function check_availability() {
		check_ajax_referer( 'nonce_verify' );

		$postcode = sanitize_text_field( wp_unslash( isset( $_POST['postcode'] ) ? $_POST['postcode'] : false ) );

		$option = get_option( 'pincode_options' );

		foreach ( $option as $data ) {
			$arr = explode( '-', $data );
			if ( $postcode == $arr[1] ) {
				echo 'Pincode Available';
			}
		}
		wp_die();
	}

}
