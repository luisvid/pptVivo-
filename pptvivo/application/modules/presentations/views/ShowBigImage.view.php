<?php

class ShowBigImage extends Render {
	
	static public function render ($image) {
		
		ob_start();
		
		?>
        <img style="width: 540px; height: 405px;" alt="" src="<?=$image?>" />
        <?php
		
		return ob_get_clean();
		
	}

}