<style>
	#broadcastBar, pressBar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	#broadcastPercent, #pressPercent { position:relative; display:inline-block; top:3px; left:48%; }
	input [type='checkbox']
	{
		width: 15px !important;
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
						<li class="active"><a href="#press" data-toggle="tab">Search Article</a></li>
						<li><a href="#broadcast" data-toggle="tab">Generate Report</a></li>
					</ul>
					
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade in active" id="press">
							<h2 style="margin: 0;">Search Article</h2>
							
							<div class="span6 offset3" style="text-align: center; margin-bottom: 30px;">
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="frmSearchArticle" method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<option>ABSA</option>
															<option>FNB</option>
															<?php displayClients(); ?>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">From Date:</td><td class="inputHolder"><input type="date" name="fromdate" id="fromdate" pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("fromdate"); ?>" /><?php echo $form->error("fromdate"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">To Date:</td><td class="inputHolder"><input type="date" name="todate" id="todate" pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("todate"); ?>" /><?php echo $form->error("todate"); ?></td></tr>
													
													<tr class="detail"><td class="inputLabel">Reviewed Only</td><td class="inputHolder"><input type="checkbox" name="reviewedOnly" id="reviewedOnly" value="true" style="width: 50px !important;" /></td></tr>
													<tr class="detail"><td class="inputLabel">Not Reviewed</td><td class="inputHolder"><input type="checkbox" name="notReviewed" id="notReviewed" value="true" style="width: 50px !important;" /></td></tr>
													
												</table>
												<br />
												<div class="login-actions">
													<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
													<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Search' multiple />
													<br/>
													<img src="<?php echo RESOURCES; ?>img/loading.gif" class="loadingImg loadingImg1" />
												</div>
											</div><!--login fields-->
										</form>
									</div><!-- /.content clearfix -->
							
									<br/>
								</div><!-- /.account-container register stacked -->
							</div><!-- /.span6 -->
							<br/><div id="pressMessage"></div>
						</div> <!-- /.tab-pane -->
						
						<!-- Broadcast tab -->
						<div class="tab-pane fade" id="broadcast">
							<h2 style="margin: 0;">Generate Reports</h2>
							
							<div class="span6 offset3" style="text-align: center">
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="frmGenerateReports" action='<?php echo URL; ?>dashboard/getGeneratedReports' method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<option>ABSA</option>
															<option>FNB</option>
															<?php displayClients(); ?>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">From Date:</td><td class="inputHolder"><input type="date" name="fromdate" id="fromdate" pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("fromdate"); ?>" /><?php echo $form->error("fromdate"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">To Date:</td><td class="inputHolder"><input type="date" name="todate" id="todate" pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("todate"); ?>" /><?php echo $form->error("todate"); ?></td></tr>
													
													<tr class="detail"><td class="inputLabel">Reviewed Only</td><td class="inputHolder"><input type="checkbox" name="reviewedOnly" id="reviewedOnly" value="true" style="width: 50px !important;" /></td></tr>
													<tr class="detail"><td class="inputLabel">Not Reviewed</td><td class="inputHolder"><input type="checkbox" name="notReviewed" id="notReviewed" value="true" style="width: 50px !important;" /></td></tr>
													
												</table>
												<br />
											</div><!--login fields-->
											<div class="login-actions">
												<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
												<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Search' multiple />
												<br/>
												<img src="<?php echo RESOURCES; ?>img/loading.gif" class="loadingImg loadingImg2" />
											</div>
										</form>
									</div><!-- /.content clearfix -->
									
									<br/>
									<div id="pressMessage"></div>
								
								</div><!-- /.account-container register stacked -->
								<br />
								<h2 style="margin: 0;">List of Reports</h2>
								<div id="reportsList">
								</div><!-- /.List reports -->
					
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
			$("li#generatereports").addClass("active");
			
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
			$(function() { //Code segment uploads file to the server
			    $('#frmSearchArticle').submit(function(e) {
				e.preventDefault();
				data = new FormData($('#frmSearchArticle')[0]);
				console.log('Submitting');
				$(".loadingImg1").fadeIn("slow");
				
				$.ajax({
				    type: 'POST',
				    url: '<?php echo URL; ?>dashboard/searchArticle',
				    data: data,
				    cache: false,
				    contentType: false,
				    processData: false,
				    success:function(response){
					$("#pressMessage").html(response.msg);
					
				    },beforeSend: function(){
						$("#pressProgress").show();
						//clear everything
						$("#pressBar").width('0%');
						$("#pressMessage").html("");
						$("#pressPercent").html("0%");
					}, uploadProgress: function(event, position, total, percentComplete){
						$("#pressBar").width(percentComplete+'%');
						$("#pressPercent").html(percentComplete+'%');
					},complete: function(response){
						appendTableHandlers();
						$(".loadingImg1").fadeOut("slow");
						/*$.msgAlert ({
							type: "success"
							, title: "Succesful"
							, text: "The data was successfully retrieved."
						});*/
						$("#frmSearchArticle")[0].reset();
					}, error: function(){
						$("#pressMessage").html("<font color='red'> ERROR: unable to upload files</font>");
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "An Error occured while trying to upload the File and Metadata"
						});
					}
				}).done(function(data) {
				    console.log(data);
				}).fail(function(jqXHR,status, errorThrown) {
				    console.log(errorThrown);
				    console.log(jqXHR.responseText);
				    console.log(jqXHR.status);
				});
			    });
			    
			    refreshList(); //this function populates the list table
			    
			    $('#frmGenerateReports').submit(function(e) {
				e.preventDefault();
				data = new FormData($('#frmGenerateReports')[0]);
				console.log('Submitting');
				$(".loadingImg2").fadeIn("slow");
				$.ajax({
				    type: 'POST',
				    url: '<?php echo URL; ?>dashboard/getGeneratedReports',
				    data: data,
				    cache: false,
				    contentType: false,
				    processData: false,
				    success:function(response){
					
				    },beforeSend: function(){
						$("#pressProgress").show();
						//clear everything
						$("#pressBar").width('0%');
						$("#pressMessage").html("");
						$("#pressPercent").html("0%");
					}, uploadProgress: function(event, position, total, percentComplete){
						$("#pressBar").width(percentComplete+'%');
						$("#pressPercent").html(percentComplete+'%');
					},complete: function(response){
						//alert("Refreshing List");
						refreshList();
						$(".loadingImg2").fadeOut("slow");
					}, error: function(){
						/*
						$("#pressMessage").html("<font color='red'> ERROR: unable to upload files</font>");
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "An Error occured while trying to generate reports"
						});
						*/
					}
				}).done(function(data) {
				    console.log(data);
				}).fail(function(jqXHR,status, errorThrown) {
				    console.log(errorThrown);
				    console.log(jqXHR.responseText);
				    console.log(jqXHR.status);
				});
			    });
			    
			    function refreshList()
			    {
				$.ajax({
				    type: 'POST',
				    url: '<?php echo URL; ?>dashboard/getReportsList',
				    cache: false,
				    contentType: false,
				    processData: false,
				    success:function(response){
					$("#reportsList").html(response.msg);
				    },beforeSend: function(){
						$("#pressProgress").show();
						//clear everything
						$("#pressBar").width('0%');
						$("#pressMessage").html("");
						$("#pressPercent").html("0%");
					}, uploadProgress: function(event, position, total, percentComplete){
						$("#pressBar").width(percentComplete+'%');
						$("#pressPercent").html(percentComplete+'%');
					},complete: function(response){
						/*$.msgAlert ({
							type: "success"
							, title: "Succesful"
							, text: "The list was successfully retrieved."
						});*/
						$("#frmSearchArticle")[0].reset();
					}, error: function(){
						$("#pressMessage").html("<font color='red'> ERROR: unable to upload files</font>");
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "An Error occured while trying to retrieve reports list"
						});
					}
				}).done(function(data) {
				    console.log(data);
				}).fail(function(jqXHR,status, errorThrown) {
				    console.log(errorThrown);
				    console.log(jqXHR.responseText);
				    console.log(jqXHR.status);
				});
			    } 
			    
			    function appendTableHandlers()
			    {
				//alert("appending Handlers");
				//Code that edits the data that is retrieved
				$("a.edit").click(function(e){
					e.preventDefault();
					//alert("XXXXXXXXXXXXXXX");
					$(this).parent().parent().find(".fieldText").fadeOut(200);
					$(this).parent().parent().find(".fieldEdit").delay(200).fadeIn(600);
					$(this).fadeOut(200);
					$(this).parent().find(".save").delay(199).fadeIn(200);
				});
				
				$("a.save").click(function(e){
					e.preventDefault();
					//"<tr><td><span class='fieldText txtUsername'> $uname</span><input type='text' value='$uname'  class='fieldEdit tbxUsername' style='display: none' /></td><td><span class='fieldText txtLevel' >$ulevel</span><input type='text' value='$ulevel'  class='fieldEdit tbxLevel' style='display: none' /></td><td><span class='fieldText txtEmail' >$email</span><input type='text' value='$email' class='fieldEdit tbxEmail' style='display: none' /></td><td>$time</td><td><span class='fieldText txtGroup' >$parent</span><input type='text' value='$parent' class='fieldEdit tbxGroup' style='display: none' /></td><td><a class='del btn btn-small btn-secondary' id='$uname' href='adminprocess.php'><span>delete</span></a><br /><br /><a class='ban btn btn-small btn-secondary' id='$uname' href='adminprocess.php'><span>ban</span></a><br /><br /><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td></tr>";
					var jsonObj = {
						pid: $(this).parent().parent().find(".tbxpid").val(),
						medianame: $(this).parent().parent().find(".tbxmedianame").val(),
						headline: $(this).parent().parent().find(".tbxheadline").val(),
						publicationdate: $(this).parent().parent().find(".tbxpublicationdate").val(),
						mediatype: $(this).parent().parent().find(".tbxmediatype").val(),
						articletext: $(this).parent().parent().find(".tbxarticletext").val()
					};
					
					$(this).parent().parent().find(".txtpid").text(jsonObj.pid);
					$(this).parent().parent().find(".txtmedianame").text(jsonObj.medianame);
					$(this).parent().parent().find(".txtheadline").text(jsonObj.headline);
					$(this).parent().parent().find(".txtpublicationdate").text(jsonObj.publicationdate);
					$(this).parent().parent().find(".txtmediatype").text(jsonObj.mediatype);
					$(this).parent().parent().find(".txtarticletext").text(jsonObj.articletext);
					
					$(this).parent().parent().find(".fieldEdit").fadeOut(200);
					$(this).parent().parent().find(".fieldText").delay(200).fadeIn(600);
					$(this).fadeOut(200);
					$(this).parent().find(".edit").delay(200).fadeIn(200);
					
					
					$.ajax({
						type: 'POST',
						url: '<?php echo URL; ?>dashboard/editData',
						data: jsonObj,
						cache: false,	
						success:function(result){
							if(result.response == "true"){
								$.msgAlert ({
									type: "success"
									, title: "Succesful"
									, text: "The data  was successfully edited."
									//, success: location.reload()
								});  
							}else{
								$.msgAlert ({
									type: "error"
									, title: "Error"
									, text: "Error in editing the data , please check the frequently asked questions or contact support. Sorry for the inconvenience "
									/*, success: location.reload()*/
								});
							}
						},
						error:function(error){
							$.msgAlert ({
								type: "error"
								, title: "Error"
								, text: "Error in editing the data, please check the frequently asked questions or contact support. Sorry for the inconvenience "
								/*, success: location.reload()*/
							});
						}
					}).done(function(data) {
					    console.log(data);
					}).fail(function(jqXHR,status, errorThrown) {
					    console.log(errorThrown);
					    console.log(jqXHR.responseText);
					    console.log(jqXHR.status);
					});
				
				});
				
				//Code that deletes the data when delete is pressed for a particular field
				$("a.del").click(function(e) {
					e.preventDefault();
					
					var id = $(this).attr("id");
					var jsonObj = {
						pid:id
					};
					
					$.msgbox("Are you sure that you want to this data?", {
					  type : 'confirm',
					  buttons : [
					    {type: 'submit', value:'Yes'},
					    {type: 'submit', value:'No'}
					  ]
					}, function(buttonPressed) {
						if(buttonPressed == 'Yes')
						{
							$.ajax({
							    type: 'POST',
							    url: '<?php echo URL; ?>dashboard/deleteData',
							    data: jsonObj,
							    cache: false,	
							    success:function(result){
								//alert(result.msg);
								if(result.response == "true"){
									$("#"+id).parent().parent().fadeOut("slow");
									
									$.msgAlert ({
										type: "success"
										, title: "Succesful"
										, text: "The data was successfully deleted."
										, success: location.reload()
									});
								}else{
									$.msgAlert ({
										type: "error"
										, title: "Error"
										, text: "Error in deleting the data, please check the frequently asked questions or contact support. Sorry for the inconvenience."
										/*, success: location.reload()*/
									});
								}
							    },
							    error:function(error){
								//alert(error.error);
								$.msgAlert ({
									type: "error"
									, title: "Error"
									, text: "Error in deleting data, please check the frequently asked questions or contact support. Sorry for the inconvenience "
									/*, success: location.reload()*/
									});
							    }
							}).done(function(data) {
							    console.log(data);
							}).fail(function(jqXHR,status, errorThrown) {
							    console.log(errorThrown);
							    console.log(jqXHR.responseText);
							    console.log(jqXHR.status);
							});
						}
						else if(buttonPressed == 'No')
						{
							//window.location.href = "./";
						}
						
					});
				});			    
			    }
			});
	
	</script>
