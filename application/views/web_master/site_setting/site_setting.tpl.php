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
    
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller; 
});   

$('.btn-close').click(function(i){
	 window.location.href=g_controller; 
});

$('#btn_save').click(function(){
   //check_duplicate();
   $("#frm_add_edit").submit();
});
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	var noReg = /^\d+$/;
	var records = $.trim($("#i_records_per_page").val());
	
	var reg_website = /^http?:\/\/(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
	
	if($.trim($("#txt_admin_email").val())=="") 
    {
		markAsError($("#txt_admin_email"),'<?php echo addslashes(t("Please provide email"))?>');
        b_valid=false;
    }  
	if(records=="")
	{
		markAsError($("#i_records_per_page"),'<?php echo addslashes(t("Please provide number of records per page"))?>');
        b_valid=false;
	}
	else
	{
		if(noReg.test(records)==false)
		{
			markAsError($("#i_records_per_page"),'<?php echo addslashes(t("Please provide numeric value."))?>');
        	b_valid=false;
		}
	} 
	
	if($("#s_facebook_url").val()!="") 
    {
		if(reg_website.test($.trim($("#s_facebook_url").val())) == false)
		{
			markAsError($("#s_facebook_url"),'<?php echo addslashes(t("Please provide a valid url with http://"))?>');
			b_valid=false;
		}
	}
	
	if($("#s_g_plus_url").val()!="") 
    {
		if(reg_website.test($.trim($("#s_g_plus_url").val())) == false)
		{
			markAsError($("#s_g_plus_url"),'<?php echo addslashes(t("Please provide a valid url with http://"))?>');
			b_valid=false;
		}
	}
	
	if($("#s_linked_in_url").val()!="") 
    {
		if(reg_website.test($.trim($("#s_linked_in_url").val())) == false)
		{
			markAsError($("#s_linked_in_url"),'<?php echo addslashes(t("Please provide a valid url with http://"))?>');
			b_valid=false;
		}
	}
	
	if($("#s_twitter_url").val()!="") 
    {
		if(reg_website.test($.trim($("#s_twitter_url").val())) == false)
		{
			markAsError($("#s_twitter_url"),'<?php echo addslashes(t("Please provide a valid url with http://"))?>');
			b_valid=false;
		}
	}
	
	if($("#s_rss_feed_url").val()!="") 
    {
		if(reg_website.test($.trim($("#s_rss_feed_url").val())) == false)
		{
			markAsError($("#s_rss_feed_url"),'<?php echo addslashes(t("Please provide a valid url with http://"))?>');
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
	$(selector).parents('.control-group').addClass("error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.text-danger').html('');	
	$(selector).parents('.control-group').removeClass("error");
} 
  
</script>

<div class="container-fluid">
 <div class="row">
			
                 <div class="col-md-8 col-md-offset-2">
				               <?php show_all_messages(); ?>
                                
                                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" >
                                <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                                <div class="row">
								<div class="col-md-5">
								
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" ><?php echo addslashes(t("Email"))?></label>
                                            <input type="email" class="form-control" name="txt_admin_email" id="txt_admin_email" placeholder="Email" value="<?php echo $posted["txt_admin_email"];?>">
                                            <span class="text-danger"></span>
                                         </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo addslashes(t("Records per page"))?></label>
                                            <input type="text" class="form-control" id="i_records_per_page" name="i_records_per_page" placeholder="Records Per Page" value="<?php echo $posted["i_records_per_page"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile"><?php echo addslashes(t("Slider Banner Speed"))?></label>
                                            <input type="text" class="form-control" id="i_banner_speed" name="i_banner_speed" placeholder="Slider Banner Speed" value="<?php echo $posted["i_banner_speed"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile"><?php echo addslashes(t("Featured Project Slider Speed"))?></label>
                                            <input type="text" class="form-control" id="i_featured_slider_speed" name="i_featured_slider_speed" placeholder="Featured Project Slider Speed" value="<?php echo $posted["i_featured_slider_speed"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Facebook Url"))?></label>
                                            <input type="text" class="form-control" id="s_facebook_url" name="s_facebook_url" placeholder="Facebook Url" value="<?php echo $posted["s_facebook_url"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Twitter Url"))?></label>
                                            <input type="text" class="form-control" id="s_twitter_url" name="s_twitter_url" placeholder="Twitter Url" value="<?php echo $posted["s_twitter_url"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Google Plus Url"))?></label>
                                            <input type="text" class="form-control" id="s_g_plus_url" name="s_g_plus_url" placeholder="Google Plus Url" value="<?php echo $posted["s_g_plus_url"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        
                                        
									</div>
                                        
										<div class="col-md-5 col-md-offset-2">
                                        
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Linked In Url"))?></label>
                                            <input type="text" class="form-control" id="s_linked_in_url" name="s_linked_in_url" placeholder="Linked In Url" value="<?php echo $posted["s_linked_in_url"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Rss Feed Url"))?></label>
                                            <input type="text" class="form-control" id="s_rss_feed_url" name="s_rss_feed_url" placeholder="Rss Feed Url" value="<?php echo $posted["s_rss_feed_url"];?>">
                                            <span class="text-danger"></span>
                                        </div>
                                        
                                        
                                        <div class="form-group"> 
                                        <label for="exampleInputFile"><?php echo addslashes(t("Home Page Banner Auto Slide"))?></label>
                                            <div class="radio">
                                                <label>
                                                	  <input  type="radio" <?php if($posted["i_auto_slide_control"]=="1") { ?>checked="" <?php } ?> value="1" id="on" name="i_auto_slide_control" style="opacity: 0;">
                                                   <!-- <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>-->
                                                    <?php echo addslashes(t('On'));?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                 	<input  type="radio" <?php if($posted["i_auto_slide_control"]=="0") { ?>checked="" <?php } ?> value="0" id="off" name="i_auto_slide_control" style="opacity: 0;">
                                                     <?php echo addslashes(t('Off'));?>
                                                </label>
                                            </div>                                            
                                        </div>
                                        
                                        <div class="form-group"> 
                                        <label for="exampleInputFile"><?php echo addslashes(t("Featured Project Auto Slide"))?></label>
                                            <div class="radio">
                                                <label>
                                                	  <input  type="radio" <?php if($posted["i_featured_project_auto_slide_control"]=="1") { ?>checked="" <?php } ?> value="1" id="on" name="i_featured_project_auto_slide_control" style="opacity: 0;">
                                                   <!-- <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>-->
                                                    <?php echo addslashes(t('On'));?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                 	<input  type="radio" <?php if($posted["i_featured_project_auto_slide_control"]=="0") { ?>checked="" <?php } ?> value="0" id="off" name="i_featured_project_auto_slide_control" style="opacity: 0;">
                                                     <?php echo addslashes(t('Off'));?>
                                                </label>
                                            </div>                                            
                                        </div>
                                        
                                        <div class="form-group"> 
                                        <label for="exampleInputFile"><?php echo addslashes(t("Project posting approval"))?></label>
                                            <div class="radio">
                                                <label>
                                                	  <input  type="radio" <?php if($posted["i_project_posting_approval"]=="1") { ?>checked="" <?php } ?> value="1" id="on" name="i_project_posting_approval" style="opacity: 0;">
                                                   <!-- <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>-->
                                                    <?php echo addslashes(t('On'));?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                 	<input  type="radio" <?php if($posted["i_project_posting_approval"]=="0") { ?>checked="" <?php } ?> value="0" id="off" name="i_project_posting_approval" style="opacity: 0;">
                                                     <?php echo addslashes(t('Off'));?>
                                                </label>
                                            </div>                                            
                                        </div>
                                        
                                        
                                        </div>
										</div>
                                        
                                        
                        

                                    <div class="form-group">
                                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
								  </div>
                                </form>
				</div>
				</div>							
									

</div>




















