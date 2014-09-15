<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 25 June 2013
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin Manage User view detail
* @package Users
* @subpackage Manage Users
* @link InfController.php 
* @link My_Controller.php
* @link views/corporate/manage_user/
*/
?>

<div class="container-fluid">

            <div class="row">
              <div class="col-md-12">
					<div class="box-header well" data-original-title>
						<h2><?php echo addslashes(t('View Detail'))?></h2>
						
					</div>
                    <?php //show_all_messages(); ?>
						
					<div class="box-content">
                    	
                        <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="" >
        					<input type="hidden" id="h_search" name="h_search" value="advanced" />				
						<fieldset>	
						<div style="margin-bottom:18px;">
						
							<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('First Name'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['first_name'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Middle Name'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['middle_name'] ?></p>
									</div>
								</div>
							</div>
							
						 </div>   
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Last Name'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['last_name'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Email'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['email'] ?></p>
									</div>
								</div>
							</div>
                         </div>  
                         
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Gender'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['gender'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Nationality'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['nationality'] ?></p>
									</div>
								</div>
							</div>
                         </div>
                         
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Mobile Number'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['mobile_number'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('ID Number'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['id_number'] ?></p>
									</div>
								</div>
							</div>
                         </div>
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Department'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo string_part($info['department_name'],40) ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Campus'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo string_part($info['campus_name'],40) ?></p>
									</div>
								</div>
							</div>
                         </div>
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Position'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['position_name'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Grade'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['grade_name'] ?></p>
									</div>
								</div>
							</div>
                         </div>
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:5%;" >
								  		<label><?php echo addslashes(t('Manager'));?> : </label>
								    </div>
								   <div style="float:left;" >
										<p><?php echo $info['manager_name'] ?></p>
									</div>
								
								</div>
						
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left;  margin-right:5%;" >
								  		<label><?php echo addslashes(t('Status'));?> : </label>
								    </div>
								    <div style="float:left;" >
									    <p><?php echo $info['s_status'] ?></p>
									</div>
								</div>
							</div>
                         </div>
                         
                         <div style="margin-bottom:18px;">
                         	<div style="height:28px;">
								<div style="width:50%; min-width:220px; float:left; ">
									<div style="width:30%; float:left; margin-right:10%;" >
								  		<label><?php echo addslashes(t('Image'));?> : </label>
								    </div>
								   <div style="float:left;" >
                                   		<?php if($info['profile_photo']) {  ?>
										<p><img src="uploaded/user_profile/thumb/thumb_<?php echo $info['profile_photo'] ?>"  /></p>
                                        <?php } else {  ?>
                                        <img src="uploaded/default/no_image_man.png"  />
                                        <?php } ?>
									</div>
								
								</div>
						
								
							</div>
                         </div>                                                                           
						<div style="clear:both;"></div>
							
						  </fieldset>
						</form>  

					</div>
                    
</div>
</div>
</div>