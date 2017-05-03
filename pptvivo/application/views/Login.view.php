<?php
/**
 * Login class
 *
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 16/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  
 */
class Login  extends Render{
	
	static public function render ($showerror=false, $currentUrl='', $returnUrl='', $returnAction='', $errormsg=null) {
		
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
            <!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?></title>	
				<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
				<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
				
				<script type="text/javascript" src="/core/js/jquery-1.7.min.js"></script>
				<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>
			</head>
			<body>
			<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        	<![endif]-->

			    <?
				echo Header::render();
				
				if(isset($_REQUEST['recentlyActivatedUser']) && $_REQUEST['recentlyActivatedUser'] != null){
					?>
                    <input type="hidden" id="recentlyActivatedUser" value="1" />
                    <?php	
				}
				?>
				   <div id="content" class="clearfix">
			           
			           <div class="wrapper">
		           		   
			               <div id="home-banner" class="clearfix">
			                   <div class="text">
			                       PLEASE,<br />TURN <span>O</span>N<br />YOUR<br />DEVICES!
			                   </div>
			                   <div class="image">
			                      <img src="/core/img/html5/home-img.png"/>
			                   </div>
			               </div>
			               
			               <div id="home-start">
                               <a class="arrow" href="?action=gettingstarted">
			                       GETTING STARTED!
			                   </a>
			               </div>
			               
			           </div>
			           
			           <div class="section-content">
			               
			               <div class="wrapper" style="width: 1100px; padding-bottom: 60px;">
			               		
			               		<h2>Watch the video...</h2>
			               	   <div class="audience-banner clearfix">
			               	   
			               	    <!--<div style="font-family: 'Bree', Arial, sans-serif; color: #e74e0f; margin-bottom: 4px; font-size: 18px;">WATCH THE VIDEO...</div> -->
			               	   	
								<iframe width="540" height="304" src="https://www.youtube.com/embed/6Ie7KmENvtc?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			               	   		
			                       <div class="audience-question">
			                           TIRED OF LOSING<br />
			                           YOUR AUDIENCE...
			                       </div>
			                       
			                       <div class="audience-list">
			                           <ul>
			                               <li>
			                                   <span>ENGAGE</span> your audience by encouraging participation and feedback. 
			                               </li>
			                               <li>
			                                  <span>SHARE</span> your presentation so attendees can follow you from their devices.
			                               </li>
			                               <li>
			                                   <span>EXPAND</span> your presentation scope by encouraging people to tweet and post on Facebook about your talk. 
			                               </li>
			                           </ul>
			                       </div>
			                   </div>
			               </div>
			               <div class="bottom">
			               </div>
			           </div>
				           
				    	<div class="section-content">
				               
			               <div class="wrapper" style="width: 1100px;">
			               			<a name="features"></a>
			               			<h2 style="margin-bottom: 15px;">Features</h2>
			                       <h3>PROBLEM</h3>
			                       <p>
			                       We have all been to conferences where people seemed to pay more attention to their electronic devices than to the live person on the podium.
			                       </p><p>
			                       For speakers it is increasingly difficult to deal with a multitasking audience.
			                       </p><p>
			                       In addition, attendees do not have the presentation material in advance and such material is generally shared by the speaker at the end of the presentation.
			                       </p>
			                       
			                       <h3>SOLUTION</h3>
			                       <p>
			                       Please, turn ON your devices!
			                       </p>
			                       <ul>
			                           <li>
			                           pptVivo! allows the speaker or lecturer share the presentation just before he starts so attendees can follow the presentation from their devices.
			                           </li>
			                           <li>
			                           It facilitates the engagement of the audience by encouraging participation and feedback through questions and polls. </li>
			                           <li>
			                           It creates a potentially vast audience by encouraging people to tweet and post on FB about the talk. Expanding the presentation far beyond the room.
			                           </li>
			                           <li>
			                           It provides to events’ organizers the metrics to measure the success of the event and the participants’ data to follow-up and generate leads for upcoming events.
			                           </li>
			                       </ul>
			                       <br />
			                       <br />
			                       <a href="?action=gettingstarted" class="getting-started">
			                       GETTING STARTED!
			                       </a>
			                      
			                       <br />
			                       <br />
			               
			               </div>
			               
			               <div class="bottom">
			               </div>
			               
	               		</div>
	               		
	               		<div class="section-content">
				               
			               <div class="wrapper" style="width: 1100px;">
								<a name="howitworks"></a>
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
			               
			               <div class="bottom">
			               </div>
			               
	               		</div>
                        
                        <div class="section-content banners-bottom">
                        
                            <img class="left-home-image" alt="" src="/core/img/TICA13_Award.png">
                            <img class="right-home-image" alt="" src="/core/img/BizSpark_Startup.jpg">
                            
                            <div class="newsletter-link-container">
                                <!-- MAILCHIMP SUBSCRIBE LINK -->
                                <a class="newsletter-link" target="_blank" href="http://eepurl.com/Cpw1v">Subscribe to our newsletter</a>
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
			
			<?php
			if($showerror){ 
			?>
			<script type="text/javascript">
				$(document).ready(function(){
					var errorMessage = '<?=parent::renderContentJavascript($errormsg)?>';
					var title = '<?=parent::renderContentJavascript(Util::getLiteral('login_form_literal'))?>';
					submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.GENERICMESSAGE,'','','',{message:errorMessage,title:title},'');
				});
			</script>
			<?php
			} 
			?>
			
	</body>
</html>
		<?
		return ob_get_clean();
	}
}
