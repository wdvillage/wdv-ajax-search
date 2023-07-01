<?php

/**
 * Shortcode
 */

class Wdv_Ajax_Search_Shortcode {
public string $shortcode;
    public function __construct() {
        add_shortcode( 'wdvajaxsearch', array( $this, 'shortcode' ) );
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
    global $wdvajaxsearch_atts; 
    $shortcode = 'wdvajaxsearch';
    $wdvajaxsearch_atts   = shortcode_atts( array('form_name'    => ''), $atts, $shortcode );
    $template = new SC101_Template_Loader1();

        ob_start();
        $template->get_template_part( 'wdv-ajax-search-public-shortcode-display' );
        return ob_get_clean();    
    }
}