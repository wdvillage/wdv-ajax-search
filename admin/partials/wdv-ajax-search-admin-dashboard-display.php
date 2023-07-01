<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wdvillage.com/
 * @since      1.0.0
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/admin/partials
 */
?>

<div class="wdv-ajax-dashboard">

    <div class="wdv-header">
        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/logo-new-green.png'?>" alt="WDV Ajax Search logo">

        <h1><?php _e('WDV Ajax Search', 'wdv-ajax-search'); ?></h1>
    </div> 

    <div class="top-box" style="vertical-align: middle;">
        <p><a href="https://wdvillage.com/wdv-ajax-search/"><?php _e('Documentation', 'wdv-ajax-search'); ?></a></p>

        <p><?php _e('You can create several different search forms for your site and put their shortcode on different pages. You just need to mark the post type you want when creating the form. For example, your site does have a custom post type "events". You can create an event search form and place it on the events page.', 'wdv-ajax-search'); ?></p>
    </div>


    <div class="top-box" style="vertical-align: middle;">   

    <!-- Open Modal for create search form -->
    <button id="create-btn"><?php _e('Create new search form!', 'wdv-ajax-search'); ?></button>


    <p>
    <?php _e('In table, in the column under the heading "Shortcode" you can find shortcodes for your search forms. This shortcode you can place on page or post. If you want use form shortcode on template  - you must use code like this:', 'wdv-ajax-search'); ?>     
        <span class="show-shortcode"><?php $var="<?php echo do_shortcode('"; echo esc_html($var);?>[wdvajaxsearch form_name="form 1"]<?php echo "'); ?>"?></span>
        <?php _e('- there you can place your form shortcode insted of [wdvajaxsearch form_name="form 1"]', 'wdv-ajax-search'); ?>
        <?php _e('(for detail look here ', 'wdv-ajax-search'); ?><a href="https://wdvillage.com/wdv-ajax-search/"><?php _e('documentation', 'wdv-ajax-search'); ?></a>).</p>

<!---------------------begin table--------------------------------->
<table style="width:100%">
  <tr>
    <th><?php _e('Search form name', 'wdv-ajax-search'); ?></th>
    <th><?php _e('Form description', 'wdv-ajax-search'); ?></th>
    <th><?php _e('Shortcode', 'wdv-ajax-search'); ?></th>
    <th><?php _e('Add/Edit Form Settings', 'wdv-ajax-search'); ?></th>
    <th><?php _e('Delete', 'wdv-ajax-search'); ?></th>
  </tr>

<?php  

global $wpdb;

$table_name = $wpdb->prefix . 'wdv_ajax_search_forms';
//ARRAY_A - Associative array
$data = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );
$last = count($data) - 1;
foreach ($data as $i => $row){
    $isFirst = ($i == 0);
    $isLast = ($i == $last);

    echo '<tr><td>'.esc_html($row['form_name']).'</td>'; 
    echo '<td>'.esc_html($row['form_description']).'</td>';
    echo '<td>'.esc_html($row['form_shortcode']).'</td>
    <td><button class="edit-btn" name="'.esc_html($row["id"]).'" id="'.$row["id"].'">'. __("Add/Edit Settings", "wdv-ajax-search").'</button>'.
    '</td>
    <td><button class="deletebtn" id="'.esc_html($row["id"]).'">'. __("Delete", "wdv-ajax-search").' '.'</button>'.
    '</td></tr>';
} ?>

</table>
<!-------------------------end table------------------------------------->
</div>



<!--------------------------------------------------------------------->
<!----------------------Modal for create------------------------------->
<!--------------------------------------------------------------------->
<div id="myModal" class="modal">

    <div class="modal-content"><span id="create-close">&times;</span>

        <div class="container">

            <h3><?php _e('Create new search form:', 'wdv-ajax-search'); ?></h3>
            <form name="form-search" action="" method="post" id="form-search">
                <div class="form-group">
                    <label><?php _e('Search form name:', 'wdv-ajax-search'); ?></label>
                    <input type="text" class="form-control" name="formname"  required>
                </div>
                <div class="form-group">
                    <label><?php _e('Search form description:', 'wdv-ajax-search'); ?></label>
                    <textarea name="description" class="form-control" rows="3" cols="28" rows="3"></textarea> 
                </div>

                <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form"><?php _e('Save', 'wdv-ajax-search'); ?></button>
            </form>
        <div class="response_msg"></div>
        </div>

    </div>

</div>
<!------------------------------------------------------------------->



<!--------------------------------------------------------------------->
<!-------------------------------Modal Edit---------------------------->
<!--------------------------------------------------------------------->

<div id="myTabModal" class="modal">

<div class="modal-tab-content">
    <span class="edit-close">&times;</span>


<div class="wdv-container">
<h3><?php _e('Form settings:', 'wdv-ajax-search'); ?></h3><div class="result"></div>
<ul>
     <li class="generalid"><?php _e('General', 'wdv-ajax-search'); ?></li>
     <li class="imageid"><?php _e('Image', 'wdv-ajax-search'); ?></li>
     <li class="layoutid"><?php _e('Layout', 'wdv-ajax-search'); ?></li>
</ul>

    <div class="contentWrapper">
              
<!-----------------------GENERAL------------------------------->
      <div class="content general">
      <h3><?php _e('General options', 'wdv-ajax-search'); ?></h3>

<!--------------------------------------> 
<!--------------------------------------> 
<form name="form-general" action="" method="post" id="form-general">

<div class="form-part">
               <?php
            $post_types = get_post_types( [ '_builtin'=>false ] );
            array_push($post_types, "post", "page");
            ?>
            <fieldset>  
                <legend><?php _e('1. Search in custom post types:', 'wdv-ajax-search'); ?></legend>  

                <?php foreach ($post_types as $post_type) { ?>

            <input type="checkbox" name="general_post_type_list[]" value="<?php echo $post_type; ?>">
            <label for=""><?php echo $post_type; ?></label><br>
                <?php } ?>
 
            </fieldset>  
</div> 


<div class="form-part"> 

          <fieldset>  
            <legend><?php _e('2. Search by:', 'wdv-ajax-search'); ?></legend> 
            <input type="radio" id="content" name="general_search_by" value="content" >
            <label for="content"><?php _e('Title & Content', 'wdv-ajax-search'); ?></label><br>
            <input type="radio" id="title" name="general_search_by" value="title"  checked>
            <label for="title"><?php _e('Title', 'wdv-ajax-search'); ?></label><br>
          </fieldset> 
</div> 


<div class="form-part">  
          <label for="norecord"><?php _e('3. Here you can write that message will see your custome if there are not records found (for example - "No record found"):', 'wdv-ajax-search'); ?></label><br>
          <input type="text" id="norecord" name="general_no_records" value="No record found"><br>

          <!--<label for="results"><?php _e('4. How many search result show on one table page:', 'wdv-ajax-search'); ?></label><br>
          <input type="text" id="results" name="general_result" value="10"><br>-->

</div>

<!--------------------------------------> 
<!-------------------------------------->  
<br>


<!-----------------------GENERAL END------------------------------->
</div>
       <!-----------------------IMAGE------------------------------->
      <div class="content image">
      <h3><?php _e('Image options', 'wdv-ajax-search'); ?></h3>

<div class="imagebox">

    <form name="form-image" action="" method="post" id="form-image"> 

        <input type="checkbox" id="image_show" name="image_show">
        <label for="image_show"><?php _e('Show images in results', 'wdv-ajax-search'); ?></label><br>


        <label for="imgwidth"><?php _e('Image width (px):', 'wdv-ajax-search'); ?></label><br>
        <input type="text" id="imgwidth" name="image_width" value="100"><br>

        <label for="imgheight"><?php _e('Image height (px):', 'wdv-ajax-search'); ?></label><br>
        <input type="text" id="imgheight" name="image_height" value="100"><br>

</div>


 <div class="imagebox">
    <fieldset>  
        <legend><?php _e('Use how default image:', 'wdv-ajax-search'); ?></legend> 
        <input type="radio" id="default1" name="image_default" value="Do not use default image" checked>
        <label for="default1"><?php _e('Do not use default image', 'wdv-ajax-search'); ?></label><br><br>
        <input type="radio" id="default2" name="image_default" value="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder.png'?>">
        <label for="default2"> 
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder.png'?>" alt="placeholder">
        </label><br>
        <input type="radio" id="default3" name="image_default" value="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder1.png'?>">
        <label for="default3">
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder1.png'?>" alt="placeholder">
        </label><br>
        <input type="radio" id="default4" name="image_default" value="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder3.png'?>">
        <label for="default4">
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/placeholder3.png'?>" alt="placeholder">
        </label><br>
    </fieldset> 
</div>



      </div>
       <!-----------------------END IMAGE------------------------------->

       <!-----------------------LAYOUT------------------------------->

        <div class="content layout">
        <h3><?php _e('Layout options', 'wdv-ajax-search'); ?></h3>

    <div class="layoutbox">

                  <label for="placeholder"><?php _e('Search box title:', 'wdv-ajax-search'); ?></label><br>
                  <input type="text" id="boxtitle" name="layout_title" value=""><br>

                  <label for="placeholder"><?php _e('Placeholder text:', 'wdv-ajax-search'); ?></label><br>
                  <input type="text" id="placeholder" name="layout_placeholder" value=""><br>

                  <label for="searchb_width"><?php _e('Search box width (%). Leave the field blank if you want the search form to have the same width as the entire block:', 'wdv-ajax-search'); ?></label><br>
                  <input type="text" id="searchb_width" name="layout_searchb_width" value=""><br>

    </div>

</div>
  <!-----------------------END LAYOUT------------------------------->
    <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form"><?php _e('Save', 'wdv-ajax-search'); ?></button>
    <input type="hidden" id="generalid" value="" name="editgeneral"/> 
</form>

  </div>
  </div>

</div>

</div>

<!------------------------------------------------------------------->



<!--------------------------------------------------------------------->
<!-----------------------------Modal- Delete--------------------------->
<!--------------------------------------------------------------------->

<div id="myDeleteModal" class="modal">

    <div class="modal-delete-content">
        <span class="delete-close">&times;</span>

        <div class="wdv-container">
            <form name="form-delete" action="" method="post" id="form-delete">
              <div class="text"><?php _e('Do you really want to delete this search form?', 'wdv-ajax-search'); ?></div>
              <button type="submit" class="btn btn-primary deleteform" name="deletebtn" value="Submit"><?php _e('Delete search form', 'wdv-ajax-search'); ?></button>
              <input type="hidden" id="hiddenid" value="" name="delete"/>
            </form>
        </div>
    </div>
</div>
<!-----------------------------Modal Delete END-------------------------->


<?php 
//******************************************************************************************
//****************************   PHP for btn Create search form    *************************
//******************************************************************************************
//Save form name 
global $wpdb;
$table_name = $wpdb->prefix . 'wdv_ajax_search_forms';
$firstdata = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

if (isset($_POST["formname"])) {
    $formname = wdv_ajax_search_test_input($_POST['formname']);
    //$rowcount = intval($wpdb->get_var("SELECT count(*) FROM $table_name WHERE form_name='$formname'"));
    $query = $wpdb->prepare( 
              "SELECT count(*) FROM $table_name WHERE form_name = %s", $formname
            );
    $rowcount = intval($wpdb->get_var($query, ARRAY_A ));

if( $rowcount > 0 ) {
  //Write text + Choose onther name
    $nameerror= __('A form with name ', 'wdv-ajax-search')."<span>".$formname."</span>". __(' already exists, please use a different name.', 'wdv-ajax-search');
    echo '<div class="nameerror">'.$nameerror.'</div>';
} else {
    $description = wdv_ajax_search_test_input($_POST['description']);
    $shortcode = '[wdvajaxsearch form_name="'.$formname.'"]';
    $wpdb->insert($table_name, array(
        'form_name' => $formname,
        'form_description' => $description,
        'form_shortcode' => $shortcode,
    ));
     echo "<meta http-equiv='refresh' content='0'>";
}
$table_name = $wpdb->prefix . 'wdv_ajax_search_forms';
//ARRAY_A - Associative array
$data = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );
}

//*****************************************************************************************
//****************************   PHP for btn Edit  (general)  ***************************
//******************************************************************************************

//Save form GENERAL options
if (isset($_POST["editgeneral"])) {
    $editgeneralid=sanitize_text_field($_POST['editgeneral']);

    $id_form=sanitize_text_field($_POST['editgeneral']);

        $general_no_records="No record found";
        $general_result=1000000;
        $general_type="";
        $general_search_by="title";

        $image_show="on";
        $image_width=100;
        $image_height=100;                                         
        $image_default="";

        $layout_theme="classic";
        $layout_title="Live search:";
        $layout_placeholder="No record found";
        $layout_searchb_width=100;

if(isset($_POST['submit'])){//to run PHP script on submit
    $general_no_records = wdv_ajax_search_test_input($_POST['general_no_records']); 
    //$general_result = wdv_ajax_search_test_input($_POST['general_result']);
    $general_result = 1000000;
    if(!empty($_POST['general_search_by'])){
    $general_search_by = wdv_ajax_search_test_input($_POST['general_search_by']);
}


if(!empty($_POST['general_post_type_list'])){
$general_type = sanitize_text_field(implode(",", (array)$_POST['general_post_type_list']));
}
if(!empty($_POST['general_search_by_list'])){
$general_search_by = sanitize_text_field(implode(",",  (array)$_POST['general_search_by_list']));
}
if(!empty($_POST['image_show'])){
        $image_show = 'on';
}else{
    $image_show = 'off';
}

if(!empty($_POST['image_width'])){
    $image_width = wdv_ajax_search_test_input($_POST['image_width']);   
}
if(!empty($_POST['image_height'])){
    $image_height = wdv_ajax_search_test_input($_POST['image_height']);
}
if(!empty($_POST['image_default'])){
    $image_default = wdv_ajax_search_test_input($_POST['image_default']);
}

if(!empty($_POST['layout_title'])){
    $layout_title = wdv_ajax_search_test_input($_POST['layout_title']); 
}    
if(!empty($_POST['layout_placeholder'])){
    $layout_placeholder = wdv_ajax_search_test_input($_POST['layout_placeholder']); 
}
if(!empty($_POST['layout_searchb_width'])){
    $layout_searchb_width = wdv_ajax_search_test_input($_POST['layout_searchb_width']); 
}


//update data in db
$wpdb->update( $table_name, array(
        'general_no_records' => $general_no_records,
        'general_result' => $general_result,
        'general_type' => $general_type,
        'general_search_by' => $general_search_by,

        'image_show' => $image_show,    
        'image_width' => $image_width,
        'image_height' => $image_height,
        'image_default' => $image_default, 

        'layout_theme' =>'classic',
        'layout_title' =>$layout_title,
        'layout_placeholder' =>$layout_placeholder,
        'layout_searchb_width' =>$layout_searchb_width,
    ),
    [ 'ID' => $id_form]
);

}
}


//********************************************************************************
//****************************   PHP for btn Delete    ****************************
//*********************************************************************************
if (isset($_POST["delete"])) {
    $deleteid=sanitize_text_field($_POST['delete']);
    //delete from db
    $wpdb->delete( $table_name, [ 'ID' => $deleteid]  );

    echo "<meta http-equiv='refresh' content='0'>";
} 

?>