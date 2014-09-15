
<script type="text/javascript">
$(document).ready(function(e) {
    $(".ajax").colorbox();
});

</script>
<div id="content" class="span10">
			<!-- content starts -->	
			
				<?php echo admin_breadcrumb($BREADCRUMB); ?>
			
			<div class="sortable row-fluid">
				<!--<a data-rel="tooltip" title="4 new members." class="well span3 top-block" href="#">-->
				<a title="<?php echo $total_new_users; ?> new members." class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-user"></span>
					<div><?php echo addslashes(t("Total Users")) ?></div>
					<div><?php echo $total_users; ?></div>
					<!--<span class="notification">4</span>-->
				</a>

				<a title="4 new pro members." class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-star-on"></span>
					<div><?php echo addslashes(t("Total Tasks")) ?></div>
					<div><?php echo $total_tasks ?></div>
					<!--<span class="notification green">4</span>-->
				</a>

				
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> <?php echo addslashes(t("Introduction"))?></h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<h1><?php echo addslashes(t("Work Flow System"))?> <small></small></h1>
						<p>It is a leading electronic university, that contribute in building the economy and society knowledge to convey the Kingdom's cultural message. The electronic university has the flexibility and quality output to the requirement needs of the labor market.</p>
						<p><b>All pages in the menu are functional, take a look at all, please share this with your followers.</b></p>
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
					
			<div class="row-fluid sortable">
			
			
			
						
							<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list-alt"></i>  <?php echo addslashes(t("Completed Task"))?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<ul class="dashboard-list">
							
							<?php if($latest_sessions) {
								foreach($latest_sessions as $key=>$value)
									{
									$start_date = $value["start_date"];
									$end_date = $value["end_date"];
							?>
								<li>
									<!--<a href="#"><img class="dashboard-avatar" alt="Usman" src=""></a>-->
									<strong><?php echo addslashes(t("Course"))?>:</strong> 
									<a class="ajax" href="<?php echo base_url().'corporate/manage_session/show_detail/'.$value['id'];?>"><?php echo $value['course_name']?></a><br>
									<strong><?php echo addslashes(t("Date"))?>:</strong> <?php echo $start_date ?> to <?php echo $end_date ?><br>
									<strong><?php echo addslashes(t("Trainee"))?>:</strong> <?php echo $value["number_of_trainee"] ?><br>
																			 
									                            
								</li>
							<?php } 
								} else {
									
							?>	
							<li><strong><?php echo addslashes(t("No result found"))?>.</strong></li>
							<?php } ?>
								
							</ul>
						</div>
					</div>
				</div>
				
						
						
						
				
				
				
				
				
				
				
				
				
				
				
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <?php echo addslashes(t("Task Latest"))?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<ul class="dashboard-list">
							
							<?php if($latest_tasks) {
								foreach($latest_tasks as $key=>$value)
									{
									
									//$reg_date = date('m/d/Y',strtotime($value["dt_registration_date"]));
									$reg_date = $value["dt_created_on"];
							?>
								<li>
									
									<strong><?php echo addslashes(t("Title"))?>:</strong> 
									<a href="<?php echo base_url().'web_master/manage_task/task_detail/'.$value['i_id'];?>" class="ajax"><?php echo $value['s_title'] ?></a><br>
									<strong><?php echo addslashes(t("Created On"))?>:</strong> <?php echo $reg_date ?><br>
									<strong><?php echo addslashes(t("Status"))?>:</strong> 
									<?php if($value['i_status']==1) {
									
									 echo make_label('Active','success');
									}
									else
							 			echo make_label('InActive','warning');
							  			?>
									 									 
									                            
								</li>
							<?php } 
								} else {
									
							?>	
							<li><strong><?php echo addslashes(t("No result found"))?>.</strong></li>
							<?php } ?>
								
							</ul>
						</div>
					</div>
				</div>		
						
						
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <?php echo addslashes(t("Member Latest"))?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<ul class="dashboard-list">
							
							<?php if($latest_users) {
								foreach($latest_users as $key=>$value)
									{
									
									//$reg_date = date('m/d/Y',strtotime($value["dt_registration_date"]));
									$reg_date = $value["dt_created_on"];
							?>
								<li>
									
									<strong><?php echo addslashes(t("Name"))?>:</strong> 
									<a href="<?php echo base_url().'web_master/manage_user/user_detail/'.$value['i_id'];?>" class="ajax"><?php echo $value['s_first_name'].' '.$value['s_last_name'] ?></a><br>
									<strong><?php echo addslashes(t("Since"))?>:</strong> <?php echo $reg_date ?><br>
									<strong><?php echo addslashes(t("Status"))?>:</strong> 
									<?php if($value['i_status']==1) {
									
									 echo make_label('Active','success');
									}
									else
							 			echo make_label('InActive','warning');
							  			?>
									 									 
									                            
								</li>
							<?php } 
								} else {
									
							?>	
							<li><strong><?php echo addslashes(t("No result found"))?>.</strong></li>
							<?php } ?>
								
							</ul>
						</div>
					</div>
				</div>
						
				
				
						
			
				
			</div>
			</div><!--/row-->

			<!--<div class="row-fluid sortable">
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Buttons</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content buttons">
						<p class="btn-group">
							  <button class="btn">Left</button>
							  <button class="btn">Middle</button>
							  <button class="btn">Right</button>
						</p>
						<p>
							<button class="btn btn-small"><i class="icon-star"></i> Icon button</button>
							<button class="btn btn-small btn-primary">Small button</button>
							<button class="btn btn-small btn-danger">Small button</button>
						</p>
						<p>
							<button class="btn btn-small btn-warning">Small button</button>
							<button class="btn btn-small btn-success">Small button</button>
							<button class="btn btn-small btn-info">Small button</button>
						</p>
						<p>
							<button class="btn btn-small btn-inverse">Small button</button>
							<button class="btn btn-large btn-primary btn-round">Round button</button>
							<button class="btn btn-large btn-round"><i class="icon-ok"></i></button>
							<button class="btn btn-primary"><i class="icon-edit icon-white"></i></button>
						</p>
						<p>
							<button class="btn btn-mini">Mini button</button>
							<button class="btn btn-mini btn-primary">Mini button</button>
							<button class="btn btn-mini btn-danger">Mini button</button>
							<button class="btn btn-mini btn-warning">Mini button</button>
						</p>
						<p>
							<button class="btn btn-mini btn-info">Mini button</button>
							<button class="btn btn-mini btn-success">Mini button</button>
							<button class="btn btn-mini btn-inverse">Mini button</button>
						</p>
					</div>
				</div>
					
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Buttons</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content  buttons">
						<p>
							<button class="btn btn-large">Large button</button>
							<button class="btn btn-large btn-primary">Large button</button>
						</p>
						<p>
							<button class="btn btn-large btn-danger">Large button</button>
							<button class="btn btn-large btn-warning">Large button</button>
						</p>
						<p>
							<button class="btn btn-large btn-success">Large button</button>
							<button class="btn btn-large btn-info">Large button</button>
						</p>
						<p>
							<button class="btn btn-large btn-inverse">Large button</button>
						</p>
						<div class="btn-group">
							<button class="btn btn-large">Large Dropdown</button>
							<button class="btn btn-large dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="icon-star"></i> Action</a></li>
								<li><a href="#"><i class="icon-tag"></i> Another action</a></li>
								<li><a href="#"><i class="icon-download-alt"></i> Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#"><i class="icon-tint"></i> Separated link</a></li>
							</ul>
						</div>
						
					</div>
				</div>
					
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Weekly Stat</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<ul class="dashboard-list">
							<li>
								<a href="#">
									<i class="icon-arrow-up"></i>                               
									<span class="green">92</span>
									New Comments                                    
								</a>
							</li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-down"></i>
							  <span class="red">15</span>
							  New Registrations
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-minus"></i>
							  <span class="blue">36</span>
							  New Articles                                    
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-comment"></i>
							  <span class="yellow">45</span>
							  User reviews                                    
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-up"></i>                               
							  <span class="green">112</span>
							  New Comments                                    
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-down"></i>
							  <span class="red">31</span>
							  New Registrations
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-minus"></i>
							  <span class="blue">93</span>
							  New Articles                                    
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-comment"></i>
							  <span class="yellow">254</span>
							  User reviews                                    
							</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>-->
				  

		  
       
					<!-- content ends -->
			</div><!--/#content.span10-->
				<!--/fluid-row-->