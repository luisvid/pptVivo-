<?php
class Register extends Render {
    
	static public function render ($fields) {
		
	    ob_start();
	    
	    ?>
	    <div class="login_form">
	    	<form method="post" action="register" id="registerUserForm" enctype="multipart/form-data">
	            	<?php
	            		//echo $fields ['name']->drawHtml();
	            	?>
	            	<?php
	            		//echo $fields ['surname']->drawHtml();
	            	?>
	            	<?php
	            		echo $fields ['email']->drawHtml();
	            	?>
	            	<?php
	            		echo $fields ['login']->drawHtml();
	            	?>
	            	<?php
	            		echo $fields ['password']->drawHtml();
	            	?>
		    </form>
		    <div class="form-row right no-padding" id="registerButtonsCell">
	            
					<input  class="buttonClass" type="button" onclick="sendFormAjax('registerUserForm', 'register_message_container', 'register_loading_container');" value="<?=Util::getLiteral('send')?>"/>
					
					<div id="register_loading_container" style="text-align: left;"></div>
					
					<div id="register_message_container" class="input-xlarge" style="text-align: left; margin-top: 4px;"></div>
	            	
	            	<div class="clear"></div>
	            
	            </div>
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}