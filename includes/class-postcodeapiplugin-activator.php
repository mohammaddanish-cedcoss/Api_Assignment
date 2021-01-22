<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Postcodeapiplugin
 * @subpackage Postcodeapiplugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Postcodeapiplugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function postcodeapiplugin_activate() {
		$my_post = array(
			'post_title'  => 'Check Postcode',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'   => 'page',
		);
		// Insert the post into the database.
		wp_insert_post( $my_post );
	}

}
