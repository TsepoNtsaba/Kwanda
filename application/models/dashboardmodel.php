<?php
/**
* Class DashboardModel
* @author Mello MP
* Marabele Enterprise (Pty) Ltd
*/
header('Content-type: application/json');

class DashboardModel{
	/**
	* Every model needs a database connection, passed to the model
	* @param object $db A PDO database connection
	*/
	public function __construct($db) {
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('Database connection could not be established.');
		}
	}
	
	/**
	* procEditAccount - Attempts to edit the user's account
	* information, including the password, which must be verified
	* before a change is made.
	*/
	function procEditUserAccount(){
		global $session, $form;
		/* Account edit attempt */
		$retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email']);
	
		/* Account edit successful */
		if($retval){
			$_SESSION['useredit'] = true;
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "Your profile details have been updated successfully."));
		}
		/* Error found with form */
		else{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
			$error = $form->error("email");
			if(!$error || $error == ""){
				$error = $form->error("curpass");
				if(!$error || $error == "")
					$error = $form->error("newpass");
			}
			
			return json_encode(Array("response" => "false", "msg" => $error));
		}
	}
	
	/**
	* procEditAccount - Attempts to edit the user's account
	* information, including the password, which must be verified
	* before a change is made.
	*/
	function procEditUser(){
		global $session, $form, $database;
		
		/* Username error checking */
		$subuser = $this->checkUsername("edituser");
		
		$uid = $_POST["uid"];
		$uname = $_POST["edituser"];
		$upass = $_POST["password"];
		$userid = $_POST["userid"];
		$ulevel = $_POST["level"];
		$email = $_POST["email"];
		$time = $_POST["time"];
		$group = $_POST["group"];
		
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$q2 = "UPDATE ".TBL_BANNED_USERS." SET username='$uname',userlevel=$ulevel,email='$email',parent_directory='$group' WHERE uid = $uid";
			if(!$database->query($q2))
				return json_encode(Array("response" => "false", "msg" => "System was unable to edit user #edit"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User edit Success"));
		}
		/* Edit user from database */
		else{
			$q1 = "UPDATE ".TBL_USERS." SET username='$uname',userlevel=$ulevel,email='$email',parent_directory='$group' WHERE uid = $uid";
			
			if(!$database->query($q1))
				return json_encode(Array("response" => "false", "msg" => "System was unable to edit user #edit"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User edit Success"));
		}
	}
	
	/**
	* procDeleteUser - If the submitted username is correct,
	* the user is deleted from the database.
	*/
	public function procDeleteUser(){
		global $session, $database, $form;
		/* Username error checking */
		$subuser = $this->checkUsername("deluser");
      
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$q2 = "DELETE FROM ".TBL_BANNED_USERS." WHERE username = '$subuser'";
			if(!$database->query($q2))
				return json_encode(Array("response" => "false", "msg" => "System was unable to delete user #del"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Delete Success"));
		}
		/* Delete user from database */
		else{
			$q1 = "DELETE FROM ".TBL_USERS." WHERE username = '$subuser'";
			
			if(!$database->query($q1))
				return json_encode(Array("response" => "false", "msg" => "System was unable to delete user #del"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Delete Success"));
		}
	}
	
	/**
	* procBanUser - If the submitted username is correct,
	* the user is banned from the member system, which entails
	* removing the username from the users table and adding
	* it to the banned users table.
	*/
	public function procBanUser(){
		global $session, $database, $form;
		/* Username error checking */
		$subuser = $this->checkUsername("banuser");
		
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "false", "msg" => "Form Error"));
		}
		/* Ban user from member system */
		else{
			/*$q = "SELECT * FROM ".TBL_USERS." WHERE username = '$subuser'";
			$result = $database->query($q);*/
			
			/* Error occurred, return given name by default */
			/*$num_rows = mysql_numrows($result);
			if(!$result || ($num_rows < 1)){
				//echo "Error displaying info";
				return json_encode(Array("response" => "false", "msg" => "User: ".$_POST['username']." no longer exists in database"));
			}*/
			//if($num_rows == 0){
				//echo "Database table empty";
			//	return json_encode(Array("response" => "false", "msg" => "Database table empty"));
			//}
			
			//for($i=0; $i<$num_rows; $i++){
				$uid  = $_POST['uid'];
				$uname  = $_POST['banuser'];
				$upass = $_POST['password'];
				$userid = $_POST['userid'];
				$ulevel = $_POST['level'];
				$email  = $_POST['email'];
				$time   = $_POST['time'];
				$parent = $_POST['group'];
			//}
			
			$q = "INSERT INTO ".TBL_BANNED_USERS." (uid, username, password, userid, userlevel, email, parent_directory) 
				VALUES ($uid, '$uname', '$upass', '$userid', $ulevel, '$email', '$parent') ;";
			
			if(!$database->query($q))
				return json_encode(Array("response" => "false", "msg" => "System was unable to ban user #ban"));
			
			$q = "DELETE FROM ".TBL_USERS." WHERE username = '$subuser'";
			
			if(!$database->query($q)){
				$q = "DELETE FROM ".TBL_BANNED_USERS." WHERE username = '$subuser'";
				$database->query($q);
				
				return json_encode(Array("response" => "false", "msg" => "System was unable to ban user #del"));
			}

			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Ban Success"));
		}
	}
	
	/**
	* procActivateUser - If the submitted username is correct,
	* the user is unbanned from the member system, which entails
	* removing the username from the banned users table and adding
	* it to the users table.
	*/
	public function procActivateUser(){
		global $session, $database, $form;
		/* Username error checking */
		//$subuser = $this->checkUsername("activateuser");
		
		/* Errors exist, have user correct them */
		/*if($form->num_errors > 0){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "false", "msg" => "Form Error"));
		}*/
		/* Ban user from member system */
		//else{
			/*$q = "SELECT * FROM ".TBL_USERS." WHERE username = '$subuser'";
			$result = $database->query($q);*/
			
			/* Error occurred, return given name by default */
			/*$num_rows = mysql_numrows($result);
			if(!$result || ($num_rows < 1)){
				//echo "Error displaying info";
				return json_encode(Array("response" => "false", "msg" => "User: ".$_POST['username']." no longer exists in database"));
			}*/
			//if($num_rows == 0){
				//echo "Database table empty";
			//	return json_encode(Array("response" => "false", "msg" => "Database table empty"));
			//}
			
			//for($i=0; $i<$num_rows; $i++){
				$uid  = $_POST['uid'];
				$uname  = $_POST['activateuser'];
				$upass = $_POST['password'];
				$userid = $_POST['userid'];
				$ulevel = $_POST['level'];
				$email  = $_POST['email'];
				$time   = $_POST['time'];
				$parent = $_POST['group'];
			//}
			
			$q = "INSERT INTO ".TBL_USERS." (uid, username, password, userid, userlevel, email, parent_directory) 
				VALUES ($uid, '$uname', '$upass', '$userid', $ulevel, '$email', '$parent') ;";
			
			if(!$database->query($q))
				return json_encode(Array("response" => "false", "msg" => "System was unable to activate user #activate"));
			
			$q = "DELETE FROM ".TBL_BANNED_USERS." WHERE username = '$uname'";
			
			if(!$database->query($q)){
				$q = "DELETE FROM ".TBL_USERS." WHERE username = '$uname'";
				$database->query($q);
				
				return json_encode(Array("response" => "false", "msg" => "System was unable to activate user #del"));
			}

			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Activate Success"));
		//}
	}
	
	/**
	* checkUsername - Helper function for the above processing,
	* it makes sure the submitted username is valid, if not,
	* it adds the appropritate error to the form.
	*/
	public function checkUsername($uname, $ban=false){
		global $database, $form;
		/* Username error checking */
		$subuser = $_POST[$uname];
		$field = $uname;  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered<br>");
		}else{
			/* Make sure username is in database */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5 || strlen($subuser) > 30 ||
			!preg_match("/^([0-9a-z])+$/", $subuser) ||
			(!$ban && !$database->usernameTaken($subuser))){
				$form->setError($field, "* Username does not exist<br>");
			}
		}
		return $subuser;
	}
	
	/**
	* procEditData - Attempts to edit the meta_data
	* information.
	*/
	function procEditData(){
		global $session, $form, $database;
		
		/* Collecting form data via post */
		$medianame = $_POST["medianame"];
		$headline = $_POST["headline"];
		$publicationdate = $_POST["publicationdate"];
		$mediatype = $_POST["mediatype"];
		$articletext = $_POST["articletext"];
		$pid = $_POST["pid"];
		
		// Errors exist, have user correct them 
		if($form->num_errors > 0){
			$q2 = "UPDATE meta_data SET medianame='$medianame',headline='$headline',publicationdate='$publicationdate',mediatype='$mediatype',articletext='$articletext' WHERE pid = '$pid'";
			$q_result = mysql_query($q2) or die(mysql_error());
			if(!$q_result)
				return json_encode(Array("response" => "false", "msg" => "System was unable to edit data 1"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User edit Success"));
		}
		// Edit user from database 
		else
		{
			$q1 = "UPDATE meta_data SET medianame='$medianame',headline='$headline',publicationdate='$publicationdate',mediatype='$mediatype',articletext='$articletext' WHERE pid = '$pid'";
			$q_result = mysql_query($q1) or die(mysql_error());
			if(!$q_result)
				return json_encode(Array("response" => "false", "msg" => "System was unable to edit data 2".
				$medianame.$headline.$publicationdate.$mediatype.$articletext.$pid));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User edit Success"));
		}
	}
	
	/**
	* procDeleteData - If the submitted id is correct,
	* the data is deleted from the database.
	*/
	public function procDeleteData()
	{
		global $session, $database, $form;
		
		$pid = $_POST["pid"];
		
		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$q2 = "DELETE FROM ".TBL_META_DATA." WHERE pid = '$pid'";
			if(!$database->query($q2))
				return json_encode(Array("response" => "false", "msg" => "System was unable to delete user #del"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Delete Success"));
		}
		/* Delete meta_data from database */
		else{
			$q1 = "DELETE FROM ".TBL_META_DATA." WHERE pid = '$pid'";
			
			if(!$database->query($q1))
				return json_encode(Array("response" => "false", "msg" => "System was unable to delete user #del"));
			//header("Location: ".$session->referrer);
			return json_encode(Array("response" => "true", "msg" => "User Delete Success"));
		}
	}
}
