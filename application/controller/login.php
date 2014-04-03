<?php
/**
* Class Login
*
* @author Mello MP
* Marabele Enterprise (Pty) Ltd
*
*/
class Login extends Controller{
	/**
	* Construct this object by extending the basic Controller class
	*/
	function __construct(){
		parent::__construct();
	}
	
	/**
	* PAGE: index
	* This method shows the login form
	*/
	public function index(){
		//require 'application/views/_templates/header.php';
		require 'application/views/login/index.php';
		//require 'application/views/_templates/footer.php';
	}
	
	/**
	* The login action
	*/
	public function login(){
		// run the login() method in the login-model
		$login_model = $this->loadModel('LoginModel');
		// perform the login method and put result into $login_successful
		$login_successful = $login_model->login();
		
		// check login status
		if($login_successful){
			// check whether user is admin or not
			global $session;
			
			// if is admin, then move user to dashboard/index
			if($session->isAdmin()){
				header('Location: '.URL.'dashboard/index');
			}
			// user not an administrator, redirect to client page
			else if($session->isAgent()){
				header('Location: '.URL.'dashboard/index');
			}
			else{
				header('Location: '.URL);
			}
		}else{
			// show user login form again
			//header('Location: '.URL.'login/index');
			header('Location: '.URL);
			//require 'application/views/login/index.php';
		}
	}
	
	/**
	* The logout action
	*/
	public function logout(){
		// load model
		$login_model = $this->loadModel('LoginModel');
		// perform logout() method in the login-model
		$login_model->logout();
		// redirect user to base URL
		header('Location: '.URL);
	}
	
	/**
	* PAGE: signup
	* This method shows the registration form
	*/
	public function signup(){
		// load login-model
		$login_model = $this->loadModel('LoginModel');
		
		//require 'application/views/_templates/header.php';
		require 'application/views/login/signup.php';
		//require 'application/views/_templates/footer.php';
	}
	
	/**
	* Register action
	*/
	public function register(){
		// load the login-model
		$login_model = $this->loadModel('LoginModel');
		// perform the registerNewUser() method of the login-model
		$registration_successful = $login_model->registerNewUser();
		
		if($registration_successful == true){
			// redirect to login page
			header('Location: '.URL.'dashboard/admin');
		}else{
			// reload the registration form
			header('Location: '.URL.'login/signup');
		}
	}
	
	/**
	* PAGE: signup
	* This method shows the forgot password form
	*/
	public function forgotPass(){
		// load views
		//require 'application/views/_templates/header.php';
		require 'application/views/login/forgotpass.php';
		//require 'application/views/_templates/footer.php';
	}
	
	/**
	* Process forgot password
	*/
	public function procForgotPass(){
		// load the login-model
		$login_model = $this->loadModel('LoginModel');
		
		// perform the procForgotPass() method of the login-model
		$result = $login_model->procForgotPass();
		
		echo $result;
		
		/*if($result){
			//header('Location: '.URL.'login/index');
			echo $result;
		}else{
			//header('Location: '.URL.'login/forgotPass');
		}*/
	}
}
		
