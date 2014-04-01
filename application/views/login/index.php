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

	<title>Dashboard Admin</title>
	
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800"-->
	<link rel="stylesheet" href="<?php echo THEME; ?>css/font-awesome.css">
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap-responsive.css">

	<link rel="stylesheet" href="<?php echo THEME; ?>css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	
	<link rel="stylesheet" href="public/theme/css/application.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>default.css">

	<script src="<?php echo THEME; ?>js/libs/modernizr-2.5.3.min.js"></script>

</head>

<body class="login">



<div class="account-container login stacked">
	
	<div class="content clearfix">
		
		<!--form action="process.php" method="post"-->
		<form action="<?php echo URL; ?>login/login" method="post">
		
			<h1>Sign In</h1>		
			
			<div class="login-fields">
				
				<p>Sign in using your registered account:</p>
				
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" value="<?php echo $form->value("user"); ?>" placeholder="Username" class="login username-field" />
					<?php echo $form->error("user"); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="<?php echo $form->value("pass"); ?>" placeholder="Password" class="login password-field"/>
					<?php echo $form->error("pass"); ?>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<!--span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span-->
									
				<!--button class="button btn btn-primary btn-large">Sign In</button-->
				<input type="hidden" name="sublogin" value="1">
				
				<div class="btn-login">
					<button class="btn-secondary btn-login2">Sign In</button>
				</div>
				
				<span class="login-checkbox">
					<input id="Field" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" <?php if($form->value("remember") != ""){ echo "checked"; } ?>/>
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
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
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	<a href="forgotpass.php">Forgot Password?</a>
</div> <!-- /login-extra -->




<script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo THEME; ?>js/signin.js"></script>

</body>
</html>
