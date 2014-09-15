<?php 

/***

File Name: product show_list.tpl.php 
Created By: ACS Dev 
Created On: August 14, 2014 
Purpose: CURD for Product 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/admin/js/custom_js/add_edit_view.js" type="text/javascript"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
        
                    <div class="box-header well">
                        <h2><?php echo addslashes(t("Search"))?></h2>             
                    </div>
    
                    <?php show_all_messages(); ?>
                    <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action?>" >
                        <input type="hidden" id="h_search" name="h_search" value="" />    
                    </form>
            
                    <form class="" id="frm_search_2" name="frm_search_2" method="post" action="" >
                        <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                        <div id="div_err_2"></div>        
                        <div class="row">
                            <div class="col-md-5">
                            								<div class="form-group">
									<label class=""><?php echo addslashes(t("Category"))?></label>
									<?php echo form_dropdown('i_category_id', $dd_val, ($i_category_id != ''? array($i_category_id) : ''), 'class="form-control"')?>
								</div>								<div class="form-group">
									<label class=""><?php echo addslashes(t("Product Name"))?></label>
									<input type="text" name="s_product_name" id="s_product_name" value="<?php echo $s_product_name?>" class="form-control" />
								</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>                 
                            <button type="button" id="btn_srchall" name="btn_srchall" class="btn"><?php echo addslashes(t("Show All"))?></button>
                        </div>
                    </form>  
                </div>
            </div>

            <?php echo $table_view;?><!-- content ends -->
        </div>
    </div>
</div>
