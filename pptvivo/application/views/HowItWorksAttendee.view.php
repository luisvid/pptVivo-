<?php

/**
 * How it works view.
 *
 * @author mmagni
 */
class HowItWorksAttendee extends Render {
	
	public static function render() {
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> How It Works: Attendee</title>	
				<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
<!--				<link rel="stylesheet" type="text/css" href="/core/css/generalextra.css" />-->
				<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
				
				<script type="text/javascript" src="/core/js/jquery-1.7.min.js"></script>
<!--				<script type="text/javascript" src="/core/js/modernizr-2.6.2.min.js"></script>-->
				<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>
			</head>
			<body>
			<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        	<![endif]-->

			    <?
				echo Header::render();
			?>
			
			<div class="clearfix" id="content">
           
           <div class="section-content clearfix">
               <div class="wrapper clearfix">
                   <h2>How it Works</h2>
                   <div class="left-col-220">
                   
                       <div class="attendee">
                           <div class="top-arrow">
                              <a href="?action=howitworksAttendee">ATTENDEE</a>
                           </div>
                           <div class="image">
                               <img alt="" src="/core/img/html5/attendee.png">
                           </div>
                       </div>
                       
                   </div>
                   <div class="right-col-690">
                       <div class="video-col">
                           <div class="video">
                            <iframe width="540" height="304" src="https://www.youtube.com/embed/RGclGNuxQak?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>   
                           </div>
                           
                           <ol>
                               <li><div class="number-circle">1</div>Type URL or scan the QR code</li>
                               <li><div class="number-circle">2</div>Login to pptVIvo! (optional)</li>
                               <li><div class="number-circle">3</div>Follow the presentation from your Device! </li>
                               <li><span class="space"></span>If you sign in, you can:
                                   <ul class="sign-in">
                                       <li>Take notes</li>
                                       <li>Ask questions</li>
                                       <li>Share presentation in Facebook or Twitter</li>
                                       <li>Save a copy of the presentation</li>
                                   </ul>
                               </li>
                           </ol>
                           <br>
                           <br>
                           <a class="getting-started" href="?action=gettingstarted">
                           GETTING STARTED!
                           </a>
                           <br>
                           <br>
                           
                       </div>
                       <div class="right-col-160">
                           <div class="howitwork-block">
                               <div class="title">
                                   HOW IT WORK
                               </div>
                               <div class="link">
                                   <a class="speaker-button" href="?action=howitworksSpeaker">
                                       SPEAKER
                                   </a>
                               </div>
                           </div>
                       </div>
                   </div>
                   
               </div>
               <div class="bottom">
               </div>
           </div>
       
       </div>
			
	<?
		echo FooterView::render();
	?>
	
			<!-- Scripts Zone -->
			<script type="text/javascript" src="/core/js/main.js"></script>
			<script type="text/javascript" src="/core/js/plugins.js"></script>
			<script type="text/javascript" src="/core/js/actionResponse.js"></script>
			<script type="text/javascript" src="/core/js/allPopup.js"></script>
			<script type="text/javascript" src="/core/js/util.js"></script>
			<script type="text/javascript" src="/core/js/scripts.js"></script>
			<script type="text/javascript" src="/core/js/login.js"></script>
			<script type="text/javascript" src="/core/js/EnumsJS.js"></script>
			</body>
			</html>
		<?
		return ob_get_clean();
	}
}
