<?php
/**
 * Session.php
 * 
 * The Session class is meant to simplify the task of keeping
 * track of logged in users and also guests.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 * Modified by: Arman G. de Castro, October 3, 2008
 * email: armandecastro@gmail.com
 */
require("application/libs/classes/database.php");
require("application/libs/classes/mailer.php");
require("application/libs/classes/form.php");
require("application/libs/classes/PHPExcelClass/PHPExcel.php");

class Session{
	var $username;     //Username given on sign-up
	var $userid;       //Random value generated on current login
	var $userlevel;    //The level to which the user pertains
	var $time;         //Time user was last active (page loaded)
	var $logged_in;    //True if user is logged in, false otherwise
	var $userinfo = array();  //The array holding all user info
	var $url;          //The page url current being viewed
	var $referrer;     //Last recorded site page viewed
	var $pid;     //upload to be reviewed
	/**
	* Note: referrer should really only be considered the actual
	* page referrer in process.php, any other time it may be
	* inaccurate.
	*/

	/* Class constructor */
	function Session(){
		$this->time = time();
		$this->startSession();
	}

	/**
	* startSession - Performs all the actions necessary to 
	* initialize this session object. Tries to determine if the
	* the user has logged in already, and sets the variables 
	* accordingly. Also takes advantage of this page load to
	* update the active visitors tables.
	*/
	function startSession(){
		global $database;  //The database connection
		session_start();   //Tell PHP to start the session

		/* Determine if user is logged in */
		$this->logged_in = $this->checkLogin();

		/**
		* Set guest value to users not logged in, and update
		* active guests table accordingly.
	       */
		if(!$this->logged_in){
			$this->username = $_SESSION['username'] = GUEST_NAME;
			$this->userlevel = GUEST_LEVEL;
			$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
		}else{ /* Update users last active timestamp */
			$database->addActiveUser($this->username, $this->time);
		}
      
		/* Remove inactive visitors from database */
		$database->removeInactiveUsers();
		$database->removeInactiveGuests();
	
		/* Set referrer page */
		if(isset($_SESSION['url'])){
			$this->referrer = $_SESSION['url'];
		}else{
			$this->referrer = "/";
		}
		
		/* Set current url */
		$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
	}

	/**
	* checkLogin - Checks if the user has already previously
	* logged in, and a session with the user has already been
	* established. Also checks to see if user has been remembered.
	* If so, the database is queried to make sure of the user's 
	* authenticity. Returns true if the user has logged in.
	*/
	function checkLogin(){
		global $database;  //The database connection
		/* Check if user has been remembered */
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
			$this->username = $_SESSION['username'] = $_COOKIE['cookname'];
			$this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
		}

		/* Username and userid have been set and not guest */
		if(isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != GUEST_NAME){
			/* Confirm that username and userid are valid */
			if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0){
				/* Variables are incorrect, user not logged in */
				unset($_SESSION['username']);
				unset($_SESSION['userid']);
				return false;
			}
			
			/* User is logged in, set class variables */
			$this->userinfo  = $database->getUserInfo($_SESSION['username']);
			$this->username  = $this->userinfo['username'];
			$this->userid    = $this->userinfo['userid'];
			$this->userlevel = $this->userinfo['userlevel'];
			return true;
		}else{ /* User not logged in */
			return false;
		}	
	}

	/**
	* login - The user has submitted his username and password
	* through the login form, this function checks the authenticity
	* of that information in the database and creates the session.
	* Effectively logging in the user if all goes well.
	*/
	function login($subuser, $subpass, $subremember){
		global $database, $form;  //The database and form object

		/* Username error checking */
		$field = "username";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered");
		}else{
			/* Check if username is not alphanumeric */
			if(!preg_match("/^([0-9a-z])*$/", $subuser)){
				$form->setError($field, "* Username not alphanumeric");
			}
		}

		/* Password error checking */
		$field = "password";  //Use field name for password
		if(!$subpass){
			$form->setError($field, "* Password not entered");
		}
      
		/* Return if form errors exist */
		if($form->num_errors > 0){
			return false;
		}	

		/* Checks that username is in database and password is correct */
		$subuser = stripslashes($subuser);
		$result = $database->confirmUserPass($subuser, md5($subpass));

		/* Check error codes */
		if($result == 1){
			$field = "username";
			$form->setError($field, "* Username not found");
		}else if($result == 2){
			$field = "password";
			$form->setError($field, "* Invalid password");
		}
      
		/* Return if form errors exist */
		if($form->num_errors > 0){
			return false;
		}

		/* Username and password correct, register session variables */
		$this->userinfo  = $database->getUserInfo($subuser);
		$this->username  = $_SESSION['username'] = $this->userinfo['username'];
		$this->userid    = $_SESSION['userid']   = $this->generateRandID();
		$this->userlevel = $this->userinfo['userlevel'];
      
		/* Insert userid into database and update active users table */
		$database->updateUserField($this->username, "userid", $this->userid);
		$database->addActiveUser($this->username, $this->time);
		$database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

		/**
		* This is the cool part: the user has requested that we remember that
		* he's logged in, so we set two cookies. One to hold his username,
		* and one to hold his random value userid. It expires by the time
		* specified in constants.php. Now, next time he comes to our site, we will
		* log him in automatically, but only if he didn't log out before he left.
		*/
		if($subremember){
			setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
		}

		/* Login completed successfully */
		return true;
	}

	/**
	* logout - Gets called when the user wants to be logged out of the
	* website. It deletes any cookies that were stored on the users
	* computer as a result of him wanting to be remembered, and also
	* unsets session variables and demotes his user level to guest.
	*/
	function logout(){
		global $database;  //The database connection
		/**
		* Delete cookies - the time must be in the past,
		* so just negate what you added when creating the
		* cookie.
		*/
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
			setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
		}

		/* Unset PHP session variables */
		unset($_SESSION['username']);
		unset($_SESSION['userid']);
	
		/* Reflect fact that user has logged out */
		$this->logged_in = false;
      
		/**
		* Remove from active users table and add to
		* active guests tables.
		*/
		$database->removeActiveUser($this->username);
		$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      
		/* Set user level to guest */
		$this->username  = GUEST_NAME;
		$this->userlevel = GUEST_LEVEL;
	}

	/**
	* register - Gets called when the user has just submitted the
	* registration form. Determines if there were any errors with
	* the entry fields, if so, it records the errors and returns
	* 1. If no errors were found, it registers the new user and
	* returns 0. Returns 2 if registration failed.
	*/
	function register($subuser, $subpass, $subconfirm, $subemail, $sublevel){
		global $database, $form, $mailer;  //The database, form and mailer object
      
		/* Username error checking */
		$field = "user";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered");
		}else{
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5){
				$form->setError($field, "* Username below 5 characters");
			}else if(strlen($subuser) > 30){
				$form->setError($field, "* Username above 30 characters");
			}else if(!preg_match("/^([0-9a-z_])+$/", $subuser)){ /* Check if username is not alphanumeric */
				$form->setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if(strcasecmp($subuser, GUEST_NAME) == 0){
				$form->setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if($database->usernameTaken($subuser)){
				$form->setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if($database->usernameBanned($subuser)){
				$form->setError($field, "* Username banned");
			}
		}	

		/* Password error checking */
		$field = "pass";  //Use field name for password
		if(!$subpass){
			$form->setError($field, "* Password not entered");
		}else{
			/* Spruce up password and check length*/
			$subpass = stripslashes($subpass);
			if(strlen($subpass) < 4){
				$form->setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", ($subpass = trim($subpass)))){
				$form->setError($field, "* Password not alphanumeric");
			}
			/**
			* Note: I trimmed the password only after I checked the length
			* because if you fill the password field up with spaces
			* it looks like a lot more characters than 4, so it looks
			* kind of stupid to report "password too short".
			*/
		}
		
		/* Confirm Password error checking */
		$field = "confirm_pass";  //Use field name for password
		if(!$subconfirm){
			$form->setError($field, "* Please confirm password");
		}else{
			/* Spruce up password and check length*/
			$subconfirm = stripslashes($subconfirm);
			
			if($subconfirm != $subpass){
				$form->setError($field, "* Passwords do not match!");
			}
			/**
			* Note: I trimmed the password only after I checked the length
			* because if you fill the password field up with spaces
			* it looks like a lot more characters than 4, so it looks
			* kind of stupid to report "password too short".
			*/
		}
      
		/* Email error checking */
		$field = "email";  //Use field name for email
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email not entered");
		}else{
			/* Check if valid email address */
			$regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
				."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
				."\.([a-z]{2,}){1}$/";
			if(!preg_match($regex,$subemail)){
				$form->setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return 1;  //Errors with form
		}
		/* No errors, add the new account to the */
		else{
			if($sublevel == 8){
				$subid = $this->generateRandID();
				$group = "Employee";
				if($database->addNewMaster($subuser, md5($subpass), $subid, $subemail, $group)){
					if(EMAIL_WELCOME){
						if(!$mailer->sendWelcome($subuser,$subemail,$subpass)){
							return 2;
						}
					}	
					return 0;  //New user added succesfully
				}else{
					return 2;  //Registration attempt failed
				}
			}else if($sublevel == 1){
				$subid = $this->generateRandID();
				$group = "Client";
				if($database->addNewAgent($subuser, md5($subpass), $subid, $subemail, $group)){
					if(EMAIL_WELCOME){
						if(!$mailer->sendWelcome($subuser,$subemail,$subpass)){
							return 2;
						}
					}
					return 0;  //New user added succesfully
				}else{
					return 2;  //Registration attempt failed
				}
			}
		}
	}
   
	function SessionMasterRegister($subuser, $subpass, $subemail){
		global $database, $form, $mailer;  //The database, form and mailer object
      
		/* Username error checking */
		$field = "user";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered");
		}else{
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5){
				$form->setError($field, "* Username below 5 characters");
			}else if(strlen($subuser) > 30){
				$form->setError($field, "* Username above 30 characters");
			}
			/* Check if username is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", $subuser)){
				$form->setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if(strcasecmp($subuser, GUEST_NAME) == 0){
				$form->setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if($database->usernameTaken($subuser)){
				$form->setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if($database->usernameBanned($subuser)){
				$form->setError($field, "* Username banned");
			}
		}
	
		/* Password error checking */
		$field = "pass";  //Use field name for password
		if(!$subpass){
			$form->setError($field, "* Password not entered");
		}else{
			/* Spruce up password and check length*/
			$subpass = stripslashes($subpass);
			if(strlen($subpass) < 4){
				$form->setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if(!eregi("^([0-9a-z])+$", ($subpass = trim($subpass)))){
				$form->setError($field, "* Password not alphanumeric");
			}
			/**
			* Note: I trimmed the password only after I checked the length
			* because if you fill the password field up with spaces
			* it looks like a lot more characters than 4, so it looks
			* kind of stupid to report "password too short".
			*/
		}
      
		/* Email error checking */
		$field = "email";  //Use field name for email
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email not entered");
		}else{
			/* Check if valid email address */
			$regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
				."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
				."\.([a-z]{2,}){1}$/";
			if(!preg_match($regex,$subemail)){
				$form->setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return 1;  //Errors with form
		}
		/* No errors, add the new account to the */
		else{
			//THE NAME OF THE CURRENT USER THE PARENT...
			$parent = $this->username;
			if($database->addNewMaster($subuser, md5($subpass), $subemail, $parent)){
				if(EMAIL_WELCOME){
					$mailer->sendWelcome($subuser,$subemail,$subpass);
				}
				return 0;  //New user added succesfully
			}else{
				return 2;  //Registration attempt failed
			}
		}
	}
   
   
	function SessionMemberRegister($subuser, $subpass, $subemail){
		global $database, $form, $mailer;  //The database, form and mailer object
	
		/* Username error checking */
		$field = "user";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered");
		}else{
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5){
				$form->setError($field, "* Username below 5 characters");
			}else if(strlen($subuser) > 30){
				$form->setError($field, "* Username above 30 characters");
			}
			/* Check if username is not alphanumeric */
			else if(!eregi("^([0-9a-z])+$", $subuser)){
				$form->setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if(strcasecmp($subuser, GUEST_NAME) == 0){
				$form->setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if($database->usernameTaken($subuser)){
				$form->setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if($database->usernameBanned($subuser)){
				$form->setError($field, "* Username banned");
			}
		}

		/* Password error checking */
		$field = "pass";  //Use field name for password
		if(!$subpass){
			$form->setError($field, "* Password not entered");
		}else{
			/* Spruce up password and check length*/
			$subpass = stripslashes($subpass);
			if(strlen($subpass) < 4){
				$form->setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", ($subpass = trim($subpass)))){
				$form->setError($field, "* Password not alphanumeric");
			}
			/**
			* Note: I trimmed the password only after I checked the length
			* because if you fill the password field up with spaces
			* it looks like a lot more characters than 4, so it looks
			* kind of stupid to report "password too short".
			*/
		}
      
		/* Email error checking */
		$field = "email";  //Use field name for email
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email not entered");
		}else{
			/* Check if valid email address */
			$regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
				."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
				."\.([a-z]{2,}){1}$/";
			if(!preg_match($regex,$subemail)){
				$form->setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return 1;  //Errors with form
		}
		/* No errors, add the new account to the */
		else{
			//THE NAME OF THE CURRENT USER THE PARENT...
			$parent = $this->username;
			if($database->addNewMember($subuser, md5($subpass), $subemail, $parent)){
				if(EMAIL_WELCOME){
					$mailer->sendWelcome($subuser,$subemail,$subpass);
				}
				return 0;  //New user added succesfully
			}else{
				return 2;  //Registration attempt failed
			}
		}
	}
   
   
	function SessionAgentRegister($subuser, $subpass, $subemail){
		global $database, $form, $mailer;  //The database, form and mailer object
      
		/* Username error checking */
		$field = "user";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered");
		}else{
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5){
				$form->setError($field, "* Username below 5 characters");
			}else if(strlen($subuser) > 30){
				$form->setError($field, "* Username above 30 characters");
			}
			/* Check if username is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", $subuser)){
				$form->setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if(strcasecmp($subuser, GUEST_NAME) == 0){
				$form->setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if($database->usernameTaken($subuser)){
				$form->setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if($database->usernameBanned($subuser)){
				$form->setError($field, "* Username banned");
			}
		}

		/* Password error checking */
		$field = "pass";  //Use field name for password
		if(!$subpass){
			$form->setError($field, "* Password not entered");
		}else{
			/* Spruce up password and check length*/
			$subpass = stripslashes($subpass);
			if(strlen($subpass) < 4){
				$form->setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", ($subpass = trim($subpass)))){
				$form->setError($field, "* Password not alphanumeric");
			}
			/**
			* Note: I trimmed the password only after I checked the length
			* because if you fill the password field up with spaces
			* it looks like a lot more characters than 4, so it looks
			* kind of stupid to report "password too short".
			*/
		}
      
		/* Email error checking */
		$field = "email";  //Use field name for email
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email not entered");
		}else{
			/* Check if valid email address */
			$regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
				."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
				."\.([a-z]{2,}){1}$/";
			if(!preg_match($regex,$subemail)){
				$form->setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return 1;  //Errors with form
		}
		/* No errors, add the new account to the */
		else{
			//THE NAME OF THE CURRENT USER THE PARENT...
			$parent = $this->username;
			if($database->addNewAgent($subuser, md5($subpass), $subemail, $parent)){
				if(EMAIL_WELCOME){
					$mailer->sendWelcome($subuser,$subemail,$subpass);
				}
				return 0;  //New user added succesfully
			}else{
				return 2;  //Registration attempt failed
			}
		}	
	}
	/**
	* editAccount - Attempts to edit the user's account information
	* including the password, which it first makes sure is correct
	* if entered, if so and the new password is in the right
	* format, the change is made. All other fields are changed
	* automatically.
	*/
	function editAccount($subcurpass, $subnewpass, $subemail){
		global $database, $form;  //The database and form object
		/* New password entered */
		if($subnewpass){
			/* Current Password error checking */
			$field = "curpass";  //Use field name for current password
			if(!$subcurpass){
				$form->setError($field, "* Current Password not entered");
			}else{
				/* Check if password too short or is not alphanumeric */
				$subcurpass = stripslashes($subcurpass);
				if(strlen($subcurpass) < 4 || !preg_match("/^([0-9a-z])+$/", ($subcurpass = trim($subcurpass)))){
					$form->setError($field, "* Current Password incorrect");
				}
				/* Password entered is incorrect */
				if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
					$form->setError($field, "* Current Password incorrect");
				}
			}
         
			/* New Password error checking */
			$field = "newpass";  //Use field name for new password
			/* Spruce up password and check length*/
			$subpass = stripslashes($subnewpass);
			if(strlen($subnewpass) < 4){
				$form->setError($field, "* New Password too short");
			}
			/* Check if password is not alphanumeric */
			else if(!preg_match("/^([0-9a-z])+$/", ($subnewpass = trim($subnewpass)))){
				$form->setError($field, "* New Password not alphanumeric");
			}
		}
		/* Change password attempted */
		else if($subcurpass){
			/* New Password error reporting */
			$field = "newpass";  //Use field name for new password
			$form->setError($field, "* New Password not entered");
		}	
      
		/* Email error checking */
		$field = "email";  //Use field name for email
		if($subemail && strlen($subemail = trim($subemail)) > 0){
			/* Check if valid email address */
			$regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
				."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
				."\.([a-z]{2,}){1}$/";
			if(!preg_match($regex,$subemail)){
				$form->setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}
      
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return false;  //Errors with form
		}
      
		/* Update password since there were no errors */
		if($subcurpass && $subnewpass){
			$database->updateUserField($this->username,"password",md5($subnewpass));
		}
      
		/* Change Email */
		if($subemail){
			$database->updateUserField($this->username,"email",$subemail);
		}
      
		/* Success! */
		return true;
	}
   
	/**
	* isAdmin - Returns true if currently logged in user is
	* an administrator, false otherwise.
	*/
	function isAdmin(){
		return ($this->userlevel == ADMIN_LEVEL || $this->username  == ADMIN_NAME);
	}
   
	function isMaster(){
		return ($this->userlevel == MASTER_LEVEL);
	}
   
	function isAgent(){
		return ($this->userlevel == AGENT_LEVEL);
	}
   
	function isMember(){
		return ($this->userlevel == AGENT_MEMBER_LEVEL);
	}
   

	/**
	* generateRandID - Generates a string made up of randomized
	* letters (lower and upper case) and digits and returns
	* the md5 hash of it to be used as a userid.
	*/
	function generateRandID(){
		return md5($this->generateRandStr(16));
	}
   
	/**
	* generateRandStr - Generates a string made up of randomized
	* letters (lower and upper case) and digits, the length
	* is a specified parameter.
	*/
	function generateRandStr($length){
		$randstr = "";
		for($i=0; $i<$length; $i++){
			$randnum = mt_rand(0,61);
			if($randnum < 10){
				$randstr .= chr($randnum+48);
			}else if($randnum < 36){
				$randstr .= chr($randnum+55);
			}else{
				$randstr .= chr($randnum+61);
			}
		}
		return $randstr;
	}
	
	/**
	* Function uploadMetaData
	* Attempts to write to the database the form data and sets
	* form errors if the form was not properly filled
	* @param meta-data info
	* @return upload result;
	*/
	function uploadMetaData($client, $article_id, $publication_date, $media_type, $headline, $author, $circulation, $eav, $reach, $article_text, $file_url, $media_name = NULL, $show_name = NULL, $start_time = NULL, $duration = NULL){
		global $database, $form, $mailer;  //The database, form and mailer object
	      
		/* Clientname error checking */
		$field = "client";  //Use field name for clientname
		if(!$client || strlen($client = trim($client)) == 0){
			$form->setError($field, "* Client not selected");
		}else{
			/* Spruce up clientname */
			$client = stripslashes($client);
		}
		
		/* ArticleID error checking */
		$field = "articleid";  //Use field name for Article ID
		if(!$article_id || strlen($article_id = trim($article_id)) == 0){
			$form->setError($field, "* Article ID not entered");
		}else{
			/* Spruce up Article ID */
			$article_id = stripslashes($article_id);
		}
	      
		/* Publication Date error checking */
		$field = "publicationdate";  //Use field name for Publication Date
		if(!$publication_date || strlen($publication_date = trim($publication_date)) == 0){
			$form->setError($field, "* Publication Date not entered");
		}else{
			/* Check if valid date format */
			//$regex = "^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$";
			//$regex = "/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|11)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468][048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(02)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02)(-)(29)))(\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/";
			/*if(!eregi($regex,$publication_date)){
				$form->setError($field, "* Publication Date invalid");
			}*/
			$publication_date = stripslashes($publication_date);
		}
		
		/* Media Type error checking */
		$field = "mediatype";  //Use field name for Media Type
		if(!$media_type || strlen($media_type = trim($media_type)) == 0){
			$form->setError($field, "* Media Type not selected");
		}else{
			$media_type = stripslashes($media_type);
		}
		
		/* Media Type error checking */
		if($media_name)
			$media_name = stripslashes($media_name);
		//}
		
		/* Headline error checking */
		$field = "headline";  //Use field name for Headline
		if(!$headline || strlen($headline = trim($headline)) == 0){
			$form->setError($field, "* Headline not entered");
		}else{
			$headline = stripslashes($headline);
		}
		
		/* Author error checking */
		$field = "author";  //Use field name for Author
		if(!$author || strlen($author = trim($author)) == 0){
			$form->setError($field, "* Author not entered");
		}else{
			$author = stripslashes($author);
		}
		
		/* Circulation error checking */
		$field = "circulation";  //Use field name for Circulation
		if(!$circulation || strlen($circulation = trim($circulation)) == 0){
			$form->setError($field, "* Circulation not entered");
		}else{
			$circulation = stripslashes($circulation);
		}
		
		/* Eav error checking */
		$field = "eav";  //Use field name for Eav
		if(!$eav || strlen($eav = trim($eav)) == 0){
			$form->setError($field, "* Eav not entered");
		}else{
			$eav = stripslashes($eav);
		}
		
		/* Reach error checking */
		$field = "reach";  //Use field name for Reach
		if(!$reach || strlen($reach = trim($reach)) == 0){
			$form->setError($field, "* Reach not entered");
		}else{
			$reach = stripslashes($reach);
		}
		
		if($show_name)
			$show_name = stripslashes($show_name);
			
		if($start_time)
			$start_time = stripslashes($start_time);
		
		if($duration)
			$duration = stripslashes($duration);
			
		/* Article Text error checking */
		$field = "articletext";  //Use field name for Article Text
		if(!$article_text || strlen($article_text = trim($article_text)) == 0){
			$form->setError($field, "* Article Text not entered");
		}else{
			$article_text = stripslashes($article_text);
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			return 1;  //Errors with form
		}
		/* No errors, add the meta-data to the database*/
		else{
			if($database->addMetaData($client, $article_id, $publication_date, $media_type, $media_name = NULL, $headline, $author, $circulation, $eav, $reach, $show_name, $start_time, $duration, $article_text, $file_url)){
				if(EMAIL_WELCOME){
					//$mailer->sendWelcome($subuser,$subemail,$subpass);
				}
				return 0;  // Meta-data added succesfully
			}else{
				return 2;  // Meta-data query attempt failed
			}
		}
	}
};


/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;

/* Initialize form object */
$form = new Form;

