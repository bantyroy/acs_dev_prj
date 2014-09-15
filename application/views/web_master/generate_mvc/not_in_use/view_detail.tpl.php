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

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
 
   <div class="container-fluid">
   
      <h2><?php echo addslashes(t('View Detail'))?></h2>	
      		
    	<div class="row">
        <label class="col-md-4"><?php echo addslashes(t('Title'));?> : </label>
                        
           <div class="col-md-8">
                <p><?php echo $info_det[0]['s_title']; ?></p>
            </div>
            <div class="clearfix"></div>
              <label class="col-md-4"><?php echo addslashes(t('Details'));?> : </label>
                     
             <div class="col-md-8">
                            <p><?php echo $info_det[0]['s_details'] ?></p>
                        </div>
		<div class="clearfix"></div>
                        
		<label class="col-md-4"><?php echo addslashes(t('Date'));?> : </label>
        <div class="col-md-8">
                            <p><?php echo $info_det[0]['dt_posted_date'] ?></p>
                        </div>
		<div class="clearfix"></div>
                     
                      <label class="col-md-4"><?php echo addslashes(t('Place'));?> : </label>
                      
                       <div class="col-md-8">
                            <p><?php echo $info_det[0]['s_place']?></p>
                        </div>                    
            	
             		<div class="clearfix"></div>  
                                          
                    	<label class="col-md-4"><?php echo addslashes(t('Image'));?> : </label>
                  
                       <div class="col-md-8">
                            <p><img src="<?php echo $img_path.'thumb_'.$info_det[0]['s_image'];?>" width="50" height="50"  border="0" /></p>
                        </div>
          <div class="clearfix"></div>
                    
                       <label class="col-md-4"><?php echo addslashes(t('Status'));?> : </label>
                    
     <div class="col-md-8">
                            <p>
								<?php if($info_det[0]['i_status']==1)
                                {  
                                    echo make_label('Active','success');
                                }
                                else
                                    echo make_label('InActive','warning');
                                 
                                 ?>
                            </p>
                        </div>
     				<div class="clearfix"></div>                                                                  
            
                </div>         

    </div>
    
    </div>