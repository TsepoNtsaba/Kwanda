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
		//$this->upload();
	}
	
	/**
	* PAGE: admin
	* An admin restricted page
	*/
	public function admin(){
		// check whether user is an admin or not
		global $session;
		
		if($session->isAdmin() || $session->isMaster()){
			// load views
			require 'application/views/_templates/header.php';
			require 'application/views/dashboard/admin.php';
			require 'application/views/_templates/footer.php';
		}
		
		/**
		* User not an administrator, redirect to main page
		* automatically.
		*/
		else{
			header('Location: '.URL);
		}
	}
	
	/**
	*Page:monitor
	*Monitor social networks and search the webcrawler
	*/
	public function monitor(){
		// load views
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/monitor.php';
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
		
		echo $result;
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
		global $session;
		
		if($session->isAdmin() || $session->isMaster() || $session->isAgent()){
			// load views
			require 'application/views/_templates/header.php';
			require 'application/views/_templates/settings.php';
			require 'application/views/_templates/footer.php';
		}
		
		/**
		* User not an administrator, redirect to main page
		* automatically.
		*/
		else{
			header('Location: '.URL);
		}
	}
	
	/**
	* PAGE: skins
	* Allows the users to choose their preferred theme
	*/
	public function skins(){
		// load views
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/skins.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function upload(){
		// load views
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/upload.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function press(){
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/press.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function broadcast(){
		require 'application/views/_templates/header.php';
		require 'application/views/dashboard/broadcast.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function uploadPress(){
		// run the uploadPress() method in the login-model
		$upload_model = $this->loadModel('UploadModel');
		// perform the login method and put result into $upload_successful
		$upload_successful = $upload_model->uploadPress();
		
		echo $upload_successful;
	}
	
	public function uploadBroadcast()
	{
		// run the uploadBroadcast() method in the login-model
		$upload_model = $this->loadModel('UploadModel');
		// perform the login method and put result into $upload_successful
		$upload_successful = $upload_model->uploadBroadcast();
		
		echo $upload_successful;
	}
}
