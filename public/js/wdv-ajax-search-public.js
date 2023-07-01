(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	 */

    $(document).ready(function(){

    let inputs = document.getElementsByTagName('input');

    var newinputs=[];
    for (let input of inputs) {
        if(input.id){
            newinputs.push(input);
        }
    }

  for (let newinput of newinputs) {
        // fetch data from table without reload/refresh page
        loadData(); 


        function loadData(query){
        var getId=document.getElementById( newinput.id );
        var formname = getId.getAttribute("name");
          $.ajax({
            url : objTips.url,
            type: "POST",
            data: {
               action: 'wdv_ajax_search_ajaxcall',
               formname: formname,
               query:query
            },
            chache :false,
            success:function(response){  
            var newres = ".wdv-site-search #result-" + newinput.id.substring(16);
            $( newres ).html(response);
            var newspinn = " #spinn-" + newinput.id.substring(16);
            var addhere = ".wdv-site-search .input-group" + newspinn;         
            $( newspinn ).remove();
            }
          });  

        }


        // live search data from table without reload/refresh page
        var wdvsearch = ".wdv-site-search "+ "#" + newinput.id;
        $( wdvsearch ).keyup(function(){
          var search = $(this).val();

          if (search !="") {
            loadData(search);
          }else{
            loadData();
            //unbind event after first use:
          $( wdvsearch ).one('keyup',function(){
            var nspinn = "spinn-" + newinput.id.substring(16);
            var addhere = ".wdv-site-search .input-group #wdv-ajax-search-" + newinput.id.substring(16);  
            $(addhere).after('<div class="spinn" id=' + nspinn +'><i class="fas fa-sync fa-spin"></i></div>');
          });
          }
        });

    if(document.getElementById( newinput.id )){
    var inputfocus = document.getElementById( newinput.id );
    inputfocus.addEventListener('focus', (event) => {
    var resultid = 'result-' + newinput.id.substring(16);
    var result=document.getElementById( resultid );
    result.style.display = "block";
    });
    }


    //unbind event after first use:
    $( wdvsearch ).one('keyup',function(){
        var nspinn = "spinn-" + newinput.id.substring(16);
        var addhere = ".wdv-site-search .input-group #wdv-ajax-search-" + newinput.id.substring(16); 
       $( addhere ).after('<div class="spinn" id=' + nspinn + '><i class="fas fa-sync fa-spin"></i></div>');
    });

    //show table
    $( wdvsearch ).click(function() {
      var res = '.wdv-site-search #result-' + newinput.id;
      $( res ).css('display', 'block');      
    });

    //close table
    $(document).mouseup(function (e) {
        var resul = '.wdv-site-search #result-' + newinput.id;
        var container = $( resul );
        if (container.has(e.target).length === 0){
            container.css('display', 'none');
        }
    });



}




//hide alert for last page
$(".wdv-site-search .alert").hide();

//show previous page
$(document).on('click','.wrapper .wdv-prev',function(){
    var findid= $(this).parent().attr("id");
    findid='#'+findid;
    $( findid ).css( "display", "none" );
    var newid=Number(findid.slice(5))-1;
    newid='#page'+newid;
    $( newid ).css( "display", "block" );
});


//show next page
$(document).on('click','.wrapper .wdv-next',function(){
    var findid= $(this).parent().attr("id");
    findid='#'+findid;
    $( findid ).css( "display", "none" );

     var newid=Number(findid.slice(5))+1;
     if (newid>50) {
       $(".wdv-site-search .alert").show();
     } else {
      newid='#page'+newid;
     $( newid ).css( "display", "block" );   
     }

});


// Close tab by ESC
$(document).keyup(function(e) {
if (e.keyCode==27) {
var result=document.getElementById('result');
result.style.display = "none";
}
});









        
});


})( jQuery );