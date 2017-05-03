<?php

class AddQuestion extends Render{
	
	static public function render (){
		
		ob_start();
		
		?>
		
		<form>
			<label><?=Util::getLiteral('question')?></label>
			
			<textarea id="currentQuestion" name="currentQuestion" rows="5"></textarea>
			
			<span class="help-block"></span>
			
			<input type="button" class="btn btn-primary" value="<?=Util::getLiteral('send')?>" onclick="insertExpositionQuestion();" />
			
		</form>
		
		<?php
		
		return ob_get_clean();
		
	}

}