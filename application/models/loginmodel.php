<?php
/**
* Class LoginModel
* @author Mello MP
* Marabele Enterprise (Pty) Ltd.
*/
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
		$retval = $session->register($_POST['user'], $_POST['pass'], $_POST['email']);
		
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
}
	
	
	
	