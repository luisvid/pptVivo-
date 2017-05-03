<?php

class ForgotPassword extends Render {
    
	static public function render ($fields) {
		
	    ob_start();
	    
	    ?>
	    <div class="login_form">
	    	<form method="post" action="restorePasswordMail" id="restorePasswordMailForm" enctype="multipart/form-data">
	    		<div id="forgotPasswordTitle" class="fila_form alert alert-info">
	    			<?=Util::getLiteral('forgot_password_header')?>
	    		</div>
		    
	        
	            	<?php
	            	echo $fields ['email']->drawHtml();
	            	?>
	            
	            <br />
	            
		    </form>
	            <div class="form-row right no-padding" id="forgotPasswordButtonsCell">
					<input class="buttonClass" type="button" onclick="sendFormAjax('restorePasswordMailForm', 'action_message_container', 'action_loading_container');" value="<?=Util::getLiteral('send')?>"/>
					<div id="action_loading_container" style="text-align: left;"></div>
					<div id="action_message_container" style="text-align: left; margin-top: 4px;"></div>
	            	<div class="clear"></div>
	            </div>
		    
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}