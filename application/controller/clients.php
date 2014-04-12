<?php
/**
* Class Clients
* @author Mello MP
* Marabele Enterprise (Pty) Ltd
*/
class Clients extends Controller{
	/**
	* PAGE: index
	* The dashboard homepage
	*/
	public function index(){
		// load views.
		require 'application/views/_templates/header.php';
		require 'application/views/clients/index.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	* PAGE: settings
	* Settings page to edit user details
	*/
	public function settings(){
		// load views
		require 'application/views/_templates/header.php';
		require 'application/views/_templates/settings.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	* PAGE: skins
	* Allows the users to choose their preferred theme
	*/
	public function skins(){
		// load views
		require 'application/views/_templates/header.php';
		require 'application/views/clients/skins.php';
		require 'application/views/_templates/footer.php';
	}
}
