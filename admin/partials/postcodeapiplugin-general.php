<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $p_mwb_p_obj;
$p_genaral_settings = apply_filters( 'p_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="p-secion-wrap">
	<table class="form-table p-settings-table">
		<?php
			$p_general_html = $p_mwb_p_obj->mwb_p_plug_generate_html( $p_genaral_settings );
			echo esc_html( $p_general_html );
		?>
	</table>
</div>
