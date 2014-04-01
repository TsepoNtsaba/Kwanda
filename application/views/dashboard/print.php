<?php
/**
 * print.php
 *
* Page Print Upload Form
* @author Kwasi KK
* Marabele Enterprise (Pty) Ltd
*/
global $session, $form;
?>
	
		
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Print &amp; pictures</h2>
						<p>View, read and upload documents and images.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->
	
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="span6 offset3" style="text-align: center">
						<div style="width: 550px; margin:0;" class="account-container register stacked">
							
							<div class="content clearfix">
								
								<form id="myForm" action='<?php echo URL; ?>dashboard/uploadPrint' method="post" enctype="multipart/form-data">
									<!--span class="label label-secondary">Uploader</span>&nbsp;&nbsp; -->
									<div class="login-fields">
										
										<table class="table">
											<tr class="detail"><td class="inputLabel">Select Client:</td><td class="inputHolder"><select style="width:323px;" id="client" name="client" value="<?php echo $form->value("client"); ?>" required ><option>ABSA</option><option>FNB</option></select><?php echo $form->error("client"); ?></td></tr>
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
											<input type="file" name="file[]" id="file" class="login" onchange="check_file()" multiple required />
											<?php echo $form->error("file[]"); ?>
										 </div>
										 <br/>
										 <br/>
										 
										 <div class="login-actions">
											<input type="hidden" name="MAX_FILE_SIZE" value="2147483648" />
											<input  class="btn btn-large btn-secondary" id='submit'  type='submit' name='submit' value='Upload' multiple />
										 </div>
									
									</div><!--login fields-->
									
									
								</form><br>
								<br>
							</div><!--content clearfix-->
							<div id="progress" class="progress progress-striped">
								<div id="bar" class="bar"></div> <!-- /.bar -->
								<div id="percent">0%</div >
							</div> <!-- /.progress -->
							<br/>
							<div id="message"></div>
							
						</div><!--account-container register stacked-->
					</div><!-- /.span6 -->
					<!--p style="text-align: center"><a href="#wrapper" class="top">Back to top</a></p-->
				</div><!-- /.row -->		
			</div> <!-- /.container -->
		</div><!-- /#content -->
	</div> <!--wrapper-->
	
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>
	<!--style>
		.inputLabel
		{
			text-align: right;
		}
		.inputHolder
		{
			text-align: left;
		}
	</style-->
	<script src="<?php echo THEME; ?>js/Theme.js"></script>
	<!--script>
		//This function turns form data into a json object
		$.fn.serializeObject = function()
		{
		    var o = {};
		    var a = this.serializeArray();
		    $.each(a, function() {
			if (o[this.name] !== undefined) {
			    if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			    }
			    o[this.name].push(this.value || '');
			} else {
			    o[this.name] = this.value || '';
			}
		    });
		    return o;
		};
		
		$(function() {
		    $('#myForm').submit(function(e) {
			str=document.getElementById('file').value;
			alert("Form Submitted: " + str); 
			
			$("#loadingImage").show(); 
			
			str=document.getElementById('file').value.toUpperCase();
			if(!str || str == ''){
				alert("Please select a file before you proceed to upload");
				return false;
			}
			//return true;
			
			var obj = $("#myForm").serializeObject();
			alert(obj.file);
			
			var form = $(this);
			var fd = new FormData();
			fd.append("file", $("#file")[0].files[0]);
			$.ajax({
			    type: form.attr("method"),
			    url: form.attr("action"),
			    data: fd,
			    processData: false,
			    contentType: false,
			    cache: false,
			    success: function(result){
				alert("Form Success: "+result.response);
				if(result.response == "unsuccessful")
					return true;
				$.msgbox('The file(s) have been successfully uploaded. To continue to the analysis process, click continue.', {
				  type : 'info',
				  buttons : [
				    {type: 'submit', value:'<< Back'},
				    {type: 'submit', value:'Continue >>'}
				  ]
				}, function(buttonPressed) {
					if(buttonPressed == '<< Back')
					{
					}
					else if(buttonPressed == 'Continue >>')
					{
						window.location.href = "../charts.php";
					}
					
				});
			    },
			    error:function(error){
				alert("Upload Error: "+ error.error);
				//return true;
			    }
			});
			e.preventDefault();
			//return false;
			
		    });
		});
	</script-->
	<script type="text/javascript">
		function check_file(){
			//Image file formats
			str=document.getElementById('file').value.toUpperCase();
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
				document.getElementById('file').value='';
			}
	    }
	</script>
	
	<script>
		//Uploader Form uploading script
		$(document).ready(function(){
			var options = { 
				beforeSend: function(){
					$("#progress").show();
					//clear everything
					$("#bar").width('0%');
					$("#message").html("");
					$("#percent").html("0%");
				}, uploadProgress: function(event, position, total, percentComplete){
					$("#bar").width(percentComplete+'%');
					$("#percent").html(percentComplete+'%');
				}, success: function(){
					$("#bar").width('100%');
					$("#percent").html('100%');
				}, complete: function(response){
					$("#message").html("<font color='green'>"+response.responseText+"</font>");
				}, error: function(){
					$("#message").html("<font color='red'> ERROR: unable to upload files</font>");
				}
			}; 

			//$("#myForm").ajaxForm(options);
		});

	</script>

	<script>
		$(function(){
			Theme.init ();
			$("li#upload").addClass("active");
		});
	</script>
