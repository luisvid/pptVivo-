<?php
class AdditionalInfo extends Render {
	
	public static function render() {
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> | Additional Information</title>	
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
                   <h2>Wayra Call 2013: Additional Information</h2>
                    
					<br />
					Hello Wayra Judge
					<br />
					<br />
					Here you'll find additional information to help you better understand what pptVivo! is, how it works and what our business model is.
					<br />
					Because an image is worth a thousand words, or 500 characters in this case, we organized it in a visual way. Please, click on images to enlarge them.
					<br />
					<br />
					First you´ll find our promotional video explaining why pptVivo! is a great idea, then a couple of uses cases diagram for both Speakers and Attendees.
					<br />
					Finally in Business Model we show The Business Model Canvas for pptVivo! and three additional diagrams that show the Freemiun & Free Trial hybrid model, how we plan to charge users and the user convertion rate for the first year.
					<br />
					<br />
					We hope this will be useful for you.
					<br />
					<br />
					Best regards.
					<br />
					<br />
					Belen Fernandez
					<br />
					Luis Videla			
					<br />
					<br />
					
					<h3>Promo Video</h3>
					<br />
					
					<iframe width="560" height="315" src="https://www.youtube.com/embed/6Ie7KmENvtc" frameborder="0" allowfullscreen></iframe>
					<br />

					<h3>Use Case: Speaker</h3>
					<br />	
						<a href="/core/img/additionalInfo/SpeakerUseCase.png" target="_blank"><img src="/core/img/additionalInfo/SpeakerUseCase.png" width="800" height="511" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
	
					<h3>Use Case: Attendee</h3>
						<br />	
						<a href="/core/img/additionalInfo/AttendeeUseCase.png" target="_blank"><img src="/core/img/additionalInfo/AttendeeUseCase.png" width="800" height="511" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
					
					<h3>Bussines Model</h3>
						<br />	
						<a href="/core/img/additionalInfo/BusinessModelCanvaspptVivo.png" target="_blank"><img src="/core/img/additionalInfo/BusinessModelCanvaspptVivo.png" width="800" height="600" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
	
					<h4>Freemium & Free Trial hybrid model</h4>
						<a href="/core/img/additionalInfo/HybridModel.png" target="_blank"><img src="/core/img/additionalInfo/HybridModel.png" width="400" height="273" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
					
					<h4>Plans</h4>
						<a href="/core/img/additionalInfo/PlanChart.png" target="_blank"><img src="/core/img/additionalInfo/PlanChart.png" width="600" height="278" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
	
					<h4>User convertion rate during 1st year of Public Beta</h4>
						<a href="/core/img/additionalInfo/TheFunnel.png" target="_blank"><img src="/core/img/additionalInfo/TheFunnel.png" width="400" height="439" alt="Speaker Use Case"></a>
					<br />
						click on image to enlarge
					<br />
					<br />
					<br />
					<br />
					<br />
					
					<h3>Contact us</h3>
					<img src="/core/img/additionalInfo/pptVIvoContactUs.png" alt="" />
							
					<br />
					<br />
                   
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
