<?php

class Register extends Render {
    
	static public function render ($fields) {
		
	    ob_start();
	    
	    ?>
	   <div class="login_form">
	    	<form method="post" action="register" id="registerUserForm" enctype="multipart/form-data">
	            	<?php
		            	echo $fields ['name']->drawHtml("pull-left");
	            	?>
	        
	            	<?php
		            	echo $fields ['surname']->drawHtml("pull-left");
	            	?>
	        
	            	<?php
		            	echo $fields ['email']->drawHtml("pull-left");
	            	?>
	            
	            	<?php
		            	echo $fields ['login']->drawHtml("pull-left");
	            	?>
	                
	            	<?php
		            	echo $fields ['password']->drawHtml();
	            	?>
		    
		    </form>
	             <div class="form-row right no-padding" id="registerButtonsCell">
	            
					<input  class="buttonClass" type="button" onclick="sendFormAjax('registerUserForm', 'register_message_container', 'register_loading_container');" value="<?=Util::getLiteral('send')?>"/>
					
					<div id="register_loading_container" style="text-align: left;"></div>
					
					<div id="register_message_container" style="text-align: left; float: left; margin-top: 4px;"></div>
	            	
	            	<div class="clear"></div>
	            
	            </div>
		    
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}