<?php
/**
* Class UploadModel
* @author Kwasi KK
* Marabele Enterprise (Pty) Ltd
*/
header('Content-type: application/json');

class AnalysisModel{
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
	public function searchArticle(){
		global $session, $form, $mailer, $database;

		$client = $_POST["client"];
		
		if(isset($_POST["fromdate"]))
		{
			$date = $_POST["fromdate"];
			$fromdate = "publicationdate > '$date' AND";
		}
		else
		{
			$fromdate = "";
		}
		
		if(isset($_POST["todate"]))
		{
			$date = $_POST["todate"];
			$todate = "publicationdate < '$date' AND";
		}
		else
		{
			$todate = "";
		}
		
		if(isset($_POST["reviewedOnly"]))
		{
			if($_POST["reviewedOnly"] == "true")
			{
				$q = "SELECT * FROM meta_data WHERE client='$client' AND $fromdate $todate reviewed=1";
			}
		}
		else if(isset($_POST["notReviewed"]))
		{
			if($_POST["notReviewed"] == "true")
			{
				$q = "SELECT * FROM meta_data WHERE client='$client' AND $fromdate $todate AND reviewed=0";
			}		
		}
		else
		{
			$q = "SELECT * FROM meta_data WHERE client='$client'";
		}
		
		$result = $database->query($q);
		/* Error occurred, return given name by default */
		$num_rows = mysql_numrows($result);
		if(!$result || ($num_rows < 0)){
			echo "Error displaying info";
			return;
		}
		if($num_rows == 0){
			echo "Database table empty";
			return;
		}

		/* Display table contents */
		$returnVar = "<table class='metadataTable table table-bordered table-striped table-highlight'>
			<thead><tr><th>Media Name</th><th>Title/Programme</th><th>Publication Date</th><th>Media Type</th><th>Date Recieved</th><th style='width: 400px;' >Article Text</th><th/><th/><th/></tr></thead>
			<tbody>";
		for($i=0; $i<$num_rows; $i++){
			$medianame  = mysql_result($result,$i,"medianame");
			$headline  = mysql_result($result,$i,"headline");
			$publicationdate = mysql_result($result, $i, "publicationdate");
			$mediatype = mysql_result($result, $i, "mediatype");
			$daterecieved = mysql_result($result,$i,"daterecieved");
			$articletext  = mysql_result($result,$i,"articletext");
			$pid  = mysql_result($result,$i,"pid");

			$returnVar .= "<tr>
					<td style='display: none;' ><span class='fieldText txtpid'> $pid</span><input type='text' value='$pid'  class='fieldEdit tbxpid' style='display: none' /></td>
					<td><span class='fieldText txtmedianame'> $medianame</span><input type='text' value='$medianame'  class='fieldEdit tbxmedianame' style='display: none' /></td>
					<td><span class='fieldText txtheadline'> $headline</span><input type='text' value='$headline'  class='fieldEdit tbxheadline' style='display: none' /></td>
					<td ><span class='fieldText txtpublicationdate'> $publicationdate</span><input type='text' value='$publicationdate'  class='fieldEdit tbxpublicationdate' style='display: none' /></td>
					<td ><span class='fieldText txtmediatype'> $mediatype</span><input type='text' value='$mediatype'  class='fieldEdit tbxmediatype' style='display: none' /></td>
					<td><span class='fieldText txtdaterecieved' >$daterecieved</span><input type='text' value='$daterecieved'  class='fieldEdit tbxdaterecieved' style='display: none' /></td>
					<td><span class='fieldText txtarticletext' >$articletext</span><textarea class='fieldEdit tbxarticletext' style='display: none'>$articletext</textarea></td>
					<td><a class='activate btn btn-small btn-secondary' id='$pid' href='".URL."dashboard/reviewUpload/$pid'><span>review</span></a></td>
					<td><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td>
					<td><a class='del btn btn-small btn-secondary' id='$pid' href='".URL."dashboard/deleteUpload'><span>delete</span></a></td>
				</tr>
				";
		}
		$returnVar .= "</tbody></table>";
		
		return json_encode(Array("response" => "true", "msg" => $returnVar));
	}
	
	/**
	* Takes data from the database and conversts it to excel document
	*/
	public function generateReports(){
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		global $database, $session;
		
		$client = $_POST["client"];
		
		if(isset($_POST["fromdate"]))
		{
			$date = $_POST["fromdate"];
			$fromdate = "publicationdate > '$date' AND";
		}
		else
		{
			$fromdate = "";
		}
		
		if(isset($_POST["todate"]))
		{
			$date = $_POST["todate"];
			$todate = "publicationdate < '$date' AND";
		}
		else
		{
			$todate = "";
		}
		
		if(isset($_POST["reviewedOnly"]))
		{
			if($_POST["reviewedOnly"] == "true")
			{
				$q = "SELECT * FROM meta_data WHERE client='$client' AND $fromdate $todate reviewed=1";
			}
		}
		else if(isset($_POST["notReviewed"]))
		{
			if($_POST["notReviewed"] == "true")
			{
				$q = "SELECT * FROM meta_data WHERE client='$client' AND $fromdate $todate AND reviewed=0";
			}		
		}
		else
		{
			$q = "SELECT * FROM meta_data WHERE client='$client'";
		}
		
		$result = $database->query($q);
		/* Error occurred, return given name by default */
		$num_rows = mysql_numrows($result);
		if(!$result || ($num_rows < 0)){
			echo "Error displaying info";
			return;
		}
		if($num_rows == 0){
			echo "Database table empty";
			return;
		}
		
		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		/** Include PHPExcel */
		//require_once URL.'application/libs/classes/PHPExcelClass/PHPExcel.php';
		
		// Create new PHPExcel object
		//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		//echo date('H:i:s') , " Set document properties" , EOL;
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			 ->setLastModifiedBy("Maarten Balliauw")
			 ->setTitle("PHPExcel Test Document")
			 ->setSubject("PHPExcel Test Document")
			 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
			 ->setKeywords("office PHPExcel php")
			 ->setCategory("Test result file");
		
		// Add some data
		//echo date('H:i:s') , " Add some data" , EOL;
		$objPHPExcel->setActiveSheetIndex(0)
			    ->setCellValue('A1', 'Client Name')
			    ->setCellValue('B1', 'Article ID')
			    ->setCellValue('C1', 'Publication Date')
			    ->setCellValue('D1', 'Media Type')
			    ->setCellValue('E1', 'Media Name')
			    ->setCellValue('F1', 'Headline')
			    ->setCellValue('G1', 'Author')
			    ->setCellValue('H1', 'Circulation')
			    ->setCellValue('I1', 'Eav')
			    ->setCellValue('J1', 'Reach')
			    ->setCellValue('K1', 'Show Name')
			    ->setCellValue('L1', 'Start Time')
			    ->setCellValue('M1', 'Duration')
			    ->setCellValue('N1', 'Article Text')
			    ->setCellValue('O1', 'File Location')
			    ->setCellValue('P1', 'Date Recieved')
			    ->setCellValue('Q1', 'Company')
			    ->setCellValue('R1', 'Reputation')
			    ->setCellValue('S1', 'Rating')
			    ->setCellValue('T1', 'Business')
			    ->setCellValue('U1', 'Sponsor')
			    ->setCellValue('V1', 'Spokes Person')
			    ->setCellValue('W1', 'Factor Headline')
			    ->setCellValue('X1', 'Factor Visual')
			    ->setCellValue('Y1', 'Factor Highlight')
			    ->setCellValue('Z1', 'Reviewed');
			    
			for($i=0; $i<$num_rows; $i++){
				$j = $i+2;
				$objPHPExcel->setActiveSheetIndex(0)
				    ->setCellValue('A'.$j, mysql_result($result,$i,"client"))
				    ->setCellValue('B'.$j, mysql_result($result,$i,"articleid"))
				    ->setCellValue('C'.$j, mysql_result($result,$i,"publicationdate"))
				    ->setCellValue('D'.$j, mysql_result($result,$i,"mediatype"))
				    ->setCellValue('E'.$j, mysql_result($result,$i,"medianame"))
				    ->setCellValue('F'.$j, mysql_result($result,$i,"headline"))
				    ->setCellValue('G'.$j, mysql_result($result,$i,"author"))
				    ->setCellValue('H'.$j, mysql_result($result,$i,"circulation"))
				    ->setCellValue('I'.$j, mysql_result($result,$i,"eav"))
				    ->setCellValue('J'.$j, mysql_result($result,$i,"reach"))
				    ->setCellValue('K'.$j, mysql_result($result,$i,"showname"))
				    ->setCellValue('L'.$j, mysql_result($result,$i,"starttime"))
				    ->setCellValue('M'.$j, mysql_result($result,$i,"duration"))
				    ->setCellValue('N'.$j, mysql_result($result,$i,"articletext"))
				    ->setCellValue('O'.$j, mysql_result($result,$i,"fileurl"))
				    ->setCellValue('P'.$j, mysql_result($result,$i,"daterecieved"))
				    ->setCellValue('Q'.$j, mysql_result($result,$i,"company"))
				    ->setCellValue('R'.$j, mysql_result($result,$i,"reputation"))
				    ->setCellValue('S'.$j, mysql_result($result,$i,"rating"))
				    ->setCellValue('T'.$j, mysql_result($result,$i,"business"))
				    ->setCellValue('U'.$j, mysql_result($result,$i,"sponsor"))
				    ->setCellValue('V'.$j, mysql_result($result,$i,"spokesperson"))
				    ->setCellValue('W'.$j, mysql_result($result,$i,"factorheadline"))
				    ->setCellValue('X'.$j, mysql_result($result,$i,"factorvisual"))
				    ->setCellValue('Y'.$j, mysql_result($result,$i,"factorhighlight"))
				    ->setCellValue('Z'.$j, mysql_result($result,$i,"reviewed"));
			}
			
			// Rename worksheet
			//echo date('H:i:s') , " Rename worksheet" , EOL;
			$objPHPExcel->getActiveSheet()->setTitle($client.date('s'));
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			// Save Excel 2007 file
			//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
			$callStartTime = microtime(true);

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//date('H:i:s');
			$reportUrl = "./public/clientuploads/generatedReports/".date('Y-m-d')."_".$client."_".$session->generateRandStr(5).".php";
			$reportUrl = str_replace('.php', '.xlsx',$reportUrl);
			
			$objWriter->save($reportUrl);
			$callEndTime = microtime(true);
			$callTime = $callEndTime - $callStartTime;
			
			echo date('Y-m-d') , " File written to " , $reportUrl , EOL;
			echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
			// Echo memory usage
			echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
			
			$q2 = "INSERT INTO reports (reporturl) VALUES ('$reportUrl') ";
			$result = $database->query($q2);
			
			echo $result;
	}
	
	/**
	* Upload file and its metadata
	*/
	public function getReportsList(){
		global $session, $form, $mailer, $database;

		$q = "SELECT * FROM reports ORDER BY reportsid DESC";
		
		$result = $database->query($q);
		/* Error occurred, return given name by default */
		$num_rows = mysql_numrows($result);
		if(!$result || ($num_rows < 0)){
			echo "Error displaying info";
			return;
		}
		if($num_rows == 0){
			echo "Database table empty";
			return;
		}

		/* Display table contents */
		$returnVar = "<table class='metadataTable table table-bordered table-striped table-highlight'>
			<thead><tr><th>Report ID</th><th>Report Location</th><th></th></tr></thead>
			<tbody>";
		for($i=0; $i<$num_rows; $i++){
			$reportsid  = mysql_result($result,$i,"reportsid");
			$reporturl  = mysql_result($result,$i,"reporturl");
			
			$returnVar .= "<tr>
					<td><span class='fieldText txtreportsid'> $reportsid</span></td>
					<td><span class='fieldText txtreporturl'> $reporturl</span></td>
					<td><a class='del btn btn-small btn-secondary' href='".URL."$reporturl'><span>Download</span></a></td>
				</tr>
				";
		}
		$returnVar .= "</tbody></table>";
		
		return json_encode(Array("response" => "true", "msg" => $returnVar));
	}
	
}
