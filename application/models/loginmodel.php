<?php
/**
* Class LoginModel
* @author Mello MP
* Marabele Enterprise (Pty) Ltd.
*/

header('Content-type: application/json');

class LoginModel{
	/**
	* Every model needs a database connection, passed to the model
	* @param object $db A PDO database connection
	*/
	public function __construct($db){
		try{
			$this->db = $db;
		}catch(PDOException $e){
			exit('Database connection could not be establised.');
		}
	}
	
	/**
	* Login process
	* @return bool success state
	*/
	public function login(){
		global $session, $form;
		/* Login attempt */
		$retval = $session->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
		
		/* Login successful */
		if($retval){
			//header("Location: ./index.php");
			return true;
		}
		/* Login failed */
		else{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
		}
		return false;
	}
	
	/**
	* Logout process
	*/
	public function logout(){
		// delete the session
		global $session;
		$retval = $session->logout();
	}
	
	/**
	* Users login status
	* @return bool user's login status
	*/
	public function isUserLoggedIn(){
		return Session::get('user_logged_in');
	}
	
	/**
	* Register New User process
	* @return bool gives back the success status of the registration
	*/
	public function registerNewUser(){
		global $session, $form;
		/* Convert username to all lowercase (by option) */
		if(ALL_LOWERCASE){
			$_POST['user'] = strtolower($_POST['user']);
		}
		
		/* Registration attempt */
		$retval = $session->register($_POST['user'], $_POST['pass'], $_POST['confirm_pass'], $_POST['email'], $_POST['user_level']);
		
		/* Registration Successful */
		if($retval == 0){
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = true;
			//header("Location: ".$session->referrer);
			unset($_SESSION['regsuccess']);
			return true;
		}
		
		/* Error found with form */
		else if($retval == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
		}
		
		/* Registration attempt failed */
		else if($retval == 2){
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = false;
			//header("Location: ".$session->referrer);
		}
		
		return false;
	}
	
	/**
	* procForgotPass - Validates the given username then if
	* everything is fine, a new password is generated and
	* emailed to the address the user gave on sign up.
	*/
	public function procForgotPass(){
		global $database, $session, $mailer, $form;
		
		/* Username error checking */
		$subuser = $_POST['username'];
		$field = "username";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered<br>");
		}else{
			/* Make sure username is in database */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5 || strlen($subuser) > 30 || !preg_match("/^([0-9a-z])+$/", $subuser) || (!$database->usernameTaken($subuser))){
				$form->setError("user", "* Username does not exist<br>");
			}
		}
      
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			
			return json_encode(Array("response" => "false", "msg" => 'The Username: "'.$subuser.'" does not exist!!'));
		}
		/* Generate new password and email it to user */
		else{
			/* Generate new password */
			$newpass = $session->generateRandStr(8);
			
			/* Get email of user */
			$userinfo = $database->getUserInfo($subuser);
			$email  = $userinfo['email'];
			
			/* Attempt to send the email with new password */
			if($mailer->sendNewPass($subuser, $email, $newpass)){
				/* Email sent, update database */
				$database->updateUserField($subuser, "password", md5($newpass));
				$_SESSION['forgotpass'] = true;
				//return true;
				return json_encode(Array("response" => "true", "msg" => $email));
			}
			/* Email failure, do not change password */
			else{
				$_SESSION['forgotpass'] = false;
				
				return json_encode(Array("response" => "false", "msg" => "An Error occured while sending you an email, please try again later."));
				//return "Email failure, do not change password";
			}
		}
	}
}
	
	
	
	