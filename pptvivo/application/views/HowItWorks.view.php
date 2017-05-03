<?php

/**
 * How it works view.
 *
 * @author mmagni
 */
class HowItWorks extends Render {
	
	public static function render() {
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> | How It Works</title>	
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
			
			<div id="content" class="clearfix">  
	           <div class="section-content clearfix">
	               <div class="wrapper">
	                   <h2>How it Works</h2>
	                   <div id="howitworks-content">
	                       <div class="speaker">
	                           <div class="top-arrow">
	                              <a href="?action=howitworksSpeaker">SPEAKER</a>
	                           </div>
	                           <div class="image">
	                               <img src="/core/img/html5/speaker.png" alt="" />
	                           </div>
	                       </div>
	                           
	                      <div class="attendee">
	                          <div class="top-arrow">
	                               <a href="?action=howitworksAttendee">ATTENDEE</a>
	                          </div>
	                          <div class="image">
	                              <img src="/core/img/html5/attendee.png" alt="" />
	                          </div>
	                      </div>
	                  </div>
	               </div>
	               <div class="bottom"></div>
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
