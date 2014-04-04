<style>
	.fieldEdit{
		width: 100%;
	}
</style>
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
//include("../include/classes/session.php");

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
 global $session, $database, $form;
 
function displayUsers(){
	global $session, $database;
	
	if($session->isAdmin()){
		$q = "SELECT * "
			."FROM ".TBL_USERS." ORDER BY userlevel DESC,username";
	}else{
		$q = "SELECT * "
			."FROM ".TBL_USERS." WHERE userlevel = 1 ORDER BY userlevel DESC,username";
	}
	
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
	//echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
	//echo "<table class='table table-bordered table-striped table-highlight'>";
	echo "<thead><tr><th>Username</th><th>Level</th><th>Email</th><th>Group</th><th/><th/><th/></tr></thead>";
	echo "<tbody>";
	for($i=0; $i<$num_rows; $i++){
		$uid  = mysql_result($result,$i,"uid");
		$uname  = mysql_result($result,$i,"username");
		$upass = mysql_result($result, $i, "password");
		$userid = mysql_result($result, $i, "userid");
		$ulevel = mysql_result($result,$i,"userlevel");
		$email  = mysql_result($result,$i,"email");
		$time   = mysql_result($result,$i,"timestamp");
		$parent = mysql_result($result,$i,"parent_directory");
		
		if($ulevel != 9){
			echo "<tr>
					<td style='display: none'><span class='fieldText txtUid'> $uid</span><input type='text' value='$uid'  class='fieldEdit tbxUid' style='display: none' /></td>
					<td><span class='fieldText txtUsername'> $uname</span><input type='text' value='$uname'  class='fieldEdit tbxUsername' style='display: none' /></td>
					<td style='display: none'><span class='fieldText txtPassword'> $upass</span><input type='text' value='$upass'  class='fieldEdit tbxPassword' style='display: none' /></td>
					<td style='display: none'><span class='fieldText txtUserid'> $userid</span><input type='text' value='$userid'  class='fieldEdit tbxUserid' style='display: none' /></td>
					<td><span class='fieldText txtLevel' >$ulevel</span><input type='text' value='$ulevel'  class='fieldEdit tbxLevel' style='display: none' /></td>
					<td><span class='fieldText txtEmail' >$email</span><input type='text' value='$email' class='fieldEdit tbxEmail' style='display: none' /></td>
					<td style='display: none'><span class='fieldText txtTime'> $time</span><input type='text' value='$time'  class='fieldEdit tbxTime' style='display: none' /></td>
					<td><span class='fieldText txtGroup' >$parent</span><input type='text' value='$parent' class='fieldEdit tbxGroup' style='display: none' /></td>
					<td><a class='del btn btn-small btn-secondary' id='$uname' href='".URL."dashboard/deleteUser'><span>delete</span></a></td><td><a class='ban btn btn-small btn-secondary' id='$uid' href=''><span>ban</span></a></td><td><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td>
				</tr>";
		}
	}
	echo "</tbody><br>";
}


/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers(){
	global $session, $database;
	
	if($session->isAdmin()){
		$q = "SELECT * "
			."FROM ".TBL_BANNED_USERS." ORDER BY userlevel DESC, username";
	}else{
		$q = "SELECT * "
			."FROM ".TBL_BANNED_USERS." WHERE userlevel = 1 ORDER BY userlevel DESC,username";
	}
	
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
	//echo "<table class='table table-bordered table-striped table-highlight'>";
	echo "<thead><tr><th>Username</th><th>Level</th><th>Email</th><th>Group</th><th>TimeBanned</th><th/><th/><th/></tr></thead>";
	echo "<tbody>";
	for($i=0; $i<$num_rows; $i++){
		$uid  = mysql_result($result,$i,"uid");
		$uname  = mysql_result($result,$i,"username");
		$upass = mysql_result($result, $i, "password");
		$userid = mysql_result($result, $i, "userid");
		$ulevel = mysql_result($result,$i,"userlevel");
		$email  = mysql_result($result,$i,"email");
		$time   = mysql_result($result,$i,"timestamp");
		$parent = mysql_result($result,$i,"parent_directory");
		
		if($ulevel != 9){
			echo "<tr>
					<td style='display: none'><span class='fieldText txtUid'> $uid</span><input type='text' value='$uid'  class='fieldEdit tbxUid' style='display: none' /></td>
					<td><span class='fieldText txtUsername'> $uname</span><input type='text' value='$uname'  class='fieldEdit tbxUsername' style='display: none' /></td>
					<td style='display: none'><span class='fieldText txtPassword'> $upass</span><input type='text' value='$upass'  class='fieldEdit tbxPassword' style='display: none' /></td>
					<td style='display: none'><span class='fieldText txtUserid'> $userid</span><input type='text' value='$userid'  class='fieldEdit tbxUserid' style='display: none' /></td>
					<td><span class='fieldText txtLevel' >$ulevel</span><input type='text' value='$ulevel'  class='fieldEdit tbxLevel' style='display: none' /></td>
					<td><span class='fieldText txtEmail' >$email</span><input type='text' value='$email' class='fieldEdit tbxEmail' style='display: none' /></td>
					<td><span class='fieldText txtGroup' >$parent</span><input type='text' value='$parent' class='fieldEdit tbxGroup' style='display: none' /></td>
					<td><span class='fieldText txtTime'> $time</span><input type='text' value='$time'  class='fieldEdit tbxTime' style='display: none' /></td>
					<td><a class='del btn btn-small btn-secondary' id='$uname' href='".URL."dashboard/deleteUser'><span>delete</span></a></td><td><a class='activate btn btn-small btn-secondary' id='$uid' href=''><span>activate</span></a></td><td><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td>
				</tr>";
		}
	}
	echo "</tbody><br>\n";
}
?>		
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Admin Center</h2>
						<p>
							Active User Total: <?php echo $database->getNumMembers().'. ';
							echo "There are $database->num_active_users registered member(s) and ";
							echo "$database->num_active_guests guests viewing the site.";?>
						</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->
		

		<!--h1>Admin Center</h1>
		<font size="5" color="#ff0000">
			<b>::::::::::::::::::::::::::::::::::::::::::::</b>
		</font>
		<font size="4">Logged in as <b><?php //echo $session->username; ?></b></font><br><br>
		Back to [<a href="../index.php">Main Page</a>]<br><br-->
	
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="span7">
<?php
	if($form->num_errors > 0){
		echo "<font size=\"4\" color=\"#ff0000\">"."!*** Error with request, please fix</font><br><br>";
	}
?>
						<h3 class="title">Active Users</h3>
						
						<table class="table table-bordered table-striped table-highlight">
<?php
/**
 * Display Users Table
 */
	displayUsers();
?>
						</table>
					</div> <!--/.span7 -->
				</div> <!--./row -->

				<div class="row hidden">
					<div class="span6">
						<h3>Delete Inactive Users</h3>
							This will delete all users (not administrators), who have not logged in to the site<br>
							within a certain time period. You specify the days spent inactive.<br><br>
									
						<table class='table table-bordered table-striped table-highlight'>
							<tbody>
								<form action="adminprocess.php" method="POST">
									<tr>
										<td>
											Days:<br>
											<select name="inactdays">
												<option value="3">3
												<option value="7">7
												<option value="14">14
												<option value="30">30
												<option value="100">100
												<option value="365">365
											</select>
										</td>
										<td>
											<br>
													<input type="hidden" name="subdelinact" value="1">
													<input class="btn btn-secondary" type="submit" value="Delete All Inactive">
										</td>
									</tr>
								</form>
							</tbody>
						</table>
					</div> <!-- /.span6 -->
				</div> <!-- /.row -->

<?php
/**
 * Display Banned Users Table
 */
?>
				<div class="row">
					<div class="span4">
						<h3 class="title">Banned Users</h3>
						<table class="table table-bordered table-striped table-highlight">
<?php
	displayBannedUsers();
?>
						</table>
					</div> <!-- /.span4 -->
				</div> <!-- /.row -->
<?php
/**
 * Delete Banned User
 */
?>
				<div class="row hidden">
					<div class="span4">
						<h3 class="title">Delete Banned User</h3>
<?php echo $form->error("delbanuser"); ?>
						<table class='table table-bordered table-striped table-highlight'>
							<tbody>
								<tr>
									<td>
										<form action="adminprocess.php" method="POST">
											Username:<br>
											<input type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
											<input type="hidden" name="subdelbanned" value="1">
											<input class="btn btn-secondary" type="submit" value="Delete Banned User">
										</form>
									</td>
								</tr>
							</tbody>
						</table>
					</div> <!-- /.span4 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->
	
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>
	

	<script src="<?php echo THEME; ?>js/plugins/excanvas/excanvas.min.js"></script>
	
	<script type="text/javascript">
	 $(function() {
		$("a.del").click(function(e) {
			e.preventDefault();
			
			var id = $(this).attr("id");
			var jsonObj = {
				deluser:id
			};
			
			$.msgbox("Are you sure that you want to delete user ("+jsonObj.deluser+") ?", {
			  type : 'confirm',
			  buttons : [
			    {type: 'submit', value:'Yes'},
			    {type: 'submit', value:'No'}
			  ]
			}, function(buttonPressed) {
				if(buttonPressed == 'Yes')
				{
					$.ajax({
					    type: 'POST',
					    url: '<?php echo URL; ?>dashboard/deleteUser',
					    data: jsonObj,
					    cache: false,	
					    success:function(result){
						//alert(result.msg);
						if(result.response == "true"){
							$("#"+id).parent().parent().fadeOut("slow");
							
							$.msgAlert ({
								type: "success"
								, title: "Succesful"
								, text: "The user ("+jsonObj.deluser+") was successfully deleted."
								, success: location.reload()
							});
						}else{
							$.msgAlert ({
								type: "error"
								, title: "Error"
								, text: "Error in deleting user ("+jsonObj.deluser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
								/*, success: location.reload()*/
							});
						}
					    },
					    error:function(error){
						//alert(error.error);
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in deleting user ("+jsonObj.deluser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
							});
					    }
					});
				}
				else if(buttonPressed == 'No')
				{
					//window.location.href = "./";
				}
				
			});
		});
		
		$("a.ban").click(function(e){
			e.preventDefault();
			
			var jsonObj = {
				uid: $(this).parent().parent().find(".tbxUid").val(),
				banuser: $(this).parent().parent().find(".tbxUsername").val(),
				password: $(this).parent().parent().find(".tbxPassword").val(),
				userid: $(this).parent().parent().find(".tbxUserid").val(),
				level: $(this).parent().parent().find(".tbxLevel").val(),
				email: $(this).parent().parent().find(".tbxEmail").val(),
				time: $(this).parent().parent().find(".tbxTime").val(),
				group: $(this).parent().parent().find(".tbxGroup").val()
			};
			
			var id = $(this).attr("id");
			
			$.msgbox("Are you sure that you want to ban user ("+jsonObj.banuser+") ?", {
			  type : 'confirm',
			  buttons : [
			    {type: 'submit', value:'Yes'},
			    {type: 'submit', value:'No'}
			  ]
			}, function(buttonPressed) {
				if(buttonPressed == 'Yes')
				{
					$.ajax({
					    type: 'POST',
					    url: '<?php echo URL; ?>dashboard/banUser',
					    data: jsonObj,
					    cache: false,	
					    success:function(result){
						//alert(result.msg);
						if(result.response == "true"){
							$("#"+id).parent().parent().fadeOut("slow");
							
							$.msgAlert ({
								type: "success"
								, title: "Succesful"
								, text: "The user ("+jsonObj.banuser+") was successfully banned."
								, success: location.reload()
							});
						}else{
							$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in banning user ("+jsonObj.banuser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
							});
						}
					    },
					    error:function(error){
						//alert(error.error);
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in banning user ("+jsonObj.banuser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
							});
					    }
					});
					
					return false;
				}
				else if(buttonPressed == 'No')
				{
					//window.location.href = "./";
				}
				
			});
			return false;
		});
		
		$("a.activate").click(function(e){
			e.preventDefault();
			
			var jsonObj = {
				uid: $(this).parent().parent().find(".tbxUid").val(),
				activateuser: $(this).parent().parent().find(".tbxUsername").val(),
				password: $(this).parent().parent().find(".tbxPassword").val(),
				userid: $(this).parent().parent().find(".tbxUserid").val(),
				level: $(this).parent().parent().find(".tbxLevel").val(),
				email: $(this).parent().parent().find(".tbxEmail").val(),
				time: $(this).parent().parent().find(".tbxTime").val(),
				group: $(this).parent().parent().find(".tbxGroup").val()
			};
			
			var id = $(this).attr("id");
			
			$.msgbox("Are you sure that you want to activate user ("+jsonObj.activateuser+") ?", {
			  type : 'confirm',
			  buttons : [
			    {type: 'submit', value:'Yes'},
			    {type: 'submit', value:'No'}
			  ]
			}, function(buttonPressed) {
				if(buttonPressed == 'Yes')
				{
					$.ajax({
					    type: 'POST',
					    url: '<?php echo URL; ?>dashboard/activateUser',
					    data: jsonObj,
					    cache: false,	
					    success:function(result){
						//alert(result.msg);
						if(result.response == "true"){
							$("#"+id).parent().parent().fadeOut("slow");
							
							$.msgAlert ({
								type: "success"
								, title: "Succesful"
								, text: "The user ("+jsonObj.activateuser+") was successfully Activated."
								, success: location.reload()
							});
						}else{
							$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in Activating user ("+jsonObj.activateuser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
							});
						}
					    },
					    error:function(error){
						//alert(error.error);
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in Activating user ("+jsonObj.activateuser+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
							});
					    }
					});
					
					return false;
				}
				else if(buttonPressed == 'No')
				{
					//window.location.href = "./";
				}
				
			});
			return false;
		});
	 });
	</script>

	<script>
		$(function(){
			//Theme.init ();
			$("li#admin").addClass("active");
			
			$("a.edit").click(function(e){
				e.preventDefault();
				
				$(this).parent().parent().find(".fieldText").fadeOut(200);
				$(this).parent().parent().find(".fieldEdit").delay(200).fadeIn(600);
				$(this).fadeOut(200);
				$(this).parent().find(".save").delay(199).fadeIn(200);
			});
			
			$("a.save").click(function(e){
				e.preventDefault();
				//"<tr><td><span class='fieldText txtUsername'> $uname</span><input type='text' value='$uname'  class='fieldEdit tbxUsername' style='display: none' /></td><td><span class='fieldText txtLevel' >$ulevel</span><input type='text' value='$ulevel'  class='fieldEdit tbxLevel' style='display: none' /></td><td><span class='fieldText txtEmail' >$email</span><input type='text' value='$email' class='fieldEdit tbxEmail' style='display: none' /></td><td>$time</td><td><span class='fieldText txtGroup' >$parent</span><input type='text' value='$parent' class='fieldEdit tbxGroup' style='display: none' /></td><td><a class='del btn btn-small btn-secondary' id='$uname' href='adminprocess.php'><span>delete</span></a><br /><br /><a class='ban btn btn-small btn-secondary' id='$uname' href='adminprocess.php'><span>ban</span></a><br /><br /><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td></tr>";
				var jsonObj = {
					uid: $(this).parent().parent().find(".tbxUid").val(),
					edituser: $(this).parent().parent().find(".tbxUsername").val(),
					password: $(this).parent().parent().find(".tbxPassword").val(),
					userid: $(this).parent().parent().find(".tbxUserid").val(),
					level: $(this).parent().parent().find(".tbxLevel").val(),
					email: $(this).parent().parent().find(".tbxEmail").val(),
					time: $(this).parent().parent().find(".tbxTime").val(),
					group: $(this).parent().parent().find(".tbxGroup").val()
				};
				
				$(this).parent().parent().find(".txtUid").text(jsonObj.uid);
				$(this).parent().parent().find(".txtUsername").text(jsonObj.edituser);
				$(this).parent().parent().find(".txtPassword").text(jsonObj.password);
				$(this).parent().parent().find(".txtUserid").text(jsonObj.userid);
				$(this).parent().parent().find(".txtLevel").text(jsonObj.level);
				$(this).parent().parent().find(".txtEmail").text(jsonObj.email);
				$(this).parent().parent().find(".txtTime").text(jsonObj.time);
				$(this).parent().parent().find(".txtGroup").text(jsonObj.group);
				
				$(this).parent().parent().find(".fieldEdit").fadeOut(200);
				$(this).parent().parent().find(".fieldText").delay(200).fadeIn(600);
				$(this).fadeOut(200);
				$(this).parent().find(".edit").delay(200).fadeIn(200);
				
				
				$.ajax({
					type: 'POST',
					url: '<?php echo URL; ?>dashboard/editUser',
					data: jsonObj,
					cache: false,	
					success:function(result){
						if(result.response == "true"){
							$.msgAlert ({
								type: "success"
								, title: "Succesful"
								, text: "The user ("+jsonObj.username+") was successfully edited."
								, success: location.reload()
							});  
						}else{
							$.msgAlert ({
								type: "error"
								, title: "Error"
								, text: "Error in editing user ("+jsonObj.username+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
								/*, success: location.reload()*/
							});
						}
					},
					error:function(error){
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "Error in editing user ("+jsonObj.username+"), please check the frequently asked questions or contact support. Sorry for the inconvenience :-("
							/*, success: location.reload()*/
						});
					}
				});
			
			});
		});
	</script>
