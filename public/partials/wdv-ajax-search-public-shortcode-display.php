  <?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wdvillage.com/
 * @since      1.0.0
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/public/partials
 */
global $wdvajaxsearch_atts;

//get data from db
global $wpdb;
$form_table_name = $wpdb->prefix . "wdv_ajax_search_forms";
$formname= $wdvajaxsearch_atts['form_name'];

$query = $wpdb->prepare( 
  "SELECT * FROM $form_table_name WHERE form_name = %s", 
  $formname
);
$data = $wpdb->get_row( $query, ARRAY_A );

if ($data===NULL){
    $layout_theme= '';
    $layout_placeholder= '';
    $layout_title= '';
    $layout_searchb_width= 100;
} else {
    $layout_theme= $data['layout_theme'];
    $layout_placeholder= $data['layout_placeholder'];
    $layout_title= $data['layout_title'];
    $layout_searchb_width= $data['layout_searchb_width'];
}
?>
   
<div class="wdv-site-search" style='width:<?php echo esc_html($layout_searchb_width)."%"; ?>'>

<form method="post">

              <label for="search"><?php echo esc_html($layout_title); ?></label>
            <div class="cont" <?php if($layout_theme==='with-shadow'){echo "style='  -webkit-box-shadow: 2px 2px 18px 5px rgba(64,148,255,0.45); 
box-shadow: 2px 2px 18px 5px rgba(64,148,255,0.45);'";} ?>  <?php if($layout_theme==='with-btn'){echo "style='border: 0 solid #ccc;'";} ?>>
              <span class="input-group-addon"><i class="fa fa-search" <?php if($layout_theme==='with-btn'){echo "style='background:#eee;'";} ?>></i></span> 
              <span class="input-group">
                <input type="text" id='<?php echo "wdv-ajax-search-" . $wdvajaxsearch_atts["form_name"]; ?>'  class="form-control" autocomplete="off" placeholder="<?php echo $layout_placeholder; ?>" name="<?php echo $wdvajaxsearch_atts["form_name"]; ?>" <?php if($layout_theme==='with-btn'){echo "style='   border-top-width: 1px; border-bottom-width: 1px;'";} ?>>
              </span>              
            </div>

      <div id="<?php echo "result-" . $wdvajaxsearch_atts["form_name"]; ?>" class="result"></div>
      <div id="<?php echo "alert-" . $wdvajaxsearch_atts["form_name"]; ?>" class="alert">Too many results found. Use a search phrase instead of a search word for a more precise search.</div>
</form>  
</div>