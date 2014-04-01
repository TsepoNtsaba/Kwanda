

<body>
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>Themes</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					<div class="span6">
						<h3>Ocean Breeze</h3>
						<img src="<?php echo THEME; ?>img/themes/ocean.png" alt="" />			
					</div> <!-- /.span6-->
			
					<div class="span6">
						<h3>Black & Orange</h3>
						<img src="<?php echo THEME; ?>img/themes/black.png" alt="" />			
					</div> <!-- /.span6-->
				</div> <!-- /.row -->		
				<br />
		
				<div class="row">
					<div class="span6">
						<h3>Fire Starter</h3>
						<img src="<?php echo THEME; ?>img/themes/fire.png" alt="" />			
					</div> <!-- /.span6-->
			
					<div class="span6">
						<h3>Mean Green</h3>
						<img src="<?php echo THEME; ?>img/themes/green.png" alt="" />			
					</div> <!-- /.span6-->
				</div> <!-- /.row -->			
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->

	<script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
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
