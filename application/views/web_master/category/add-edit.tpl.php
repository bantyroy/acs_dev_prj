<?php 

/***

File Name: category add-edit.tpl.php 
Created By: ACS Dev 
Created On: August 08, 2014 
Purpose: CURD for Category 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/admin/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type"text/javascript">
$(document).ready(function(){
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
        
		if($("#s_category").val()=='')
		{
			markAsError($("#s_category"),'<?php echo addslashes(t("Please provide category"))?>');
			b_valid = false;
		}
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
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
                <div class="row">
                
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Category"))?><span class="text-danger">*</span></label>
			<input class="form-control" rel="s_category" id="s_category" name="s_category" value="<?php echo $posted["s_category"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Category Description"))?><span class="text-danger"></span></label>
			<textarea name="s_category_description" id="s_category_description" rel="s_category_description" class="form-control"><?php echo $posted["s_category_description"]?></textarea><span class="text-danger"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Upload Image"))?><span class="text-danger"></span></label>
			%s<input id="s_image" name="s_image" type="file" /><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Date"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="s_date" id="s_date" name="s_date" value="<?php echo $posted["s_date"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
                </div>
                
                <div class="form-group">
                    <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
                    <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>">
                </div>
            </form>
        </div>
    </div><!--/row-->
</div><!-- content ends -->
