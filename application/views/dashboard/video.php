<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 * Modified by: Arman G. de Castro, October 3, 2008
 * email: armandecastro@gmail.com
 */
include("../include/classes/session.php");

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayUsers(){
   global $database;
   $q = "SELECT username,userlevel,email,timestamp, parent_directory "
       ."FROM ".TBL_USERS." ORDER BY userlevel DESC,username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Email</b></td><td><b>Last Active</b></td><td><b>Group</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname  = mysql_result($result,$i,"username");
      $ulevel = mysql_result($result,$i,"userlevel");
      $email  = mysql_result($result,$i,"email");
      $time   = mysql_result($result,$i,"timestamp");
      $parent = mysql_result($result,$i,"parent_directory");

      echo "<tr><td>$uname</td><td>$ulevel</td><td>$email</td><td>$time</td><td>$parent</td></tr>\n";
   }
   echo "</table><br>\n";
}

/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers(){
   global $database;
   $q = "SELECT username,timestamp "
       ."FROM ".TBL_BANNED_USERS." ORDER BY username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname = mysql_result($result,$i,"username");
      $time  = mysql_result($result,$i,"timestamp");

      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
   
/**
 * User not an administrator, redirect to main page
 * automatically.
 */
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else{
/**
 * Administrator is viewing page, so display all
 * forms.
 */
 }
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html> <!--<![endif]-->
<head>
	<title>KDashboard Admin</title>
	
	<meta charset="utf-8">
	
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<script type="text/javascript" src="../theme/plugins/lightbox/js/jquery.min.js"></script><!--lightbox-->

	<link rel="stylesheet" type="text/css" href="../theme/plugins/lightbox/js/lightbox/themes/facebook/jquery.lightbox.css" /><!--lightbox-->
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="../theme/plugins/js/lightbox/themes/default/jquery.lightbox.ie6.css" /><!--lightbox
	<![endif]-->

	<script type="text/javascript" src="../theme/plugins/lightbox/js/lightbox/jquery.lightbox.min.js"></script><!--lightbox-->
	
	  <link rel="stylesheet" type="text/css" href="../theme/plugins/msgbox/javascript/msgbox/jquery.msgbox.css" /><!--messagebox-->
	  
	  <script type="text/javascript" src="../theme/plugins/msgbox/javascript/msgbox/jquery.msgbox.min.js"></script><!--messagebox-->
	  
	  <link rel="stylesheet" href="../theme/plugins/msgAlert/css/msgAlert.css" type="text/css" charset="utf-8" /><!--MessageAlert-->
	  
	  <script src="../theme/plugins/msgAlert/js/msgAlert.js"></script><!--MessageAlert-->
	
	<!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800"-->
	<link rel="stylesheet" href="../theme/css/font-awesome.css">
	
	<link rel="stylesheet" href="../theme/css/bootstrap.css">
	<link rel="stylesheet" href="../theme/css/bootstrap-responsive.css">

	<link rel="stylesheet" href="../theme/css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	
	<link rel="stylesheet" href="../theme/css/application-black-orange.css">
	<link rel="stylesheet" href="../theme/css/pages/dashboard.css">
	
	<style>
		#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
		#percent { position:relative; display:inline-block; top:3px; left:48%; }
	</style>
	
	<link rel="stylesheet" href="../theme/default.css">

	<script src="../theme/js/libs/modernizr-2.5.3.min.js"></script>
</head>

<body>	
	<div id="wrapper">	
		<div id="topbar">
			<div class="container">
				<a href="javascript:;" id="menu-trigger" class="dropdown-toggle" data-toggle="dropdown" data-target="#">
					<i class="icon-cog"></i>
				</a>
	
				<div id="top-nav">
					<ul>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								KDashboard			
								<b class="caret"></b>
							</a>
					
							<ul class="dropdown-menu pull-right">
								<li><a href="admin.php">Clients</a></li>
								<!--li><a href="javascript:;">View Site #2</a></li-->
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Management & Analysis</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="./reports.html">Generate Report</a></li>
										<li><a tabindex="-1" href="./charts.html">Analysis</a></li>
										<!--li><a tabindex="-1" href="#">Second level link</a></li-->
										<li class="dropdown-submenu">
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
					</ul>
			
					<ul class="pull-right">
						<li><a href="javascript:;"><i class="icon-user"></i><?php echo ' '.$session->username; ?></a></li><!--Username is collected from session and database -->
						<li><a href="javascript:;"><span class="badge badge-primary">1</span> New Message</a></li>
						<li class="dropdown">
							<a href="../pages/settings.html" class="dropdown-toggle" data-toggle="dropdown">
								Help						
								<b class="caret"></b>
							</a>
					
							<ul class="dropdown-menu pull-right">
								<li><a href="../faq.html">FAQ</a></li>
								<li><a href="javascript:;">Contact Us</a></li>
								<li><a href="javascript:;">About Us</a></li>
							</ul> 
						</li>
						<li><a href="../../process.php">Logout</a></li>
					</ul>
				</div> <!-- /#top-nav -->
			</div> <!-- /.container -->
		</div> <!-- /#topbar -->

		<div id="header">
			<div class="container">
				<a href="../index.html" class="brand">KDashboard Admin</a>
				<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<i class="icon-reorder"></i>
				</a>
	
				<div class="nav-collapse">
					<ul id="main-nav" class="nav pull-right">
						<li id="portal" class="nav-icon">
							<a href="../portal.php">
								<i class="icon-home"></i>
								<span>Home</span>        					
							</a>
						</li>
				
						<li id="admin">					
							<a href="../admin.php">
								<i class="icon-user"></i>
								<span>Clients</span> 
								<b class="caret"></b>
							</a>	
						</li>
						
						<li class="active">					
							<a href="../upload.php">
								<i class="icon-upload"></i>
								<span>Upload</span> 
								<!--<b class="caret"></b>-->
							</a>	
						</li>
				
				
						<li class="dropdown">					
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
						</li>
				
				
						<li class="dropdown">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-copy"></i>
								<span>Management &amp; Analysis</span> 
								<b class="caret"></b>
							</a>	
						
							<ul class="dropdown-menu">
								<li><a href="../reports.html">Generate Report</a></li>
								<li><a href="../charts.html">Analysis</a></li>
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Upload</a>
									<ul class="dropdown-menu">
										<li><a tabindex="-1" href="./print.php">Print Clip</a></li>
										<li><a tabindex="-1" href="./video.php">Tv Broadcast</a></li>
										<li><a tabindex="-1" href="./sound.php">Radio Broadcast</a></li>
										<li><a tabindex="-1" href="./online.php">Online Content</a></li>
									</ul>
								</li>
							</ul>    
						</li>
				
						<li class="dropdown">					
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-external-link"></i>
								<span>Extras</span> 
								<b class="caret"></b>
							</a>	
				
							<ul class="dropdown-menu">							
								<!--li><a href="./login.html">Login</a></li-->
								<li><a href="../signup.html">Signup a User</a></li>
								<!--li><a href="./error.html">Error</a></li-->
								<li><a href="../skins.html">Skins</a></li>
								<!--li><a href="./sticky.html">Sticky Footer</a></li-->
								<li><a href="../settings.php">Settings</a></li>
							</ul>    				
						</li>
					</ul>
				</div> <!-- /.nav-collapse -->
			</div> <!-- /.container -->	
		</div> <!-- /#header -->

		
		
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Video clip</h2>
						<p>Play and upload video clips.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					<div class="span6 offset3" style="text-align: center">
						<div class="account-container register stacked">
							
							<div class="content clearfix">
								
								<form id="myForm" action="upload_video.php" method="post" enctype="multipart/form-data">
									<span class="label label-secondary">Uploader</span>&nbsp;&nbsp;
									<div class="login-fields">
										
										<div class="field">
											<label for="file">Filename: </label>
											<input type="file" name="file[]" id="file" class="login" onchange="check_file()" multiple />
										 </div>
										 
										 <a href="#">*Add Meta-data</a>
										 <br/>
										 <br/>
										 
										 <div class="login-actions">
											<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
											 <input  class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Upload' multiple />
										 </div>
									
									</div><!--login fields-->
									
									
								</form><br>
								<br>
							</div><!--content clearfix-->
								<div id="progress" class="progress progress-striped">
											<div id="bar" class="bar"></div> <!-- /.bar -->
											<div id="percent">0%</div >
								</div> <!-- /.progress -->
								<br/>
								<div id="message"></div>
						</div><!--account-container register stacked-->
					<div><!-- /.span6 -->
		
						<br>
						<!--Gallery-->
						<h2 style="text-align: center">Video Gallery</h2>
					<?php
			
							$uploadDir = "./video/";
							$counter = 0;
							echo '<section id="tables">';
							echo '<table class="table table-bordered table-striped table-highlight">';
							echo '<thead>';
							echo '<tr>';
							echo '<th>#</th>';
							echo '<th>Title</th>';
							echo '<th>Delete</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
					if ($handle = opendir('./video')) 
					{
					
					    while (false !== ($file = readdir($handle)))
					    {
							if (($file != ".") && ($file != ".."))
							{
								$ext = substr(strrchr($file, "."), 1);
								echo '<tr>';
								echo '<td>'.$counter++.'</td>';
								echo '<td>';
								echo '<a target="_blank" href='.$uploadDir . $file.' title='.$file.'>';
								echo '<video width="320" height="240" controls autoplay>';
								echo '<source src='.$uploadDir . $file.' type='.ext.'>';
								echo '<object data='.$uploadDir . $file.' width="320" height="240">';
									echo '<embed width="320" height="240" src='.$uploadDir . $file.'>';
								echo '</object>';
								echo '</video>';
								echo '</a>';
								echo '</td>';
								
								echo '<td>';
								echo '<form id="delete" action="deleteVideo.php?file=./video/'.$file.'" method="post"><input type="submit" class="btn btn-small btn-secondary" value="Delete"></form>';	
								echo '</td>';
								echo '</tr>';
							}
						}

					    closedir($handle);
					}
					
							echo '</tbody>';
							echo '</table>';
							echo '<br />';
							echo '</section>';
						
						?>
						
						 <p  style="text-align: center"><button  class="btn btn-large btn-secondary" id="deleteAll">Delete all files.</button></p>

						<p style="text-align: center"><a href="#wrapper" class="top">Back to top</a></p>
		
						
				</div><!-- /.row -->		
			</div> <!-- /.container -->
		</div><!-- /#content -->
	</div> <!--wrapper-->
	
	<script src="../theme/js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="../theme/js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="../theme/js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="../theme/js/Theme.js"></script>
	
	<script src="../theme/js/jquery.form.js"></script>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#submit").click(function() {
			$.msgbox('The file(s) have been successfully uploaded. To continue to the analysis process, click continue.', {
			  type : 'info',
			  buttons : [
			    {type: 'submit', value:'<< Back'},
			    {type: 'submit', value:'Continue >>'}
			  ]
			}, function(buttonPressed) {
				if(buttonPressed == '<< Back')
				{
				}
				else if(buttonPressed == 'Continue >>')
				{
					window.location.href = "../charts.php";
				}
				
			});
		});
	 });
	</script>
	
	<script type="text/javascript">
	  jQuery(document).ready(function($){
	    $('.lightbox').lightbox();
	  });
	</script>
	
	
	<script type="text/javascript">
		function check_file(){
			//Video file formats
			str=document.getElementById('file').value.toUpperCase();
			suffix=".AAF";
			suffix2=".3GP";
			suffix3=".AVI";
			suffix4=".FLV";
			suffix5=".OGG";
			suffix6=".WMV";
			suffix7=".MPEG";
			suffix8=".M4V";
			suffix9=".M1V";
			suffix10=".M2V";
			suffix11=".SOL";
			suffix12=".MOV";
			suffix13=".MPG";
			suffix14=".MP4";
			
		
			
			if(!(str.indexOf(suffix, str.length - suffix.length) !== -1||str.indexOf(suffix2, str.length - suffix2.length) !== -1 ||str.indexOf(suffix3, str.length - suffix3.length) !== -1||str.indexOf(suffix4, str.length - suffix4.length) !== -1||str.indexOf(suffix5, str.length - suffix5.length) !== -1||str.indexOf(suffix5, str.length - suffix5.length) !== -1||str.indexOf(suffix6, str.length - suffix6.length) !== -1||str.indexOf(suffix6, str.length - suffix6.length) !== -1||str.indexOf(suffix7, str.length - suffix7.length) !== -1
				||str.indexOf(suffix8, str.length - suffix8.length) !== -1||str.indexOf(suffix9, str.length - suffix9.length) !== -1||str.indexOf(suffix10, str.length - suffix10.length) !== -1||str.indexOf(suffix11, str.length - suffix11.length) !== -1||str.indexOf(suffix12, str.length - suffix12.length) !== -1||str.indexOf(suffix13, str.length - suffix13.length) !== -1||str.indexOf(suffix14, str.length - suffix14.length) !== -1) )
			{
				alert('File type not allowed,\nAllowed file: Popular video formats and document file formats such as *.avi, *.mp4, *.3gp, *.flv, *.wmv etc.');
				document.getElementById('file').value='';
			}
	    }
	</script>

	<script>
	//Delete a file
	$(document).ready(function()
	{

		var options = { 
		    beforeSend: function() 
		    {
			
		    },
		    success: function() 
		    {
				$.msgAlert ({
					type: "success"
					, title: "Succesful"
					, text: "File was successfully deleted."
					, success: location.reload()
				});
		    },
			error: function()
			{
				$.msgAlert ({
					type: "error"
					, title: "Error"
					, text: "Error in deleting the files."
					, success: location.reload()
				});

			}
		     
		}; 

	     $("#delete").ajaxForm(options);

	});
	</script>
	<script>
	//Delete All Files
	    $(function() {
		$('#deleteAll').click(function() {
			$.msgbox("Are you sure that you want to permanently delete all files?", {
				type: "confirm",
				buttons : [
				{type: "submit", value: "Yes"},
				{type: "submit", value: "No"}
				]
				}, function(result) {
					if(result == "Yes")
					{
					
						$.get( "deleteAllVideo.php", function() {
							$.msgAlert ({
							type: "success"
							, title: "Succesful"
							, text: "All files were successfully deleted."
							, success: location.reload()
							});
						})
						.fail(function() {
							$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in deleting all files."
							, success: location.reload()
							});
						});
					}
												 
				});
			});
	    });
	</script>
	
	<script>
	//Uploader Form uploading script
	$(document).ready(function()
	{

		var options = { 
	    beforeSend: function() 
	    {
		$("#progress").show();
		//clear everything
		$("#bar").width('0%');
		$("#message").html("");
			$("#percent").html("0%");
	    },
	    uploadProgress: function(event, position, total, percentComplete) 
	    {
		$("#bar").width(percentComplete+'%');
		$("#percent").html(percentComplete+'%');

	    
	    },
	    success: function() 
	    {
		$("#bar").width('100%');
		$("#percent").html('100%');

	    },
		complete: function(response) 
		{
			$("#message").html("<font color='green'>"+response.responseText+"</font>");
		},
		error: function()
		{
			$("#message").html("<font color='red'> ERROR: unable to upload files</font>");

		}
	     
	}; 

	     $("#myForm").ajaxForm(options);

	});

	</script>

	<script>
		$(function(){
			Theme.init ();
		});
	</script>
	
<div id="footer">
		<div class="container">
			<div class="row">
				<div class="span6">
					© 2014 <a href="http://www.kwandamedia.co.za">Kwanda Media</a>, all rights reserved.
				</div> <!-- /span6 -->
			
				<div id="builtby" class="span6">
					<a href="#">Developed by Marabele (Pty) Ltd</a>				
				</div> <!-- /.span6 -->
			</div> <!-- /row -->
		</div> <!-- /container -->
	</div> <!-- /#footer -->
	
</body>
</html>