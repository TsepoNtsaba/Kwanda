<?php
/**
* @author Mello MP
* view.php
*/
global $form, $session, $database;

$pid = $session->pid;

$q = "SELECT * FROM meta_data WHERE pid='$pid'";
$result = $database->query($q);

$row1 = mysql_fetch_array($result);

$fileurl = $row1["fileurl"];
$mediatype = $row1["mediatype"];

echo "<script>alert('".$mediatype." _ fileurl: ".$fileurl."');</script>";

?>
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Review upload</h2>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->
		
		<div id="content">
			<div class="container">
				<div class="row">
					<?php
						if($mediatype == "Press"){
							echo '<object style="float: left;" data="'.$fileurl.'" type="application/pdf" width="640" height="800">
									<!--embed src="'.URL.'public/assignment4.pdf" type="application/pdf" alt="file" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">&nbsp; </embed-->
									<p>
										Your web browser does not have a PDF plugin. Instead you can 
										<a href="<?php echo URL; ?>public/assignment4.pdf">click here to download the document.</a>
									</p>
								</object>';
						}
						else
						{
							echo '
								<video width="320" height="240" controls>
									<source src="'.$fileurl.'" type="video/mp4">
									<source src="'.$fileurl.'" type="video/ogg">
										<object style="float: left;" data="'.$fileurl.'" type="application/pdf" width="640" height="800">
											<!--embed src="'.URL.'public/assignment4.pdf" type="application/pdf" alt="file" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">&nbsp; </embed-->
											<p>
												Your web browser does not have a media player plugin. Instead you can 
												<a href="'.$fileurl.'">click here to download the document.</a>
											</p>
										</object>
								</video>';
						}
					?>
							<div style="float: left;margin-left:0px; " class="" style="text-align: center">
								<div style="width: 550px; margin:0; height:795px;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="reviewForm" action='<?php echo URL; ?>dashboard/uploadReview' method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<option>ABSA</option>
															<option>FNB</option>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">Company:</td><td class="inputHolder"><input type="text" name="company" id="company" placeholder="Company" value="<?php echo $form->value("company"); ?>" /><?php echo $form->error("company"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Reputation Variable:</td><td class="inputHolder"><input type="date" name="reputationvariable" id="reputationvariable" placeholder="Reputation Variable"   value="<?php echo $form->value("reputationvariable"); ?>" /><?php echo $form->error("reputationvariable"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Rating:</td><td class="inputHolder"><select style="width:323px;" id="rating"  name="rating" value="<?php echo $form->value("mediatype"); ?>"><option>Positive</option><option>Negative</option><option>Video</option></select><?php echo $form->error("rating"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Business Portfolio:</td><td class="inputHolder"><input type="text" name="businessportfolio" id="businessportfolio" placeholder="Business Portfolio" value="<?php echo $form->value("businessportfolio"); ?>" required /><?php echo $form->error("businessportfolio"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Sponsorship:</td><td class="inputHolder"><input type="text" name="sponsorship" id="sponsorship" placeholder="Sponsorship" value="<?php echo $form->value("sponsorship"); ?>" /><?php echo $form->error("sponsorship"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Spokes Person:</td><td class="inputHolder"><input type="text" name="spokesperson" id="spokesperson" placeholder="Spokes Person" value="<?php echo $form->value("spokesperson"); ?>" /><?php echo $form->error("spokesperson"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Factor Headline:</td><td class="inputHolder"><input type="text" name="factorheadline" id="factorheadline" placeholder="Factor Headline" value="<?php echo $form->value("factorheadline"); ?>" /><?php echo $form->error("factorheadline"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Factor Visual:</td><td class="inputHolder"><input type="text" name="factorvisual" id="factorvisual" placeholder="Factor Visual" value="<?php echo $form->value("factorvisual"); ?>" /><?php echo $form->error("factorvisual"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Factor Highlight:</td><td class="inputHolder"><input type="text" name="factorhighlight" id="factorhighlight" placeholder="Factor Highlight" value="<?php echo $form->value("factorhighlight"); ?>" /><?php echo $form->error("factorhighlight"); ?></td></tr>
												</table> 
												<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>" /><!-- ***************set value to passed pid*************-->
												<div class="login-actions">
													<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
													<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Submit' multiple />
													<img src="<?php echo RESOURCES; ?>img/loading.gif" class="loadingImg loadingImg1" />
												</div>
											</div><!--login fields-->
										</form>
									</div><!-- /.content clearfix -->
									<br/>
									<div id="pressMessage"></div>
								
								</div><!-- /.account-container register stacked -->
							</div><!-- /.span6 -->
					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->

	<script>
		//Uploader Form uploading script
		$(document).ready(function(){
			var options = {
				beforeSend: function(){
					$(".loadingImg1").fadeIn("slow");
				}, uploadProgress: function(event, position, total, percentComplete){
					
				}, success: function(){
					
				}, complete: function(response){
					$(".loadingImg1").fadeOut("slow");
					$("#pressMessage").html("<font color='green'>"+response.responseText+"</font>");
					$.msgAlert ({
						type: "success"
						, title: "Succesful"
						, text: "The data was uploaded successfully."
					});
					$("#reviewForm")[0].reset();
				}, error: function(){
					$("#pressMessage").html("<font color='red'> ERROR: unable to upload files</font>");
					$.msgAlert ({
						type: "error"
						, title: "Error"
						, text: "An Error occured while trying to upload the File and Metadata"
					});
				}
			}; 
			
			$("#reviewForm").ajaxForm(options);
		});
	</script>