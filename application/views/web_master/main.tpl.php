<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title><?php echo $title != '' ? $title.' | ' : ''; ?> ###SITE_NAME_UFC###</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<meta name="description" content="Work Flow System, a fully featured, responsive, HTML5, Bootstrap template.">
	<meta name="author" content="Acumen">
	<base href="<?php echo base_url(); ?>" />

	<!-- The styles -->
	

		<!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url()?>resource/admin/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url()?>resource/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url()?>resource/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />      
     
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url()?>resource/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url()?>resource/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url()?>resource/admin/css/acu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>resource/admin/css/colorbox.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>resource/admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>resource/admin/css/chosen.css" rel="stylesheet" type="text/css" />
   
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
    
     <!-- jQuery 2.0.2 -->
        <script src="<?php echo base_url()?>resource/admin/js/jquery-1.7.2.min.js"></script>
        
        <script type="text/javascript" language="javascript" src="<?php echo base_url()?>resource/admin/js/jquery.chosen.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo base_url()?>resource/admin/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url()?>resource/admin/js/bootstrap.js" type="text/javascript"></script>
       
        <!-- Sparkline -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script> 
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url()?>resource/admin/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url()?>resource/admin/js/jquery.colorbox-min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo base_url()?>resource/admin/js/jquery-ui-1.8.21.custom.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url()?>resource/admin/js/bootstrap-typeahead.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url()?>resource/admin/js/jquery.noty.js"></script>
		            
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="resource/admin/js/AdminLTE/dashboard.js" type="text/javascript"></script>-->

		<script type="text/javascript">
            var prefLaguage = "<?php echo $this->session->userdata('current_language');?>";
        </script>

    <!-- custom application script for dmp site
    <script src="resource/admin/js/acs.js"></script>
     -->
    
</head>
<body class="skin-blue">
		<!-- topbar starts -->
		<header class="header">
            
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
             <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-danger">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 job notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-danger">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 user notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-danger">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 payment notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo base_url()?>resource/admin/img/<?php echo $admin_avatar;?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?>  <!--- Web Developer-->
                                        <small>Member since <?php echo date('M', strtotime($admin_details['dt_created_on'])) ?> <?php echo date('Y', strtotime($admin_details['dt_created_on'])) ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                               <!-- <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo admin_base_url().'my_account'; ?>" class="btn btn-default btn-flat"><?php echo addslashes(t("Profile"))?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo admin_base_url().'home/logout'; ?>" class="btn btn-default btn-flat"><?php echo addslashes(t("Sign out"))?></a>
                                        
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
				
				<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                				
				<!--<img src="<?php echo base_url().'resource/admin/img/logo.png' ?>" alt="###SITE_NAME_LINK###" class="logo" />--><span style="font-size: 33px; color: #fff;">Acs Dev Project</span>
                
            </nav>
        </header>
       <div class="wrapper row-offcanvas row-offcanvas-left">
       	
			<aside class="left-side sidebar-offcanvas">
					<!-- sidebar: style can be found in sidebar.less -->
					<section class="sidebar">
						<!-- Sidebar user panel -->
						<div class="user-panel">
							<div class="pull-left image">
								<img src="<?php echo base_url()?>resource/admin/img/<?php echo $admin_avatar;?>" class="img-circle" alt="User Image" />
							</div>
							<div class="pull-left info">
								<p>Hello, <?php echo $admin_details['s_first_name'];?></p>
	
								<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
							</div>
						</div>
						<!-- search form -->
						<!--<form action="#" method="get" class="sidebar-form">
							<div class="input-group">
								<input type="text" name="q" class="form-control" placeholder="Search..."/>
								<span class="input-group-btn">
									<button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>-->
						<!-- /.search form -->
						<!-- sidebar menu: : style can be found in sidebar.less -->
						<ul class="sidebar-menu">
							<?php create_left_menus(); ?>
						</ul>
					</section>
					<!-- /.sidebar -->
				</aside>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $title;?>                        
                    </h1>                    
                       <?php echo admin_breadcrumb($BREADCRUMB); ?>                    
                </section>

                <!-- Main content -->               
        
                <?php
                    /********** CONTENT HERE ************/
					echo $content ;
                ?>                       
                      
                <!-- /.content -->
            </aside><!-- /.right-side -->
       </div>
</body>
</html>

<script type="text/javascript" language="javascript">
function showConfirmation(msg,refId,extraData){
	jQuery(function($){
		var modalObj	=	$("#confirm_box") ;
		modalObj.find('.modal-body p').html(msg);
		modalObj.modal('show');

		$("#modal_cancel").on('click',function(event){
			$('#modal_yes').off();
			callbackEventCancel(modalObj,refId);
		});

		$("#modal_yes").on('click',function(event){
			$('#modal_cancel').off();
			callbackEventYes(modalObj,refId,extraData);
		});
	});
}

var callbackEventCancel	=	function(modalObj,refId){
	// callbackevent can be use
	$(modalObj).modal('hide');
	
}

function set_menu_sessions(pid,cid,lnk)
{
	jQuery.ajax({
			  url: '<?php echo admin_base_url()?>'+'dashboard/set_menu_session/',
			  type: 'POST',
			  data: 'parent_id='+pid+'&child_id='+cid,
			  success: function(msg) {
				window.location.href='<?php echo admin_base_url()?>'+lnk;	
		  }
	});
}

</script>