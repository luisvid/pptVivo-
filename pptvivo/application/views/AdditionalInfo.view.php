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
                  <h2>pptVivo! Additional Information</h2>
                    
					<br>
					Hello Judge
					<br>
					<br>
					Here you'll find additional information to help you better understand
					what pptVivo! is, how it works and what our business model is.<br> 
					Because an image is worth a thousand words, or 500
					characters in this case, we organized it in a visual way. Please, click
					on images to enlarge them.<br>
					First you´ll find our promotional video explaining why pptVivo! is a great idea, then a couple of use cases
					diagram for both Speakers and Attendees. 
					In Business Model we show the value proposition canvas and a brief description of our B2B business model and 
					in Market Analysis we show the size of the US, UK and Asia Meeting Industry and a description of our Target Market.<br>
					Then there is a comparison chart with our main competitors, and finally a link to download our pitch deck.
					<br><br>
					We hope this is useful for you.
					<br>
					<br>
					Best regards.
					<br>
					<br>
					Belen Fernandez
					<br>
					Luis Videla			
					<br>
					<br>
					<br>
					
                   <!--<div class="left-col-220">
                       <br>
                   </div> -->
                   
                   <!-- <div class="right-col-690"> -->
						<br>
						<h3>What is pptVivo! ?</h3>
							pptVivo! is an easy to use browser-based software platform, designed to increase audience engagement and transform meetings into interactive and immersive experiences for both presenter and audience.
							<br>

						<h3>Promo Video</h3>
							<br>
							<iframe width="560" height="315" src="https://www.youtube.com/embed/6Ie7KmENvtc" frameborder="0" allowfullscreen></iframe>
							<br>

						<h3>How does it work?</h3>
							<h4>For the Speaker</h4>
							The speaker must be registered in pptVivo! in order to create his channel and upload his presentations to the site, manually or through the PowerPoint plug-in (he should have downloaded and installed beforehand), and to set the display options to enable attendees to: navigate among slides, ask questions, download the presentation and rate or share it on social networks.
							Before starting the presentation, the speaker shares with attendees the name of the presentation via URL and QR code.
							<br>
							<br>
							<a href="/core/img/additionalInfo/SpeakerUseCase.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt="Use Case: Speake" src="/core/img/additionalInfo/SpeakerUseCase.png"></a>
							<br>
							click on image to enlarge
							<br>
							<br>	
						<h3><a href="http://pptvivo.com/en/users?action=downloadInfo" target="_blank">Click here to see how to install the PowerPoint addin</a></h3>
							<br>
							<br>

							<h4>For Attendees</h4>
							It is not required for attendees to be registered in order to follow a presentation on their devices, they only need to copy the short URL or scan the QR code shared by the speaker to start it. However, the registration is necessary in order to use advanced features like: asking questions, qualifying, sharing, taking notes and downloading a copy of the presentation to their account.
							<br>	
							<br>
							<a href="/core/img/additionalInfo/AttendeeUseCase.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 408px;" alt="Use Case: Attendee" src="/core/img/additionalInfo/AttendeeUseCase.png"></a>
							<br>
							click on image to enlarge
							<br>
							<br>
						
						<h3>Bussines Model</h3>
							<h4>B2B Business Model</h4>
							<b>Customers:</b> Event Planners looking for engagement, participation, quality metrics and to increase leads and conversions.<br>
							<b>Users:</b> Speakers to whom we provide a live slidesharing and interaction tool, and Attendees who can interact with the speaker and other attendees.<br>
							<b>Revenue model:</b> A layered pricing model based in attendee number, support type, stats, metrics and a Custom Branded version for sponsors.<br>

							<h4>Value Proposition</h4>
							<a href="/core/img/additionalInfo/ValuePropositionCanvas.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt="Bussines Model" src="/core/img/additionalInfo/ValuePropositionCanvas.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>
						
						<h3>Market Analysis</h3>

							<b>US Meetings Industry</b><br>
							- Employs 1.7M people.<br>
							- 6% (102K) jobs specific to meeting planners and venues. <br>
							- Event planner profession projected grow 33%  2012-2022.<br>
							- US GDP contribution: more than the air transportation, motion picture, sound recording.<br>
							- 1.83M meetings were held during 2012 attended by 225M people.<br><br>

							<b>UK & Ireland Meetings Industry</b><br>
							- 1.3M meetings in 2011 in 10,000 venues.<br>
							- Attendees spent £40B.<br>
							- Organizers staged on average 147 events per year and received £11B from meetings in the UK.<br>
							- UK GDP contribution: £58.4B in 2011. <br>
							- Rated 17th industry the UK.<br><br>

							<b>Asia Meetings Industry</b><br>
							- China Meeting Industry $150B market with annual growth of 20%.<br>
							- Asia takes 23.7% of the world’s total international meetings: Singapore 10%, Japan 7.4% & Korea 6.3%.<br>
							- Organizers staged on average 44 events per year and spent average $818K per event in China.<br>
						
							<br>
							<h4>US Meetings Industry</h4>														
							<a href="/core/img/additionalInfo/MarketAnalysi1s.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt=" Meetings Industry" src="/core/img/additionalInfo/MarketAnalysi1s.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>
						
							<h4>Target Market</h4>
							Our Target Market is the 54% of those Event Planners that according to the reports and statistics we have, 
							is the amount of professionals that are relying upon ongoing education to stay current with the last technology 
							and are more likely to use new technology to improve their business.
							<br>

							<a href="/core/img/additionalInfo/TargetMarket.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt="Target Market" src="/core/img/additionalInfo/TargetMarket.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>

						<h3>Meeting Industry Reports and Statistics</h3>	
						<a href="https://www.dropbox.com/s/3j4scoc8des92xt/2014%20Economic%20Significance%20of%20Meetings%20to%20the%20US%20Fact%20Sheet.pdf?dl=0" target="_blank">2014 Economic Significance of Meetings to the US Fact Sheet</a>
						<br>
						<a href="https://www.dropbox.com/s/ynx16wl9xiyuemf/MPI%20Meetings%20Outlook_2014%20Winter%20Edition.pdf?dl=0" target="_blank">MPI Meetings Outlook 2014 Winter Edition</a>
						<br>
						<a href="https://www.dropbox.com/s/phpmww2dl5lpsbc/7PredictionsMobileEventAppIndustry2015.pdf?dl=0" target="_blank">Predictions for the Mobile Event App Industry in 2015</a>
						

						<br>
						<br>
						
						<h3>Competitive Analysis</h3>
							<br>	
							<a href="/core/img/additionalInfo/competitors.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 200px;" alt="Competitive Analysis" src="/core/img/additionalInfo/competitors.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>	
						<h3>Pitch Deck</h3>	
						<br>
						<iframe src="https://onedrive.live.com/embed?cid=EA2B8F42411D71BC&resid=ea2b8f42411d71bc%2148954&authkey=AD78z35ow2oFECM&em=2" width="402" height="327" frameborder="0" scrolling="no"></iframe>
						<br>	
							<a href="/core/img/additionalInfo/pptVivo_PitchDeck.pptx" target="_blank">Download pitch deck</a>
						<br>
						<br>

						<h3>To sum up<br>
						</h3>

						<br>
						<span style="font-style: italic; font-weight: bold;">
						“Mobile audience engagement technology will dramatically change the
						quality and impact of live meetings. The live event industry is going
						through a mobile transformation – practically everybody these days
						bring a smartphone or a tablet to a conference.”</span>
						<br>
						Corbin Ball<br>
						International Speaker, technology consultant, five times named as one of The 25 Most Influential People in the Meetings Industry.
						<br>
						<br>
						<h4>Thanks!</h4>
						<br>
						<br>

					
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
