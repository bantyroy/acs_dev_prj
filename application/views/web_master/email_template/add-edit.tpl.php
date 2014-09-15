<?php
/*********
* Author: Acumen CS
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
<link href="<?php echo base_url()?>resource/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>resource/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script language="javascript">
$(document).ready(function(){

$(".textarea").wysihtml5();

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
	if($("#s_subject").val()=="") 
    {
		markAsError($("#s_subject"),'<?php echo addslashes(t("Please provide subject"))?>');
        b_valid=false;
    }
	if($("#s_body").val()=="") 
    {
		markAsError($("#s_body"),'<?php echo addslashes(t("Please provide body"))?>');
        b_valid=false;
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
}); 
  
</script>
<div class="container-fluid">
	<div class="row">
    
    <div class="col-md-10 col-md-offset-1">
        <div class="box-header">
            <h3 class="box-title"><?php echo $heading;?></h3>
        </div><!-- /.box-header -->
        <!-- form start -->			
 
			<?php show_all_messages();?>
					
					
						<form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off">
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						<input name="my_selected" id="my_selected" value="" type="hidden" />
                        
                        <div class="row">
								<div class="col-md-5">
	   							<div class="form-group">
                                     <label><?php echo addslashes(t("Subject"))?> <span class="text-danger">*</span></label>
                                     <input class="form-control" id="s_subject" name="s_subject" value="<?php echo $posted["s_subject"];?>" type="text" />
                                            <span class="text-danger"></span>
                           		</div>
						   		</div>						   
						   <div class="col-md-5 col-md-offset-2"></div>						   
						</div>
                        <div class="form-group">
                        <label for="focusedInput"><?php echo addslashes(t("Body"))?> <span class="text-danger">*</span></label>
                                                 
                         <textarea class="textarea" name="s_body" id="s_body" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $posted["s_body"];?></textarea>
								  <span class="text-danger"></span> 
                        </div>
                            
						<div class="form-group">
							 <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
                                       
							  <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>" >
						</div>
						  
						</form>   

					</div>
				
			</div><!--/row-->		

<!-- content ends -->
</div>