<?php
class AttendancesList extends Render {
	
	static public function render ($list, $filterGroup, $pager) {
		
		ob_start();
		?>
    	
    	<br />
    	
    	<div class="list-container" id="attendancesList">
			<?php
			for($i=0 ; $i < count($list) ; $i++){
				
				$presentation = $list[$i];
				
			?>
			<div class="list-item clearfix" id="presentation_<?=$presentation->getId()?>">
				
				<div class="info">
				 	<div class="name"> <?=$presentation->getTitle()?> </div>
					 	<div class="details"> 
						<?php
						foreach ($presentation->getExpositions() as $exposition) {
						?>
							<?
							$dateObj = DateTime::createFromFormat("Y-m-d", $exposition->getExposureDate());
							?>
							<a href="javascript:viewAttendanceComments(<?=$exposition->getId()?>, <?=$presentation->getId()?>)"><?=$dateObj->format(Util::getLiteral('date_format'))?></a>
                            <br />
						<?php
						} 
						?>
						</div>
				</div>
				
				 <div class="options">
					<?php
	    				$presentationPathData = Util::getPresentationPathData($presentation);
	    				$fileName = $presentationPathData['presentationsPath'] .$presentation->getFilename();
	    				
	    				if(file_exists($fileName)){ ?>
									<a class="icon download" title="<?=Util::getLiteral('open') ?>" href="/services/download.php?presentationId=<?=$presentation->getId()?>"><?= Util::getLiteral('open') ?></a>
							 <?php } ?>
	    				<a class="icon delete" title="<?= Util::getLiteral('delete') ?>" href="javascript:deleteAttendedPresentation(<?=$presentation->getId()?>);"><?= Util::getLiteral('delete') ?></a>
				 </div>
				 
			</div>
	
			<?php 
			}
			?>
		
		</div>
    	 
    	<?php 	
		if(count($list) == 0){   		
			echo '<div>'.Util::getLiteral('no_results_found').'</div>';
		}
		?>
    		
    	<br />
    		
		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);    	

		$_REQUEST['jsToLoad'][] = "/modules/presentations/js/presentations.js";
				
		return ob_get_clean();
		
	}
}