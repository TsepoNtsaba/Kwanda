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
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>plugins/msgAlert/css/msgAlert.css" charset="utf-8" /><!--MessageAlert-->
	
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>css/bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>css/ui-lightness/jquery-ui-1.8.21.custom.css">	
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>css/application.css">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME; ?>default.css">

	<script type="text/javascript" src="<?php echo THEME; ?>js/jquery.form.js"></script>
	
	<script type="text/javascript" src="<?php echo THEME; ?>js/libs/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/lightbox/js/lightbox/jquery.lightbox.min.js"></script><!--lightbox-->
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/msgbox/javascript/msgbox/jquery.msgbox.min.js"></script><!--messagebox-->
	<script type="text/javascript" src="<?php echo THEME; ?>plugins/msgAlert/js/msgAlert.js"></script><!--MessageAlert-->
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
				
				<?php //echo $form->error("username"); ?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" maxlength="30" value="<?php echo $form->value("username"); ?>" placeholder="Username" class="login username-field" required />
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				<input type="hidden" name="subforgot" value="1">
				<div class="btn-login">
					<button class="btn-secondary btn-login2">Get New Password</button>
				</div>
			</div> <!-- .actions -->
			
			<a href="<?php echo URL; ?>">Back to Main</a>
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo THEME; ?>js/signin.js"></script>

	<script> 
		//Uploader Form uploading script
		$(document).ready(function(){
			//This function turns form data into a json object
			$.fn.serializeObject = function(){
				var o = {};
				var a = this.serializeArray();
				$.each(a, function(){
					if(o[this.name] !== undefined){
						if(!o[this.name].push){
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					}else{
						o[this.name] = this.value || '';
					}
				});
				return o;
			}
			
			$("#forgotPassForm").submit(function(e){
				e.preventDefault();
				//alert(e);
				$.ajax({
					type: 'POST',
					url: '<?php echo URL; ?>login/procForgotPass',
					data: $("#forgotPassForm").serializeObject(),
					cache: false,	
					success: function(result){
						if(result.response == "true"){
							$.msgbox("An email containing your new password has been sent to the address: "+result.msg+", please use that password to log into the portal.", {
								type : 'confirm',
								buttons : [
									{type: 'submit', value:'OK'},
								]
							}, function(buttonPressed){
								window.location.href = "<?php echo URL; ?>";
							});
						}else{
							$.msgAlert({
								type: "error"
								, title: "Error"
								, text: result.msg
							});
						}
					},
					error:function(error){
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "An Error occured while sending you an email, please try again later. "+error.error
						});
					}
				});
				
				return false;
			});
		});

	</script>

</body>
</html>
