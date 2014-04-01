<?php
/**
* Class UploadModel
* @author Kwasi KK
* Marabele Enterprise (Pty) Ltd
*/
header('Content-type: application/json');

class UploadModel{
	/**
	* Every model needs a database connection, passed to the model
	* @param object $db A PDO database connection
	*/
	public function __construct($db){
		try{
			$this->db = $db;
		}catch (PDOException $e){
			exit('Database connection could not be established.');
		}
	}
	
	public function sanitize($string, $force_lowercase = true, $anal = false){
	    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
			   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
			   "—", "–", ",", "<", ".", ">", "/", "?");
	    $clean = trim(str_replace($strip, "", strip_tags($string)));
	    $clean = preg_replace('/\s+/', "-", $clean);
	    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
	    return ($force_lowercase) ?
		(function_exists('mb_strtolower')) ?
		    mb_strtolower($clean, 'UTF-8') :
		    strtolower($clean) :
		$clean;
	}
	
	/**
	* Upload file and its metadata
	*/
	public function uploadPrint(){
		global $session, $form;
		$result = 1;
		
		if(isset($_FILES["file"])){ //processes the file that was uploaded
			/*check to see if an actual file was uploaded if not return and try again.*/
			$counter = 0;
			for($i = 0; $i < count($_FILES['file']['name']); $i++){
				if($_FILES['file'] ['error'][$i] == 4){
					$counter++;
				}
			}
			
			if($counter == 5){
				echo '<p> No file was uploaded, please try <a href="'.URL.'dashboard/upload">again.</a></p>';
				exit;
			}
			
			/*Upload file, assign it a name, check to see if its a valid format and move it to the designated folder*/
			for($i = 0; $i < count($_FILES['file']['name']); $i++){
				$ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1);
				
				$name =  substr($_FILES['file']['name'][$i], 0);
				
				$name =  current(explode(".", $name));
				
				$name = $this->sanitize($name);
				
				//generate a random file name to avoid name confilct
				//$fPath = md5(rand() * time()) . ". $ext";
				
				$field = $name;
				if(!$field || strlen($field = trim($field)) == 0){
					$form->setError("file[]", "* File not selected");
				}
				
				$fPath = UPLOAD.'print/';
				
				if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $fPath.$name.'.'.$ext)){
					//echo '<p> The file "'.$_FILES["file"]["name"][$i].'" has been successfully uploaded. Click <a target="_blank" href="'.$fPath. $name .'.'. $ext.'">here</a> to view. </p>';
					$result = 0;
				}else{
					switch ($_FILES['file'] ['error'][$i]){  
						case 1:
							print '<p> The file "'.$_FILES["file"]["name"][$i].'" is bigger than this PHP installation allows, please try <a href="./print.php">again.</a></p>';
							exit;
						case 2:
							print '<p> The file "'.$_FILES["file"]["name"][$i].'" is bigger than this form allows, please try <a href="./print.php">again.</a></p>';
							exit;
						case 3:
							print '<p> Only part of the file "'.$_FILES["file"]["name"][$i].'" was uploaded. Please try <a href="./print.php">again.</a></p>';
							exit;
					}
				}
			}
		}
		
		// IF the file was successfully uploaded than insert meta-data into the database
		if($result == 0){
			global $session;
		
			$client = $_POST["client"];
			$article_id = $_POST["articleid"];
			$publication_date = $_POST["publicationdate"];
			$media_type = $_POST["mediatype"];
			$headline = $_POST["headline"];
			$author = $_POST["author"];
			$circulation = $_POST["circulation"];
			$eav = $_POST["eav"];
			$reach = $_POST["reach"];
			$article_text = $_POST["articletext"];
			
			$name =  substr($_FILES['file']['name'][0], 0);
			$name =  current(explode(".", $name));
			$name = $this->sanitize($name);
			$ext = substr(strrchr($_FILES['file']['name'][0], "."), 1);
			
			$fileurl = $fPath . $name .'.'. $ext;
			
			$result = $session->uploadMetaData($client, $article_id, $publication_date, $media_type, $headline, $author, $circulation, $eav, $reach, $article_text, $fileurl);
		}
		//return $result;
		// Upload meta-data successful
		if($result == 0){
			//$_SESSION['reguname'] = $_POST['user'];
			//$_SESSION['regsuccess'] = true;
			//header("Location: ".$session->referrer);
			//unset($_SESSION['regsuccess']);
			return true;
			//$arr["response"] = "Success".$client.$publication_date;
			//return json_encode($arr);
		}
		
		// Error found with form
		else if($result == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			//header("Location: ".$session->referrer);
		}
		
		// Upload meta-data attempt failed
		else if($result == 2){
			//$_SESSION['reguname'] = $_POST['user'];
			//$_SESSION['regsuccess'] = false;
			//header("Location: ".$session->referrer);
		}
		
		//echo '<script> alert("'.$form->error("articleid").'"); </script>';
		
		return false;
	}
}
