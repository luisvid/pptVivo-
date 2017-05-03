<?php

class Create extends Render{
	
	public function render($fields){
		
		ob_start();

		?>
	    <div class="account-form">

	    	<div class="form-row" id="notice"></div>
	    
			<form method="post" action="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>?action=create" id="createPresentationForm" enctype="multipart/form-data" >
		    
				<div class="form-row">
					<label><?=Util::getLiteral('file')?></label>
					<input type="file" name="control_file" id="control_file" class="mandatory-input input-file-validate"  style="border: 1px solid #a9bdc6" />
				</div>
				
				<?php
				echo $fields ['title']->drawHtml("");
				
				echo $fields ['description']->drawHtml();
				?>
		
			</form>
			
			<div class="form-row right">
				<input class="buttonClass" type="button" onclick="sendUploadForm('createPresentationForm');" value="<?=Util::getLiteral('send')?>" id="send_file" />
			</div>
		
		</div>
				
		<a href="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>"><?=Util::getLiteral('back')?></a>
		
		<?php 
		
		$_REQUEST['jsToLoad'][] = "/modules/presentations/js/presentations.js";
		
		return ob_get_clean();
	}

}