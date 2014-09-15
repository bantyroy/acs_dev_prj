<?php
/*********
* Author: Acumen CS
* Date  : 24 Jan 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin access control Edit
* @package General
* @subpackage country
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/access_control/
*/
?>
<?php
    //Javascript For List View//
?>
<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 


});   
</script>    
 
<div id="content" class="span10">
			<!-- content starts -->
		
			<?php echo admin_breadcrumb($BREADCRUMB); ?>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo $posted["txt_user_type"]?></h2>
						<div class="box-icon">
							<?php /*?><a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a><?php */?>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
                    
                    <div class="box-content">
						<?php 
						
							//pr($s_menu);
						
						// foreach($s_menu as $key=>$value) { }
						?>	
                 
					<?php show_all_messages(); /*echo validation_errors();*/ ?>

                
	            
					</div>
					
				</div><!--/span-->

			</div><!--/row-->		

			<?php
			if($menu_action)
			{ 
				$count_box	=	0 ;	
				$first_label_id	=	-1;
			
				foreach($menu_action as $key=>$value) 
				{
					if($first_label_id!=$value['first_label_id'])
					{
						if($first_label_id!=-1)
						{
						?>
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
							</div>
							</fieldset>
						</form>                  
					</div>
				</div><!--/span-->

				<?php
                    if($count_box%2==0)
                        echo '</div>'; // End of row
                    }
                    if($count_box%2==0)
                        echo '<div class="row-fluid sortable">' ;
                    
                    $count_box	+= 1;
				?>
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> <?php echo $value['first_label_menu']; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  		<form class="form-horizontal" name="frm_actions" method="post" action="">
						
							<input type="hidden" name="h_first_label_menu_id" value="<?php echo $value['first_label_id'] ?>">
							
							<fieldset>
				<?php		
					}
				?>
						
							<div class="control-group">
								<label class="control-label" for="selectError1"><?php echo $value['second_label_menu']; ?></label>
									<div class="controls">
										<input type="hidden" value="<?php echo $value['second_label_id']; ?>" name="h_action_permit[]" >
									  <select id="select<?php echo '_'.$value['first_label_id'].'_'.$value['second_label_id']; ?>" name="opt_actions[<?php echo $value['second_label_id']; ?>][]" multiple data-rel="chosen" style="width:200px;">
									  	<?php 
											$arr_action	=	explode('||',$value['s_action_permit']) ;
											$selected_action	=	explode('##',$value['actions']);
											
											if(!empty($arr_action))
											{
												foreach($arr_action as $key_1=>$value_1)
												{	
													$selected	=	'';
													if(in_array($value_1,$selected_action))
														$selected	=	"selected='selected'";
													
													echo "<option ".$selected." value='".$value_1."'>".$value_1."</option>";
												}
											}
										?>

									  </select>
									</div>
						  </div>
								
		<?php				

				$first_label_id	=	$value['first_label_id'];
			}
			
			?>
			
						<div class="form-actions">
									<button type="submit" class="btn btn-primary">Save changes</button>
									<button class="btn">Cancel</button>
							  	</div>
								</fieldset>
							</form>                  
                  		</div>
					</div><!--/span-->
				</div>
			
			<?php
			
		}
		?>	

<!-- content ends -->
</div>