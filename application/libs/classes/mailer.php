<?php 
/**
 * Mailer.php
 *
 * The Mailer class is meant to simplify the task of sending
 * emails to users. Note: this email system will not work
 * if your server is not setup to send mail.
 *
 * If you are running Windows and want a mail server, check
 * out this website to see a list of freeware programs:
 * <http://www.snapfiles.com/freeware/server/fwmailserver.html>
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 * Modified by: Arman G. de Castro, October 3, 2008
 * email: armandecastro@gmail.com
 */
 require("application/libs/classes/class.phpmailer.php");

class Mailer{
	/**
	* sendWelcome - Sends a welcome message to the newly
	* registered user, also supplying the username and
	* password.
	*/
	public function sendWelcome($user, $email, $pass){
		global $php_mailer;
		
		$php_mailer->CharSet = "utf-8";
		
		$php_mailer->AddAddress($email);
		
		$php_mailer->Subject  = "Kwanda Media Portal - Registration!";
		
		$php_mailer->From = "info";
		
		$php_mailer->Body = "Welcome! You have just been registered as a client at Kwanda Media Portal "
						."with the following information:\n\n"
						."Username: ".$user."\n"
						."Password: ".$pass."\n\n"
						."If you ever lose or forget your password, a new "
						."password will be generated for you and sent to this "
						."email address, if you would like to change your "
						."email address you can do so by going to the "
						."Settings page after signing in.\n\n"
						."Please do not reply to this email as this is an automatically generated email :-) .\n\n"
						."- Kwanda Media Portal";
		
		if(!$php_mailer->Send()){
			//echo 'Message was not sent.';
			//echo 'Mailer error: ' . $mailer->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent.';
			return true;
		}
	}
   
	/**
	* sendNewPass - Sends the newly generated password
	* to the user's email address that was specified at
	* sign-up.
	*/
	public function sendNewPass($user, $email, $pass){
		global $php_mailer;
	     
		$php_mailer->CharSet = "utf-8";
		
		$php_mailer->AddAddress($email);
		
		$php_mailer->Subject  = "Kwanda Media Portal - Your new password";
		
		$php_mailer->From = "support";
		
		$php_mailer->Body = "We've generated a new password for you at your "
					."request, you can use this new password with your "
					."username to log in to the Kwanda Media Portal.\n\n"
					."Username: ".$user."\n"
					."New Password: ".$pass."\n\n"
					."It is recommended that you change your password "
					."to something that is easier to remember, which "
					."can be done by going to the Settings page "
					."after signing in.\n\n"
					."Please do not reply to this email as this is an automatically generated email :-) .\n\n"
					."- Kwanda Media Portal";
		if(!$php_mailer->Send()){
			//echo 'Message was not sent.';
			//echo 'Mailer error: ' . $mailer->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent.';
			return true;
		}		
	}
	
	/**
	* sendNotification - Sends the newly generated report
	* to the user's email address that was specified at
	* upload.
	*/
	public function sendNotification($user, $email){
		global $php_mailer;
	     
		$php_mailer->CharSet = "utf-8";
		
		$php_mailer->AddAddress($email);
		
		$php_mailer->Subject  = "Kwanda Media Portal - News Update!";
		
		$php_mailer->From = "info";
		
		$link = URL;
		
		$php_mailer->Body = "Hey ".$user.", \n\n"
					."We've generated a new report for you "
					.", you can access the report by "
					."following the link to the Kwanda Media Portal below.\n\n"
					.$link."\n\n"
					."Please do not reply to this email as this is an automatically generated email :-) .\n\n"
					."- Kwanda Media Portal";
		
		if(!$php_mailer->Send()){
			//echo 'Message was not sent.';
			//echo 'Mailer error: ' . $mailer->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent.';
			return true;
		}		
	}
	
	
	/**
	* contac