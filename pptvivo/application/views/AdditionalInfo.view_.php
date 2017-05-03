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
                  <h2>Wayra Call 2014: Additional Information</h2>
                    
					<br>
					Hello Wayra Judge
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
						<h3>Promo Video</h3>
							<br>
							<iframe width="560" height="315" src="https://www.youtube.com/embed/6Ie7KmENvtc" frameborder="0" allowfullscreen></iframe>
							<br>

						<h3>Use Case: Speaker</h3>

						<br>
							<a href="/core/img/additionalInfo/SpeakerUseCase.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt="Use Case: Speake" src="/core/img/additionalInfo/SpeakerUseCase.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>	
						<a href="http://pptvivo.com/en/users?action=downloadInfo" target="_blank">Click here to see how to install the PowerPoint addinn</a>
						<br>
						<br>

						<h3>Use Case: Attendee</h3>
							<br>	
							<a href="/core/img/additionalInfo/AttendeeUseCase.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 408px;" alt="Use Case: Attendee" src="/core/img/additionalInfo/AttendeeUseCase.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>
						
						<h3>Bussines Model</h3>
							<h4>B2B Business Model</h4>
							<b>Customers:</b> Event Planners looking for engagement, participation, quality metrics and to increase leads and conversions.<br>
							<b>Users:</b> Speakers to whom we provide a 2nd screen to PowerPoint and a channel to increase engagement and feedback. Attendees who can interact with the speaker and other attendees.<br>
							<b>Revenue model:</b> We offer 30 days free trial for one event of up to 50 people. A layered pricing model based in attendee number, support type, stats, metrics and a Custom Branded version for sponsors.<br>

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
							Our Target Market is about 55K meeting professionals that spend about $62,76B on event planning.<br>
							In the first year of launched, it is expected to get 1% of out target market, that means 550 event planners, with an average sale of $2,000 per event, we expect a $1.1Million annual revenue.<br>
							In three years we expect to gain the 11% of our target market, with an average sale of $2,500 per event, we expect $15.1Million annual revenue.<br><br>
							According to reports those amounts of professionals are relying upon ongoing education to stay current with the last technology and are more likely to use new technology to improve their business.<br>
							<a href="/core/img/additionalInfo/TargetMarket.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 384px;" alt="Target Market" src="/core/img/additionalInfo/TargetMarket.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>						

						<h3>Competitive Analysis</h3>
							<br>	
							<a href="/core/img/additionalInfo/CompetitiveAnalysis.png" target="_blank"><img style="border: 0px solid ; width: 600px; height: 200px;" alt="Competitive Analysis" src="/core/img/additionalInfo/CompetitiveAnalysis.png"></a>
						<br>
							click on image to enlarge
						<br>
						<br>	
						<h3>Pitch Deck</h3>					
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
