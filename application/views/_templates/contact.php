<style>
	#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	#percent { position:relative; display:inline-block; top:3px; left:48%; }
</style>
<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 * Modified by: Arman G. de Castro, October 3, 2008
 * email: armandecastro@gmail.com
 */
global $session, $form;

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
?>
	
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Contact Us</h2>
						<p>Fill in the form bellow to contact the portal developers.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					<h2 style="margin: 0;">Contact Form</h2>
					
					<div class="span6 offset3" style="text-align: center">
						<div style="width: 550px; margin:0;" class="account-container register stacked">
							<div class="content clearfix">
								<form id="broadcastForm" action='<?php echo URL; ?>dashboard/uploadBroadcast' method="post" enctype="multipart/form-data">
									<div class="login-fields">
										<table class="">
											<tr class="detail"><td class="inputLabel">Name:</td><td class="inputHolder"><input type="text" name="name" id="name" placeholder="Name" value="<?php echo $form->value("name"); ?>" required /><?php echo $form->error("name"); ?></td></tr>
											<tr class="detail"><td class="inputLabel">Email:</td><td class="inputHolder"><input type="email" name="email" id="email" placeholder="Email" required pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" title="Email example: a@b.co" value="<?php echo $form->value("email"); ?>" /><?php echo $form->error("email"); ?></td></tr>
											<tr class="detail"><td class="inputLabel">Subject:</td><td class="inputHolder"><input type="text" name="subject" id="subject" placeholder="Subject" value="<?php echo $form->value("subject"); ?>" required /><?php echo $form->error("subject"); ?></td></tr>
											<tr class="detail"><td class="inputLabel">Message:</td><td class="inputHolder"><textarea style="width:310px;" name="message" id="message" maxlength="500" required /><?php echo $form->value("articletext"); ?></textarea><?php echo $form->error("message"); ?></td></tr>
										</table><br/>
										<div class="login-actions">
											<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
											<input  class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Submit' multiple />
										</div>
									</div><!--login fields-->
								</form>
							</div><!-- /.content clearfix -->
							
							<div id="broadcastProgress" class="progress progress-striped">
								<div id="broadcastBar" class="bar"></div> <!-- /.bar -->
								<div id="broadcastPercent">0%</div >
							</div> <!-- /.progress -->
							<br/>
							<div id="broadcastMessage"></div>
						
						</div><!-- /.account-container register stacked -->
					</div><!-- /.span6 -->
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

