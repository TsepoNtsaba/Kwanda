<style>
	#broadcastBar, pressBar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	#broadcastPercent, #pressPercent { position:relative; display:inline-block; top:3px; left:48%; }
	.checkbx
	{
		width: 15px;
	}
</style>
<?php
global $session, $form;

/**
 * displayClients - Displays the clients in
 * a nicely formatted drop-down list.
 */
 function displayClients(){
	global $database;
	$q = "SELECT * "
		."FROM ".TBL_USERS." WHERE userlevel = 1 ORDER BY userlevel DESC,username";
	
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
	//echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
	//echo "<table class='table table-bordered table-striped table-highlight'>";
	//echo "<thead><tr><th>Username</th><th>Level</th><th>Email</th><th>Group</th><th/><th/><th/></tr></thead>";
	//echo "<tbody>";
	for($i=0; $i<$num_rows; $i++){
		$uid  = mysql_result($result,$i,"uid");
		$uname  = mysql_result($result,$i,"username");
		$upass = mysql_result($result, $i, "password");
		$userid = mysql_result($result, $i, "userid");
		$ulevel = mysql_result($result,$i,"userlevel");
		$email  = mysql_result($result,$i,"email");
		$time   = mysql_result($result,$i,"timestamp");
		$parent = mysql_result($result,$i,"parent_directory");

		echo "<option class='clients' value='$uname'>$uname</option>";
	}
	//echo "</tbody><br>";
}

?>
	
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Generate reports panel</h2>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#searcharticle" data-toggle="tab">Search Article</a></li>
						<li><a href="#generatereports" data-toggle="tab">Generate Reports</a></li>
					</ul>
		
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade in active" id="searcharticle">
							<h2 style="margin: 0;">Search Article</h2>
							
							<div class="span6 offset3" style="text-align: center">
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="pressForm" action='<?php echo URL; ?>dashboard/uploadPress' method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<!--option>ABSA</option>
															<option>FNB</option-->
															<?php displayClients(); ?>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">From Date:</td><td class="inputHolder"><input type="date" name="fromdate" id="fromdate" required pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("fromdate"); ?>" /><?php echo $form->error("fromdate"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">To Date:</td><td class="inputHolder"><input type="date" name="todate" id="todate" required pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("todate"); ?>" /><?php echo $form->error("todate"); ?></td></tr>
													
													<tr class="detail"><td class="inputLabel"></td><td class="inputHolder"><input type="checkbox" name="reviewed" value="reviewedOnly" required />Reviewed Only</td></tr>
													<tr class="detail"><td class="inputLabel"></td><td class="inputHolder"><input type="checkbox" name="reviewed" value="notReviewed" required />Not Reviewed</td></tr>
													
												</table>
											
												<div class="login-actions">
													<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
													<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Search' multiple />
												</div>
											</div><!--login fields-->
										</form>
									</div><!-- /.content clearfix -->
							
									<div id="pressProgress" class="progress progress-striped">
										<div id="pressBar" class="bar"></div> <!-- /.bar -->
										<div id="pressPercent">0%</div >
									</div> <!-- /.progress -->
									<br/>
									<div id="pressMessage"></div>
								
								</div><!-- /.account-container register stacked -->
							</div><!-- /.span6 -->
							
						</div> <!-- /.tab-pane -->
						
						<!-- generatereports tab -->
						<div class="tab-pane fade" id="generatereports">
							<h2 style="margin: 0;">Generate Reports</h2>
							
							<div class="span6 offset3" style="text-align: center">
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="pressForm" action='<?php echo URL; ?>dashboard/uploadPress' method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<!--option>ABSA</option>
															<option>FNB</option-->
															<?php displayClients(); ?>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">From Date:</td><td class="inputHolder"><input type="date" name="fromdate" id="fromdate" required pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("fromdate"); ?>" /><?php echo $form->error("fromdate"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">To Date:</td><td class="inputHolder"><input type="date" name="todate" id="todate" required pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("todate"); ?>" /><?php echo $form->error("todate"); ?></td></tr>
													
													<tr class="detail"><td class="inputLabel"></td><td class="inputHolder"><input type="checkbox" name="reviewed" class="checkbx" value="reviewedOnly" required />Reviewed Only</td></tr>
													<tr class="detail"><td class="inputLabel"></td><td class="inputHolder"><input type="checkbox" name="reviewed" class="checkbx" value="notReviewed" required />Not Reviewed</td></tr>
													
												</table>
											
												<div class="login-actions">
													<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
													<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Search' multiple />
												</div>
											</div><!--login fields-->
										</form>
									</div><!-- /.content clearfix -->
							
									<div id="pressProgress" class="progress progress-striped">
										<div id="pressBar" class="bar"></div> <!-- /.bar -->
										<div id="pressPercent">0%</div >
									</div> <!-- /.progress -->
									<br/>
									<div id="pressMessage"></div>
								
								</div><!-- /.account-container register stacked -->
								
								<h2 style="margin: 0;">List Reports</h2>
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										List
									</div><!-- /.content clearfix -->
									
									<div id="broadcastProgress" class="progress progress-striped">
										<div id="broadcastBar" class="bar"></div> <!-- /.bar -->
										<div id="broadcastPercent">0%</div >
									</div> <!-- /.progress -->
									<br/>
									<div id="broadcastMessage"></div>
								
								</div><!-- /.account-container register stacked -->
							</div><!-- /.span6 -->						
						</div> <!-- /.tab-pane -->
					</div> <!-- /.tab-content -->
					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->
	
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>

	<script>
		$(function(){
			Theme.init ();
			$("li#upload").addClass("active");
			
			$("option.clients").each(function(){
				$(this).text(function(i, oldText){
					return $(this)[0].value.toUpperCase();
				});
			});
		});
	</script>
	
	<script type="text/javascript">
		function check_file_press(){
			//Image file formats
			str=document.getElementById('pressFile').value.toUpperCase();
			suffix=".JPG";
			suffix2=".JPEG";
			suffix3=".JPE";
			suffix4=".JFIF";
			suffix5=".TIF";
			suffix6=".TIFF";
			suffix7=".ICO";
			suffix8=".DIB";
			suffix9=".BMP";
			suffix10=".GIF";
			suffix11=".PNG";
			suffix12=".IMG";
			suffix13=".BMP";
			suffix14=".ICO";
			
			//Documemnt file formats
			suffix15=".DJVU";
			suffix16=".DJV";
			suffix17=".DBK";
			suffix18=".XML";
			suffix19=".FB2";
			suffix20=".DOCX";
			suffix21=".ODT";
			suffix22=".PDF";
			suffix23="DOC";
		
			
			if(!(str.indexOf(suffix, str.length - suffix.length) !== -1||str.indexOf(suffix2, str.length - suffix2.length) !== -1 ||str.indexOf(suffix3, str.length - suffix3.length) !== -1||str.indexOf(suffix4, str.length - suffix4.length) !== -1||str.indexOf(suffix5, str.length - suffix5.length) !== -1||str.indexOf(suffix5, str.length - suffix5.length) !== -1||str.indexOf(suffix6, str.length - suffix6.length) !== -1||str.indexOf(suffix6, str.length - suffix6.length) !== -1||str.indexOf(suffix7, str.length - suffix7.length) !== -1
				||str.indexOf(suffix8, str.length - suffix8.length) !== -1||str.indexOf(suffix9, str.length - suffix9.length) !== -1||str.indexOf(suffix10, str.length - suffix10.length) !== -1||str.indexOf(suffix11, str.length - suffix11.length) !== -1||str.indexOf(suffix12, str.length - suffix12.length) !== -1||str.indexOf(suffix13, str.length - suffix13.length) !== -1||str.indexOf(suffix14, str.length - suffix14.length) !== -1||str.indexOf(suffix15, str.length - suffix15.length) !== -1
				||str.indexOf(suffix16, str.length - suffix16.length) !== -1 ||str.indexOf(suffix17, str.length - suffix17.length) !== -1 ||str.indexOf(suffix18, str.length - suffix18.length) !== -1 ||str.indexOf(suffix19, str.length - suffix19.length) !== -1 ||str.indexOf(suffix20, str.length - suffix20.length) !== -1 ||str.indexOf(suffix21, str.length - suffix21.length) !== -1 ||str.indexOf(suffix22, str.length - suffix22.length) !== -1 
				||str.indexOf(suffix23, str.length - suffix23.length) !== -1)) 
			{
				alert('File type not allowed,\nAllowed file: Popular image file formats and document file formats such as *.jpg, *.jpeg, *.png, *.pdf, *.doc etc.');
				document.getElementById('pressFile').value='';
			}
	    }
	</script>
	
	<script type="text/javascript">
		function check_file_broadcast(){
			//Audio file formats
			str=document.getElementById('broadcastFile').value.toUpperCase();
			suffix=".3GP";
			suffix2=".AIFF";
			suffix3=".MP3";
			suffix4=".WAV";
			suffix5=".FLAC";
			suffix6=".M4A";
			suffix7=".OGG";
			suffix8=".WMA";
			suffix9=".RA";
			suffix10=".RAM";
			suffix11=".AMR";
			suffix12=".DSS";
			suffix13=".DVF";
			suffix14=".DSS";
			
			// Video file formats
			suffix15=".AAF";
			suffix16=".3GP";
			suffix17=".AVI";
			suffix18=".FLV";
			suffix19=".OGG";
			suffix20=".WMV";
			suffix21=".MPEG";
			suffix22=".M4V";
			suffix23=".M1V";
			suffix24=".M2V";
			suffix25=".SOL";
			suffix26=".MOV";
			suffix27=".MPG";
			suffix28=".MP4";
			suffix29=".MKV";
			
			if(!(str.indexOf(suffix, str.length - suffix.length) !== -1 || str.indexOf(suffix2, str.length - suffix2.length) !== -1 || str.indexOf(suffix3, str.length - suffix3.length) !== -1
				|| str.indexOf(suffix4, str.length - suffix4.length) !== -1 || str.indexOf(suffix5, str.length - suffix5.length) !== -1 || str.indexOf(suffix6, str.length - suffix6.length) !== -1 
				|| str.indexOf(suffix7, str.length - suffix7.length) !== -1 || str.indexOf(suffix8, str.length - suffix8.length) !== -1 || str.indexOf(suffix9, str.length - suffix9.length) !== -1
				|| str.indexOf(suffix10, str.length - suffix10.length) !== -1 || str.indexOf(suffix11, str.length - suffix11.length) !== -1 || str.indexOf(suffix12, str.length - suffix12.length) !== -1 
				|| str.indexOf(suffix13, str.length - suffix13.length) !== -1 || str.indexOf(suffix14, str.length - suffix14.length) !== -1 || str.indexOf(suffix15, str.length - suffix15.length) !== -1 
				|| str.indexOf(suffix16, str.length - suffix16.length) !== -1 || str.indexOf(suffix17, str.length - suffix17.length) !== -1 || str.indexOf(suffix18, str.length - suffix18.length) !== -1
				|| str.indexOf(suffix19, str.length - suffix19.length) !== -1 || str.indexOf(suffix20, str.length - suffix20.length) !== -1 || str.indexOf(suffix21, str.length - suffix21.length) !== -1 
				|| str.indexOf(suffix22, str.length - suffix22.length) !== -1 || str.indexOf(suffix23, str.length - suffix23.length) !== -1 || str.indexOf(suffix24, str.length - suffix24.length) !== -1 
				|| str.indexOf(suffix25, str.length - suffix25.length) !== -1 || str.indexOf(suffix26, str.length - suffix26.length) !== -1 || str.indexOf(suffix27, str.length - suffix27.length) !== -1
				|| str.indexOf(suffix28, str.length - suffix28.length) !== -1 || str.indexOf(suffix29, str.length - suffix29.length) !== -1))
			{
				alert('File type not allowed,\nAllowed file: Popular video formats and audio file formats such as *.mp3, *.wav, *.3gp, *.wma, *.flac, *.avi, *.mp4, *.3gp, *.flv, *.wmv, *.mkv etc.');
				document.getElementById('broadcastFile').value='';
			}
		}
	</script>
	
	<script>
		//Uploader Form uploading script
		$(document).ready(function(){
			var options = {
				beforeSend: function(){
					$("#pressProgress").show();
					//clear everything
					$("#pressBar").width('0%');
					$("#pressMessage").html("");
					$("#pressPercent").html("0%");
				}, uploadProgress: function(event, position, total, percentComplete){
					$("#pressBar").width(percentComplete+'%');
					$("#pressPercent").html(percentComplete+'%');
				}, success: function(){
					$("#pressBar").width('100%');
					$("#pressPercent").html('100%');
				}, complete: function(response){
					$("#pressMessage").html("<font color='green'>"+response.responseText+"</font>");
					$.msgAlert ({
						type: "success"
						, title: "Succesful"
						, text: "The File and Metadata were uploaded successfully."
					});
					$("#pressForm")[0].reset();
				}, error: function(){
					$("#pressMessage").html("<font color='red'> ERROR: unable to upload files</font>");
					$.msgAlert ({
						type: "error"
						, title: "Error"
						, text: "An Error occured while trying to upload the File and Metadata"
					});
				}
			}; 
			
			$("#pressForm").ajaxForm(options);
		});
	</script>
	
	<script>
		//Uploader Form uploading script
		$(document).ready(function(){
			var options = {
				beforeSend: function(){
					$("#broadcastProgress").show();
					//clear everything
					$("#broadcastBar").width('0%');
					$("#broadcastMessage").html("");
					$("#broadcastPercent").html("0%");
				}, uploadProgress: function(event, position, total, percentComplete){
					$("#broadcastBar").width(percentComplete+'%');
					$("#broadcastPercent").html(percentComplete+'%');
				}, success: function(){
					$("#broadcastBar").width('100%');
					$("#broadcastPercent").html('100%');
				}, complete: function(response){
					$("#broadcastMessage").html("<font color='green'>"+response.responseText+"</font>");
					$.msgAlert ({
						type: "success"
						, title: "Succesful"
						, text: "The File and Metadata were uploaded successfully."
					});
					$("#broadcastForm")[0].reset();
				}, error: function(){
					$("#broadcastMessage").html("<font color='red'> ERROR: unable to upload files</font>");
					$.msgAlert ({
						type: "error"
						, title: "Error"
						, text: "An Error occured while trying to upload the File and Metadata"
					});
				}
			}; 
			
			$("#broadcastForm").ajaxForm(options);
		});

	</script>
