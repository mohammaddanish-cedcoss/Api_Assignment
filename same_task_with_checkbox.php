<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Postcodeapiplugin_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function p_admin_enqueue_styles($hook) {

		wp_enqueue_style('mwb-p-select2-css', POSTCODEAPIPLUGIN_DIR_URL . 'admin/css/postcodeapiplugin-select2.css', array(), time(), 'all');

		wp_enqueue_style($this->plugin_name, POSTCODEAPIPLUGIN_DIR_URL . 'admin/css/postcodeapiplugin-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function p_admin_enqueue_scripts($hook) {

		wp_enqueue_script('mwb-p-select2', POSTCODEAPIPLUGIN_DIR_URL . 'admin/js/postcodeapiplugin-select2.js', array('jquery'), time(), false);

		wp_register_script($this->plugin_name . 'admin-js', POSTCODEAPIPLUGIN_DIR_URL . 'admin/js/postcodeapiplugin-admin.js', array('jquery', 'mwb-p-select2'), $this->version, false);

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'p_admin_param',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'reloadurl' => admin_url('admin.php?page=postcodeapiplugin_menu'),
			)
		);

		wp_enqueue_script($this->plugin_name . 'admin-js');
	}

	/**
	 * Adding settings menu for postcodeapiplugin.
	 *
	 * @since    1.0.0
	 */
	public function p_options_page() {
		global $submenu;
		if (empty($GLOBALS['admin_page_hooks']['mwb-plugins'])) {
			add_menu_page(__('MakeWebBetter', 'postcodeapiplugin'), __('MakeWebBetter', 'postcodeapiplugin'), 'manage_options', 'mwb-plugins', array($this, 'mwb_plugins_listing_page'), POSTCODEAPIPLUGIN_DIR_URL . 'admin/images/mwb-logo.png', 15);
			$p_menus = apply_filters('mwb_add_plugins_menus_array', array());
			if (is_array($p_menus) && !empty($p_menus)) {
				foreach ($p_menus as $p_key => $p_value) {
					add_submenu_page('mwb-plugins', $p_value['name'], $p_value['name'], 'manage_options', $p_value['menu_link'], array($p_value['instance'], $p_value['function']));
				}
			}
		}
	}

	/**
	 * postcodeapiplugin p_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function p_admin_submenu_page($menus = array()) {
		$menus[] = array(
			'name' => __('postcodeapiplugin', 'postcodeapiplugin'),
			'slug' => 'postcodeapiplugin_menu',
			'menu_link' => 'postcodeapiplugin_menu',
			'instance' => $this,
			'function' => 'p_options_menu_html',
		);
		return $menus;
	}

	/**
	 * postcodeapiplugin mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters('mwb_add_plugins_menus_array', array());
		if (is_array($active_marketplaces) && !empty($active_marketplaces)) {
			require POSTCODEAPIPLUGIN_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * postcodeapiplugin admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function p_options_menu_html() {

		include_once POSTCODEAPIPLUGIN_DIR_PATH . 'admin/partials/postcodeapiplugin-admin-display.php';
	}

	/**
	 * postcodeapiplugin admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $p_settings_general Settings fields.
	 */
	public function p_admin_general_settings_page($p_settings_general) {
		$p_settings_general = array(
			array(
				'title' => __('Text Field Demo', 'postcodeapiplugin'),
				'type' => 'text',
				'description' => __('This is text field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_text_demo',
				'value' => '',
				'class' => 'p-text-class',
				'placeholder' => __('Text Demo', 'postcodeapiplugin'),
			),
			array(
				'title' => __('Number Field Demo', 'postcodeapiplugin'),
				'type' => 'number',
				'description' => __('This is number field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_number_demo',
				'value' => '',
				'class' => 'p-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __('Password Field Demo', 'postcodeapiplugin'),
				'type' => 'password',
				'description' => __('This is password field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_password_demo',
				'value' => '',
				'class' => 'p-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __('Textarea Field Demo', 'postcodeapiplugin'),
				'type' => 'textarea',
				'description' => __('This is textarea field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_textarea_demo',
				'value' => '',
				'class' => 'p-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __('Textarea Demo', 'postcodeapiplugin'),
			),
			array(
				'title' => __('Select Field Demo', 'postcodeapiplugin'),
				'type' => 'select',
				'description' => __('This is select field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_select_demo',
				'value' => '',
				'class' => 'p-select-class',
				'placeholder' => __('Select Demo', 'postcodeapiplugin'),
				'options' => array(
					'INR' => __('Rs.', 'postcodeapiplugin'),
					'USD' => __('$', 'postcodeapiplugin'),
				),
			),
			array(
				'title' => __('Multiselect Field Demo', 'postcodeapiplugin'),
				'type' => 'multiselect',
				'description' => __('This is multiselect field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_multiselect_demo',
				'value' => '',
				'class' => 'p-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __('Multiselect Demo', 'postcodeapiplugin'),
				'options' => array(
					'INR' => __('Rs.', 'postcodeapiplugin'),
					'USD' => __('$', 'postcodeapiplugin'),
				),
			),
			array(
				'title' => __('Checkbox Field Demo', 'postcodeapiplugin'),
				'type' => 'checkbox',
				'description' => __('This is checkbox field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_checkbox_demo',
				'value' => '',
				'class' => 'p-checkbox-class',
				'placeholder' => __('Checkbox Demo', 'postcodeapiplugin'),
			),

			array(
				'title' => __('Radio Field Demo', 'postcodeapiplugin'),
				'type' => 'radio',
				'description' => __('This is radio field demo follow same structure for further use.', 'postcodeapiplugin'),
				'id' => 'p_radio_demo',
				'value' => '',
				'class' => 'p-radio-class',
				'placeholder' => __('Radio Demo', 'postcodeapiplugin'),
				'options' => array(
					'yes' => __('YES', 'postcodeapiplugin'),
					'no' => __('NO', 'postcodeapiplugin'),
				),
			),

			array(
				'type' => 'button',
				'id' => 'p_button_demo',
				'button_text' => __('Button Demo', 'postcodeapiplugin'),
				'class' => 'p-button-class',
			),
		);
		return $p_settings_general;
	}

	/**
	 * @internal never define functions inside callbacks.
	 * these functions could be run multiple times; this would result in a fatal error.
	 */

	/**
	 * custom option and settings
	 */
	public function pincode_settings_init() {
		// Register a new setting for "Pincode" page.
		register_setting('pincode', 'pincode_options');

		// Register a new section in the "pincode" page.
		add_settings_section(
			'pincode_section_developers',
			__('Checked the box for Availability.', 'postcodeapiplugin'), array($this, 'pincode_section_developers_callback'),
			'pincode'
		);

		$request = wp_remote_get('https://api.postalpincode.in/postoffice/lucknow');
		$response = wp_remote_retrieve_body($request);

		$arr = json_decode($response);

		// Register a new field in the "pincode_section_developers" section, inside the "pincode" page.

		foreach ($arr[0]->PostOffice as $data) {
			add_settings_field(
				'pincode_field_' . $data->Pincode, // As of WP 4.6 this value is used only internally.
				// Use $args' label_for to populate the id inside the callback.
				__($data->Name, 'postcodeapiplugin'),
				array($this, 'pincode_field_cb'),
				'pincode',
				'pincode_section_developers',
				array(
					'label_for' => $data->Name,
					'class' => 'pincode_row',
					'pincode_custom_data' => 'custom',
					'value' => $data->Pincode,
				)
			);
		}
	}
	/**
	 * Custom option and settings:
	 *  - callback functions
	 */

	/**
	 * Pincode section callback function.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	public function pincode_section_developers_callback($args) {
		?>
		<p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('It\'s so Easy.', 'postcodeapiplugin');?></p>
		<?php
}

	/**
	 * Pincode field callback function.
	 *
	 * WordPress has magic interaction with the following keys: label_for, class.
	 * - the "label_for" key value is used for the "for" attribute of the <label>.
	 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
	 * Note: you can add custom key value pairs to be used inside your callbacks.
	 *
	 * @param array $args
	 */
	public function pincode_field_cb($args) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option('pincode_options');
		$current = $options[$args['label_for']];
		?>

		<input id="<?php echo esc_attr($args['label_for']); ?>" name="pincode_options[<?php echo esc_attr($args['label_for']); ?>]" type="checkbox" value="<?php echo esc_attr($args['value']); ?>" <?php echo (esc_attr($current) == esc_attr($args['value'])) ? ('checked') : (''); ?>>

		<?php
}

	/**
	 * Add the top level menu page.
	 */
	public function pincode_options_page() {
		add_menu_page(
			'Pincode',
			'Pincode Options',
			'manage_options',
			'pincode',
			array($this, 'pincode_options_page_html'),
			'dashicons-yes-alt',
		);
	}

	/**
	 * Top level menu callback function
	 */
	public function pincode_options_page_html() {
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}

		// add error/update messages

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url
		if (isset($_GET['settings-updated'])) {
			// add settings saved message with the class of "updated"
			add_settings_error('pincode_messages', 'pincode_message', __('Settings Saved', 'pincode'), 'updated');
		}

		// show error/update messages
		settings_errors('pincode_messages');
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php
// output security fields for the registered setting "pincode"
		settings_fields('pincode');
		// output setting sections and their fields
		// (sections are registered for "pincode", each field is registered to a specific section)
		do_settings_sections('pincode');
		// output save settings button
		submit_button('Save Settings');
		?>
			</form>
		</div>
		<?php
}
}
