<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $p_mwb_p_obj;
$p_default_status = $p_mwb_p_obj->mwb_p_plug_system_status();
$p_wordpress_details = is_array( $p_default_status['wp'] ) && ! empty( $p_default_status['wp'] ) ? $p_default_status['wp'] : array();
$p_php_details = is_array( $p_default_status['php'] ) && ! empty( $p_default_status['php'] ) ? $p_default_status['php'] : array();
?>
<div class="mwb-p-table-wrap">
	<div class="mwb-p-table-inner-container">
		<table class="mwb-p-table" id="mwb-p-wp">
			<thead>
				<tr>
					<th><?php esc_html_e( 'WP Variables', 'postcodeapiplugin' ); ?></th>
					<th><?php esc_html_e( 'WP Values', 'postcodeapiplugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $p_wordpress_details ) && ! empty( $p_wordpress_details ) ) { ?>
					<?php foreach ( $p_wordpress_details as $wp_key => $wp_value ) { ?>
						<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
							<tr>
								<td><?php echo esc_html( $wp_key ); ?></td>
								<td><?php echo esc_html( $wp_value ); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="mwb-p-table-inner-container">
		<table class="mwb-p-table" id="mwb-p-php">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Sysytem Variables', 'postcodeapiplugin' ); ?></th>
					<th><?php esc_html_e( 'System Values', 'postcodeapiplugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $p_php_details ) && ! empty( $p_php_details ) ) { ?>
					<?php foreach ( $p_php_details as $php_key => $php_value ) { ?>
						<tr>
							<td><?php echo esc_html( $php_key ); ?></td>
							<td><?php echo esc_html( $php_value ); ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
