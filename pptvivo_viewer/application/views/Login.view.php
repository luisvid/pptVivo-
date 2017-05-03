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
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Footer.view.php');

class Login  extends Render{
	
	static public function render ($showerror=false, $currentUrl='', $returnUrl='', $returnAction='', $errormsg=null) {
		
		ob_start();
		?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

	<title><?=$_SESSION['s_parameters']['site_title']?> Login</title>	

	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/docs.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />

	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>

	<script type="text/javascript" src="/core/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>
	
</head>
	<body class="login-body">
	<!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

	<header class="login-header">
		<h1>
			<a class="ir brand" href="#"><img src="/core/img/html5/pptvivo.png" alt="" /></a>
			<div><?=self::renderContent(Util::getLiteral('login'));?></div>
		</h1>
	</header>
		
	<div id="content" class="clearfix">
		<div class="section-content clearfix">
	    	<div class="wrapper">
	    		<div class="login-container">
	    		 <div class="popup login in-content">
	    		 <div class="popup-content">
			     <div class="form">
					<div class="login_form">
						<form action="/<?=$_SESSION['s_languageIsoUrl']?>/login" name="loginForm" id="loginForm" method="post">
							<input type="hidden" id="action" name="action" value="login" />
	                    	<input type="hidden" id="returnUrl" name="returnUrl" value="<?php echo $returnUrl;?>" />
	                    	<input type="hidden" id="returnAction" name="returnAction" value="<?php echo $returnAction;?>" />
									<div class="form-row">
			                                     <label><?php echo self::renderContent(Util::getLiteral('user'))?>:</label>
			                                     <input type="text" class="mandatory-input input-medium" value="" id="login_user" name="login_user" title="<?php echo self::renderContent(Util::getLiteral('user'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>" />
		        	                </div>
									
									<div class="form-row">
			                           <label><?php echo self::renderContent(Util::getLiteral('password'))?>:</label>
			                           <input type="password" class="mandatory-input input-medium" value="" id="login_password" name="login_password" title="<?php echo self::renderContent(Util::getLiteral('password'));?>" alt="<?php echo self::renderContent(Util::getLiteral('password'));?>" />
			                           <a class="forgot-link" href="javascript:showForgotPasswordForm();"><?=Util::getLiteral('forgot_your_password')?></a>
		        	                </div>
									
									<div class="form-row right no-padding">
	                                    <input class="buttonClass" type="button" onclick="validateLoginForm('loginForm');" value="<?php echo self::renderContent(Util::getLiteral('join'));?>" title="<?php echo self::renderContent(Util::getLiteral('login'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>"/>
			                        </div>
									
						</form>
						
						<?php
						if($_SESSION['s_parameters']['social_networks_login'] == 1){ ?>
						<div class="row-fluid show-grid">
							<div class="span12">
								<div class="external-login-container">
									<?
									echo Util::getLiteral('or_login_with');
									
									if($_SESSION['s_parameters']['facebook_login'] == 1){
										?>
										<a href="/services/social_networks_login/social_networks_login.php?login&amp;oauth_provider=facebook&amp;returnUrl=<?=base64_encode($_REQUEST ['REQUEST_URI'])?>">
											<img width="25px" src="/core/img/login/facebook_icon.png" alt="Facebook Login" />
										</a>
										<?php
									}
									if($_SESSION['s_parameters']['twitter_login'] == 1){
										?>
										<a href="/services/social_networks_login/social_networks_login.php?login&amp;oauth_provider=twitter&amp;returnUrl=<?=base64_encode($_REQUEST ['REQUEST_URI'])?>">
											<img width="25px" src="/core/img/login/twitter_icon.png" alt="Twitter Login" />
										</a>
										<?php
									} 
									?>
								</div>
							</div>
						</div>
						<?php }?>
						
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
	                   
								<div class="row-fluid show-grid">
									<div class="register-text-container">
										 <?=Util::getLiteral('register_question')?>
										 <a href="javascript:showRegisterForm();"><?=Util::getLiteral('register')?></a>
									</div>
								</div>
								
								<hr />
								
								<div class="row-fluid show-grid">
									<div style="text-align: center;">
										<a class="orange" href="/<?=$_SESSION['s_languageIsoUrl']?>/login?action=login&amp;login_user=pptvivo_public_attendant&amp;login_password=pptvivo_public_attendant"><?=Util::getLiteral('see_public_presentation')?></a>
									</div>
								</div>

					</div>
 					
					<script type="text/javascript">
						document.forms[0].login_user.focus();
					</script>
					
			</div>
			</div>
			</div>
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