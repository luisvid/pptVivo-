<?php

class PopupLoginForm extends Render {
    
	public static function render () {
		
	    ob_start();
	    
	    ?>
	    <div id="login-popup-container">
		    <div id="popup-bgr" class="full"> </div>
       		<div id="popup-container">
		    	<div class="popup login">
	               <div class="top" style="position: relative;">
	               		<span style="position: absolute;">JOIN THE</span> 
	               		<span class="beta">BETA</span>
	               		<i onclick="$('#login-popup-container').remove();" class="login-popup-close icon-remove" style=""></i>
               	   </div>
	               <div class="popup-content">
	                   <div class="form">
		                   <form action="/<?=$_SESSION['s_languageIsoUrl']?>/login" name="loginForm" id="loginForm" method="post">
		                       <div class="form-row">
		                           <label><?php echo self::renderContent(Util::getLiteral('user'))?>:</label>
		                           <input type="text" class="mandatory-input" value="" id="login_user" name="login_user" title="<?php echo self::renderContent(Util::getLiteral('user'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>" />
		                           <div class="error" style="display: none;">error msg</div>
		                       </div>
		                       <div class="form-row">
		                           <label><?php echo self::renderContent(Util::getLiteral('password'))?>:</label>
		                           <input type="password" class="mandatory-input" value="" id="login_password" name="login_password" title="<?php echo self::renderContent(Util::getLiteral('password'));?>" alt="<?php echo self::renderContent(Util::getLiteral('password'));?>" />
		                           <div class="error" style="display: none;">error msg</div>
		                       </div>
		                       <div class="form-row right no-padding">
		                          <input type="button" class="submit" value="JOIN" onclick="sendLoginFormAjax();">
		                       </div>
		                       <div class="icon forgot-pass"></div><a href="javascript:showForgotPasswordForm();">Forgot your password?</a>
		                   </form>
		                   <br />
						   <label><?=Util::getLiteral('register_question')?></label> 
						   <a class="forgot-link" href="javascript:window.location = '/?action=gettingstarted';"><?=Util::getLiteral('register')?></a>
	                   </div>
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
											<a href="/services/social_networks_login/social_networks_login.php?login&amp;oauth_provider=facebook">
												<img  width="25px" src="/core/img/login/facebook_icon.png" alt="Facebook Login" />
											</a>
											<?php
										}
										if($_SESSION['s_parameters']['twitter_login'] == 1){
											?>
											<a href="/services/social_networks_login/social_networks_login.php?login&amp;oauth_provider=twitter">
												<img width="25px" src="/core/img/login/twitter_icon.png" alt="Twitter Login" />
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
           </div>
		</div>
	    <?php
	    
	    return ob_get_clean();
	}
}