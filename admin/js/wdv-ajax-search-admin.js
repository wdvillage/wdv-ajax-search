(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

  $(document).ready(function(){

        function loadData(id){
           var editgeneralid=Number(id);
          $.ajax({
            url : ajaxurl,
            type: "POST",
            data: {
               action: 'wdv_ajax_search_ajaxcall_edit',
               form_id: editgeneralid
            },
            success:function(response){  
              const data = JSON.parse(response);
              var datalength=data.length;

 if ( datalength===0){

              var form_id=0;
              /*GENERAL*/
              var general_no_records='No record found';
              var general_result=1000000;
              var general_search_by='title';
              var general_type='post,page';

               /*IMAGE*/
              var image_show='no';
              var image_width=100;
              var image_height=100;
              var image_default='Do not use default image';

              /*layout*/
              var layout_theme='classic';
              var layout_title= 'Live search:';
              var layout_placeholder= 'No record found';
              var layout_searchb_width= 100;

}else {

              var form_id=data[0].id;
              /*GENERAL*/
              var general_no_records= data[0].general_no_records;
              var general_result= data[0].general_result;
              var general_search_by= data[0].general_search_by;
              var general_type= data[0].general_type;
 
               /*IMAGE*/
              var image_show= data[0].image_show;
              var image_width= data[0].image_width;
              var image_height= data[0].image_height;
              var image_default= data[0].image_default;

               /*layout*/
              var layout_theme= data[0].layout_theme;
              var layout_title= data[0].layout_title;
              var layout_placeholder= data[0].layout_placeholder;
              var layout_searchb_width= data[0].layout_searchb_width;


}


             var posttypelist = [];
             if ( datalength===0){
              posttypelist=[post,page];
             }else{
             posttypelist=document.getElementsByName("general_post_type_list[]");
             }
             for (let ii = 0; ii < posttypelist.length; ++ii) {
               posttypelist[ii].checked = false;
                var general_typearr=general_type.split(','); 
                for (let i = 0; i < general_typearr.length; ++i) {
                    if (posttypelist[ii].value===general_typearr[i]) {
                      posttypelist[ii].checked = true;
                    } 
                }
              }    

              $('#norecord').val(general_no_records); 

              $('#results').val(general_result); 

             var searchbylist = document.getElementsByName("general_search_by"); 
             for (let ii = 0; ii < 2; ++ii) {
               searchbylist[ii].checked = false;
                    if (searchbylist[ii].value===general_search_by) {
                      searchbylist[ii].checked = true;
                    } 
              } 

            /*IMAGE*/
             var imageshow = document.getElementById("image_show"); 
               imageshow.checked = false;
                    if (imageshow.value===image_show) {
                      imageshow.checked = true;
                    }  

              $('#imgwidth').val(image_width); 
              $('#imgheight').val(image_height); 
             var imagedefault = document.getElementsByName("image_default"); 
             for (let ii = 0; ii < imagedefault.length; ++ii) {
               imagedefault[ii].checked = false;
                    if (imagedefault[ii].value===image_default) {
                      imagedefault[ii].checked = true;
                    } 
              } 

            /*LAYOUT*/
              $('#layout_theme').val(layout_theme);              

              $('#boxtitle').val(layout_title); 
              $('#placeholder').val(layout_placeholder); 
              $('#searchb_width').val(layout_searchb_width); 

            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                       
            } 
          });  

        }


//Modal for btn "Create new search form!"
// Get modal
var modal = document.getElementById("myModal");
// Get createbtn
var createbtn = document.getElementById("create-btn");
var createspan = document.getElementById("create-close");

// When the user clicks on the button, open the modal window
createbtn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on the <span> (x), close the modal window
createspan.onclick = function() {
  modal.style.display = "none";
}

//When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


//***********************************************
//Modal for btn "Add/Edit"
// Get modal
var editgeneralid=0;
var editmodal = document.getElementById("myTabModal");
// Get the button that opens the modal
var editbtns = document.getElementsByClassName("edit-btn");
                for(var i=0; i<editbtns.length; i++)
                {
                    editbtns[i].onclick = function() {
                      editmodal.style.display = "block";
                      editgeneralid = $(this).attr("id");
                      loadData(editgeneralid);

                      $('#generalid').val(editgeneralid);
                      $('#imageid').val(editgeneralid);
                      $('#layoutid').val(editgeneralid);
                    }
                } 
// Get the <span> element that closes the modal
var editspans = document.getElementsByClassName("edit-close");
                for(var i=0; i<editspans.length; i++)
                {
                     // When the user clicks on the <span> (x), close the modal
                    editspans[i].onclick = function() {
                      editmodal.style.display = "none";
                    }
                } 

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    editmodal.style.display = "none";
  }
}

//***********************************************
//Modal for btn "Delete"
// Get modal
var deleteid=0;
var deletemodal = document.getElementById("myDeleteModal");
// Get the button that opens the modal
var deletebtns = document.getElementsByClassName("deletebtn");
                for(var i=0; i<deletebtns.length; i++)
                {
                    deletebtns[i].onclick = function() {
                      deletemodal.style.display = "block";

         deleteid = $(this).attr("id");

                      $('#hiddenid').val(deleteid);
                    }
                } 
// Get the <span> element that closes the modal
var deletespans = document.getElementsByClassName("delete-close");
                for(var i=0; i<deletespans.length; i++)
                {
                     // When the user clicks anywhere outside the modal, close it
                    deletespans[i].onclick = function() {
                      deletemodal.style.display = "none";
                    }
                } 

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    deletemodal.style.display = "none";
  }
}

       $(".image").hide();
       $(".frontend").hide();
        $(".layout").hide();
       $(".general").show();

   $(".generalid").click(function(event){
       $(".image").hide();
       $(".frontend").hide();
               $(".layout").hide();
       $(".general").show();
   });
   $(".imageid").click(function(event){
       $(".image").show();
       $(".frontend").hide();
               $(".layout").hide();
       $(".general").hide();
   });
      $(".frontendid").click(function(event){
       $(".image").hide();
       $(".frontend").show();
               $(".layout").hide();
       $(".general").hide();
   });
      $(".layoutid").click(function(event){
       $(".image").hide();
       $(".frontend").hide();
               $(".layout").show();
       $(".general").hide();
   });





  });

})( jQuery );