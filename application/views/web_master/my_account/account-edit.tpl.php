<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 28 June 2013
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin Manage User Edit
* @package Users
* @subpackage Manage Users
* @link InfController.php 
* @link My_Controller.php
* @link views/corporate/manage_user/


*/

pr($posted,1);
?>
<script type="text/javascript" src=  "<?php echo base_url();?>resource/admin/js/add_more.js"></script>
<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
    
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller; 
});   


$('#btn_save').click(function(){
   check_duplicate();
   //$("#frm_add_edit").submit();
}); 

//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#email");
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
					  markAsError($("#email"),'<?php echo addslashes(t("This email already exists"))?>');                      
                  }
                  else
                  { 
                      $("#frm_add_edit").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_add_edit").submit();  
    }
    

}
//////////end Checking Duplicate///////// 
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	var password = $.trim($("#password").val());
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
	var mobileReg = /^\d{12}$/;		
	var IDReg = /^\d{10}$/;	
	var mobileNumber = $.trim($("#mobile_number").val());
	
	if($.trim($("#first_name").val())=="") 
    {
		markAsError($("#first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
        b_valid=false;
    }
	if($.trim($("#last_name").val())=="") 
    {
		markAsError($("#last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
        b_valid=false;
    }
	if($.trim($("#email").val())=="") 
    {
		markAsError($("#email"),'<?php echo addslashes(t("Please provide email"))?>');
        b_valid=false;
    }
	else if(emailPattern.test($.trim($("#email").val()))==false)
	{
		markAsError($("#email"),'<?php echo addslashes(t("Please provide valid email"))?>');
        b_valid=false;
	}
	if($.trim($("#i_role").val())=="") 
    {
		markAsError($("#i_role"),'<?php echo addslashes(t("Please select user type"))?>');
        b_valid=false;
    }
	if($.trim($("#id_number").val())=="") 
    {
		markAsError($("#id_number"),'<?php echo addslashes(t("Please provide id number"))?>');
        b_valid=false;
    }
	else if(IDReg.test($.trim($("#id_number").val()))==false)
	{
		markAsError($("#id_number"),'<?php echo addslashes(t("Please provide ten digits id number"))?>');
        b_valid=false;
	}
	if(password!="")
	{
		var p_test = passwordValidation(password);
		if(!p_test)
		{
			markAsError($("#password"),'<?php echo addslashes(t("Password should be proper"))?>');
        	b_valid=false;
		}
	}
	if(mobileNumber!="")
	{
		if(mobileReg.test(mobileNumber)==false)
		{
			markAsError($("#mobile_number"),'<?php echo addslashes(t("Please provide mobile number in numeric."))?>');
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

function passwordValidation(pass)
 {
  if(pass.length <6 || pass.length >12) return false;
  if(/[0-9]{1,}/.test(pass) == false)  return false;
  if(/[A-Z]{1,}/.test(pass) == false)  return false;
  if(/[!@#$*]{1,}/.test(pass) == false)  return false;
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
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo addslashes(t('Account Management'));?></h2>
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
						  <fieldset>
							
							<div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('First Name'));?></label>
								<div class="controls">
								  <input class="focused" id="first_name" name="first_name" value="<?php echo $posted["s_first_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Last Name'));?></label>
								<div class="controls">
								  <input class="focused" id="last_name" name="last_name" value="<?php echo $posted["s_last_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>	
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Email'));?></label>
								<div class="controls">
								  <input class="focused" id="email" name="email" value="<?php echo $posted["s_email"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                  			 <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Mobile Number'));?></label>
								<div class="controls">
								  <input class="focused" id="mobile_number" name="mobile_number" value="<?php echo $posted["s_contact_number"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                          
      
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