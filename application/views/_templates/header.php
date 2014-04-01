<?php global $session; ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title>Clients | Kwanda Media Portal</title>
	
	<meta charset="utf-8">
	
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/lightbox/js/jquery.min.js"></script><!--lightbox-->
	
	  <link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>plugins/msgbox/javascript/msgbox/jquery.msgbox.css" /><!--messagebox-->
	  
	  <script type="text/javascript" src="<?php echo THEME; ?>plugins/msgbox/javascript/msgbox/jquery.msgbox.min.js"></script><!--messagebox-->
	  
	  <link rel="stylesheet" href="<?php echo THEME; ?>plugins/msgAlert/css/msgAlert.css" type="text/css" charset="utf-8" /><!--MessageAlert-->
	  
	  <script src="<?php echo THEME; ?>plugins/msgAlert/js/msgAlert.js"></script><!--MessageAlert-->
	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/font-awesome.css">
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap-responsive.css">

	<link rel="stylesheet" href="<?php echo THEME; ?>css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/application-black-orange.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/pages/dashboard.css">

	<script src="<?php echo THEME; ?>js/libs/modernizr-2.5.3.min.js"></script>
</head>

<body>	
	<div id="wrapper">	
		<div id="topbar">
			<div class="container">
				<a href="javascript:;" id="menu-trigger" class="dropdown-toggle" data-toggle="dropdown" data-target="#">
					<i class="icon-cog"></i>
				</a>
	
				<div id="top-nav">
					<!--ul>
						<!--li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								KDashboard			
								<b class="caret"></b>
							</a>
					
							<ul class="dropdown-menu pull-right">
								<li><a href="admin.php">Clients</a></li>
								<!--li><a href="javascript:;">View Site #2</a></li-->
								<!--li class="dropdown-submenu">
									<a tabindex="-1" href="#">Management & Analysis</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="./reports.html">Generate Report</a></li>
										<li><a tabindex="-1" href="./charts.html">Analysis</a></li>
										<!--li><a tabindex="-1" href="#">Second level link</a></li-->
										<!--li class="dropdown-submenu">
											<a tabindex="-1" href="#">Upload</a>
											<ul class="dropdown-menu">
												<li><a tabindex="-1" href="#">Print Clip</a></li>
												<li><a tabindex="-1" href="#">TV Broadcast</a></li>
												<li><a tabindex="-1" href="#">Radio Broadcast</a></li>
											</ul>
										</li>
									</ul>
								</li>
						
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Monitor</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="#">Blogs</a></li>
										<li><a tabindex="-1" href="#">News</a></li>
										<li><a tabindex="-1" href="#">Videos</a></li>
										<li><a tabindex="-1" href="#">Social Search</a></li>
									</ul>
								</li>
							</ul> 
						</li>
					</ul-->
			
					<ul class="pull-right">
						<li><a href="javascript:;"><i class="icon-user"></i><?php echo ' '.$session->username; ?></a></li><!--Username is collected from session and database -->
						<?php if($session->isAgent()){ ?>
								<li><a href="javascript:;"><span class="badge badge-primary">1</span> New Message</a></li>
						<?php } ?>
						<li class="dropdown">
							<a href="./pages/settings.html" class="dropdown-toggle" data-toggle="dropdown">
								Help						
								<b class="caret"></b>
							</a>
					
							<ul class="dropdown-menu pull-right">
								<li><a href="./faq.html">FAQ</a></li>
								<li><a href="javascript:;">Contact Us</a></li>
								<li><a href="javascript:;">About Us</a></li>
								<!--li class="dropdown-submenu">
									<!--a tabindex="-1" href="#">Dropdown menu</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="#">Second level link</a></li>
										<li><a tabindex="-1" href="#">Second level link</a></li>
										<li><a tabindex="-1" href="#">Second level link</a></li>
									</ul-->
								</li>
							</ul> 
						</li>
						<li><a href="<?php echo URL; ?>login/logout">Logout</a></li>
					</ul>
				</div> <!-- /#top-nav -->
			</div> <!-- /.container -->
		</div> <!-- /#topbar -->

		<div id="header">
			<div class="container">
				<a href="./index.html" class="brand">KDashboard Admin</a>
				<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<i class="icon-reorder"></i>
				</a>
	
				<div class="nav-collapse">
					<ul id="main-nav" class="nav pull-right">
						<li id="portal" class="nav-icon">
							<a href="<?php echo URL; ?>dashboard/index">
								<i class="icon-home"></i>
								<span>Home</span>        					
							</a>
						</li>
						
						<?php if($session->isAdmin()){ ?>
							<li id="admin">
								<a href="<?php echo URL; ?>dashboard/admin">
									<i class="icon-user"></i>
									<span>Clients</span> 
									<!--<b class="caret"></b>-->
								</a>	
							</li>
						
							<li id="upload">					
								<a href="<?php echo URL; ?>dashboard/upload">
									<i class="icon-upload"></i>
									<span>Upload</span> 
									<!--b class="caret"></b-->
								</a>
								
								<!-- ul class="dropdown-menu">
									<li><a tabindex="-1" href="../../upload/sound.php">Sound Clip</a></li>
									<li><a tabindex="-1" href="../../upload/video.php">Video Clip</a></li>
									<li><a tabindex="-1" href="../../upload/print.php">Print</a></li>
									<li><a tabindex="-1" href="../../upload/online.php">Online Content</a></li>
								</ul -->
							</li>
						<?php } ?>
						
						<!--li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-th"></i>
								<span>Monitor</span> 
								<b class="caret"></b>
							</a>
							
							<ul class="dropdown-menu">
								<li><a href="#">Blogs</a></li>
								<li><a href="#">News</a></li>
								<li><a href="#">Videos</a></li>
								<li><a href="#">Social Search</a></li>
							</ul>    				
						</li-->
				
				
						<!--li class="dropdown">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-copy"></i>
								<span>Management &amp; Analysis</span> 
								<b class="caret"></b>
							</a>	
						
							<ul class="dropdown-menu">
								<li><a href="./reports.html">Generate Report</a></li>
								<li><a href="./charts.html">Analysis</a></li>
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Upload</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="#">Print Clip</a></li>
										<li><a tabindex="-1" href="#">Tv Broadcast</a></li>
										<li><a tabindex="-1" href="#">Radio Broadcast</a></li>
									</ul>
								</li>
							</ul>    
						</li-->
				
						<!--li class="dropdown">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-th"></i>
								<span>Components</span> 
								<b class="caret"></b>
							</a>	
				
							<ul class="dropdown-menu">
								<li><a href="./elements.html">Elements</a></li>
								<li><a href="./validation.html">Validation</a></li>
								<li><a href="./jqueryui.html">jQuery UI</a></li>
								<li><a href="./charts.html">Charts</a></li>
								<li><a href="./bonus.html">Bonus Elements</a></li>
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Dropdown menu</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="#">Second level link</a></li>
										<li><a tabindex="-1" href="#">Second level link</a></li>
										<li><a tabindex="-1" href="#">Second level link</a></li>
									</ul>
								</li>
							</ul>    				
						</li>
				
						<li class="dropdown">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-copy"></i>
								<span>Clients</span> 
								<b class="caret"></b>
							</a>	
				
							<ul class="dropdown-menu">
								<li><a href="./faq.html">FAQ</a></li>
								<li><a href="./gallery.html">Image Gallery</a></li>
								<li><a href="./pricing.html">Pricing Plans</a></li>
								<li><a href="./reports.html">Reports</a></li>
								<li><a href="./settings.html">Settings</a></li>
							</ul>    				
						</li-->
				
						<li class="dropdown" id="extras">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-external-link"></i>
								<span>Extras</span> 
								<b class="caret"></b>
							</a>	
				
							<ul class="dropdown-menu">							
								<!--li><a href="./login.html">Login</a></li-->
								<?php if($session->isAdmin()){ ?>
									<li><a href="<?php echo URL; ?>login/signup/">Signup a User</a></li>
								<?php } ?>
								<!--li><a href="./error.html">Error</a></li-->
								<?php if($session->isAgent()){ ?>
									<li><a href="<?php echo URL; ?>clients/skins/">Skins</a></li>
								<?php } ?>
								<!--li><a href="./sticky.html">Sticky Footer</a></li-->
								<li><a href="<?php echo URL; ?>dashboard/settings/">Settings</a></li>
							</ul>    				
						</li>
					</ul>
				</div> <!-- /.nav-collapse -->
			</div> <!-- /.container -->	
		</div> <!-- /#header -->
