<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Postcodeapiplugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function postcodeapiplugin_deactivate() {
		$post_id = get_page_by_title( 'Check Postcode' );
		if ( $post_id ) {
			wp_delete_post( $post_id->ID ,true );
		}
	}

}
