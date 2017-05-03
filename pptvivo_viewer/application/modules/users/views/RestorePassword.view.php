<?php

class RestorePassword extends Render {
    
	static public function render ($fields) {
		
	    ob_start();
	    
	    ?>
	    <div style="margin-top: 10px;">
	    
	    	<form method="post" action="/<?=$_SESSION ['s_languageIsoUrl']?>?action=resetPassword" id="resetPasswordForm" enctype="multipart/form-data">
	    	
	    		<input type="hidden" name="key" value="<?=$_REQUEST['key']?>" />
	    	
	    		<div id="resetPasswordTitle" class="fila_form">
	    			
	    			<strong><?=Util::getLiteral('reset_password_header')?></strong>
	    			
	    			<div class="clear"></div>
	    			
	    		</div>
	    		
	    		<br />
		    
		    	<div id="userPassword" class="fila_form">
	        
	            	<?php
	            	echo $fields ['password']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <br />
	            
	            <div class="fila_form" id="resetPasswordButtonsCell">
	            
					<input style="margin-right: 6px;" class="form_bt btn btn-info" type="button" onclick="sendForm('resetPasswordForm');" value="<?=Util::getLiteral('send')?>"/>
					
					<div class="clear"></div>
	            
	            </div>
		    
		    </form>
		    
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}