<?php
/**
 * Settings.php
 *To edit user setings such as password and username
 *You can also manage the web crawler settings and your index collections(LucidWorks)
 *
 *
 */
global $session;
global $form;

if(!$session->logged_in){
	header("Location: ".URL);
}
?>		

		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Settings</h2>
						<p>Edit user settings and manage the web crawler.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
				
				<div class="row">
					<div class="tabbable">
						<div class="span3">
							<ul class="nav nav-tabs nav-stacked">
								<li class="active">
									<a href="#tab1" data-toggle="tab">
										<i class="icon-user"></i>
										Basic
										<i class="icon-chevron-right"></i>
									</a>              			              	
								</li>
								<li>
									<a href="#tab2" data-toggle="tab">
										<i class="icon-wrench"></i>
										Web Crawler
										<i class="icon-chevron-right"></i>
									</a>              		
								</li>
								<!--<li>
									<a href="#tab3" data-toggle="tab">
										<i class="icon-envelope"></i>
										Messaging
										<i class="icon-chevron-right"></i>
									</a>              		
								</li>
								<li>
									<a href="#tab4" data-toggle="tab">
										<i class="icon-money"></i>
										Payments
										<i class="icon-chevron-right"></i>
									</a>              		
								</li>
								<li>
									<a href="#tab5" data-toggle="tab">
										<i class="icon-bar-chart"></i>
										Reports
										<i class="icon-chevron-right"></i>
									</a>              		
								</li-->
							</ul>
						</div> <!-- /.span3 -->
			
						<div class="">
							<div class="tab-content" style="padding-left: 20px;">
								<div class="tab-pane active" id="tab1">
									<h2>Edit Basic Settings</h2>
									<p>Edit user settings<p>
									<br />
									
									<form id="edit-profile" class="form-horizontal" action="<?php echo URL; ?>dashboard/editUserAccount" method="POST">
										<fieldset>
											<div class="control-group">
												<label class="control-label" for="username">Username</label>
												<div class="controls">
													<input type="text" class="input-medium disabled" id="username" value="<?php echo $session->username; ?>" disabled="">
													<p class="help-block">Your username is for logging in and cannot be changed.</p>
												</div> <!-- /controls -->				
											</div> <!-- /control-group -->
									
											<!--div class="control-group">											
												<label class="control-label" for="firstname">First Name</label>
												<div class="controls">
													<input type="text" class="input-medium" id="firstname" value="Rod">
												</div> <!-- /controls -->				
											<!--/div> <!-- /control-group -->
									
											<!--div class="control-group">											
												<label class="control-label" for="lastname">Last Name</label>
												<div class="controls">
													<input type="text" class="input-medium" id="lastname" value="Howard">
												</div> <!-- /controls -->				
											<!--/div> <!-- /control-group -->
									
											<div class="control-group">											
												<label class="control-label" for="email">Email Address</label>
												<div class="controls">
													<input type="text" name="email" class="input-large" id="email" value="<?php echo $session->userinfo['email']; ?>" required pattern="^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{1,})*\.([a-z]{2,}){1}$" />
													<?php echo $form->error("email"); ?>
												</div> <!-- /controls -->				
											</div> <!-- /control-group -->
									
											<br><br>
									
											<div class="control-group">											
												<label class="control-label" for="password1">Current Password</label>
												<div class="controls">
													<input type="password" name="curpass" class="input-medium" id="password1" value="<?php echo $form->value("curpass"); ?>" required />
													<?php echo $form->error("curpass"); ?>
												</div> <!-- /controls -->				
											</div> <!-- /control-group -->
									
											<div class="control-group">											
												<label class="control-label" for="password2">New Password</label>
												<div class="controls">
													<input type="password" name="newpass" class="input-medium" id="password2" value="<?php echo $form->value("newpass"); ?>" required />
													<?php echo $form->error("newpass"); ?>
												</div> <!-- /controls -->				
											</div> <!-- /control-group -->
									
											<br>
									
											<div class="form-actions">
												<input type="submit" class="btn btn-secondary btn-large" value="Save Settings" /> 
												<button class="btn btn-large">Cancel</button>
											</div> <!-- /form-actions -->
										</fieldset>
									</form>
								</div> <!-- /#tab1 -->
						
								<div class="tab-pane" id="tab2">
									<h2>Edit Web Crawler settings</h2>
									
									<iframe id="webcrawler_settings" style="height:2000px; width:100%" src="http://127.0.0.1:2016/admin/" seamless ><p>Aw snap :-( Your browser doesn't support iframes. Please don't use IE, Opera, or Safari. If your using Firefox or Google Chrome, please upgrade your browser.</p></iframe>
								</div> <!-- /#tab2 -->
						
								<div class="tab-pane" id="tab3">
									<h2>Tab #3</h2>
									<p>
										Aenean interdum faucibus urna, et laoreet dui fringilla eu. In sagittis tempor justo, id auctor risus vestibulum sed. Nulla facilisi. Phasellus sollicitudin interdum lacus, tincidunt rhoncus augue porta et. Cras molestie bibendum sem, nec feugiat mauris consectetur vel. Nunc tellus sapien, ornare at ullamcorper sed, tempor ut ipsum. Nunc ac purus in quam pellentesque aliquam eget sed sapien. Curabitur sed nulla libero, eget pellentesque ante. Etiam condimentum pellentesque tincidunt. Suspendisse non odio mauris, eget tempor quam. Curabitur eget lectus quis metus tempor adipiscing non ut nisi. Curabitur sed neque tellus.
									</p>
									<p>
										Vestibulum elementum tincidunt est ac placerat. Curabitur nulla sapien, sollicitudin sed cursus at, accumsan vel lorem. Etiam luctus vulputate suscipit. Nulla cursus enim in urna vestibulum auctor. Maecenas ultrices iaculis enim vitae ornare. Morbi arcu lorem, tincidunt vitae aliquam non, venenatis quis nibh. Pellentesque ornare leo sed lectus malesuada imperdiet. Aenean rhoncus, nulla non laoreet lacinia, nisl orci facilisis dolor, in rhoncus mauris odio nec ipsum. Phasellus pellentesque varius odio nec faucibus. Phasellus a lorem quis ipsum lobortis tincidunt in ut quam.
									</p>
									<p>
										Cras et nisi ac nulla dictum vulputate. Nam laoreet sapien at mi interdum sed molestie quam venenatis. Fusce lacinia malesuada erat, id mollis orci lobortis nec. Quisque at nibh nunc. Aliquam quam diam, iaculis id sollicitudin sit amet, laoreet vel purus. Integer et lectus eget arcu pharetra blandit. Vestibulum id vulputate eros. Vivamus non erat urna. Donec consectetur scelerisque semper. Proin enim arcu, sodales a congue ac, fringilla eu odio. Praesent laoreet nunc eu metus ullamcorper vitae lobortis leo interdum. Morbi feugiat ultrices diam sed auctor. Donec a dolor sit amet lectus posuere cursus vitae quis nulla. Morbi sed mi quis tortor tristique tincidunt ac a elit. Donec enim nisl, lobortis eget vehicula eget, auctor eget enim.
									</p>
								</div> <!-- /#tab3 -->
						
								<div class="tab-pane" id="tab4">
									<h2>Tab #4</h2>
									<p>
										Aenean interdum faucibus urna, et laoreet dui fringilla eu. In sagittis tempor justo, id auctor risus vestibulum sed. Nulla facilisi. Phasellus sollicitudin interdum lacus, tincidunt rhoncus augue porta et. Cras molestie bibendum sem, nec feugiat mauris consectetur vel. Nunc tellus sapien, ornare at ullamcorper sed, tempor ut ipsum. Nunc ac purus in quam pellentesque aliquam eget sed sapien. Curabitur sed nulla libero, eget pellentesque ante. Etiam condimentum pellentesque tincidunt. Suspendisse non odio mauris, eget tempor quam. Curabitur eget lectus quis metus tempor adipiscing non ut nisi. Curabitur sed neque tellus.
									</p>
									<p>
										Vestibulum elementum tincidunt est ac placerat. Curabitur nulla sapien, sollicitudin sed cursus at, accumsan vel lorem. Etiam luctus vulputate suscipit. Nulla cursus enim in urna vestibulum auctor. Maecenas ultrices iaculis enim vitae ornare. Morbi arcu lorem, tincidunt vitae aliquam non, venenatis quis nibh. Pellentesque ornare leo sed lectus malesuada imperdiet. Aenean rhoncus, nulla non laoreet lacinia, nisl orci facilisis dolor, in rhoncus mauris odio nec ipsum. Phasellus pellentesque varius odio nec faucibus. Phasellus a lorem quis ipsum lobortis tincidunt in ut quam.
									</p>
									<p>
										Cras et nisi ac nulla dictum vulputate. Nam laoreet sapien at mi interdum sed molestie quam venenatis. Fusce lacinia malesuada erat, id mollis orci lobortis nec. Quisque at nibh nunc. Aliquam quam diam, iaculis id sollicitudin sit amet, laoreet vel purus. Integer et lectus eget arcu pharetra blandit. Vestibulum id vulputate eros. Vivamus non erat urna. Donec consectetur scelerisque semper. Proin enim arcu, sodales a congue ac, fringilla eu odio. Praesent laoreet nunc eu metus ullamcorper vitae lobortis leo interdum. Morbi feugiat ultrices diam sed auctor. Donec a dolor sit amet lectus posuere cursus vitae quis nulla. Morbi sed mi quis tortor tristique tincidunt ac a elit. Donec enim nisl, lobortis eget vehicula eget, auctor eget enim.
									</p>
								</div> <!-- /#tab4 -->
						
								<div class="tab-pane" id="tab5">
									<h2>Tab #5</h2>
									<p>
										Aenean interdum faucibus urna, et laoreet dui fringilla eu. In sagittis tempor justo, id auctor risus vestibulum sed. Nulla facilisi. Phasellus sollicitudin interdum lacus, tincidunt rhoncus augue porta et. Cras molestie bibendum sem, nec feugiat mauris consectetur vel. Nunc tellus sapien, ornare at ullamcorper sed, tempor ut ipsum. Nunc ac purus in quam pellentesque aliquam eget sed sapien. Curabitur sed nulla libero, eget pellentesque ante. Etiam condimentum pellentesque tincidunt. Suspendisse non odio mauris, eget tempor quam. Curabitur eget lectus quis metus tempor adipiscing non ut nisi. Curabitur sed neque tellus.
									</p>
									<p>
										Vestibulum elementum tincidunt est ac placerat. Curabitur nulla sapien, sollicitudin sed cursus at, accumsan vel lorem. Etiam luctus vulputate suscipit. Nulla cursus enim in urna vestibulum auctor. Maecenas ultrices iaculis enim vitae ornare. Morbi arcu lorem, tincidunt vitae aliquam non, venenatis quis nibh. Pellentesque ornare leo sed lectus malesuada imperdiet. Aenean rhoncus, nulla non laoreet lacinia, nisl orci facilisis dolor, in rhoncus mauris odio nec ipsum. Phasellus pellentesque varius odio nec faucibus. Phasellus a lorem quis ipsum lobortis tincidunt in ut quam.
									</p>
									<p>
										Cras et nisi ac nulla dictum vulputate. Nam laoreet sapien at mi interdum sed molestie quam venenatis. Fusce lacinia malesuada erat, id mollis orci lobortis nec. Quisque at nibh nunc. Aliquam quam diam, iaculis id sollicitudin sit amet, laoreet vel purus. Integer et lectus eget arcu pharetra blandit. Vestibulum id vulputate eros. Vivamus non erat urna. Donec consectetur scelerisque semper. Proin enim arcu, sodales a congue ac, fringilla eu odio. Praesent laoreet nunc eu metus ullamcorper vitae lobortis leo interdum. Morbi feugiat ultrices diam sed auctor. Donec a dolor sit amet lectus posuere cursus vitae quis nulla. Morbi sed mi quis tortor tristique tincidunt ac a elit. Donec enim nisl, lobortis eget vehicula eget, auctor eget enim.
									</p>
								</div> <!-- /#tab5 -->
							</div> <!-- /.tab-content -->
						</div> <!-- /.span9 -->
					</div> <!-- /.tabbable -->
				</div> <!-- /.row -->
			
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->
	
	<!--script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script-->
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>

	<script>
		$(function(){
			Theme.init();
			$("li#extras").addClass("active");
		});
	</script>
	
	<script>
		$(document).ready(function(){
			//This function turns form data into a json object
			$.fn.serializeObject = function(){
				var o = {};
				var a = this.serializeArray();
				$.each(a, function(){
					if(o[this.name] !== undefined){
						if(!o[this.name].push){
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					}else{
						o[this.name] = this.value || '';
					}
				});
				return o;
			}
			
			$("#edit-profile").submit(function(e){
				e.preventDefault();
				
				$.ajax({
					type: 'POST',
					url: '<?php echo URL; ?>dashboard/editUserAccount',
					data: $("#edit-profile").serializeObject(),
					cache: false,	
					success: function(result){
						if(result.response == "true"){
							$.msgAlert({
								type: "success"
								, title: "Success"
								, text: result.msg
							});
							$("#password1").val("");
							$("#password2").val("");
						}else{
							$.msgAlert({
								type: "error"
								, title: "Error"
								, text: result.msg
							});
						}
					},
					error:function(error){
						$.msgAlert ({
							type: "error"
							, title: "Error"
							, text: "An Error occured while trying to update your profile details, please try again later. "+error.error
						});
					}
				});
				
				return false;
			});
		});
	</script>
