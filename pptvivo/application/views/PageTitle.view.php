<?php
/** 
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 12/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  Master.view.php
 */

class PageTitle extends Render {
	
	static public function render () {
		ob_start();
		?>		

		<h2>
		<?=$_REQUEST['currentContent']['title'] ;?>
		
		<?php
		$contentText = $_REQUEST['currentContent']['body'];
		if($contentText != ''){ 
			?>
			-> <?=$contentText?>
			<?php
		} 
		?>
		</h2>
			<div id="search_on" style="display: none">
								
								<form id="search-form" class="search-form" name="search" method="post" action="/<?=$_SESSION['s_languageIsoUrl']?>/search">
									
									<label for="search-query"><span class="search-name"><?=self::renderContent(Util::getLiteral('search'))?></span></label>
									<input id="maxresults" type="hidden" name="maxresults" value="20" />
									<input id="fromresult" type="hidden" name="fromresult" value="0" />
									<input id="search-query" value="<?=self::renderContent(Util::getLiteral('search_txt'))?>" onfocus="clearMe(this);" name="search_query"/>
									<a href="#" class="button-buscar" id="button-buscar" title="<?=self::renderContent(Util::getLiteral('click_here_search'))?>" onclick="$('#search-form').submit();" onkeypress="$('#search-form').submit();">
									<?=self::renderContent(Util::getLiteral('search'))?>
									</a>		
								<?
								$searchButtons = null;
								if (isset($searchButtons) && $searchButtons!='') {
										
									foreach ($searchButtons as $searchButton) {
									?>
									 <div id="search_module_button_<?=$searchButton['pfwid']?>" class="<?=$searchButton['css']?>" onclick="javascript:submitActionForm('/<?=$_SESSION['s_languageIsoUrl']?>/search',generalActions.SEARCH,'','',{search_query:document.getElementById('search-query').value})"></div>
									<? 
									}
									
								} 
								?>
								</form>
			</div>

		<?php
		return ob_get_clean();
	}
}