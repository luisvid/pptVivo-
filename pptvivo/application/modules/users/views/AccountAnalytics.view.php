<?php

class AccountAnalytics extends Render{
	
	public function render(){
		
		ob_start();
		?>
	   <table cellpadding="0" cellspacing="0" width="100%" class="analytics-table">
                           <thead>
                               <tr>
                                   <th>
                                   PRESENTATION
                                   </th>
                                   <th>
                                   VIEWS
                                   </th>
                                   <th>
                                   TWEETS
                                   </th>
                                   <th>
                                   FACEBOOK
                                   </th>
                                   <th>
                                   DOWNLOADS
                                   </th>
                                   <th>
                                   RATING
                                   </th>
                                   <th>
                                   FEEDBACK
                                   </th>
                                   
                               </tr>
                           </thead>
                           <tbody>
                               <tr>
                                   <td class="presentation">
                                       Efective Teacher
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td class="ratings">
                                       <div class="stars five">
                                           
                                       </div>
                                   </td>
                                   <td>
                                      <a  href="#" class="feedback">show</a>
                                   </td>
                               </tr>
                               
                               <tr>
                                   <td class="presentation">
                                       Efective Teacher
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td class="ratings">
                                       <div class="stars three">
                                           
                                       </div>
                                   </td>
                                   <td>
                                      <a  href="#" class="feedback">show</a>
                                   </td>
                               </tr>
                               
                               <tr>
                                   <td class="presentation">
                                       Efective Teacher
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td class="ratings">
                                       <div class="stars one">
                                           
                                       </div>
                                   </td>
                                   <td>
                                      <a  href="#" class="feedback">show</a>
                                   </td>
                               </tr>
                               
                               <tr>
                                   <td class="presentation">
                                       Efective Teacher
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td>
                                       1325
                                   </td>
                                   <td class="ratings">
                                       <div class="stars four">
                                           
                                       </div>
                                   </td>
                                   <td>
                                      <a  href="#" class="feedback">show</a>
                                   </td>
                               </tr>
                           
                           </tbody>
                       </table>
                       
	<div id="popup-center-logged" class="fixed-height">
		<div id="popup-bgr" class="popup-bgr-small"> </div>
                  <div id="popup-container">
                      <div class="popup welcome">
                          <div class="top center">SOON</div>
                          <div class="popup-content">
                              <p>You will enjoy the most useful and detailed information about your presentations. (These options will be available for Silver and Gold accounts)</p>
                              <a href="/<?=$_REQUEST['urlargs'][0]?>/<?=Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);?>" class="continue">Continue</a>
                          </div>
                      </div>
                  </div>
	</div>
                   
		<?php
		return ob_get_clean();
	}

}