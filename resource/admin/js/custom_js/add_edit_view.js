/*** 
* File Name: add_edit_view.js
* Created By: ACS Dev
* Created On: July 31, 2014
* Purpose: Add Edit page required javascript code 
*/

// Display error
var markAsError = function(selector,msg){
    $(selector).next('.text-danger').html(msg);    
    $(selector).parents('.control-group').addClass("error");
    
    $(selector).on('focus',function(){
        removeAsError($(this));
    });
}

// Hide error
var removeAsError = function(selector){
    $(selector).next('.text-danger').html('');    
    $(selector).parents('.control-group').removeClass("error");
} 
   
$(document).ready(function(){  
    
    // Click on cancel button
    $('#btn_cancel').click(function(i){
         window.location.href=g_controller+'show_list/';
    });  

    // Clieck on close button
    $('.btn-close').click(function(i){
         window.location.href=g_controller; 
    });  

    // Click on save button
    $('#btn_save').click(function(){
       //check_duplicate();
       $("#frm_add_edit").submit();
    }); 
    
    //Submitting search all//
    $("#btn_srchall").click(function(){
        $("#frm_search_3").submit();
    });
    //end Submitting search all//
    
    $(".glyphicon-zoom-in").colorbox();
    
    //Submitting the form//                                            
    $("#btn_submit").click(function(){
        var formid=$(this).attr("search");    
        $("#frm_search_"+formid).attr("action", search_action);
        $("#frm_search_"+formid).submit(); 
    });                                              
    //Submitting the form//
});