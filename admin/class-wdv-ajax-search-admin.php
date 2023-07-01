<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wdvillage.com/
 * @since      1.0.0
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/admin
 * @author     wdvillage <vrpr2008@gmail.com>
 */
class Wdv_Ajax_Search_Admin {

	//public	$objTabs;  
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wdv_Ajax_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wdv_Ajax_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wdv-ajax-search-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wdv_Ajax_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wdv_Ajax_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


$screen = get_current_screen();

if ($screen->id==='toplevel_page_wdv-ajax-search-dashboard') {
    	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wdv-ajax-search-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
} 
}

        //---------------------------------------------------
        // MENU SECTION
        //---------------------------------------------------
        public function menu_section() {
          add_menu_page( 'WDV Ajax Search', 
          	__('WDV Ajax Search', 'wdv-ajax-search'), 
          	'manage_options', 
          	'wdv-ajax-search-dashboard', 
          	array($this, 'menu_section_display'), 
          	'dashicons-search', 24 );
}

        public function menu_section_display(){
            include_once plugin_dir_path( __FILE__ ) . 'partials/wdv-ajax-search-admin-dashboard-display.php';
        } 

       public function wdv_ajax_search_ajaxcall_edit() {  
			global $wpdb;
			$table_forms = $wpdb->prefix . "wdv_ajax_search_forms";

			$form_id = esc_html($_POST['form_id']);
			$query = $wpdb->prepare( 
			  "SELECT * FROM $table_forms WHERE id = %d", $form_id
			);
			$results = $wpdb->get_results( $query, ARRAY_A  );

			echo json_encode( $results, JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);

			wp_die();
		}
}
        function wdv_ajax_search_admin_form_site_callback(){
            include_once plugin_dir_path( __FILE__ ) . 'partials/wdv-ajax-search-admin-form-site-display.php';
        } 
        function wdv_ajax_search_admin_form_page_callback(){
            include_once plugin_dir_path( __FILE__ ) . 'partials/wdv-ajax-search-admin-form-page-display.php';
        } 