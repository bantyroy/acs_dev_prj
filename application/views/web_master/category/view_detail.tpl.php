<?php 

/***

File Name: category view_detail.tpl.php 
Created By: ACS Dev 
Created On: August 08, 2014 
Purpose: CURD for Category 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('s_category'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_category']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_category_description'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_category_description']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_image'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_image']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_date'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_date']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
