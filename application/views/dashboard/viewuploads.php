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
//include("../include/classes/session.php");

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
 global $session, $database, $form;

/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayMetaData(){
	global $database;
	$q = "SELECT * "
		."FROM meta_data";
	
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
	//echo "<table class='table table-bordered table-striped table-highlight'>";
	echo "<table class='metadataTable table table-bordered table-striped table-highlight'>
		<thead><tr><th>Media Name</th><th>Title/Programme</th><th>Publication Date</th><th>Media Type</th><th>Date Recieved</th><th style='width: 400px;' >Article Text</th><th/><th/><th/></tr></thead>";
	echo "<tbody>";
	for($i=0; $i<$num_rows; $i++){
		$medianame  = mysql_result($result,$i,"medianame");
		$headline  = mysql_result($result,$i,"headline");
		$publicationdate = mysql_result($result, $i, "publicationdate");
		$mediatype = mysql_result($result, $i, "mediatype");
		$daterecieved = mysql_result($result,$i,"daterecieved");
		$articletext  = mysql_result($result,$i,"articletext");
		$pid  = mysql_result($result,$i,"pid");

		echo "<tr>
				<td style='display: none;' ><span class='fieldText txtpid'> $pid</span><input type='text' value='$pid'  class='fieldEdit tbxpid' style='display: none' /></td>
				<td><span class='fieldText txtmedianame'> $medianame</span><input type='text' value='$medianame'  class='fieldEdit tbxmedianame' style='display: none' /></td>
				<td><span class='fieldText txtheadline'> $headline</span><input type='text' value='$headline'  class='fieldEdit tbxheadline' style='display: none' /></td>
				<td ><span class='fieldText txtpublicationdate'> $publicationdate</span><input type='text' value='$publicationdate'  class='fieldEdit tbxpublicationdate' style='display: none' /></td>
				<td ><span class='fieldText txtmediatype'> $mediatype</span><input type='text' value='$mediatype'  class='fieldEdit tbxmediatype' style='display: none' /></td>
				<td><span class='fieldText txtdaterecieved' >$daterecieved</span><input type='text' value='$daterecieved'  class='fieldEdit tbxdaterecieved' style='display: none' /></td>
				<td><span class='fieldText txtarticletext' >$articletext</span><textarea class='fieldEdit tbxarticletext' style='display: none'>$articletext</textarea></td>
				<td><a class='del btn btn-small btn-secondary' id='$pid' href='".URL."dashboard/deleteUpload'><span>delete</span></a></td>
				<td><a class='activate btn btn-small btn-secondary' id='$pid' href='".URL."dashboard/reviewUpload' ><span>review</span></a></td>
				<td><a class='edit btn btn-small btn-secondary' href=''><span>edit</span></a><a class='save btn btn-small btn-secondary' href='' style='display: none' ><span>save</span></a></td>
			</tr>
			";
	}
	echo "</tbody></table>";
}
?>		
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Uploads Center</h2>
						<!--p>
							Put text here ...
						</p-->
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="">
						<h3 class="title">Uploads</h3>
						<?php
							displayMetaData();
						?>
					</div> <!-- /.span4 -->
				</div> <!-- /.row -->	
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->
	
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>
	

	<script src="<?php echo THEME; ?>js/plugins/excanvas/excanvas.min.js"></script>
	
	<script type="text/javascript">
	 $(function() {
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
		
		$("a.edit").click(function(e){
			e.preventDefault();
			
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
							, success: location.reload()
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
	 });
	</script>

	<script>
		$(function(){
			//Theme.init ();
			$("li#viewuploads").addClass("active");
		});
	</script>
