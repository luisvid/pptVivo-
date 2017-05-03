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
class Features  extends Render{
	
	static public function render ($showerror=false, $currentUrl='', $returnUrl='', $returnAction='', $errormsg=null) {
		
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> | Features</title>	
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
					<!-- Facebook JS SDK -->
		<div id="fb-root"></div>
		<script>
		  window.fbAsyncInit = function() {
		  FB.init({
		    appId      : '483086418382336', // App ID
		    channelUrl : '//w/channel.html', // Channel File
		    status     : true, // check login status
		    cookie     : true, // enable cookies to allow the server to access the session
		    xfbml      : true  // parse XFBML
		  });
		
		  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
		  // for any auth related change, such as login, logout or session refresh. This means that
		  // whenever someone who was previously logged out tries to log in again, the correct case below 
		  // will be handled. 
		  FB.Event.subscribe('auth.authResponseChange', function(response) {
		    // Here we specify what we do with the response anytime this event occurs. 
		    if (response.status === 'connected') {
		      // The response object is returned with a status field that lets the app know the current
		      // login status of the person. In this case, we're handling the situation where they 
		      // have logged in to the app.
		      testAPI();
		    } else if (response.status === 'not_authorized') {
		      // In this case, the person is logged into Facebook, but not into the app, so we call
		      // FB.login() to prompt them to do so. 
		      // In real-life usage, you wouldn't want to immediately prompt someone to login 
		      // like this, for two reasons:
		      // (1) JavaScript created popup windows are blocked by most browsers unless they 
		      // result from direct user interaction (such as a mouse click)
		      // (2) it is a bad experience to be continually prompted to login upon page load.
		      FB.login();
		    } else {
		      // In this case, the person is not logged into Facebook, so we call the login() 
		      // function to prompt them to do so. Note that at this stage there is no indication
		      // of whether they are logged into the app. If they aren't then they'll see the Login
		      // dialog right after they log in to Facebook. 
		      // The same caveats as above apply to the FB.login() call here.
		      FB.login();
		    }
		  });
		  };
		
		  // Load the SDK asynchronously
		  (function(d){
		   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		   if (d.getElementById(id)) {return;}
		   js = d.createElement('script'); js.id = id; js.async = true;
		   js.src = "//connect.facebook.net/en_US/all.js";
		   ref.parentNode.insertBefore(js, ref);
		  }(document));
		
		  // Here we run a very simple test of the Graph API after login is successful. 
		  // This testAPI() function is only called in those cases. 
		  function testAPI() {
		    console.log('Welcome!  Fetching your information.... ');
		    FB.api('/me', function(response) {
		      console.log('Good to see you, ' + response.name + '.');
		    });
		  }
		</script>
		<!-- End Facebook JS SDK -->
				   
				    <div id="content" class="clearfix">
			           <div class="section-content clearfix">
			               <div class="wrapper" style="width: 990px;">
<!--			                   <h2>Home Login</h2>-->
			                   <div class="left-col-220">
			                   <div class="popup login in-content">
			                   	<div class="top">JOIN THE 
			                   		<span class="beta">BETA</span>
			                   	</div>
			                   <div class="popup-content">
			                    <div class="form">
			                     	<form action="/<?=$_SESSION['s_languageIsoUrl']?>/login" name="loginForm" id="loginForm" method="post">
			                     		<input type="hidden" id="action" name="action" value="login" />
					                    <input type="hidden" id="returnUrl" name="returnUrl" value="<?php echo $returnUrl;?>" />
					                    <input type="hidden" id="returnAction" name="returnAction" value="<?php echo $returnAction;?>" />
					                        
				                     	<div class="form-row">
		                                     <label><?php echo self::renderContent(Util::getLiteral('user'))?>:</label>
		                                     <input type="text" class="mandatory-input" value="" id="login_user" name="login_user" title="<?php echo self::renderContent(Util::getLiteral('user'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>" />
	        	                         </div>
	        	                         
	        	                         <div class="form-row">
		                                     <label><?php echo self::renderContent(Util::getLiteral('password'))?>:</label>
		                                     <input type="password" class="mandatory-input" value="" id="login_password" name="login_password" title="<?php echo self::renderContent(Util::getLiteral('password'));?>" alt="<?php echo self::renderContent(Util::getLiteral('password'));?>" />
	        	                         </div>
			                     		  
			                     		  <div class="form-row right no-padding">
		                                    <input class="buttonClass" type="button" onclick="validateLoginForm('loginForm');" value="<?php echo self::renderContent(Util::getLiteral('login'));?>" title="<?php echo self::renderContent(Util::getLiteral('login'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>"/>
		                                 </div>
			                     		 
			                     	</form>
			                     
							              	<?php                               
							                  if($showerror || (isset($_REQUEST['showerror']) && $_REQUEST['showerror']==1)){
							                 ?>
								                    <div class="row-fluid show-grid">
														<div class="span12 alert alert-error">
					                                       	<?
					                                        	$message = Util::getLiteral('loginerror');
					                                        	
					                                        	if(isset($errormsg)){
					                                        		$message = $errormsg;
					                                        	}
					                                        	elseif(isset($_REQUEST['errormsg'])){
					                                        		$message = base64_decode($_REQUEST['errormsg']);
					                                        	}
					                                        	
					                                        	echo self::renderContent($message);//show the login error message
					                                        ?>
								                                
							                           </div>
												   </div>
						                   <?php }?>
			                     			 
			                     			 <div class="icon forgot-pass"></div>
			                                 <a class="forgot-link" href="javascript:showForgotPasswordForm();"><?=Util::getLiteral('forgot_your_password')?></a>

			                     			 <br />
			                      			 <br />
											 <label><?=Util::getLiteral('register_question')?></label> 
								   			 <a class="forgot-link" href="javascript:window.location = '/?action=gettingstarted';"><?=Util::getLiteral('register')?></a>
										</div>
			                    </div>
			                    
										
										<script type="text/javascript">
											document.forms[0].login_user.focus();
										</script>
										<table align="center">
												<?php
												if($_SESSION['s_parameters']['social_networks_login'] == 1){ 
												?>

												<tr>
													<td colspan="3">
														<div class="external-login-container">
															<label>
																<?=Util::getLiteral('or_login_with')?>
															</label>
															<?php
															if($_SESSION['s_parameters']['facebook_login'] == 1){
																?>
																<!--Below we include the Login Button social plugin. This button uses the JavaScript SDK to-->
																<!--present a graphical Login button that triggers the FB.login() function when clicked.-->
																<fb:login-button width="200" max-rows="1"></fb:login-button>
																<?php
															}
															if($_SESSION['s_parameters']['twitter_login'] == 1){
																?>
																<a href="/services/social_networks_login/social_networks_login.php?login&amp;oauth_provider=twitter">
																	<img class="tw-login-image" width="25px" src="/core/img/login/twitter_icon.png" alt="Twitter Login" />
																</a>
																<?php
															} 
															?>
														</div>
													</td>
												</tr>
												
												<?php
												} 
												?>
					
										</table>
												
									</div>
			                     </div>
			                     
			                   
			                   
			                   <div class="right-col-690" style="margin-left: 40px;">
			                       <h3>PROBLEM</h3>
			                       <p>
			                       We have all been to conferences where people seemed to pay more attention to their electronic devices than to the live person on the podium.
			                       </p><p>
			                       For speakers it is increasingly difficult to deal with a distracted audience.
			                       </p><p>
			                       In addition, attendees do not have the presentation material in advance and such material is generally shared by the speaker at the end of the presentation.
			                       </p>
			                       
			                       <h3>SOLUTION</h3>
			                       <p>
			                       Please, turn ON your devices!
			                       </p>
			                       <ul>
			                           <li>
			                           PPT Vivo! allows the speaker or lecturer share the presentation just before he starts so attendees can follow the presentation from their devices. </li>
			                           <li>
			                           It facilitates the engagement of the audience by encouraging participation and feedback through questions and polls. </li>
			                           <li>
			                           It creates a potentially vast audience by encouraging people to tweet and post on FB about the talk. Expanding the presentation far beyond the room.
			                           </li>
			                       </ul>
			                       <br>
			                       <br>
			                       <a href="?action=gettingstarted" class="getting-started">
			                       GETTING STARTED!
			                       </a>
			                      
			                       <br>
			                       <br>
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
