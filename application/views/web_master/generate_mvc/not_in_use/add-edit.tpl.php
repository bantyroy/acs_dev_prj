<?php
/*********
* Author: Acumen CS
* Date  : 27 Feb 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Customer Add & Edit
* @package General
* @subpackage admin_user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_admin_user/
*/
?>
<script src="<?php echo base_url()?>resource/admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script language="javascript">

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$(document).ready(function(){

CKEDITOR.replace('s_details');

$('#dt_posted_date').datepicker({
	dateFormat : 'yy-mm-dd',
});
    
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller+'show_list/'+'<?php echo $this->session->userdata('last_uri');?>';
});  

$('.btn-close').click(function(i){
	 window.location.href=g_controller; 
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
	if($("#s_title").val()=="") 
    {
		markAsError($("#s_title"),'<?php echo addslashes(t("Please provide title"))?>');
        b_valid=false;
    }
	/*if($("#s_details").val()==""  || $("#s_details").val()=="<br>") 
    {
		markAsError($("#cke_s_details"),'<?php echo addslashes(t("Please provide description"))?>');
        b_valid=false;
    }*/
		
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
		$(selector).parents('.control-group').addClass("error");
		
		$(selector).on('focus',function(){
			removeAsError($(this));
		});
	}
	
	var removeAsError	=	function(selector){
		$(selector).next('.text-danger').html('');	
		$(selector).parents('.control-group').removeClass("error");
	}	
	
	$("#opt_state").chosen().change(function(){
	
     var state_id =   $(this).val();  
	    
     $.ajax({
                type: "POST",
                url: g_controller+'ajax_change_city_option',
                data: "state_id="+state_id,
                success: function(msg){
                   if(msg!='')
                   {
				   		$("#opt_city").html(msg);
						$("#opt_city").trigger("liszt:updated");
                   }   
                }
            });
	  }) ;
	  
	$("#opt_city").chosen().change(function(){
	
	 var state_id	= $("#opt_state option:selected").val()
     var city_id 	= $(this).val();  
	    
     $.ajax({
                type: "POST",
                url: g_controller+'ajax_change_zipcode_option',
                data: "city_id="+city_id+"&state_id="+state_id,
                success: function(msg){
                   if(msg!='')
                   {
				   		$("#opt_zipcode").html(msg);
						$("#opt_zipcode").trigger("liszt:updated");
                   }   
                }
            });
	  });
	  
	  
	
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
					
					
				<form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off"  enctype="multipart/form-data">
                    <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                    <input name="my_selected" id="my_selected" value="" type="hidden" />
                            
                    <div class="row">
								<div class="col-md-5">
	   							<div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("News Title"))?> <span class="text-danger">*</span></label>
                                             <input class="form-control" id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" />
                                            <span class="text-danger"></span>
                           		</div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-2">
                                   <div class="form-group">
                                   <label for="focusedInput"><?php echo addslashes(t("Place"))?></label>
                                   <input class="form-control" id="s_place" name="s_place" value="<?php echo $posted["s_place"];?>" type="text" />
                                   <span class="text-danger"></span>
                                   </div>
                           
                           	</div>					   
						   						   
						</div>
                        <div class="form-group">
                        <label for="focusedInput"><?php echo addslashes(t("Description"))?> <span class="text-danger">*</span></label>
                                           
                         <textarea name="s_details" id="s_details" rows="3" ><?php echo $posted["s_details"];?></textarea>
							<span class="text-danger"></span> 
                        </div>
                            
                       <div class="row">
						<div class="col-md-5">
	   						<div class="form-group">
                                  <label for="focusedInput"><?php echo addslashes(t("Image"))?> </label>
                                   <?php  
								  		if(!empty($posted["s_image"]))
										{
											echo '<img src="'.$thumbDir.'thumb_'.$posted["s_image"].'" width="50" height="50"  border="0"/><br><br>';
											echo ' <input type="hidden" name="h_profile_photo" id="h_profile_photo" value="'.$posted["s_image"].'" />';
										}
									
									?>
                                     <input type="file" name="s_image" id="s_image">
                                    <span class="text-danger"></span>
                           		</div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-2">
                                   <div class="form-group">
                                   <label for="focusedInput"><?php echo addslashes(t("News Date"))?> </label>
                                   <input class="form-control" id="dt_posted_date" name="dt_posted_date" value="<?php echo $posted["dt_posted_date"];?>" type="text" />
                                   <span class="text-danger"></span>
                                   </div>
                           
                           	</div>					   
						   						   
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