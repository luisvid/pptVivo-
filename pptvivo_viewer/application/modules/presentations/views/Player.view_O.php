<?php
class Player extends Render{
	
	static public function render (&$presentation, $presentationPathData, &$configurator, $presentationAuthor, $expositionId, $currentSlide) {
		
		ob_start();
		
		$presentationsPathUsers = str_replace('\\', '/', $configurator->getPresentationsPathUsers());
		$imageLeftPath = '/files/' . $presentationsPathUsers . $presentationAuthor->getUserLogin() . '/' . $presentationPathData ['presentationName'] . '/' . $presentationPathData ['presentationName'] . '-';
		$imageRightPath = '.' . $presentationPathData['outputExtension'];
		$firstImagePath =  $imageLeftPath . ($currentSlide-1) . $imageRightPath;
		
		?>
		<div class="bs-docs-grid">
	
			<div class="container-fluid">
				
				<div class="row-fluid show-grid" id="player_container">
					
					<div class="span12" id="playerSlides">
						
						<div id="presentationLayer">
							<div id="imageLeftPath" style="display: none;"><?=$imageLeftPath?></div>
							<div id="imageRightPath" style="display: none;"><?=$imageRightPath?></div>
							<div id="currentSlide" style="display: none;"><?=$currentSlide?></div>
							<div id="expositionId" style="display: none;"><?=$expositionId?></div>
							<img src="<?=$firstImagePath?>" alt="<?=$firstImagePath?>" />
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="container-fluid">
				<div class="row-fluid show-grid">
					<div class="span12">
						<div class="row-fluid show-grid">
							<div class="span12" id="playerAds">
								ADS
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="playerMenuContainer">
			
				<div id="displayNotesArrow" onclick="displayMenu();">
					<div class="rotate">MENU</div>
					<i class="icon-plus"></i>
				</div>
				
				<div class="container-fluid" id="playerMenu" style="display: none;">
					
					<div class="row-fluid show-grid">
					
						<div class="span12 playerMenu">
						
							<div class="row-fluid show-grid">
							
								<?php
								if(isset($_SESSION['loggedUser']) && is_object($_SESSION['loggedUser']) && $_SESSION['loggedUser']->getUserlogin() != 'pptvivo_public_attendant'){ 
								?>
					
								<!-- Notes -->
								<div class="span12" id="notesMainContainer">
								
									<div class="row-fluid show-grid">	
										
										<div class="span12" id="notesContainer">
											
											<input type="button" class="btn btn-primary" value="<?=Util::getLiteral('add_note')?>" onclick="addExpositionNote();" />
											
											<div id="notesLayer_<?=$currentSlide?>">
											
												<div class="row-fluid show-grid">
													
													<div class="span12">
													
													</div>
													
												</div>
											
											</div>
											
										</div>
									
									</div>
								
								</div>
								
								<!-- Questions -->
								<div class="span12" id="questionsMainContainer">
								
									<div class="row-fluid show-grid">	
										
										<div class="span12" id="questionsContainer">
								
											<input type="button" value="<?=Util::getLiteral('questions')?>" class="btn btn-primary" onclick="addExpositionQuestion();" />
											
											<div id="playerMessages">	
											
											</div>
											
										</div>
										
									</div>
								
								</div>
								
								<!-- FB and TW sharing -->
								<div id="social-networks-share" class="span12">
									
									<div id="facebook_share_button">
										
										<script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
										
										<a onclick="postToFeed(); return false;">
											<img alt="" src="/core/img/fb_share.png" />	
										</a>
								    
										<p id="msg"></p>
								
									    <script type="text/javascript"> 
			
											FB.init({
												appId: "<?=$configurator->getFacebookAppId()?>", 
												status: true, 
												cookie: true
											});
									
											function postToFeed() {
									
												// calling the API ...
												var obj = {
													method: 'feed',
													link: '<?=Util::getCurrenProtocol()?>',
													picture: 'http://fbrell.com/f8.jpg',
													name: '<?=Util::getCurrenProtocol()?>',
													caption: 'pptVivo! ' + '#<?=str_replace(' ', '_', $presentation->getTitle())?>',
													description: '<?=self::renderContentJavascript($presentation->getDescription())?>',
													display: 'iframe'
												};
										
												function callback(response) {
													if(typeof response != 'undefined' && response != null){
														
													}
												}
										
												FB.ui(obj, callback);
											
											}
									    
									    </script>
									
									</div>
									
									<div id="twitter-share-button">
									
										<a href="https://twitter.com/share" class="twitter-share-button" data-text="#<?=str_replace(' ', '_', $presentation->getTitle())?>" data-lang="<?=$_SESSION['s_languageIso']?>">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									
									</div>
								
								</div>
								
								<?php
								} else {
								?>
								<div class="loginContainer">
									
									<a style="margin: 0 auto;" class="login" href="javascript:window.location='/?action=logoutAndLogin';">LOGIN</a>
								
								</div>
								<?php
								}
								?>
								
							</div>
							
						</div>
					
					</div>
				  
				</div>
			
			</div>
			
		</div>
		
		<script type="text/javascript" src="/modules/presentations/js/presentations.js"></script>
		
		<?php
		
		return ob_get_clean();
		
	}

}