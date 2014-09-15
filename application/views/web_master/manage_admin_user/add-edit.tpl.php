<?php
/*********
* Author: Jagabor
* Date  : 06 Jan 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin user Add & Edit
* @package General
* @subpackage admin_user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_admin_user/
*/
?>

<script language="javascript">
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
    
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller+'show_list/'+'<?php echo $this->session->userdata('last_uri');?>'; 
});   


$('#btn_save').click(function(){
   //check_duplicate();
   $("#frm_add_edit").submit();
}); 

    
//Submitting the form//
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#txt_first_name").val()=="") 
    {
		markAsError($("#txt_first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
        b_valid=false;
    }
	if($("#txt_last_name").val()=="") 
    {
		markAsError($("#txt_last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
        b_valid=false;
    }
	if($("#txt_email").val()=="") 
    {
		markAsError($("#txt_email"),'<?php echo addslashes(t("Please provide email"))?>');
        b_valid=false;
    }else if(reg.test($.trim($("#txt_email").val())) == false){
		markAsError($("#txt_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
        b_valid=false;
	}
	if($("#txt_user_name").val()=="") 
    {
		markAsError($("#txt_user_name"),'<?php echo addslashes(t("Please provide username"))?>');
        b_valid=false;
    }
	if($("#txt_password").val()=="") 
    {
		markAsError($("#txt_password"),'<?php echo addslashes(t("Please provide password"))?>');
        b_valid = false;
    }
	else if ($("#txt_password").val() != $("#txt_con_password").val())
	{
		markAsError($("#txt_con_password"),'<?php echo addslashes(t("Password and confirm password must be same"))?>');
        b_valid = false;
	}
	
    //validating//
    if(!b_valid)
    {        
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
//end Submitting the form//  	


	/*$('#txt_like_keyword, #txt_dislike_keyword').on("keyup", function(e) {
		this.value = this.value.replace(/[^a-zA-Z\,]/g, '');
	});*/

    


	var markAsError	=	function(selector,msg){
		$(selector).next('.text-danger').html(msg);	
		$(selector).parents('.form-group').addClass("error");
		
		$(selector).on('focus',function(){
			removeAsError($(this));
		});
	}
	
	var removeAsError	=	function(selector){
		$(selector).next('.text-danger').html('');	
		$(selector).parents('.form-group').removeClass("error");
	} 
}); 
  
</script>
<div class="container-fluid">
	<div class="row">
    
    <div class="col-md-10 col-md-offset-1">
            <div class="box-header">
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->				
				<?php show_all_messages(); echo validation_errors();?>
                
					<form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off">
                       <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						<input name="my_selected" id="my_selected" value="" type="hidden" />
                        	
                            <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                      <label ><?php echo addslashes(t("User Type"))?><span class="text-danger">*</span> </label>
                                        <select class="form-control" name="opt_user_type" id="opt_user_type" >
                                  			<?php echo makeOption($user_type, encrypt($posted['i_user_type']))?>
                                  		</select>
                                        
                                        <span class="text-danger"></span>
                                   </div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-1"></div> 			   
							</div>
                            
                        
                           <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                      <label ><?php echo addslashes(t("First Name"))?><span class="text-danger">*</span> </label>
                                        <input class="form-control" id="txt_first_name" name="txt_first_name" value="<?php echo $posted["s_first_name"];?>" type="text" />
                                        
                                        <span class="text-danger"></span>
                                   </div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-2">
                                   <div class="form-group">
                                   <label ><?php echo addslashes(t("Last Name"))?><span class="text-danger">*</span> </label>
                                      <input class="form-control" id="txt_last_name" name="txt_last_name" value="<?php echo $posted["s_last_name"];?>" type="text" />
                                   <span class="text-danger"></span>
                                </div>                           
                           	</div> 			   
						</div>
                        <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                      <label ><?php echo addslashes(t("Email"))?><span class="text-danger">*</span> </label>
                                       <input class="form-control" id="txt_email" name="txt_email" value="<?php echo $posted["s_email"];?>" type="text" />
                                        
                                        <span class="text-danger"></span>
                                   </div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-2">
                                   <div class="form-group">
                                   <label ><?php echo addslashes(t("User Name"))?><span class="text-danger">*</span> </label>
                                       <input class="form-control" id="txt_user_name" name="txt_user_name" value="<?php echo $posted["s_user_name"];?>" type="text" />
                                   <span class="text-danger"></span>
                                </div>                           
                           	</div> 			   
						</div>
                        <?php if($mode == 'add'){?>
                        <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                      <label ><?php echo addslashes(t("Password"))?><span class="text-danger">*</span> </label>
                                       <input class="form-control" id="txt_password" name="txt_password" value="" type="password" />
                                        
                                        <span class="text-danger"></span>
                                   </div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-2">
                                   <div class="form-group">
                                   <label ><?php echo addslashes(t("Confirm Password"))?> <span class="text-danger">*</span> </label>
                                      <input class="form-control" id="txt_con_password" name="txt_con_password" value="" type="password" />
                                   <span class="text-danger"></span>
                                </div>                           
                           	</div>   
						   						   
						</div> 
                     	<?php }?>   
                           
                            
                            
							<div class="form-group">
                         <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">                                   
                          <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>" >
                        </div>
						
						</form>   

					</div>
			</div><!--/row-->		

<!-- content ends -->
</div>