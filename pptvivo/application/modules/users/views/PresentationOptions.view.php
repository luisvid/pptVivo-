<?php

class PresentationOptions extends Render{
	
	public function render(){
		
		ob_start();
		?>
	   
                       <div id="options-list">
                           <div class="option-item clearfix">
                               <div class="name">
                                   ALLOW SLIDES NAVIGATION
                               </div>
                               <div class="more-options">
                                   
                               </div>
                               <div class="status">
                                   <div class="icon check"></div>
                               </div>
                           </div>
                           
                       <div class="option-item clearfix">
                           <div class="name">
                               ALLOW ASKIN QUESTIONS
                               
                           </div>
                           <div class="more-options">
                               
                           </div>
                           <div class="status">
                               <div class="icon check"></div>
                           </div>
                       </div>
                       
                       
                       <div class="option-item clearfix">
                           <div class="name">
                               
                               ALLOW DOWNLOADING
                               
                           </div>
                           <div class="more-options">
                               
                           </div>
                           <div class="status">
                               <div class="icon check"></div>
                           </div>
                       </div>
                       
                       <div class="option-item clearfix">
                           <div class="name">
                               ALLOW PRESENTATION RATING
                           </div>
                           <div class="more-options">
                               
                           </div>
                           <div class="status">
                               <div class="icon uncheck"></div>
                           </div>
                       </div>
                       
                       <div class="option-item clearfix">
                           <div class="name">
                               ALLOW SHARING
                               
                           </div>
                           <div class="more-options">
                              
                           </div>
                           <div class="status">
                               <div class="icon uncheck"></div>
                           </div>
                       </div>
                       
                       <div class="option-item clearfix">
                           <div class="name">
                              FEEDBACK FORM
                               
                           </div>
                           <div class="more-options">
                               <a href="#">New feedback form</a>
                           </div>
                           <div class="status">
                               <div class="icon uncheck"></div>
                           </div>
                       </div>
                       <br>
                       <a class="save" href="#">SAVE CHANGES</a>
                       <br><br><br>
                       
                       </div>
                       
	<div id="popup-center-logged" class="fixed-height">
		<div id="popup-bgr" class="small popup-bgr-small"> </div>
                  <div id="popup-container">
                      <div class="popup welcome">
                          <div class="top center">SOON</div>
                          <div class="popup-content">
                              <p>You will enjoy the great options of presentation pptVivo! offers.<br>(These options will be available for Silver and Gold accounts)</p>
                              <a href="/<?=$_REQUEST['urlargs'][0]?>/<?=Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);?>" class="continue">Continue</a>
                          </div>
                      </div>
                  </div>
	</div>
                   
		<?php
		return ob_get_clean();
	}

}