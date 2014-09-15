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

$('[data-rel="chosen"]').chosen();

});   
</script>  

<div class="container-fluid">
	<div class="row">
    
    <div class="col-md-10 col-md-offset-1">
            <div class="box-header">
                <h3 class="box-title"><?php echo $posted["txt_user_type"]?></h3>
            </div>
                 
			<?php show_all_messages(); /*echo validation_errors();*/ ?>

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
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
							</div>							
						</form>                  
					</div>
				</div><!--/span-->

				<?php
                    if($count_box%2==0)
                        echo '</div>'; // End of row
                    }
                    if($count_box%2==0)
                        echo '<div class="row">' ;
                    
                    $count_box	+= 1;
				?>
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> <?php echo $value['first_label_menu']; ?></h2>
						
					</div>
					<div class="row">
                  		<form class="form-horizontal" name="frm_actions" method="post" action="">						
							<input type="hidden" name="h_first_label_menu_id" value="<?php echo $value['first_label_id'] ?>">
							
				<?php		
					}
				?>					
							<div class="form-group">
								<label class="control-label"><?php echo $value['second_label_menu']; ?></label>
									
										<input type="hidden" value="<?php echo $value['second_label_id']; ?>" name="h_action_permit[]" >
									  <select id="select<?php echo '_'.$value['first_label_id'].'_'.$value['second_label_id']; ?>" name="opt_actions[<?php echo $value['second_label_id']; ?>][]" multiple data-rel="chosen" class="form-control">
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
								
						<?php            
                            	$first_label_id	=	$value['first_label_id'];
                        	}
                        
                        ?>			
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Save changes</button>
									<button class="btn">Cancel</button>
							  	</div>								
							</form>                  
                  		</div>
					</div><!--/span-->
				</div>			
			<?php
			
		}
		?>	

<!-- content ends -->
</div>