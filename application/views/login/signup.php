<?php
	global $session;
	global $form;
	/**
	* The user is already logged in, not allowed to register.
	*/
	/*if($session->logged_in){
		echo "<h1>Registered</h1>";
		echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
		."<a href='".URL."'>Main</a>.</p>";
	}*/
	
	/**
	 * The user has submitted the registration form and the
	 * results have been processed.
	 */
	/*if(isset($_SESSION['regsuccess'])){
		/* Registration was successful */
	/*	if($_SESSION['regsuccess']){
			echo "<h1>Registered!</h1>";
			echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
			."you may now <a href='".URL."'>log in</a>.</p>";
		}
		/* Registration failed */
	/*	else{
			echo "<h1>Registration Failed</h1>";
			echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
			."could not be completed.<br>Please try again at a later time.</p>";
			echo "<a href='".URL."'>Back to Main</a>";
		}
		unset($_SESSION['regsuccess']);
		unset($_SESSION['reguname']);
	}
	
	/**
	* The user has not filled out the registration form yet.
	* Below is the page with the sign-up form, the names
	* of the input fields are important and should not
	* be changed.
	*/
	//else{
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title>Registration | Kwanda Media Portal</title>
	
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/font-awesome.css">
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo THEME; ?>css/bootstrap-responsive.css">

	<link rel="stylesheet" href="<?php echo THEME; ?>css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	
	<link rel="stylesheet" href="<?php echo THEME; ?>css/application.css">

	<script src="<?php echo THEME; ?>js/libs/modernizr-2.5.3.min.js"></script>

</head>

<body class="login">




<div class="account-container register stacked">
	
	<div class="content clearfix">
		
		<form action="<?php echo URL; ?>login/register/" method="post">
		
			<h1>Create Your Account</h1>			
			
			<?php
				if($form->num_errors > 0){
					echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
				}
			?>
			<!--div class="login-social">
				<p>Sign in using social network:</p>
				
				<div class="twitter">
					<a href="#" class="btn_1">Login with Twitter</a>				
				</div>
				
				<div class="fb">
					<a href="#" class="btn_2">Login with Facebook</a>				
				</div>
			</div-->
			
			<div class="login-fields">
				
				<p>Create your free account:</p>
				
				<!--div class="field">
					<label for="firstname">First Name:</label>
					<input type="text" id="firstname" name="firstname" value="" placeholder="First Name" class="login" />
				</div> <!-- /field -->
				
				<!--div class="field">
					<label for="lastname">Last Name:</label>	
					<input type="text" id="lastname" name="lastname" value="" placeholder="Last Name" class="login" />
				</div> <!-- /field -->
				
				
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="user" maxlength="30" placeholder="Username" class="login" value="<?php echo $form->value("user"); ?>" required /> <?php echo $form->error("user"); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="email">Email Address:</label>
					<input type="text" id="email" name="email" maxlength="50" placeholder="Email" class="login" value="<?php echo $form->value("email"); ?>" required pattern="^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{1,})*\.([a-z]{2,}){1}$" /> <?php echo $form->error("email"); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="pass" maxlength="30" placeholder="Password" class="login" value="<?php echo $form->value("pass"); ?>" required /> <?php echo $form->error("pass"); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" id="confirm_password" name="confirm_pass" placeholder="Confirm Password" class="login"  value="<?php echo $form->value("confirm_pass"); ?>" required /> <?php echo $form->error("confirm_pass"); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="user_level">User Level:</label>
					<select id="user_level" name="user_level" required >
						<?php if($session->isAdmin()){ ?>
						<option value="<?php echo MASTER_LEVEL; ?>" >Employee</option>
						<?php } ?>
						<option value="<?php echo AGENT_LEVEL; ?>" >Client</option>
					</select>
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<!--span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">I have read and agree with the Terms of Use.</label>
				</span-->
				
				<input type="hidden" name="subjoin" value="1">
				<input type="submit" value="Register" class="button btn btn-secondary btn-large" />
				
			</div> <!-- .actions -->
			
			<a href="<?php echo URL; ?>">Back to Main</a>
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<!--div class="login-extra">
	Already have an account? <a href="./login.html">Login</a>
</div> <!-- /login-extra -->




<script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo THEME; ?>js/signin.js"></script>

</body>
</html>

<?php
	//}
?>
