<?php
/**
* @author Mello MP
* view.php
*/
global $form, $session;
?>
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>View</h2>
						<p>Upload videos, sound clips, print documents and online content.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->
		
		<div id="content">
			<div class="container">
				<div class="row">
					
					<object style="float: left;" data="<?php echo URL; ?>public/assignment4.pdf" type="application/pdf" width="640" height="800">
						<!--embed src="<?php echo URL; ?>public/assignment4.pdf" type="application/pdf" alt="file" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">&nbsp; </embed-->
						<p>
							Your web browser doesn't have a PDF plugin. Instead you can 
							<a href="<?php echo URL; ?>public/assignment4.pdf">click here to download the PDF file.</a>
						</p>
					</object>
					
							<div style="float: left;margin-left:0px;" class="" style="text-align: center">
								<div style="width: 550px; margin:0;" class="account-container register stacked">
									<div class="content clearfix">
										<form id="pressForm" action='<?php echo URL; ?>dashboard/uploadPress' method="post" enctype="multipart/form-data">
											<div class="login-fields">
												<table class="">
													<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder">
														<select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required >
															<option>ABSA</option>
															<option>FNB</option>
														</select><?php echo $form->error("client"); ?>
													</td></tr>
													<tr class="detail"><td class="inputLabel">Article ID:</td><td class="inputHolder"><input type="text" name="articleid" id="articleid" placeholder="Article ID" value="<?php echo $form->value("articleid"); ?>" required /><?php echo $form->error("articleid"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Publication Date:</td><td class="inputHolder"><input type="date" name="publicationdate" id="publicationdate" placeholder="Publication Date"  required pattern="^([0-2][0-9][0-9][0-9]/(0[1-9]|1[0-2])/([0-2][0-9]|3[0-1]))$" value="<?php echo $form->value("publicationdate"); ?>" /><?php echo $form->error("publicationdate"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Media Type:</td><td class="inputHolder"><select style="width:323px;" id="mediatype"  name="mediatype" value="<?php echo $form->value("mediatype"); ?>" required><option>Press</option><option>Sound</option><option>Video</option></select><?php echo $form->error("mediatype"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Headline:</td><td class="inputHolder"><input type="text" name="headline" id="headline" placeholder="Headline" value="<?php echo $form->value("headline"); ?>" required /><?php echo $form->error("headline"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Author:</td><td class="inputHolder"><input type="text" name="author" id="author" placeholder="Author" value="<?php echo $form->value("author"); ?>" required /><?php echo $form->error("author"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Circulation:</td><td class="inputHolder"><input type="text" name="circulation" id="circulation" placeholder="Circulation" value="<?php echo $form->value("circulation"); ?>" required /><?php echo $form->error("circulation"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Eav:</td><td class="inputHolder"><input type="text" name="eav" id="eav" placeholder="Eav" value="<?php echo $form->value("eav"); ?>" required /><?php echo $form->error("eav"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Reach:</td><td class="inputHolder"><input type="text" name="reach" id="reach" placeholder="Reach" value="<?php echo $form->value("reach"); ?>" required /><?php echo $form->error("reach"); ?></td></tr>
													<tr class="detail"><td class="inputLabel">Article Text:</td><td class="inputHolder"><textarea style="width:310px;" name="articletext" id="articletext" maxlength="500" required /><?php echo $form->value("articletext"); ?></textarea><?php echo $form->error("articletext"); ?></td></tr>
												</table>
											
												<div class="field">
													<label for="file">Filename: </label>
													<input type="file" name="file[]" id="pressFile" class="login" onchange="check_file_press()" multiple required />
													<?php echo $form->error("file[]"); ?>
												</div> <!-- /.field -->
											 
												<div class="login-actions">
													<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
													<input class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Upload' multiple />
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
					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->