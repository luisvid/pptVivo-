<?php
class Header extends Render {
    
	static public function render ($linksHeader = array()) {
		
		ob_start();
	        
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/core/enums/LoginActionManagerActions.enum.php';
		
		?>
		<script type="text/javascript">
		function CreateBookmarkLink() {
			if (document.all)
				window.external.AddFavorite(location.href, document.title);
			else if (window.sidebar)
				window.sidebar.addPanel(document.title, location.href, "");
			else {
				var title_message = "<?=Util::getLiteral('add_to_favorites')?>";
				var body_message = "<?=Util::getLiteral('add_favorites')?>";
				submitActionAjax ('/<?=$_SESSION['s_languageIso']?>',commonActionManagerActions.ERRORMESSAGE,'','','',{errorTitle:title_message,errorMessage:body_message});
			}		
		}
		</script>

				<span style="display: none; float: right; margin-right: 10px;" class="date">
					<?
						setlocale(LC_TIME, $_SESSION['s_message']['locale_code']);
						echo strftime(Util::getLiteral('date_format_long'));
					?>
				</span>
				
				<?php
				if(isset($_SESSION['loggedUser']) && is_object($_SESSION['loggedUser'])){
				?>
				
				<div id="header-nav">
		           	<div class="login options"><?=$_SESSION['loggedUser']->getUserName()?> <?=$_SESSION['loggedUser']->getUserSurName()?> 
		                   <div class="options-block">
		                       <div class="wrapper">
				                    <a class="logout" href="#" onclick="javascript:submitActionForm('/<?=$_SESSION['s_languageIsoUrl']?>/<?=$_REQUEST['currentContent']['menukey']?>','<?=LoginActionManagerActions::LOGOUT?>')">
				                        <?=Util::getLiteral('logout')?>
									</a>
		                       </div>
		                   </div>
		            </div>
				</div>
				<?php
				} 
				?>
				
<?php
		return ob_get_clean();
    }
    
    static public function pageHeaderRender () {

    	ob_start();
    	
    	?>
		<div id="header-home">
			
			<div id="link-home">
				<a id="link-home-img" href="/<?=$_SESSION['s_languageIsoUrl']?>" title="<?=$_SESSION['s_parameters']['site_title']?>">
				</a>
			</div>
				
			<div class="st01" >
				<div class="div-st01-text">
					<div class="st01-text"><?=$_SESSION['s_message']['site_header_title']?></div>
				</div>		
				<div class="st02"></div>
			</div>
				
			<div class="text-header">
				<span class="header-text"><?=$_SESSION['s_message']['site_header_motto']?></span>
			</div>
	
		</div>    	
    	<? 
    	return ob_get_clean();
    }	
}