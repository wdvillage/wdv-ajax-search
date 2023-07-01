<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wdvillage.com/
 * @since      1.0.0
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wdv_Ajax_Search
 * @subpackage Wdv_Ajax_Search/public
 * @author     wdvillage <vrpr2008@gmail.com>
 */
class Wdv_Ajax_Search_Public {


	public	$objTips;  

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( 'fontawesomepublic', plugin_dir_url( __FILE__ ) . '../includes/fonts/css/all.min.css', array(),'5.9.0' , 'all' );
        wp_enqueue_style( 'fontawesomepublicv4', plugin_dir_url( __FILE__ ) . '../includes/fonts/css/v4-shims.min.css', array(), '5.9.0', 'all' );                               
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wdv-ajax-search-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
				$objTips = (object) ['wdvajaxsearchmyajax' =>'wdvajaxsearchmyajax', 'wdvajaxsearchmyajaxbtn' =>'wdvajaxsearchmyajaxbtn'];  


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

       
	global $post;
	if( (is_single() || is_page())) {
   		wp_register_script( 'custom_highlight', plugin_dir_url( __FILE__ ). 'libs/jquery.highlight.js', array( 'jquery' ), null, true ); 
	    wp_enqueue_script('custom_highlight');
	}

	if( (is_single() || is_page()) && !has_shortcode( $post->post_content, 'wdvajaxsearch-postpage') ) {
		wp_register_script( 'custom_finder', plugin_dir_url( __FILE__ ). 'libs/jquery.finder.js', array( 'jquery', 'custom_highlight' ), null, true);  
   		wp_enqueue_script('custom_finder');
	}

	if( (is_single() || is_page()) && has_shortcode( $post->post_content, 'wdvajaxsearch-postpage') ) {
		wp_register_script( 'custom_findershort', plugin_dir_url( __FILE__ ). 'libs/jquery.findershort.js', array( 'jquery', 'custom_highlight' ), null, true);  
   		wp_enqueue_script('custom_findershort');
	}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wdv-ajax-search-public.js', array( 'jquery'), $this->version, false );
		wp_localize_script( $this->plugin_name, 'objTips', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}


public function wdv_ajax_search_ajaxcall() {   
//get data from db
global $wpdb;
$form_table_name = $wpdb->prefix . "wdv_ajax_search_forms";

$formname = sanitize_text_field( $_POST['formname'] );
$query = $wpdb->prepare( 
	"SELECT * FROM $form_table_name WHERE form_name = %s", $formname
);
$data = $wpdb->get_row( $query, ARRAY_A  );

$posttypes= $data[ 'general_type' ]; 
$searchby=$data[ 'general_search_by' ]; 
$general_type=  explode(",",  $posttypes); 
$posttypesarray=explode(",",  $posttypes);
$variables= implode(", ", $posttypesarray);
foreach ($general_type as &$value) {
    $value = "post_type=%s";
}
unset($value); // break link to last element
$general_type=  implode(" OR ", $general_type); 
$norecord= $data[ 'general_no_records' ]; 
$numberresult=$data[ 'general_result' ]; 

$image_show= $data['image_show'];
$image_width= $data['image_width'];
$image_height= $data['image_height'];
$image_default= $data['image_default'];
if($image_default==="Do not use default image"){
	$image_default='';
}

$layout_theme= $data['layout_theme'];

if ($searchby==='title'){
	searchbytitle($form_table_name, $formname, $posttypes, $searchby, $general_type, $norecord, $numberresult, $image_show, $image_width, $image_height, $image_default);
}  
elseif ($searchby==='content') { 
	searchbycontent($form_table_name, $formname, $posttypes, $searchby, $general_type, $norecord, $numberresult, $image_show, $image_width, $image_height, $image_default);
}
	wp_die();
}
        //---------------------------------------------------
        // Shortcode
        //---------------------------------------------------      
        public function wdv_ajax_search_shortcode() { 
        	$shortcode = new Wdv_Ajax_Search_Shortcode();
		}
}
/****************************************************
*****************************************************
* 
*     $searchby='title'
* 
*****************************************************
****************************************************/
function searchbytitle($form_table_name, $formname, $posttypes, $searchby, $general_type, $norecord, $numberresult, $image_show, $image_width, $image_height, $image_default) {
global $wpdb;
$output = "";
$siteurl0=admin_url();
$siteurl=str_replace('wp-admin/','',$siteurl0);

	if (isset($_POST['query'])) {
	$search =sanitize_text_field($_POST['query']);
	$table_name = $wpdb->prefix . "posts";
	$table_forms = $wpdb->prefix . "wdv_ajax_search_forms";

$search = '%'.$search.'%';
$posttypesarray=explode(",",  $posttypes);
$variables= implode(", ", $posttypesarray);
$newsearch=mb_substr($search, 1, -1);

foreach ($posttypesarray as &$value) {
    $type=$type.$value.',';
}
unset($value);
for ($x = 0; $x < count($posttypesarray); $x++) {
  $posttypesarray[$x];
}
array_push($posttypesarray, $search);
$introwcount = $wpdb->get_var($wpdb->prepare( 
	"SELECT COUNT( * ) FROM $table_name 
	WHERE ($general_type)
	AND post_title LIKE %s AND post_status='publish'",
	$posttypesarray
));
			$perpage =$numberresult;// items per page
			$pages_count  = (int)ceil($introwcount / $perpage);
			$pages_count_numb=$pages_count;

			//Create array with pages:
			$pages = array();
			while ($pages_count>0) {
				$page = array();
				array_push($pages, $page);
				$pages_count=$pages_count-1;
			}

			if ($introwcount > 0 ) {
			$pages_count_num=1;
			while ($pages_count_num<=$pages_count_numb) {	
				$output = "";
				$carrent_page = $pages_count_num;
				$minlimit = $perpage*($carrent_page-1);
				$maxlimit = $perpage*$carrent_page;
				if (($pages_count_num===$pages_count_numb)&&($maxlimit-$introwcount)<$perpage) {
					$maxlimit = intval($introwcount);
				}

				$output .= "<div class='wrapper' id=page".(string)$carrent_page."><table id='tab' class='table table-hover table-striped'>
						<thead>
						<tr>
							<th width=". $image_width . ">".$introwcount.esc_html__( '&#32;results', 'wdv-ajax-search' ). "</th>

							<th></th>
						</tr> 
						</thead><tbody>";

				$counts=$maxlimit-$minlimit;			
				array_push($posttypesarray, $minlimit, $maxlimit);

				if ($introwcount<$perpage){
					$counts=$introwcount;
				}
			$count=1;
			while ($count<=$counts) {	

$mylink = $wpdb->get_row( $wpdb->prepare( 
	"SELECT post_title, ID FROM $table_name
	WHERE (	$general_type )
	AND post_title LIKE %s AND post_status='publish' LIMIT %d, %d", 
	$posttypesarray
),ARRAY_A, $count-1 );

$myid=$mylink['ID'];		
if (!get_the_post_thumbnail( $myid, array($image_width, $image_height) )){
	if($image_default===''){
		$img='';
	} else{
			$img='<img src="'.$image_default.'" alt="Default" width="'. $image_width .'" height="'. $image_height .'">';
	}
	} else {
		 $img=get_the_post_thumbnail( $myid, array($image_width, $image_height) );
	}
	   
	    if ($image_show!=='no'){ 
		$output .= "<tr>
					<td>
					<a href='$siteurl?p={$mylink['ID']}'>{$img}</a></td>
					<td><a href='$siteurl?p={$mylink['ID']}'>{$mylink['post_title']}</a></td>
					</tr>";
		} else {
		$output .= "<tr>
					<td></td>
					<td><a href='$siteurl?p={$mylink['ID']}'>{$mylink['post_title']}</a></td>
					</tr>";						
		}

		$count=$count+1;
		}	
	$btns="";

	if ($carrent_page===1){
		$prevbtn="<button type='button' class='wdv-prev' disabled><i class='fas fa-long-arrow-alt-left'></i></button>";
		} else {
		$prevbtn="<button type='button' class='wdv-prev'><i class='fas fa-long-arrow-alt-left'></i></button>";
		}
		$pages_count  = (int)ceil($introwcount / $perpage);
	if ($carrent_page===$pages_count){

		$nextbtn="<button type='button' class='wdv-next' disabled><i class='fas fa-long-arrow-alt-right'></i></button>";
		} else {
		$nextbtn="<button type='button' class='wdv-next'><i class='fas fa-long-arrow-alt-right'></i></button>";
		}

		$btns=$prevbtn.$nextbtn;
			if ($pages_count===1) {
				$output .="</tbody></table></div>";
			} else {
				$output .="</tbody></table>". $btns . "</div>";
			}
			echo wp_kses_post($output);
			$pages_count_num=$pages_count_num+1;
	}	
			}else{
					echo "<div class='no-record'>".esc_html__( $norecord, 'wdv-ajax-search' )."</div>";		
			}
	wp_die();		
}
}

/****************************************************
*****************************************************
* 
*     $searchby='content'
* 
*****************************************************
****************************************************/
function searchbycontent($form_table_name, $formname, $posttypes, $searchby, $general_type, $norecord, $numberresult, $image_show, $image_width, $image_height, $image_default) {
//get data from db
global $wpdb;
$output = "";
$siteurl0=admin_url();
$siteurl=str_replace('wp-admin/','',$siteurl0);

function add_custom_query_var( $vars ){ $vars[] = "c"; return $vars; } 
add_filter( 'query_vars', 'add_custom_query_var' ); 
add_custom_query_var( $search );

	if (isset($_POST['query'])) {
	$search =sanitize_text_field($_POST['query']);
  	$table_name = $wpdb->prefix . "posts";
 	$table_forms = $wpdb->prefix . "wdv_ajax_search_forms";

$search = '%'.$search.'%';
$posttypesarray=explode(",",  $posttypes);
$variables= implode(", ", $posttypesarray);
$newsearch=mb_substr($search, 1, -1);

foreach ($posttypesarray as &$value) {
    $type=$type.$value.',';
}
unset($value);
for ($x = 0; $x < count($posttypesarray); $x++) {
  $posttypesarray[$x];
}
array_push($posttypesarray, $search, $search, $search, $search);
$introwcount = intval($wpdb->get_var($wpdb->prepare( "SELECT COUNT( * ) 
	FROM $table_name 
	WHERE ($general_type)
	AND ((post_content LIKE %s OR post_title LIKE %s ) 
	OR (post_content LIKE %s  AND post_title LIKE %s ))
	AND post_status='publish'", 
	$posttypesarray
)));
				$perpage =$numberresult;// items per page
				$pages_count  = (int)ceil($introwcount / $perpage);
				$pages_count_numb=$pages_count;

				//Create array with pages:
				$pages = array();
				while ($pages_count>0) {
					$page = array();
					array_push($pages, $page);
					$pages_count=$pages_count-1;
				}

				if ($introwcount > 0 ) {

				$pages_count_num=1;
				while ($pages_count_num<=$pages_count_numb) {	
						$output = "";

					$carrent_page = $pages_count_num;
					$minlimit = $perpage*($carrent_page-1);
					$maxlimit = $perpage*$carrent_page;
					if (($pages_count_num===$pages_count_numb)&&($maxlimit-$introwcount)<$perpage) {
						$maxlimit = $introwcount;
					}

						$output .= "<div class='wrapper' id=page".(string)$carrent_page."><table id='tab' class='table table-hover table-striped'>
						<thead>
						<tr>
							<th width=". $image_width . ">".$introwcount.esc_html__( '&#32;results', 'wdv-ajax-search' )."</th>

							<th></th>
						</tr>
						</thead><tbody>";

						$counts=$maxlimit-$minlimit;
						if ($introwcount<$perpage){
							$counts=$introwcount;
						}

				$count=1;
				while ($count<=$counts) {	

array_push( $posttypesarray, $minlimit, $maxlimit );
$mylink = $wpdb->get_row( $wpdb->prepare( 
"SELECT post_title,post_content,post_excerpt, ID 
FROM $table_name
WHERE ($general_type)
AND ((post_content LIKE %s  OR post_title LIKE %s ) 
OR (post_content LIKE %s  AND post_title LIKE %s  )) AND post_status='publish'
LIMIT %d, %d", $posttypesarray ), ARRAY_A, $count-1 );

		$myid=$mylink['ID'];		

		if (!get_the_post_thumbnail( $myid, array($image_width, $image_height) )){
			if($image_default===''){
				$img='';
			}else{
					$img='<img src="'.$image_default.'" alt="Default" width="'. $image_width .'" height="'. $image_height .'">';
			}
		}else {
			 $img=get_the_post_thumbnail( $myid, array($image_width, $image_height) );
		}
	    if ($image_show!=='no'){ 
		$output .= "<tr>

					<td>
					<a href=". esc_url( add_query_arg( 'c', $newsearch, $siteurl . '?p=' .$mylink['ID'] ) ).">{$img}</a></td>
					<td><a href=". esc_url( add_query_arg( 'c', $newsearch, $siteurl . '?p=' .$mylink['ID'] ) ).">{$mylink['post_title']}</a>
					<div class='p_excerpt'>{$mylink['post_excerpt']}</div>
					</td>
					</tr>";
		}else {
		$output .= "<tr>
					<td></td>
					<td><a href=". esc_url( add_query_arg( 'c', $newsearch, $siteurl . '?p=' .$mylink['ID'] ) ).">{$mylink['post_title']}</a>
					<div class='p_excerpt'>{$mylink['post_excerpt']}</div>
					</td>
					</tr>";						
		}
				$count=$count+1;
				}	
	$btns="";

	if ($carrent_page===1){
		$prevbtn="<button type='button' class='wdv-prev' disabled><i class='fas fa-long-arrow-alt-left'></i></button>";
		} else {
		$prevbtn="<button type='button' class='wdv-prev'><i class='fas fa-long-arrow-alt-left'></i></button>";
		}
		$pages_count  = (int)ceil($introwcount / $perpage);
	if ($carrent_page===$pages_count){

		$nextbtn="<button type='button' class='wdv-next' disabled><i class='fas fa-long-arrow-alt-right'></i></button>";
		} else {
		$nextbtn="<button type='button' class='wdv-next'><i class='fas fa-long-arrow-alt-right'></i></button>";
		}

		$btns=$prevbtn.$nextbtn;
			if ($pages_count===1) {
				$output .="</tbody></table></div>";
			} else {
				$output .="</tbody></table>". $btns . "</div>";
			}
	echo wp_kses_post($output);
	$pages_count_num=$pages_count_num+1;
	}	

			}else{
					echo "<div class='no-record'>".esc_html__( $norecord, 'wdv-ajax-search' )."</div>";					
				}
					wp_die();
				}

} //end $searchby='content'