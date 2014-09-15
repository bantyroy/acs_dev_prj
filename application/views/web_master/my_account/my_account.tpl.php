<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 18 June 2013
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

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 

$('#btn_save').click(function(){
	$("#frm_add_edit").submit();
});

$('#btn_cancel').click(function(){
	 window.location.href=g_controller; 
	 //alert(1);
}); 

$("#txt_new_password").keypress(function(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if(charCode==32)
		return false;
	else
		return true;
	
});
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	
    $("#div_err").hide("slow"); 
	
	
	if($.trim($("#txt_user_name").val())=="") 
    {
		markAsError($("#txt_user_name"),'<?php echo addslashes(t("Please provide user name"))?>');
        b_valid=false;
    }
	
	if($.trim($("#txt_password").val())=="" && $.trim($("#txt_new_password").val())!="")
	{
		markAsError($("#txt_password"),'<?php echo addslashes(t("Please provide old Password"))?>');
        b_valid=false;
	}
	else
	{
	
		if(($.trim($("#txt_new_password").val())!="" || $.trim($("#txt_confirm_password").val())!="") && ($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val())))
		{	
			markAsError($("#txt_confirm_password"),'<?php echo addslashes(t("New Password and Confirm Password did not match"))?>');
        	b_valid=false;
		}
		if($.trim($("#txt_new_password").val())!="")
		{
			var p_test = passwordValidation($.trim($("#txt_new_password").val()));
			if(!p_test)
			{
				markAsError($("#txt_new_password"),'<?php echo addslashes(t("Password size should be 6 to 12 characters."))?>');
	        	b_valid=false;
			}
		}		
	}
	
	if($("#s_email").val()!="") 
    {
		if(reg.test($.trim($("#s_email").val())) == false)
		{
			markAsError($("#s_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
			b_valid=false;
		}
	}	
   
    /////////validating//////
    if(!b_valid)
    {        
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////  
    
}); 

var markAsError	=	function(selector,msg){
	$(selector).next('.text-danger').html(msg);	
	$(selector).parents('.form-group').addClass("has-error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.text-danger').html('');	
	$(selector).parents('.form-group').removeClass("has-error");
} 

function passwordValidation(pass)
 {
  if(pass.length <6 || pass.length >12) return false;
  /*
  if(/[0-9]{1,}/.test(pass) == false)  return false;
  if(/[A-Z]{1,}/.test(pass) == false)  return false;
  */
 
  return true;
 }
 
 function select_avatar(obj)
 {
 	var img	= obj.attr('src');
	
	$('#selected_avatar').html('<img src="'+img+'"/>');
	$('#s_avatar').val(obj.attr('alt'));
 }
  
</script>
<div class="container-fluid">
<div class="row">
<div class="col-md-8 col-md-offset-2">
                   
			<?php show_all_messages(); ?>
                    
              <form role="form" class="" id="frm_add_edit" name="frm_add_edit" action="" method="post">
                    <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                          <div class="row">
						  <div class="col-md-5">
                          <div class="form-group">
                                <label for="exampleInputEmail1" ><?php echo addslashes(t("Username"))?></label>
                                
                                <input type="email" class="form-control" name="txt_user_name" id="txt_user_name" placeholder="User Name" value="<?php echo $posted["txt_user_name"];?>">
                                <span class="text-danger"></span>
                                
                             </div>
										 
                         <div class="form-group">
                                            <label for="exampleInputPassword1" ><?php echo addslashes(t("Old Password"))?></label>
                                          
										    <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" value="<?php echo $posted["txt_password"];?>">
                                        
                                        </div>
                                        
                             <div class="form-group">
                                    <label><?php echo addslashes(t("Email"))?></label>                                    
                                    <input type="email" class="form-control" name="s_email" id="s_email" placeholder="Email" value="<?php echo $posted["s_email"];?>">
                                    <span class="text-danger"></span>
                                    
                              </div>
                              
                              <div class="form-group">
                                <label ><?php echo addslashes(t("Instant Messanger"))?></label>
                                    <input type="text" class="form-control" id="s_chat_im" name="s_chat_im" placeholder="Contact Number" value="<?php echo $posted["s_chat_im"];?>">                                            
                              </div>
						</div>
					
					
					 <div class="col-md-5 col-md-offset-2">					
                         <div class="form-group">
                                <label for="exampleInputFile"><?php echo addslashes(t("New Password"))?></label>
                               
                                <input type="password" class="form-control" id="txt_new_password" name="txt_new_password" placeholder="New Password" value="<?php echo $posted["txt_password"];?>">
										
                           	</div>
                         	<div class="form-group" >
                                <label ><?php echo addslashes(t("Confirm Password"))?></label>
                             
                                <input type="password" class="form-control" id="txt_confirm_password" name="txt_confirm_password" placeholder="New Password" value="<?php echo $posted["txt_password"];?>">
									
                           </div>
                                        
                            <div class="form-group">
                                <label ><?php echo addslashes(t("Contact Number"))?></label>
                                    <input type="text" class="form-control" id="s_contact_number" name="s_contact_number" placeholder="Contact Number" value="<?php echo $posted["s_contact_number"];?>">                                            
                              </div>
						</div>
                               				
                    </div>
                    
                    <div class="row">
                    <div class="col-md-5">
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo addslashes(t("Select Avatar"))?></label><div class="clearfix"></div>                           
                                <img src="<?php echo base_url();?>resource/admin/img/avatar.png" alt="avatar.png" width="80" height="80" onclick="select_avatar($(this));" class="img-thumbnail" />
                                <img src="<?php echo base_url();?>resource/admin/img/avatar2.png" alt="avatar2.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo base_url();?>resource/admin/img/avatar3.png" alt="avatar3.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo base_url();?>resource/admin/img/avatar04.png" alt="avatar04.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo base_url();?>resource/admin/img/avatar5.png" alt="avatar5.png"  width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail" />
						</div>				
                     </div>
                                                     
                                <div id="selected_avatar" class="col-md-5 text-center col-md-offset-2">
                                	<?php
										if(!empty($posted["s_avatar"]))
										{
									?>
                                    		<img class="img-thumbnail" src="<?php echo base_url()?>resource/admin/img/<?php echo $posted["s_avatar"];?>" />
                                    <?php
										}
									?>
                                </div>
								<input type="hidden" name="s_avatar" id="s_avatar" value="<?php echo $posted["s_avatar"];?>" />
                       </div>  	
					
                	

                          <div class="form-group">
            
                            <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
                           
                            <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>" >
                    
                        	</div>
                                </form>
                    </div>
                </div>
            </div>
