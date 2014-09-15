<?php 

/***

File Name: product add-edit.tpl.php 
Created By: ACS Dev 
Created On: August 14, 2014 
Purpose: CURD for Product 

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
        
		if($("#i_category_id").val()=='')
		{
			markAsError($("#i_category_id"),'<?php echo addslashes(t("Please provide category id"))?>');
			b_valid = false;
		}
		if($("#i_status").val()=='')
		{
			markAsError($("#i_status"),'<?php echo addslashes(t("Please provide status"))?>');
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
		<label for="focusedInput"><?php echo addslashes(t("Category Id"))?><span class="text-danger">*</span></label>
			<?php echo form_dropdown('i_category_id', $dd_val, ($posted['i_category_id']!= '' ? array($posted['i_category_id']):''),'class="form-control" id="i_category_id"')?><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Product Name"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="s_product_name" id="s_product_name" name="s_product_name" value="<?php echo $posted["s_product_name"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Product Description"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="s_product_description" id="s_product_description" name="s_product_description" value="<?php echo $posted["s_product_description"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Upload Product Image"))?><span class="text-danger"></span></label>
			<input id="s_product_image" name="s_product_image" type="file" /><span class="text-danger"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Price"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="f_price" id="f_price" name="f_price" value="<?php echo $posted["f_price"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Quantity"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="i_quantity" id="i_quantity" name="i_quantity" value="<?php echo $posted["i_quantity"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Color"))?><span class="text-danger"></span></label>
			<?php echo form_dropdown('e_color', $dd_val, ($posted['e_color']!= '' ? array($posted['e_color']):''),'class="form-control" id="e_color"')?><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Status"))?><span class="text-danger">*</span></label>
			<input class="form-control" rel="i_status" id="i_status" name="i_status" value="<?php echo $posted["i_status"];?>" type="checkbox" /><span class="text-danger"></span>
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
