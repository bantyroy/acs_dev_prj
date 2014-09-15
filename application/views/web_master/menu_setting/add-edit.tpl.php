<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 9 June 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For news Add & Edit
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/news/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>

<script language="javascript">

jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
      // $("#frm_add_edit").submit();
	   blockPage();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_news_title");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        //$.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate title exists.</div>')
                      .insertAfter("#txt_news_title");
                      
                  }
                  else
                  {
                     // $('<div id="err_msg" class="star_succ1">You can choose this year.</div>')
                    //  .insertAfter("#txt_milestones_year");     
                      $("#frm_add_edit").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_add_edit").submit();  
    }
    

}
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_news_title").val())=="") 
    {
        s_err +='Please provide news title.<br />';
        b_valid=false;
    }
	if((text = tinyMCE.get('txt_news_description').getContent())=='') 
    {
        s_err +='Please provide description .<br />';
        b_valid=false;
    }
    
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    
    
})});    
</script>    
 
<?php
  /////////end Javascript For List View//////////  
  /****
<div class="success_massage"><span>SUCCESS!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="error_massage"><span>ERROR!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="warning_massage"><span>Warning!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="info_massage"><span>Information!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
  */
  
  
?> 

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Confirm" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr>        
		<tr>
          <td>Title *:</td>
          <td><input id="txt_news_title" name="txt_news_title" value="<?php echo $posted["txt_news_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Description *:</td>
          <td>
          <textarea name="txt_news_description" id="txt_news_description" cols="46" rows="4"><?php echo $posted["txt_news_description"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
		
       <?php /*?> <tr>
          <td>Active:</td>
          <td><input id="i_news_is_active" name="i_news_is_active" value="1" <?php if($posted["i_news_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
          <td>&nbsp;</td>
        </tr><?php */?>
      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Confirm" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>