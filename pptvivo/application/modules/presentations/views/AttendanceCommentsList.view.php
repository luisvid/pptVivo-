<?php

class AttendanceCommentsList extends Render {
	
	static public function render ($list, $presentation) {
		
		ob_start();
		
		$presentationPathData = Util::getPresentationPathData($presentation);
		
		if(is_array($list) && count($list) > 0){
		
			?>
			<table>
				<tr>
					<td style="font-weight: bold;"><?=Util::getLiteral('slide')?></td>
					<td style="font-weight: bold;"><?=Util::getLiteral('note')?></td>
                    <td></td>
				</tr>
			<?php
			
			$extension = strchr($presentationPathData['previewImgPath'], '.'); 
                
			$fileName = substr($presentationPathData['previewImgPath'], 0, strlen($extension)*-1);
			
			// la cadena small- es usada por el conversor de ppt a imagenes
			$bigFileName = str_replace('small-', '', $fileName);
			
			foreach ($list as $element){
			?>
			<tr>
				<td><?=$element->getSlide()?></td>
				<td><?=$element->getNote()?></td>
                <td>
                <?php
                $imageName = str_replace(substr($fileName, -1), $element->getSlide(), $fileName) . $extension;
                $bigImageName = str_replace(substr($bigFileName, -1), $element->getSlide(), $bigFileName) . $extension;
				?>
					<img style="height: 76px; width: 100px; cursor: pointer;" alt="preview" src="<?=$imageName?>" onclick="showBigImage('<?=$bigImageName?>');" />
                </td>
			</tr>
			<?php
			}
			
			?>
			</table>
			<?php
		
		}
		else{
			echo '<div>'.Util::getLiteral('no_results_found').'</div>';
		}
		
		return ob_get_clean();
		
	}

}