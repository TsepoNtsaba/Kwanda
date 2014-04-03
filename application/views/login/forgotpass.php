<?php
	//include("include/classes/session.php");
	global $session;
	global $form;
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title>Forgot Password</title>
	
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/lightbox/js/jquery.min.js"></script><!--lightbox-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>plugins/lightbox/js/lightbox/themes/facebook/jquery.lightbox.css" /><!--lightbox-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>plugins/msgbox/javascript/msgbox/jquery.msgbox.css" /><!--messagebox-->
	
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/lightbox/js/lightbox/jquery.lightbox.min.js"></script><!--lightbox-->
	
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/msgbox/javascript/msgbox/jquery.msgbox.min.js"></script><!--messagebox-->
	
	<link rel="stylesheet" href="<?php echo THEME; ?>plugins/msgAlert/css/msgAlert.css" type="text/css" charset="utf-8" /><!--MessageAlert-->
	
	<script src="<?php echo THEME; ?>plugins/msgAlert/js/msgAlert.js"></script><!--MessageAlert-->
	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/font-awesome.css">
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap-responsive.css">

	<link rel="stylesheet" href="<?php echo THEME; ?>css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/application.css">
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/application-black-orange.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/pages/dashboard.css">
	
	<script src="<?php echo RESOURCES; ?>js/jquery-1.10.2.min.js"></script>
	<script src="<?php echo RESOURCES; ?>js/jquery.form.js"></script>
	
	<script src="<?php echo THEME; ?>js/jquery.form.js"></script>
	
	<script src="<?php echo THEME; ?>js/libs/modernizr-2.5.3.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo THEME; ?>default.css">
</head>

<body class="login">



<div class="account-container login stacked">
	
	<div class="content clearfix">
		
		<!--form action="process.php" method="post"-->
		<form id="forgotPassForm" action="<?php echo URL; ?>login/procForgotPass" method="post">
		
			<h1>Forgot Password</h1>
			
			<div class="login-fields">
				
				<p>
					A new password will be generated for you and sent to the email address associated with your account, all you have to do is enter your username.
				</p>
				
				<?php echo $form->error("username"); ?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" maxlength="30" value="<?php echo $form->value("username"); ?>" placeholder="Username" class="login username-field" required />
				</div> <!-- /field -->
				
				<!--div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="<?php echo $form->value("password"); ?>" placeholder="Password" class="login password-field" required />
					<?php //echo //$form->error("password"); ?>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<!--span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span-->
									
				<!--button class="button btn btn-primary btn-large">Sign In</button-->
				<input type="hidden" name="subforgot" value="1">
				
				<div class="btn-login">
					<button class="btn-secondary btn-login2">Get New Password</button>
				</div>
				
				<!--span class="login-checkbox">
					<input id="Field" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" <?php if($form->value("remember") != ""){ echo "checked"; } ?>/>
					<label class="choice" for="Field">Keep me signed in</label>
				</span-->
			</div> <!-- .actions -->
			
			<!--div class="login-social">
				<!--p>Sign in using social network:</p>
				
				<div class="twitter">
					<a href="#" class="btn_1">Login with Twitter</a>				
				</div>
				
				<div class="fb">
					<a href="#" class="btn_2">Login with Facebook</a>				
				</div-->
				<!--div class="btn-login">
					<button class="btn-secondary btn-login2">Sign In</button>
				</div>
			</div-->
			
			<a href="<?php echo URL; ?>">Back to Main</a>
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<!--div class="login-extra">
	<a href="<?php //echo URL; ?>login/forgotpass">Forgot Password?</a>
</div> <!-- /login-extra -->




<!--script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo THEME; ?>js/signin.js"></script-->

	<script>
		//Uploader Form uploading script
		$(document).ready(function(){
			var options = {
				beforeSend: function(){
					/*$("#broadcastProgress").show();
					//clear everything
					$("#broadcastBar").width('0%');
					$("#broadcastMessage").html("");
					$("#broadcastPercent").html("0%");*/
				}, uploadProgress: function(event, position, total, percentComplete){
					//$("#broadcastBar").width(percentComplete+'%');
					//$("#broadcastPercent").html(percentComplete+'%');
				}, success: function(){
					//$("#broadcastBar").width('100%');
					//$("#broadcastPercent").html('100%');
					$.msgbox("An email containing your new password has been sent to the address: "+response..responseText+", please use that password to log into the portal.", {
						type : 'confirm',
						buttons : [
							{type: 'submit', value:'OK'},
						]
					}, function(buttonPressed){
						window.location.href = "<?php echo URL; ?>";
					});
				}, complete: function(response){
					//$("#broadcastMessage").html("<font color='green'>"+response.responseText+"</font>");
					$.msgbox("An email containing your new password has been sent to the address: "+response..responseText+", please use that password to log into the portal.", {
						type : 'confirm',
						buttons : [
							{type: 'submit', value:'OK'},
						]
					}, function(buttonPressed){
						window.location.href = "<?php echo URL; ?>";
					});
				}, error: function(){
					//$("#broadcastMessage").html("<font color='red'> ERROR: unable to upload files</font>");
					$.msgAlert ({
						type: "error"
						, title: "Error"
						, text: "An Error occured while send you an email, please try again later"
					});
				}
			}; 
			
			$("#forgotPassForm").ajaxForm(options);
		});

	</script>

</body>
</html>
