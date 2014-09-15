<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>###SITE_NAME_UFC###</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<meta name="description" content="Work Flow System, a fully featured, responsive, HTML5, Bootstrap template.">
	<meta name="author" content="Acumen">

	<base href="<?php echo base_url(); ?>" />

	<!-- The styles -->
	<link id="bs-css" href="resource/admin/css/bootstrap-cerulean.css" rel="stylesheet">
	
    
    <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url()?>resource/admin/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->

        <!-- Ionicons -->
        <link href="<?php echo base_url()?>resource/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url()?>resource/admin/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo base_url()?>resource/admin/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo base_url()?>resource/admin/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url()?>resource/admin/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url()?>resource/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url()?>resource/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url()?>resource/admin/css/acu.css" rel="stylesheet" type="text/css" />
   
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">

</head>

<body class="skin-blue">
   
       <header class="header">

            <!-- Header Navbar: style can be found in header.less -->
             <nav class="navbar navbar-static-top text-center" role="navigation">
         <img src="<?php echo base_url().'resource/admin/img/logo.png' ?>" alt="###SITE_NAME_LINK###" />
            </nav>
        </header>
        
       
                    		<div class="login_wrapper">
					
                                <?php
									if(!empty($posted))
										show_all_messages("error");
									else
										echo show_success_info('Please login with your Username and Password');
								 ?>
								 
								 <?php
									$current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));
									
									if(isset($_COOKIE['acs_login_username']) && isset($_COOKIE['acs_login_password']))
									{	
										$user_name	= $_COOKIE['acs_login_username'];
										$password	= $_COOKIE['acs_login_password'];
										$checked	= 'checked="checked"';
									}
									else
									{	
										$checked = $password = $user_name = "";
									}
								?>
								
						
                                <form role="form" method="post" action="">
                             
                                    <div class="form-group">
                                        
                                        <input name="txt_user_name" type="text" value="<?php echo $user_name; ?>" class="form-control" placeholder="Username" autocomplete="off" >
                                    </div>
                      
                                    <div class="form-group">
                                        
                                        <input id="txt_password" name="txt_password" type="password" value="<?php echo $password?>" class="form-control" placeholder="Password" autocomplete="off">
                                    </div>
                                    
                                    <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="chk_remember" id="remember" <?php echo $checked?>/>Remember Me
                                            </label>
                                        </div>
                                    
                              
                                     <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                   </form>
              					</div>
                       

 



	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
    
     <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo base_url()?>resource/admin/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url()?>resource/admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo base_url()?>resource/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>resource/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url()?>resource/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url()?>resource/admin/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo base_url()?>resource/admin/js/AdminLTE/dashboard.js" type="text/javascript"></script>	
</body>
</html>