<?php
/*********
* Author: Saikat Das 
* Date  : 02 August 2013
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin Manage User Edit
* @package Users
* @subpackage Manage Users
* @link InfController.php 
* @link My_Controller.php
* @link views/web_master/manage_user/
*/
?>
<link rel="StyleSheet" href="<?php echo base_url();?>resource/admin/css/ui-lightness/jquery-ui-1.8.6.custom.css" type="text/css" media="all"/>
<script type="text/javascript" src="<?php echo base_url();?>resource/admin/js/jquery.autoGrowInput.js"></script>
<script type="text/javascript" src=  "<?php echo base_url();?>resource/admin/js/add_more.js"></script>
<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>"; //controller Path

  var mod="<?php echo $mode;?>";
	 
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller; 
});   


$('#btn_save').click(function(){
   
   if(mod== 'add')
   {
   		 check_duplicate();
		 $("#frm_add_edit").submit(); // added on 19 dec 2013
   }
   else if(mod== 'edit')
   {
   		$("#frm_add_edit").submit();
   }
  
}); 

//////////Checking Duplicate/////////
function check_duplicate(){ //loose codeing//
    
	$("#s_email").next().remove("#err_msg");
	$("#s_user_name").next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	

	if($("#s_email").val()!="")
    {
        //$.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$("#s_email").val()
                },
				
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
					  markAsError($("#s_email"),'<?php echo addslashes(t("This email already exists"))?>');                      
                  }
				  else if($("#s_user_name").val()!="")
				  {
			        $.post(g_controller+"ajax_checkduplicate_username",
			               {"h_id":$("#h_id").val(),
			                "h_duplicate_value":$("#s_user_name").val()
			                },
							
				                function(data)
				                {
				                  if(data!="valid")////invalid 
				                  {
									  markAsError($("#s_user_name"),'<?php echo addslashes(t("This User name already exists"))?>');                      
				                  }
					             else
								 {
								 	$("#frm_add_edit").submit();
								 }    
				               
							});
					}
				  
			});
				
	}
   	else
	{
		$("#frm_add_edit").submit();
	}


}
//////////end Checking Duplicate///////// 

$("#s_password").keypress(function(evt){
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
    $("#div_err").hide("slow"); 
	var password = $.trim($("#s_password").val());
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
	var mobileReg = /^\d{12}$/;		
	var mobileNumber = $.trim($("#s_contact_number").val());
	var IDReg = /^\d{10}$/;	
	
	if($.trim($("#s_first_name").val())=="") 
    {
		markAsError($("#s_first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
        b_valid=false;
    }
	if($.trim($("#s_last_name").val())=="") 
    {
		markAsError($("#s_last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
        b_valid=false;
    }
	if($.trim($("#s_email").val())=="") 
    {
		markAsError($("#s_email"),'<?php echo addslashes(t("Please provide email"))?>');
        b_valid=false;
    }
	else if(emailPattern.test($.trim($("#s_email").val()))==false)
	{
		markAsError($("#s_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
        b_valid=false;
	}
	else if($.trim($("#s_email").val())!="")
	{
		var e_test = emailValidation($.trim($("#s_email").val()));
		if(!e_test)
		{
			markAsError($("#s_email"),'<?php echo addslashes(t("Email must belong to dream wedding@dream wedding.edu.sa format"))?>');
        	b_valid=false;
		}
		
	}
	
	if(mod=="add")
	{
		if($.trim($("#s_user_name").val())=="") 
	    {
			markAsError($("#s_user_name"),'<?php echo addslashes(t("Please provide user name"))?>');
	        b_valid=false;
	    }
		
		if($.trim($("#s_password").val())=="")
		{
			markAsError($("#s_password"),'<?php echo addslashes(t("Please provide password"))?>');
	        b_valid=false;
		}
		else if($.trim($("#s_password").val())!="")
		{
			var p_test = passwordValidation(password);
			if(!p_test)
			{
				<?php /*?>markAsError($("#s_password"),'<?php echo addslashes(t("Password size should be 6 to 12 and <br> must contain capital letter and number"))?>');<?php */?>
				markAsError($("#s_password"),'<?php echo addslashes(t("Password size should be 6 to 12 characters."))?>');
	        	b_valid=false;
			}
		}
	}
	
	
	if(mobileNumber!="")
	{
		if(mobileReg.test(mobileNumber)==false)
		{
			markAsError($("#s_contact_number"),'<?php echo addslashes(t("Please provide a 12 digit mobile number in numeric."))?>');
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

 function emailValidation(email)
 {

  var arr_email = email.split('@');  
  if(arr_email[1]!="dream wedding.edu.sa")
  	return false;
  else	
  	return true;
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


var markAsError	=	function(selector,msg){
	$(selector).next('.help-inline').html(msg);	
	$(selector).parents('.control-group').addClass("error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.help-inline').html('');	
	$(selector).parents('.control-group').removeClass("error");
} 
  
</script>

<div id="content" class="span10">
			<!-- content starts -->
		
			<?php echo admin_breadcrumb($BREADCRUMB); ?>
			<?php if(validation_errors()){ ?>
			<div id="err" class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php echo validation_errors(); ?>				
			</div>
			<?php } ?>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo addslashes(t('User Management'));?></h2>
						<div class="box-icon">
							<?php /*?><a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a><?php */?>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
                    
                    <div class="box-content">					
						
						<?php show_all_messages(); ?>
						
			
					<form class="form-horizontal" id="frm_add_edit" name="frm_add_edit" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
						  <fieldset>
							
							<div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('First Name *'));?></label>
								<div class="controls">
								  <input type="text" class="focused" id="s_first_name" name="s_first_name" value="<?php echo $post[0]["s_first_name"];?>" />
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
							 <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Last Name *'));?></label>
								<div class="controls">
								  <input class="focused" id="s_last_name" name="s_last_name" value="<?php echo $post[0]["s_last_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>	
							
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('User Name *'));?></label>
								<div class="controls">
								  <input class="focused" id="s_user_name" name="s_user_name" type="text" value="<?php echo $post[0]["s_user_name"];?>" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                          <?php if($mode=="add"){ ?>
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Password *'));?></label>
								<div class="controls">
								  <input class="focused"  id="s_password" name="s_password"  type="password" value="<?php if($post[0]["s_password"]!=""){ echo '"'.$post[0]["s_password"].'"'."readonly=readonly"; } ?>" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>	
                            <?php } ?>
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Email *'));?></label>
								<div class="controls">
								  <input class="focused" id="s_email" name="s_email" value="<?php echo $post[0]["s_email"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Address'));?></label>
								<div class="controls">
								  <input class="focused" id="s_address" name="s_address" value="<?php echo $post[0]["s_address"];?>" type="text">
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                           
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Contact Number *'));?></label>
								<div class="controls">
								  <input class="focused" id="s_contact_number" name="s_contact_number" value="<?php echo $post[0]["s_contact_number"];?>" type="text">
								  <span class="help-inline"></span> 	
                                </div>
							</div>
							
							 <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('User Type *'));?></label>
								<div class="controls">
								
								  <select id="i_user_type" data-placeholder="<?php echo addslashes(t('Select User Type'))?>" name="i_user_type" data-rel="chosen" style="width:220px;">
								   <option value=""></option>
									<?php echo makeOptionUserType($user_type,$post[0]["i_user_type"]);?>
								  </select>
								  <span class="help-inline"></span>  	
                                </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('User Status '));?></label>
								<div class="controls">
								  <select id="i_status" data-placeholder="<?php echo addslashes(t('Select User Status'))?>" name="i_status" data-rel="chosen" style="width:220px;">
								   <option value="1"><?php echo addslashes("Active"); ?></option>
								    <option value="0"><?php echo addslashes("InActive"); ?></option>
								   </select>
								  <span class="help-inline"></span>  	
                                </div>
							</div>
                            
                            <!-- ADD MORE STARTS -->
                            
                            
                            
      
      						<!-- ADD MORE END -->
                            
                            		
							<div class="form-actions">
                            	
                               
							  <button type="button" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo addslashes(t('Save changes'));?></button>
							  <button type="button" id="btn_cancel" name="btn_cancel" class="btn"><?php echo addslashes(t('Cancel'));?></button>
							</div>
						  </fieldset>
						</form>   

					</div>
					
				</div><!--/span-->

			</div><!--/row-->		

<!-- content ends -->
</div>