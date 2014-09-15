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
	var mobileReg = /^\d+$/;	
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
								  <input class="focused" id="first_name" name="first_name" value="<?php echo $posted["first_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Middle Name'));?></label>
								<div class="controls">
								  <input class="focused" id="middle_name" name="middle_name" value="<?php echo $posted["middle_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Last Name'));?></label>
								<div class="controls">
								  <input class="focused" id="last_name" name="last_name" value="<?php echo $posted["last_name"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>	
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Email'));?></label>
								<div class="controls">
								  <input class="focused" id="email" name="email" value="<?php echo $posted["email"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label"  for="selectError"><?php echo addslashes(t('User Type'))?></label>
								<div class="controls">
								  <select id="i_role" name="i_role" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionUserRole($posted['i_role']) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('ID Number'));?></label>
								<div class="controls">
								  <input class="focused" id="id_number" name="id_number" value="<?php echo $posted["id_number"];?>" type="text" maxlength="10">
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <?php if($mode=="add") { ?>
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Password'))?></label>
                                
								<div class="controls">
								  <input class="focused" id="password" name="password" value="<?php echo $posted["password"];?>" type="password" >
								  <span class="help-inline"></span> 
                                  <br/>[<?php echo addslashes(t('6 – 12 characters, atleast one Caps letter, 
one Special character [#,$@,*,!], numeric values'))?>]	
                                </div>
                                
							</div>
                            
                            <?php } ?>
                            
                            <div class="control-group">
								<label class="control-label"><?php echo addslashes(t('Profile Photo'));?></label>
								<div class="controls">
                                  <?php  
										if(!empty($posted["profile_photo"]))
										{
											echo '<img src="'.$thumbDir.'thumb_'.$posted["profile_photo"].'" width="50" height="50"  border="0"/><br><br>';
											echo ' <input type="hidden" name="h_profile_photo" id="h_profile_photo" value="'.$posted["profile_photo"].'" />';
										}
									
									?>	
								  <input type="file" name="profile_photo" id="profile_photo">
								</div>
							  </div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Gender'))?></label>
								<div class="controls">
								  <label class="radio">
									<div class="radio" id="uniform-optionsRadios1">
                                        <span <?php if($posted["gender"]=="male") { ?>class="checked" <?php } ?>>
                                        <input <?php if($mode=="add") { ?>checked="" <?php } ?> type="radio" <?php if($posted["gender"]=="male") { ?>checked="" <?php } ?> value="male" id="male" name="gender" style="opacity: 0;">
                                        </span>
                                    </div>
									<?php echo addslashes(t('Male'));?>
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<div class="radio" id="uniform-optionsRadios2">
                                        <span <?php if($posted["gender"]=="female") { ?>class="checked" <?php } ?>>
                                        <input  type="radio" <?php if($posted["gender"]=="female") { ?>checked="" <?php } ?> value="female" id="female" name="gender" style="opacity: 0;">
                                        </span>
                                    </div>
									<?php echo addslashes(t('Female'));?>
								  </label>
								</div>
							</div>
                            
                            <?php /*?><div class="control-group">
								<label class="control-label" for="focusedInput">Nationality</label>
								<div class="controls">
								  <input class="focused" id="nationality" name="nationality" value="<?php echo $posted["nationality"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div><?php */?>
                            
                            <div class="control-group">
								<label class="control-label"  for="selectError"><?php echo addslashes(t('Nationality'));?></label>
								<div class="controls">
								  <select id="nationality" name="nationality" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionNationality($posted['nationality']) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo addslashes(t('Mobile Number'));?></label>
								<div class="controls">
								  <input class="focused" id="mobile_number" name="mobile_number" value="<?php echo $posted["mobile_number"];?>" type="text" >
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label"  for="selectError"><?php echo addslashes(t('Manager'));?></label>
								<div class="controls">
								  <select id="manager_id" name="manager_id" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionUserManager($posted['manager_id'],decrypt($posted["h_id"])) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label"  for="selectError"><?php echo addslashes(t('Campus'));?></label>
								<div class="controls">
								  <select id="campus_id" name="campus_id" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionCampus($posted['campus_id']) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="selectError"><?php echo addslashes(t('Department'))?></label>
								<div class="controls">
								  <select id="department_id" name="department_id" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionDepartment($posted['department_id']) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="selectError"><?php echo addslashes(t('Position'));?></label>
								<div class="controls">
								  <select id="position_id" name="position_id" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionPosition($posted['position_id']) ?>
								  </select>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="selectError"><?php echo addslashes(t('Grade'))?></label>
								<div class="controls">
								  <select id="grade_id" name="grade_id" data-rel="chosen" style="width:220px;">
									<?php echo makeOptionGrade($posted['grade_id']) ?>
								  </select>
								</div>
							</div>
                            
                            <!-- ADD MORE STARTS -->
                            
                            <div style="clear:both;">
                            
                            	<div class="box-header well" data-original-title>
                                    <h2><i class="icon-edit"></i> <?php echo addslashes(t('User Courses'));?></h2>                                    
                                </div>
                                
                                <?php if(count($posted['certificate'])>0){
									
										$length = count($posted['certificate']);
									 }else {
										$length = 1;	 
									 }
								 ?>
                               
                                <div class="box-content">
                                
                                <?php for($j=0; $j<$length; $j++) {
									
								 ?>
                                
                                	<div id="add_more_pass_<?php echo $j ?>"  >
                                    <input type="button" class="add_more_remove" id="add_more_remove" rel="add_more_pass_" value="<?php echo addslashes(t('Delete'));?>" />
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Course Type'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_type_<?php echo $j ?>" name="course_type[]" type="text" value="<?php echo $posted['certificate'][$j]['course_type'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Course Name'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_name_<?php echo $j ?>" name="course_name[]" type="text" value="<?php echo $posted['certificate'][$j]['course_name'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Council/University/Institute'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_organisation_<?php echo $j ?>" name="course_organisation[]" type="text" value="<?php echo $posted['certificate'][$j]['course_organisation'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Year'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_year_<?php echo $j ?>" name="course_year[]" type="text" value="<?php echo $posted['certificate'][$j]['year'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Subject'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_subject_<?php echo $j ?>" name="course_subject[]" type="text" value="<?php echo $posted['certificate'][$j]['subject'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Marks Obtained'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_marks_<?php echo $j ?>" name="course_marks[]" type="text" value="<?php echo $posted['certificate'][$j]['marks_obtained'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Total Marks'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_total_marks_<?php echo $j ?>" name="course_total_marks[]" type="text" value="<?php echo $posted['certificate'][$j]['total_marks'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput"><?php echo addslashes(t('Grade'));?></label>
                                            <div class="controls">
                                              <input class="focused" id="course_grade_<?php echo $j ?>" name="course_grade[]" type="text" value="<?php echo $posted['certificate'][$j]['grade'] ?>">
                                              <span class="help-inline"></span> 	
                                            </div>
                                        </div>
                                        
                                    </div>
                                     
                                 <?php } ?>    
                                     <a href="javascript:void(0)"  onclick="addmore('add_more_pass_');" ><?php echo addslashes(t('add more'));?></a>

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