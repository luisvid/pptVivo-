<?php

class ExpositionsList extends Render {
	
	static public function render ($list, $pager, $presentation) {
		
		ob_start();
		
		if(count($list) > 0){
			
			?>
			<div>
			<?=Util::getLiteral('exposures_of')?>: <?=$presentation->getTitle()?>
			</div>
			
			<br />
			<?php
		
			for($i=0 ; $i < count($list) ; $i++){
				
				$exposition = $list[$i];
				
			?>
			<div class="exposition-element" id="exposition_<?=$exposition->getId()?>">
				<div class="exposition-element-date">
					<?
					$dateObj = DateTime::createFromFormat("Y-m-d", $exposition->getExposureDate());
					?>
					<strong><?=$dateObj->format(Util::getLiteral('date_format'))?> - <?=Util::getLiteral('attendants')?>:</strong>
				</div>
				<div class="exposition-attendants">
				<?php
				$attendantsCount = count($exposition->getAttendants());
				if($attendantsCount > 0){
					foreach ($exposition->getAttendants() as $attendant) {
					?>
					<div>
					<?=$attendant->getUsername()?> <?=$attendant->getUsersurname()?>
					</div>
					<?php
					}
				}
				else{
					?>
					<div>
					<?=Util::getLiteral('no_attendants')?>
					</div>
					<?php
				}
				?>
				</div>
				<strong><?=Util::getLiteral('questions')?>:</strong>
				<div class="exposition-questions">
					<?php
					$questionsCount = count($exposition->getQuestions());
					if($questionsCount > 0){
						foreach ($exposition->getQuestions() as $question) {
						?>
						<div>
							<strong><?=Util::getLiteral('slide')?>:</strong> <?=$question->getSlide()?> 
							<strong><?=Util::getLiteral('user')?>:</strong> <?=$question->getUserName()?> <?=$question->getUserSurname()?>
							<strong><?=Util::getLiteral('question')?>:</strong> <?=$question->getQuestion()?>
						</div>
						<?php
						}
					}
					else{
						?>
						<div>
						<?=Util::getLiteral('no_questions')?>
						</div>
						<?php
					}
					?>
				</div>
				
			</div>
	
			<?php
	    	}
		}
    	else{   		
			echo '<div>'.Util::getLiteral('no_results_found').'</div>';
		}
		?>
    		
    	<br />
    		
		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);

		?>
		<br />
		<a href="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>"><?=Util::getLiteral('back')?></a>
		<?php

		$_REQUEST['jsToLoad'][] = "/modules/presentations/js/presentations.js";
				
		return ob_get_clean();
		
	}
}