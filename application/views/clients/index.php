<?php
/**
 * Portal.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 * Modified by: Arman G. de Castro, October 3, 2008
 * email: armandecastro@gmail.com
 */
?>
		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>KDashboard</h2>
						<p>You are currently working on 4 projects, with 23 total tasks.</p>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			<div class="container">
				<div class="row">
					<div class="span4">
						<h3>Welcome back, Admin.</h3>
						<!--p>You are currently signed up to the Free Trial Plan. <br /><a href="javascript:;">Upgrade your plan today</a>.</p-->
							
						<table class="table stat-table">
							<tbody>
								<tr>
									<td class="value">789</td>
									<td class="full">Visits Today</td>
								</tr>
								<tr>
									<td class="value">634</td>
									<td class="full">Unique Visits</td>
								</tr>
								<tr>
									<td class="value">13</td>
									<td class="full">Pending Comments</td>
								</tr>
								<tr>
									<td class="value">17</td>
									<td class="full">Support Requests</td>
								</tr>
							</tbody>
						</table>
					</div> <!-- /.span4 -->
						
					<div class="span8">
						<div id="line-chart" class="chart-holder"></div> <!-- /#bar-chart -->
					</div> <!-- /.span8 -->
				</div> <!-- /.row -->
					
				<div class="row">
					<div class="span5">
						<h3 class="title">Sales</h3>
						<div id="donut-chart" class="chart-holder"></div> <!-- /#donut-chart -->
					</div> <!-- /.span5 -->
									
					<div class="span7">
						<h3 class="title">Support Request</h3>
							
						<table class="table">
							<thead>
								<tr>
									<th>Label</th>
									<th>Subject</th>
									<th>User</th>
								</tr>						
							</thead>
							
							<tbody>
								<tr>
									<td><span class="label label-primary">Open</span></td>
									<td class="full"><a href="#">Lorem ipsum dolor sit amet</a></td>					
									<td class="who">Posted by Bill</td>
								</tr>
								<tr>
									<td><span class="label label-primary">Open</span></td>
									<td class="full"><a href="#">Consectetur adipiscing</a></td>
									<td class="who">Posted by Pam</td>
								</tr>
								<tr>
									<td><span class="label label-primary">Open</span></td>
									<td class="full"><a href="#">Sed in porta lectus maecenas</a></td>					
									<td class="who">Posted by Curtis</td>
								</tr>
								<tr>
									<td><span class="label label-danger">Closed</span></td>
									<td class="full"><a href="#">Dignissim enim</a></td>					
									<td class="who">Posted by John</td>
								</tr>
								<tr>
									<td><span class="label label-secondary">Responded</span></td>
									<td class="full"><a href="#">Duis nec rutrum lorem</a></td>				
									<td class="who">Posted by James</td>
								</tr>
								<tr>
									<td><span class="label label-danger">Closed</span></td>
									<td class="full"><a href="#">Maecenas id velit et elit</a></td>					
									<td class="who">Posted by Sam</td>
								</tr>
								<tr>
									<td><span class="label label-secondary">Responded</span></td>
									<td class="full"><a href="#">Duis nec rutrum lorem</a></td>
									<td class="who">Posted by Carlos</td>
								</tr>
							</tbody>
						</table>	
					</div> <!-- /.span7 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /#content -->
	</div> <!-- /#wrapper -->

	<script src="<?php echo THEME; ?>js/libs/jquery-1.7.2.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

	<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

	<script src="<?php echo THEME; ?>js/Theme.js"></script>
	<script src="<?php echo THEME; ?>js/Charts.js"></script>

	<script src="<?php echo THEME; ?>js/plugins/excanvas/excanvas.min.js"></script>
	<script src="<?php echo THEME; ?>js/plugins/flot/jquery.flot.js"></script>
	<script src="<?php echo THEME; ?>js/plugins/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo THEME; ?>js/plugins/flot/jquery.flot.orderBars.js"></script>
	<script src="<?php echo THEME; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script src="<?php echo THEME; ?>js/plugins/flot/jquery.flot.resize.js"></script>

	<script src="<?php echo THEME; ?>js/demos/charts/line.js"></script>
	<script src="<?php echo THEME; ?>js/demos/charts/donut.js"></script>
	<script>
		$(function(){
			Theme.init ();
			$("li#portal").addClass("active");
		});
	</script>
