<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 21 June 2013
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin country Edit
* @package General
* @subpackage country
* @link InfController.php 
* @link My_Controller.php 
* @link views/admin/country/
*/
?>
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
    var $this = $("#txt_user_type");
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
					  markAsError($("#txt_user_type"),'Duplicate user type name exists');                      
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
	
	
	if($.trim($("#txt_user_type").val())=="") 
    {
		markAsError($("#txt_user_type"),'Please provide user type name');
        b_valid=false;
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
	$(selector).parents('.form-group').addClass("error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.text-danger').html('');	
	$(selector).parents('.form-group').removeClass("error");
} 
  
</script>
<div class="container-fluid">
	<div class="row">
    
    <div class="col-md-10 col-md-offset-1">
            <div class="box-header">
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->					
						
						<?php //show_all_messages(); ?>
					
					
						<form class="form-horizontal" id="frm_add_edit" name="frm_add_edit" action="" method="post">
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						 <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                      <label ><?php echo addslashes(t("User Type"))?><span class="text-danger">*</span> </label>
                                       <input class="form-control" id="txt_user_type" name="txt_user_type" value="<?php echo $posted["txt_user_type"];?>" type="text" >
                                        
                                        <span class="text-danger"></span>
                                   </div>
						   		</div>		
                                <div class="col-md-5 col-md-offset-1"></div> 			   
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