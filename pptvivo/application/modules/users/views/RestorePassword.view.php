<?php

class RestorePassword extends Render {
    
	static public function render ($fields) {
		
	    ob_start();
	    
	    ?>
	    <div style="width: 380px; margin: 0 auto;">
	    
	    	<form method="post" class="form" action="/<?=$_SESSION ['s_languageIsoUrl']?>?action=resetPassword" id="resetPasswordForm" enctype="multipart/form-data">
	    	
	    		<input type="hidden" name="key" value="<?=$_REQUEST['key']?>" />
	    		
	    		<div id="resetPasswordTitle" class="fila_form" style="margin: 10px 0px; padding-left: 70px;">
	    		
	    			<img alt="" src="/core/img/html5/pptvivo.png" />
	    			
	    			<div style="margin: 10px 0px;"><?=Util::getLiteral('reset_password_header')?></div>
	    			
	    			<div class="clear"></div>
	    			
	    		</div>
		    
		    	<div id="userPassword" class="fila_form">
	        
	            	<?php
	            	echo $fields ['password']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <div class="fila_form" id="resetPasswordButtonsCell">
	            
					<input style="float: right;" class="submit" type="button" onclick="sendForm('resetPasswordForm');" value="<?=Util::getLiteral('send')?>"/>
					
					<div class="clear"></div>
	            
	            </div>
		    
		    </form>
		    
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}