<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wdvillage.com/
 * @since      1.0.0
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/includes
 * @author     wdvillage <vrpr2008@gmail.com>
 */
class Wdv_Ajax_Search_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

               global $wpdb;
                $wdv_ajax_search_db_version = '1.0.0';

                // Table settings
                $table_name = $wpdb->prefix . 'wdv_ajax_search_forms';
                $charset_collate = $wpdb->get_charset_collate();

                if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {
                $sql = "CREATE TABLE $table_name (
                                        `id` int(11) NOT NULL AUTO_INCREMENT,

                                        `form_name` varchar(250) NOT NULL,
                                        `form_description` varchar(250) NOT NULL,
                                        `form_shortcode` varchar(250) NOT NULL,

                                        `general_type` varchar(250)  DEFAULT 'post,page',
                                        `general_search_by` varchar(250) DEFAULT 'content',
                                        `general_no_records` varchar(250) DEFAULT 'No record found',
                                        `general_result` int(11) DEFAULT 1000000,

                                        `image_show` varchar(250) DEFAULT 'on',
                                        `image_width` int(11) DEFAULT 100,
                                        `image_height` int(11) DEFAULT 67,                                         
                                        `image_default` varchar(250) DEFAULT 'Do not use default image',


                                         `layout_theme`  varchar(250) DEFAULT 'classic',
                                         `layout_title` varchar(250) DEFAULT 'Live search:',
                                         `layout_placeholder` varchar(250) DEFAULT 'Search here...',
                                         `layout_searchb_width` int(11) DEFAULT 100,                                            

                                        PRIMARY KEY  (id)
                                        ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }

                add_option( 'wdv_ajax_search_db_version', $wdv_ajax_search_db_version );




    }

}