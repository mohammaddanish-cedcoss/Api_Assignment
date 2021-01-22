<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $p_mwb_p_obj;
$p_active_tab   = isset( $_GET['p_tab'] ) ? sanitize_key( $_GET['p_tab'] ) : 'postcodeapiplugin-general';
$p_default_tabs = $p_mwb_p_obj->mwb_p_plug_default_tabs();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-p-main-wrapper">
	<div class="mwb-p-go-pro">
		<div class="mwb-p-go-pro-banner">
			<div class="mwb-p-inner-container">
				<div class="mwb-p-name-wrapper">
					<p><?php esc_html_e( 'postcodeapiplugin', 'postcodeapiplugin' ); ?></p></div>
					<div class="mwb-p-static-menu">
						<ul>
							<li>
								<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="_blank">
									<span class="dashicons dashicons-phone"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/hubspot-woocommerce-integration/' ); ?>" target="_blank">
									<span class="dashicons dashicons-media-document"></span>
								</a>
							</li>
							<?php $p_plugin_pro_link = apply_filters( 'p_pro_plugin_link', '' ); ?>
							<?php if ( isset( $p_plugin_pro_link ) && '' != $p_plugin_pro_link ) { ?>
								<li class="mwb-p-main-menu-button">
									<a id="mwb-p-go-pro-link" href="<?php echo esc_url( $p_plugin_pro_link ); ?>" class="" title="" target="_blank"><?php esc_html_e( 'GO PRO NOW', 'postcodeapiplugin' ); ?></a>
								</li>
							<?php } else { ?>
								<li class="mwb-p-main-menu-button">
									<a id="mwb-p-go-pro-link" href="#" class="" title=""><?php esc_html_e( 'GO PRO NOW', 'postcodeapiplugin' ); ?></a>
								</li>
							<?php } ?>
							<?php $p_plugin_pro = apply_filters( 'p_pro_plugin_purcahsed', 'no' ); ?>
							<?php if ( isset( $p_plugin_pro ) && 'yes' == $p_plugin_pro ) { ?>
								<li>
									<a id="mwb-p-skype-link" href="<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>" target="_blank">
										<img src="<?php echo esc_url( POSTCODEAPIPLUGIN_DIR_URL . 'admin/images/skype_logo.png' ); ?>" style="height: 15px;width: 15px;" ><?php esc_html_e( 'Chat Now', 'postcodeapiplugin' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="mwb-p-main-template">
			<div class="mwb-p-body-template">
				<div class="mwb-p-navigator-template">
					<div class="mwb-p-navigations">
						<?php
						if ( is_array( $p_default_tabs ) && ! empty( $p_default_tabs ) ) {

							foreach ( $p_default_tabs as $p_tab_key => $p_default_tabs ) {

								$p_tab_classes = 'mwb-p-nav-tab ';

								if ( ! empty( $p_active_tab ) && $p_active_tab === $p_tab_key ) {
									$p_tab_classes .= 'p-nav-tab-active';
								}
								?>
								
								<div class="mwb-p-tabs">
									<a class="<?php echo esc_attr( $p_tab_classes ); ?>" id="<?php echo esc_attr( $p_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=postcodeapiplugin_menu' ) . '&p_tab=' . esc_attr( $p_tab_key ) ); ?>"><?php echo esc_html( $p_default_tabs['title'] ); ?></a>
								</div>

								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="mwb-p-content-template">
					<div class="mwb-p-content-container">
						<?php
							// if submenu is directly clicked on woocommerce.
						if ( empty( $p_active_tab ) ) {

							$p_active_tab = 'mwb_p_plug_general';
						}

							// look for the path based on the tab id in the admin templates.
						$p_tab_content_path = 'admin/partials/' . $p_active_tab . '.php';

						$p_mwb_p_obj->mwb_p_plug_load_template( $p_tab_content_path );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
