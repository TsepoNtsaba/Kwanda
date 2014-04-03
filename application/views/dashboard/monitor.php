<?php
/**
 * Monitor.php
 *
 * 
 */
//include("include/classes/session.php");
 global $session, $database, $form;
?>

		<div id="masthead">
			<div class="container">
				<div class="masthead-pad">
					<div class="masthead-text">
						<h2>KDashboard</h2>
					</div> <!-- /.masthead-text -->
				</div>
			</div> <!-- /.container -->	
		</div> <!-- /#masthead -->

		<div id="content">
			
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#twitter" data-toggle="tab">Twitter</a></li>
						  <li><a href="#facebook" data-toggle="tab">Facebook</a></li>
						  <li><a href="#search" data-toggle="tab">Kwanda Search Engine</a></li>
						  
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
						  <div class="tab-pane fade in active" id="twitter">
							<h1 style="text-align: center">Twitter Sentiment Analysis</h1>
							<div id="twitter_search" style="text-align: center">
							<form method="GET">
							   <span class="label label-secondary">Keyword</span>&nbsp;&nbsp; <input type="text" name="q" />
							    <input class="btn btn-large btn-secondary" type="submit" />
							</form>
							</div>
							
							<?php

							if(isset($_GET['q']) && $_GET['q']!='') {
							    //include_once(MONITOR.'config.php');
							   // include_once(MONITOR.'lib/TwitterSentimentAnalysis.php');
							    

								$TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY,TWITTER_CONSUMER_KEY,TWITTER_CONSUMER_SECRET,TWITTER_ACCESS_KEY,TWITTER_ACCESS_SECRET);
								$DatumboxAPI = new DatumboxAPI(DATUMBOX_API_KEY);
								
								$query = $_GET['q'];
							    
								$DocumentClassification=array();
								$DocumentClassification['TopicClassification']=$DatumboxAPI->TopicClassification($query);
								/*$DocumentClassification['SpamDetection']=$DatumboxAPI->SpamDetection($query);
								$DocumentClassification['AdultContentDetection']=$DatumboxAPI->AdultContentDetection($query);
								$DocumentClassification['CommercialDetection']=$DatumboxAPI->CommercialDetection($query);
								$DocumentClassification['EducationalDetection']=$DatumboxAPI->EducationalDetection($query);
								$DocumentClassification['GenderDetection']=$DatumboxAPI->GenderDetection($query);*/
								
								//Example of using Information Retrieval API Functions
								//$InformationRetrieval=array();

								//$url='http://en.wikipedia.org/wiki/Google_Search';
								//$html=file_get_contents($url);

								//$InformationRetrieval['TextExtraction']=$DatumboxAPI->TextExtraction($html);
								//$InformationRetrieval['KeywordExtraction']=$DatumboxAPI->KeywordExtraction($InformationRetrieval['TextExtraction'],3);

							    //Search Tweets parameters as described at https://dev.twitter.com/docs/api/1.1/get/search/tweets
							    $twitterSearchParams=array(
								'q'=>$query,
								'lang'=>'en',
								'count'=>30,
							    );
							    $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);
							    
							    //Open Graph Search parameters as described at https://developers.facebook.com/docs/reference/api/search/
							    /*$facebookSearchParams=array(
								'q'=>$_GET['q'],
								'type'=>'post',
								'limit'=>10, //not supported for posts
							    );
							    $faceResults=$FacebookSentimentAnalysis->sentimentAnalysis($facebookSearchParams);*/
							     
							    ?>
							    <div class="well"><p style="text-align: center">You searched for "<?php echo $query; ?>"</p></div>
							    <table style="width:100%; height:100%" class="table table-bordered table-striped table-highlight">
								
								<?php
								
								//Print the Results
								//echo '<h1>Document Classification</h1>';
								//echo '<pre>';
								//echo $DocumentClassification['TopicClassification'];
								//echo '</pre>'; 
								
								/*echo '<h1>Information Retrieval</h1>';
								echo '<pre>';
								print_r($InformationRetrieval);
								echo '</pre>';*/
								
								foreach($results as $status) {
								    
								    $color=NULL;
								    if($status['sentiment']=='positive') {
									$color='#00FF00';
								    }
								    else if($status['sentiment']=='negative') {
									$color='#FF0000';
								    }
								    else if($status['sentiment']=='neutral') {
									$color='#FFFFFF';
								    }
								    ?>
								    <tr style="background:<?php echo $color; ?>;">
									<td><?php echo $status['id']; ?></td>
									<td><?php echo $status['user']; ?></td>
									<td><?php echo $status['text']; ?></td>
									<td><a href="<?php echo $status['url']; ?>" target="_blank">View</a></td>
									<td><?php echo $status['sentiment']; ?></td>
								    </tr>
								    <?php
								}
								?> 
							    </table>
							    <?php
							    
							}
							
							

							?>
						  </div>
						  
						  <div class="tab-pane fade" id="facebook">
							  <h1 style="text-align: center">Facebook Sentiment Analysis</h1>
							  <div id="facebook_search" style="text-align: center">
							<form method="GET">
							   <span class="label label-secondary">Keyword</span>&nbsp;&nbsp; <input type="text" name="q" />
							    <input class="btn btn-large btn-secondary" type="submit" />
							</form>
							</div>
							
							<?php

							if(isset($_GET['q']) && $_GET['q']!='') {
							    //include_once(dirname(__FILE__).MONITOR.'config.php');
							    //include_once(dirname(__FILE__).MONITOR.'lib/FacebookSentimentAnalysis.php');

								$FacebookSentimentAnalysis = new FacebookSentimentAnalysis(DATUMBOX_API_KEY,FACEBOOK_APP_ID,FACEBOOK_APP_SECRET);
								$DatumboxAPI = new DatumboxAPI(DATUMBOX_API_KEY);
								
								$query = $_GET['q'];
							    
								$DocumentClassification=array();
								$DocumentClassification['TopicClassification']=$DatumboxAPI->TopicClassification($query);
								/*$DocumentClassification['SpamDetection']=$DatumboxAPI->SpamDetection($query);
								$DocumentClassification['AdultContentDetection']=$DatumboxAPI->AdultContentDetection($query);
								$DocumentClassification['CommercialDetection']=$DatumboxAPI->CommercialDetection($query);
								$DocumentClassification['EducationalDetection']=$DatumboxAPI->EducationalDetection($query);
								$DocumentClassification['GenderDetection']=$DatumboxAPI->GenderDetection($query);*/
								
								//Example of using Information Retrieval API Functions
								//$InformationRetrieval=array();

								//$url='http://en.wikipedia.org/wiki/Google_Search';
								//$html=file_get_contents($url);

								//$InformationRetrieval['TextExtraction']=$DatumboxAPI->TextExtraction($html);
								//$InformationRetrieval['KeywordExtraction']=$DatumboxAPI->KeywordExtraction($InformationRetrieval['TextExtraction'],3);

							    //Search Tweets parameters as described at https://dev.twitter.com/docs/api/1.1/get/search/tweets
							    
							    //Open Graph Search parameters as described at https://developers.facebook.com/docs/reference/api/search/
							    $facebookSearchParams=array(
								'q'=>$_GET['q'],
								'type'=>'post',
								'limit'=>20, //not supported for posts
							    );
							    $faceResults=$FacebookSentimentAnalysis->sentimentAnalysis($facebookSearchParams);
							     
							    ?>
							    <div class="well"><p style="text-align: center">You searched for "<?php echo $query; ?>"</p></div>
							    <table style="width:100%; height:100%" class="table table-bordered table-striped table-highlight">
								
								<?php
								
								//Print the Results
								//echo '<h1>Document Classification</h1>';
								//echo '<pre>';
								//echo $DocumentClassification['TopicClassification'];
								//echo '</pre>'; 
								
								
								foreach($faceResults as $status) {
								    
								    $color=NULL;
								    if($status['sentiment']=='positive') {
									$color='#00FF00';
								    }
								    else if($status['sentiment']=='negative') {
									$color='#FF0000';
								    }
								    else if($status['sentiment']=='neutral') {
									$color='#FFFFFF';
								    }
								    ?>
								    <tr style="background:<?php echo $color; ?>;">
									<td><?php echo $status['id']; ?></td>
									<td><?php echo $status['user']; ?></td>
									<td><?php echo $status['text']; ?></td>
									<td><a href="<?php echo $status['url']; ?>" target="_blank">View</a></td>
									<td><?php echo $status['sentiment']; ?></td>
								    </tr>
								    <?php
								}
								?>    
							    </table>
							    <?php
							}

							?>
						
						  </div>
						  <div class="tab-pane fade" id="search">
							   <!--<h1 style="text-align: center">KSearch</h1>-->
							<p/>
							
							<!--<pre>
								<?php 
									  //curl echo 'http://localhost:2016/api/collections';
									  /*$ch = curl_init('http://localhost:2014/api/collections');
									  echo $ch;
									  curl_exec($ch);
									  curl_close($ch);*/
									  $query = $_GET['q'];
								?>
							</pre>-->
							<!--<div class="panel-group" id="accordion">
								<div class="panel panel-default">
								    <div class="panel-heading">
								      <h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									 Data Source Name
									</a>
								      </h4>
								    </div>
								    <div id="collapseOne" class="panel-collapse collapse in">
								      <div class="panel-body">
									<ul class="list-group">
									  <li class="list-group-item">Cras justo odio</li>
									  <li class="list-group-item">Dapibus ac facilisis in</li>
									  <li class="list-group-item">Morbi leo risus</li>
									  <li class="list-group-item">Porta ac consectetur ac</li>
									  <li class="list-group-item">Vestibulum at eros</li>
									</ul>
								      </div>
								    </div>
								  </div>
								  
								  <div class="panel panel-default">
								    <div class="panel-heading">
								      <h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									  Keyword Display
									</a>
								      </h4>
								    </div>
								    <div id="collapseTwo" class="panel-collapse collapse">
								      <div class="panel-body">
									<ul class="list-group">
									  <li class="list-group-item">Cras justo odio</li>
									  <li class="list-group-item">Dapibus ac facilisis in</li>
									  <li class="list-group-item">Morbi leo risus</li>
									  <li class="list-group-item">Porta ac consectetur ac</li>
									  <li class="list-group-item">Vestibulum at eros</li>
									</ul>
								      </div>
								    </div>
								  </div>
							</div>-->
							
							<!--<div id="ksearch" style="text-align: center">
							<form name="input" action="http://localhost:2014/solr/South_Africa/lucid" method="get" >
								<span class="label label-secondary">Keyword</span>&nbsp;&nbsp;<input type="text" name="q" />
								<input  class="btn btn-large btn-secondary" type="submit"/>
								<input type="hidden" name="wt" value="json" />
							</form>
							</div>
							
							<br/>
							<?php
							if(isset($_GET['q']) && $_GET['q']!='') {
							?>
							<div class="well"><p style="text-align: center">You searched for "<?php echo $query; ?>"</p></div>
							<?php
							}
							?>-->
							
							<iframe id="flare" style="height:1000px; width:100%" src="http://127.0.0.1:2016/flare/" seamless ><p>Aw snap :-( Your browser doesn't support iframes. Please don't use IE, Opera, or Safari. If your using Firefox or Google Chrome, please upgrade your browser.</p></iframe>
						  </div>
						</div>
						
					
				
			
		</div> <!-- /#content -->
		</div>

		<script src="<?php echo THEME; ?>js/libs/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="<?php echo THEME; ?>js/libs/jquery.ui.touch-punch.min.js"></script>

		<script src="<?php echo THEME; ?>js/libs/bootstrap/bootstrap.min.js"></script>

		<script src="<?php echo THEME; ?>js/Theme.js"></script>
		

		<script src="<?php echo THEME; ?>js/plugins/excanvas/excanvas.min.js"></script>
		
		<script>
			$(function(){
				Theme.init ();
				$("li#monitor").addClass("active");
			});
		</script>