<?php
/**
* Class Dashboard
* @author Mello MP
* Marabele Enterprise (Pty) Ltd
*/
class Dashboard extends Controller{
	/**
	* PAGE: index
	* The dashboard homepage
	*/
	public function index(){
		// load views.
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/index.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	* PAGE: admin
	* An admin restricted page
	*/
	public function admin(){
		// check whether user is an admin or not
		global $session;
		/**
		* User not an administrator, redirect to main page
		* automatically.
		*/
		if(!$session->isAdmin()){
			header('Location: '.URL);
		}
		
		// else load views
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/admin.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	* Edit user account action
	*/
	public function editUserAccount(){
		// load dashboard-model
		$dash_model = $this->loadModel('DashboardModel');
		// perform deleteUser() method in the Dashboard-Model
		$result = $dash_model->procEditUserAccount();
		
		global $session;
		if($result){
			// has no form errors
			header('Location: '.$session->referrer);
		}else{
			// has some form errors
			header('Location: '.URL.'dashboard/settings');
		}
	}
	
	/**
	* Edit user action
	*/
	public function editUser(){
		// load dashboard-model
		$dash_model = $this->loadModel('DashboardModel');
		// perform deleteUser() method in the Dashboard-Model
		$result = $dash_model->procEditUser();
		
		/*global $session;
		if($result){
			// has no form errors
			header('Location: '.$session->referrer);
		}else{
			// has some form errors
			header('Location: '.$session->referrer);
		}*/
		echo $result;
	}
	
	/**
	* Delete user action
	*/
	public function deleteUser(){
		// load dashboard-model
		$dash_model = $this->loadModel('DashboardModel');
		// perform deleteUser() method in the Dashboard-Model
		$result = $dash_model->procDeleteUser();
		
		/*global $session;
		if($result){
			// has no form errors
			header('Location: '.$session->referrer);
		}else{
			// has some form errors
			header('Location: '.$session->referrer);
		}*/
		echo $result;
	}
	
	/**
	* Ban user action
	*/
	public function banUser(){
		// load dashboard-model
		$dash_model = $this->loadModel('DashboardModel');
		// perform deleteUser() method in the Dashboard-Model
		$result = $dash_model->procBanUser();
		
		echo $result;
	}
	
	/**
	* Activate user action
	*/
	public function activateUser(){
		// load dashboard-model
		$dash_model = $this->loadModel('DashboardModel');
		// perform deleteUser() method in the Dashboard-Model
		$result = $dash_model->procActivateUser();
		
		echo $result;
	}
	
	/**
	* PAGE: settings
	* Settings page to edit user details
	*/
	public function settings(){
		// check whether user is an admin or not
		global $session;
		/**
		* User not an administrator, redirect to main page
		* automatically.
		*/
		if(!$session->isAdmin()){
			header('Location: '.URL);
		}
		
		// else load views
		require 'application/views/_templates/header.php';
		require 'application/views/_templates/settings.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function upload()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/upload.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function _print()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/print.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function sound()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/sound.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function video()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/video.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function uploadPrint()
	{
		// run the uploadPrint() method in the login-model
		$upload_model = $this->loadModel('UploadModel');
		// perform the login method and put result into $upload_successful
		$upload_successful = $upload_model->uploadPrint();
		
		// if file and it's meta-data were uploaded successfully
		if($upload_successful){
			header('Location: '.URL.'dashboard/upload');
			//$arr["response"] = $upload_successful;
			//echo json_encode($arr);
		}else{
			// show user form again
			//header('Location: '.URL.'login/index');
			header('Location: '.URL.'dashboard/_print');
			//$arr["response"] = $upload_successful;
			//echo json_encode($arr);
		}
	}
}
