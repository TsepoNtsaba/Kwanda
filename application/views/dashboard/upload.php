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
global $session;

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
?>
	
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Upload panel</h2>
						<p>Upload videos, sound clips, print documents and online content.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					<a class="upload-icon" href="<?php echo URL; ?>dashboard/_print" ><img  src="<?php echo RESOURCES; ?>img/press_icon.jpg"/><br/><p>Print</p></a>
					<a class="upload-icon" href="<?php echo URL; ?>dashboard/sound" ><img src="<?php echo RESOURCES; ?>img/music.png"/><br/><p>Sound</p></a>
					<a class="upload-icon" href="<?php echo URL; ?>dashboard/video"><img src="<?php echo RESOURCES; ?>img/video2.jpg"/><br/><p>Video</p></a>
				</div>
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->
	

	<script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>

	<script>
		$(function(){
			Theme.init ();
			$("li#upload").addClass("active");
		});
	</script>
