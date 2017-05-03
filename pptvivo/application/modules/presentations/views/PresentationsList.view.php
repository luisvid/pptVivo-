<?php

require_once $_SERVER ['DOCUMENT_ROOT'].'/../application/modules/presentations/classes/Presentation.class.php';

class PresentationsList extends Render {
	
	static public function render ($list, $filterGroup, $pager) {
		ob_start();
		
		?>
		<div class="list-col">
		                       	
		<div id="listActions" class="listActions">    	
	    	<input type="button" class="buttonClass" name="btn_newElement" onclick="window.location='/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>?action=createPresentation&amp;loginRequired=1'" value="<?=Util::getLiteral('add_presentation')?>"/>
	    </div>
	    
    	<br />
    	
		<?php
		if(count($list) > 0){
			
			?>
			<div class="list-container">
			<?php
			
			$contentUrl = Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);
			
			for($i=0 ; $i < count($list) ; $i++){
				
				$presentation = $list[$i];
				
				$expositions = $presentation->getExpositions();
			?>
	    		<div class="list-item clearfix" id="presentation_<?=$presentation->getId()?>">
	    			
	    			<div class="info">
	    			
	    				<div class="details fontBold preview" >
							<?php
							$presentationPathData = Util::getPresentationPathData($presentation);
			    				
							if(file_exists($presentationPathData['previewSrc'] )){
							?>
							<img alt="preview" src="<?=$presentationPathData['previewImgPath']?>" />
							<?php
							}
							else{
								echo Util::getLiteral('preview_not_available');
							}
							?>
						</div>
						
						<div class="presentation-detail">
						
							<div class="name">
								<?=$presentation->getTitle()?>
							</div>
						
							<div class="details"> 
								<?php
								$dateObj = DateTime::createFromFormat("Y-m-d", $presentation->getCreationdate());
								echo Util::getLiteral('created') . ': ' . $dateObj->format(Util::getLiteral('date_format')); 
								?>
							</div>	
							
						</div>
						
                   </div>
                   
                   <div class="options">
                   
                        <a class="icon question" title="<?=Util::getLiteral('show_questions')?>" href="/<?=$_REQUEST['urlargs'][0]?>/<?=$contentUrl?>/<?=$presentation->getId()?>"><?=Util::getLiteral('show_questions')?></a>
                   
                   		<?php
                   		if(count($expositions) <= 0){ 
                   		?>
                        <a title="<?=Util::getLiteral('create_exposition')?>" class="icon play" href="javascript:createPresentationExposition(<?=$presentation->getId()?>);">Play</a>
                        <?php
                   		}
                        
    					$fileName = $presentationPathData['presentationsPath'] .$presentation->getFilename();
    					if(file_exists($fileName)){ ?>
							<a class="icon download" title="<?=Util::getLiteral('open') ?>" href="/services/download.php?presentationId=<?=$presentation->getId()?>"><?= Util::getLiteral('open') ?></a>
					 	<?php 
    					}
    					?>
						 
					 	<a class="icon delete" title="<?=Util::getLiteral('delete') ?>" href="javascript:deletePresentation(<?=$presentation->getId()?>);"><?= Util::getLiteral('delete') ?></a>
                   </div>
                   
                   <div class="details fontBold presentation-url" id="presentation_url_<?=$presentation->getId()?>" >
						<?php
						$presentationUrl = $_SESSION['s_parameters']['player_url'] . $contentUrl . '/' . $_SESSION ['loggedUser']->getUserlogin () . '/' . $presentation->getId();
						?>
						<div style="display: none;" id="base_presentation_url_<?=$presentation->getId()?>"><?=$presentationUrl?></div>
						<?
						if(count($expositions) > 0){
							?>
							
							<?php
							/* @var $exposition Exposition */
							foreach ($expositions as $exposition){

								$expositionUrl = $exposition->getShortUrl();
								$expositionQRCode = $exposition->getQrCode();
								?>
                                <div>
									<span><?=Util::getLiteral('exposition_created')?>:
                                    <?php
	                                $dateObjExposition = DateTime::createFromFormat("Y-m-d", $exposition->getExposuredate());
	                                echo $dateObjExposition->format(Util::getLiteral('date_format')); 
	                                ?>
                                    </span>
	                                <a target="_blank" class="icon url" href="<?=$expositionUrl?>" title="<?=Util::getLiteral('show_short_url')?>"></a>
									<a class="short-url-text" target="_blank" href="<?=$expositionUrl?>"><?=$expositionUrl?></a>
									<a class="icon qr" href="/<?=$_REQUEST['urlargs'][0]?>/<?=$contentUrl?>?action=viewQR&qrPath=<?= base64_encode($expositionQRCode) ?>&expositionUrl=<?=base64_encode($expositionUrl)?>"></a>
	                                <a class="icon cancel" style="top: 7px;" title="<?=Util::getLiteral('cancel') ?>" href="javascript:cancelExposition(<?=$exposition->getId()?>);"><?= Util::getLiteral('cancel') ?></a>
                                </div>
								<?php
							}
							?>
							<?php
						}
						else{
							?>
						<div class="presentations_links_info"><?=Util::getLiteral('presentation_url')?>:</div>
							<?php
						}
						?>
					</div>
	    			
	    		</div>
			<?php
	    	}
	    	?>
	    	</div>
	    	<?php
		}
		else{
			echo '<div>'.Util::getLiteral('no_results_found').'</div>';
		}
		?>
		
		</div>
		<div class="right-col-160">
			<div class="howitwork-block">
				<div class="title">
					ACTIONS
				</div>
				<div class="link">
					<ul class="how">
						<li><div class="icon play"></div>Create Exposition</li>
                        <li><div class="icon cancel"></div>Cancel Exposition</li>
						<li><div class="icon download"></div>Download</li>
						<li><div class="icon delete"></div>Delete Presentation</li>
                        <li><div class="icon question"></div>Show Questions</li>
                        <li><div class="icon url"></div>Show Short URL</li>
						<li><div class="icon qr"></div>Show QR Code</li>
					</ul>
				</div>
			</div>
		</div>
    		
    	<br />
		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);    	

		$_REQUEST['jsToLoad'][] = "/modules/presentations/js/presentations.js";
		
		return ob_get_clean();
		
	}
}