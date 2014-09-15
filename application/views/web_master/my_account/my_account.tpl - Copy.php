<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 10 Dec 2012
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin My account Edit
* @package General
* @subpackage My account
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/my_account/
*/
?>

<script language="javascript">
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
   }); 
});    

   
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

   
	if($.trim($("#txt_user_name").val())=="") 
    {
        s_err +='Please provide Username.<br />';
        b_valid=false;
    }
	
	if($.trim($("#txt_password").val())=="" && $.trim($("#txt_new_password").val())!="")
	{
		s_err +='Please provide Old Password.';
		b_valid=false;
	}
	else
	{
		if(($.trim($("#txt_new_password").val())!="" || $.trim($("#txt_confirm_password").val())!="") && ($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val())))
		{
			s_err +='New Password and Confirm Password did not match.<br />';
			b_valid=false;
		}
		/*if($.trim($("#txt_new_password").val())!= '' && $.trim($("#txt_password").val())=="")
		{
			s_err +='New Password and Confirm Password did not match.';
			b_valid=false;
		}*/
	}	
	
    
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    
    
})});    
</script>
<div id="right_panel">
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here you can set your username and other personal settings.</div>
	<div class="clr"></div>
    <div id="accountlist">
    	<h2>My Account</h2>
		
        
        <form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>
        <div id="div_err">
            <?php
              show_msg();  
            ?>
        </div>     
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div id="myaccount">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">       
        
        <tr>
          <td>Username <span class="red_txt">**</span>:</td>
          <td><input id="txt_user_name" name="txt_user_name" value="<?php echo $posted["txt_user_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>        
        
        <tr>
          <td colspan="2">
          <strong>Change your password:</strong>
          <br /><span style="font-size:10px">(To change your password you have to fill up the following three fields properly.)</span>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Old Password <span class="red_txt">**</span>:</td>
          <td><input id="txt_password" name="txt_password" value="" type="password" size="40" autocomplete="off" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>New Password <span class="red_txt">**</span>:</td>
          <td><input id="txt_new_password" name="txt_new_password" value="" type="password" size="40" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Confirm Password <span class="red_txt">**</span>:</td>
          <td><input id="txt_confirm_password" name="txt_confirm_password" value="" type="password" size="40" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save content." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving content and return to previous page."/>
    </div>
    
</form>
        
    </div>  
  </div>
