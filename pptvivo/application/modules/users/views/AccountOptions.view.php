<?php

class AccountOptions extends Render{
	
	public function render(){
		
		ob_start();
		?>
	   
                       <div class="plans clearfix">
                           <div class="plan-col">
                               <ul class="labels">
                                   <li>PRIVATE UPLOADS</li>
                                   <li>LARGER FILES UPLOADS</li>
                                   <li>PRESENTATION OPTIONS</li>
                                   <li>POWER POINT PLUG-IN</li>
                                   <li>FEEDBACK FORMS</li>
                                   <li>ANALYTICS</li>
                                   <li>AD REMOVAL</li>
                               </ul>
                               
                           </div>
                           
                           <div class="plan-col">
                               <div class="top basic">
                                   <div class="wrapper">BASIC</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                               </ul>
                               
                           </div>
                           
                           <div class="plan-col">
                               <div class="top silver">
                                   <div class="wrapper">SILVER</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                                   <li><div class="icon uncheck"></div></li>
                               </ul>
                               
                           </div>
                           
                           <div class="plan-col last">
                               <div class="top gold">
                                   <div class="wrapper">GOLD</div>
                               </div>
                               <ul class="checks">
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                                   <li><div class="icon check"></div></li>
                               </ul>
                               
                           </div>
                       </div>
                       
                       <div class="billing-block clearfix">
                           <div class="billing-arrow">
                               BILLING INFO
                           </div>
                           <div class="billing-data">
                               Credit Card
                           </div>
                       </div>
                       
                       <div class="download-block">
                           <div class="top">
                               DOWNLOAD AND INSTALL PLUG-IN
                           </div>
                           <div class="text">
                               Download and install the pptVivo! synchronization<br>add-in for MS PowerPoint in your Windows PC. <br>
                               <span>(OS X version and Keynote add-in coming soon!)</span>
                           </div>
                           <a name="download-icon" href="?action=downloadInfo" class="download-button">
                               Download
                           </a>
                       </div>
                       
	<div id="popup-center-logged" class="fixed-height">
		<div id="popup-bgr"> </div>
		<div id="popup-container">
			<div class="popup welcome">
				<div class="top">WELCOME TO <span class="ppt-inline">PPT VIVO</span> <span class="beta">BETA</span></div>
				<div class="popup-content">
					<p>
						Since we're currently beta testing our service and not all the advanced features are enabled, you don't need to choose a plan or enter any payment info.
					</p>
					<p>                  
						We look forward to helping you, so please do not hesitate to contact us if you have further questions, comments or feedback.
					</p>
                  	<p>	                  
                  		We appreciate your patience.
                  	</p>
                  	<p>	                  
                  		The pptVivo! Team
                  	</p>
					<a href="/<?=$_REQUEST['urlargs'][0]?>/<?=Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);?>" class="continue">Continue</a>
				</div>
			</div>
		</div>
	</div>
                   
		<?php
		return ob_get_clean();
	}

}