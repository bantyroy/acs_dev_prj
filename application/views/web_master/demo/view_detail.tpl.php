<?php 

/***

File Name: demo view_detail.tpl.php 
Created By: ACS Dev 
Created On: September 09, 2014 
Purpose: CURD for Demo 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('s_name'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_name']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_role'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_role']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_status'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_status']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
