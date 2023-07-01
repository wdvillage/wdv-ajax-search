<?php

/**
 * Shortcode
 */
class Wdv_Ajax_Search_On_Page_Shortcode {

    public function __construct() {
        add_shortcode( 'wdvajaxsearch-postpage', array( $this, 'shortcode' ) );
    }

    /**
     * Shortcode handler
     *
     * @param  array  $atts
     * @param  string  $content
     *
     * @return string
     */
    public function shortcode($atts) {  
    $template = new SC101_Template_Loader1();
        ob_start();
        $template->get_template_part( 'wdv-ajax-search-public-page-shortcode-display' );
        return ob_get_clean();
    }
}