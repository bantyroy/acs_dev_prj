<?php 

/***

File Name: demo add-edit.tpl.php 
Created By: ACS Dev 
Created On: September 09, 2014 
Purpose: CURD for Demo 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/admin/js/custom_js/add_edit_view.js" type="text/javascript"></script>
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
		<label for="focusedInput"><?php echo addslashes(t("Name"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="s_name" id="s_name" name="s_name" value="<?php echo $posted["s_name"];?>" type="text" /><span class="text-danger"></span>
		</div>
	</div>
	<div class="col-md-5  col-md-offset-2">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Role"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="i_role" id="i_role" name="i_role" value="<?php echo $posted["i_role"];?>" type="checkbox" /><span class="text-danger"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5 ">
		<div class="form-group">
		<label for="focusedInput"><?php echo addslashes(t("Is Active"))?><span class="text-danger"></span></label>
			<input class="form-control" rel="i_status" id="i_status" name="i_status" value="<?php echo $posted["i_status"];?>" type="radio" /><span class="text-danger"></span>
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
