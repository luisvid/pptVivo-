<?php
/**
 * Getting Started View
 *
 * @author Gabriel Guzman
 */
class GettingStarted extends Render {
	
	public static function render() {
		
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
			<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> | Getting Started</title>	
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
				<script type="text/javascript">
					function toggleTabs(tabId, tabObject){
						$('.tab-content').hide();
						$('#' + tabId).show();
						$('.tab-element').removeClass('active');
						$('.' + tabObject).addClass('active');
					}
				</script>
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
                   <h2 class="grey">Choose a Plan</h2>
                   <div class="clearfix">
                   <div class="left-col-220">
                          <div class="plans clearfix big">
                              <div class="plan-col">
                                  <ul class="labels">
                                      <li>PRIVATE UPLOADS</li>
                                      <li>LARGER FILES UPLOADS</li>
                                      <li>PRESENTATION OPTIONS</li>
                                      <li>POWER POINT PLUG-IN</li>
                                      <li>FEEDBACK FORMS</li>
                                      <li>ANALYTICS</li>
                                      <li>AD REMOVAL</li>
                                  </ul>
                                  
                              </div>
                      </div>
                   </div>
                   
                   <div class="right-col-690">
                       <div class="plans clearfix big">
                                                      
                           <div class="plan-col">
                               <div class="top basic">
                                   <div class="wrapper">BASIC</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                               </ul>
                               
                           </div>
                           
                           <div class="plan-col">
                               <div class="top silver">
                                   <div class="wrapper">SILVER</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                               </ul>
                               
                           </div>
                           
                           <div class="plan-col last">
                               <div class="top gold">
                                   <div class="wrapper">GOLD</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                               </ul>
                               
                           </div>
                       </div>
                       
                       <div class="billing-block clearfix">
                           <div class="billing-arrow orange">
                               BILLING INFO
                           </div>
                           <div class="billing-data">
                               Credit Card
                           </div>
                       </div>
                       
                      
                   </div>
                    
				</div>
                
                <h2>Registration</h2>
                <div class="left-col-220">
                </div>
                
                <div class="right-col-690" style="width: 720px;">
                       <div class="registration-block">
                           <div class="nav" style="margin-bottom: 0px;">
                               <a name="registrationAnchor" class="tab-registration tab-element active" href="javascript:toggleTabs('personal-info-tab', 'tab-registration');">
                                   <span class="number">1</span> PERSONAL INFO
                               </a>
                               <a class="tab-download tab-element" href="javascript:toggleTabs('download-plugin-tab', 'tab-download');">
                                   <span class="number">2</span> DOWNLOAD AND INSTALL PLUG-IN
                               </a>
                           </div>
                           <div id="personal-info-tab" class="tab-content">
                               <div class="wrapper">
                                   <div class="form two-col-form small-input">
	                                   <form method="post" action="" id="registerForm">
	                                       <div class="clearfix">
	                                           <div class="form-2-col">
	                                               <div class="form-row">
	                                                   <label><?=Util::getLiteral('name')?>:</label>
	                                                   <input class="input-text-validate mandatory-input" type="text" value="" name="control_userName" id="control_userName" />
	                                               </div>
	                                               
	                                               <div class="form-row">
	                                                   <label><?=Util::getLiteral('surname')?>:</label>
	                                                   <input class="input-text-validate mandatory-input" type="text" value="" name="control_userSurname" id="control_userSurname" />
	                                               </div>
	                                               
	                                               <div class="form-row">
	                                                   <label><?=Util::getLiteral('user')?>:</label>
	                                                   <input class="input-text-validate mandatory-input" type="text" value="" name="control_userLogin" id="control_userLogin" />
	                                               </div>
	                                           </div>
	                                           <div class="form-2-col fr">
	                                              <div class="form-row">
	                                                  <label><?=Util::getLiteral('email')?>:</label>
	                                                  <input class="input-mail-validate mandatory-input" type="text" value="" name="control_userEmail" id="control_userEmail" />
	                                              </div>
	                                              
	                                              <div class="form-row">
	                                                  <label><?=Util::getLiteral('password')?>:</label>
	                                                  <input class="input-password-validate input-text-validate mandatory-input" type="password" value="" name="control_userPassword" id="control_userPassword" />
	                                              </div>
	                                              
	                                              <div class="form-row">
	                                                  <label><?=Util::getLiteral('repeat_password')?>:</label>
	                                                  <input class="input-password-validate input-text-validate mandatory-input" type="password" value="" name="control_userPassword_2" id="control_userPassword_2" />
	                                              </div>
	                                           </div>
	                                       </div>
	                                       <div class="form-row right" style="padding-bottom: 12px;">
	                                       	  <span id="register-message" class="error-message" style="margin-right: 10px; display: none;"></span>
                                              <input type="button" class="submit" value="SAVE CHANGES" onclick="sendRegisterForm();">
	                                       </div>
                                       </form>
                                   </div>
                                   
                               </div>
                           </div>
                           <div id="download-plugin-tab" class="tab-content" style="display: none;">
                               <div class="wrapper">
                                   <div class="text">
                                       Download and install the pptVivo! synchronization<br>add-in for MS PowerPoint in your Windows PC. <br>
                                       <span>(OS X version and Keynote add-in coming soon!)</span>
                                   </div>
                                   <a href="?action=downloadInfo" class="download-button">Download</a>
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
	
	<div id="popup-center" class="fixed-height">
		<div id="popup-bgr" style="height: 480px;" > </div>
		<div id="popup-container">
			<div class="popup welcome">
				<div class="top">WELCOME TO <span class="ppt-inline">PPT VIVO</span> <span class="beta">BETA</span></div>
				<div class="popup-content">
					<p>
						Since we're currently beta testing our service and not all the advanced features are enabled, you don't need to choose a plan or enter any payment info.
					</p>
					<p>                  
						We look forward to helping you, so please do not hesitate to contact us if you have further questions, comments or feedback.
					</p>
                  	<p>	                  
                  		We appreciate your patience.
                  	</p>
                  	<p>	                  
                  		The pptVivo! Team
                  	</p>
					<a href="#registrationAnchor" class="continue">Continue</a>
				</div>
			</div>
		</div>
	</div>
	
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
