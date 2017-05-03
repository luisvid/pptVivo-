<?php

class AddNote extends Render{
	
	static public function render (){
		
		ob_start();
		
		?>
		
		<form>
			<label><?=Util::getLiteral('note')?></label>
			
			<textarea id="currentNote" name="currentNote" rows="5"></textarea>
			
			<span class="help-block"></span>
			
			<input type="button" class="btn btn-primary" value="<?=Util::getLiteral('send')?>" onclick="insertExpositionNote();" />
			
		</form>
		
		<?php
		
		return ob_get_clean();
		
	}

}