<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the welcome html.
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
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-p-main-wrapper">
	<div class="mwb-p-go-pro">
		<div class="mwb-p-go-pro-banner">
			<div class="mwb-p-inner-container">
				<div class="mwb-p-name-wrapper" id="mwb-p-page-header">
					<h3><?php esc_html_e( 'Welcome To MakeWebBetter', 'postcodeapiplugin' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="mwb-p-inner-logo-container">
				<div class="mwb-p-main-logo">
					<img src="<?php echo esc_url( POSTCODEAPIPLUGIN_DIR_URL . 'admin/images/logo.png' ); ?>">
					<h2><?php esc_html_e( 'We make the customer experience better', 'postcodeapiplugin' ); ?></h2>
					<h3><?php esc_html_e( 'Being best at something feels great. Every Business desires a smooth buyer’s journey, WE ARE BEST AT IT.', 'postcodeapiplugin' ); ?></h3>
				</div>
				<div class="mwb-p-active-plugins-list">
					<?php
					$mwb_p_all_plugins = get_option( 'mwb_all_plugins_active', false );
					if ( is_array( $mwb_p_all_plugins ) && ! empty( $mwb_p_all_plugins ) ) {
						?>
						<table class="mwb-p-table">
							<thead>
								<tr class="mwb-plugins-head-row">
									<th><?php esc_html_e( 'Plugin Name', 'postcodeapiplugin' ); ?></th>
									<th><?php esc_html_e( 'Active Status', 'postcodeapiplugin' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( is_array( $mwb_p_all_plugins ) && ! empty( $mwb_p_all_plugins ) ) { ?>
									<?php foreach ( $mwb_p_all_plugins as $p_plugin_key => $p_plugin_value ) { ?>
										<tr class="mwb-plugins-row">
											<td><?php echo esc_html( $p_plugin_value['plugin_name'] ); ?></td>
											<?php if ( isset( $p_plugin_value['active'] ) && '1' != $p_plugin_value['active'] ) { ?>
												<td><?php esc_html_e( 'NO', 'postcodeapiplugin' ); ?></td>
											<?php } else { ?>
												<td><?php esc_html_e( 'YES', 'postcodeapiplugin' ); ?></td>
											<?php } ?>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<?php
					}
					?>
				</div>
			</div>
		</div>
