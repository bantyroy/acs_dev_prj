<?php 

/***

File Name: product view_detail.tpl.php 
Created By: ACS Dev 
Created On: August 14, 2014 
Purpose: CURD for Product 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('i_category_id'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_category_id']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_product_name'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_product_name']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_product_description'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_product_description']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_product_image'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_product_image']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('f_price'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['f_price']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_quantity'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_quantity']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('e_color'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['e_color']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_status'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_status']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
