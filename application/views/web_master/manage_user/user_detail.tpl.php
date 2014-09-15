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

<div id="content" class="span10" style="max-height:500px;overflow-x:hidden; overflow-y:scroll;">
    			
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> <?php echo addslashes(t('View Detail'))?></h2>
                
            </div>
           
        <div class="box-content">
            
         <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="">
            <input type="hidden" id="h_search" name="h_search" value="advanced" />				
            <fieldset>	
          		<div class="searchBox">
            
                <div class="searchRow">
                    <div class="searchCell">
                        <div class="searchLabel" >
                            <label><?php echo addslashes(t('Full Name'));?> : </label>
                        </div>
                       <div >
                            <p><?php echo $info_det[0]['s_first_name']." ".$info_det[0]['s_last_name']; ?></p>
                        </div>
                    
                    </div>
					
					
					 <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('Created On'));?> : </label>
                        </div>
                        <div>
                            <p><?php echo $info_det[0]['dt_created_on'] ?></p>
                        </div>
                    </div>
            </div>
                    
              
                <div class="searchRow">
                    <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('User Name'));?> : </label>
                        </div>
                       <div>
                            <p><?php echo $info_det[0]['s_user_name'] ?></p>
                        </div>
                    
                    </div>
            
                    <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('Email'));?> : </label>
                        </div>
                        <div>
                            <p><?php echo $info_det[0]['s_email'] ?></p>
                        </div>
                    </div>
                </div>
              
              <div class="searchRow">
                    <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('Mobile Number'));?> : </label>
                        </div>
                       <div >
                            <p><?php echo $info_det[0]['s_contact_number'] ?></p>
                        </div>
                    
                    </div>
             </div>
              <div class="searchRow">
                    <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('User Type'));?> : </label>
                        </div>
                       <div>
                            <p><?php 
							
							foreach($u_type as $key=> $txt)
							{
								if($key== intval($info_det[0]['i_user_type']))
								{
									echo addslashes(t($txt));
								}
							}
							 ?></p>
                        </div>
                    
                    </div>
            
                   
                    <div class="searchCell">
                        <div class="searchLabel">
                            <label><?php echo addslashes(t('Status'));?> : </label>
                        </div>
                        <div >
                            <p><?php if($info_det[0]['i_status']==1){  echo make_label('Active','success');
							}
							else
							 echo make_label('InActive','warning');
							 
							 ?></p>
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