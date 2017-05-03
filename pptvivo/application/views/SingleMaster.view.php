<?php
/**
 *  Single Master View
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 19/09/2012 *  
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/Render.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/CssManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/JsManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Header.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Footer.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Menu.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/PageTitle.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Content.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/HeaderManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/FooterManager.class.php');

class SingleMasterView extends Render {
    
    public function render (&$render) {
        
        $link = '';	
        
        $siteTitle = isset($_SESSION['s_parameters']['site_title']) ? $_SESSION['s_parameters']['site_title'] : '';
		
		foreach ($_SESSION['s_languages'] as $language){
			$link .= '<link rel="alternate" type="text/html" href="/'.$language->getIso().'" hreflang="'.$language->getIso().'" lang="'.$language->getIso().'" title="'.$siteTitle.'" />'."\n";
		}
		
		ob_start();
		       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$siteTitle?></title>
	
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="cache-control" content="public" />
	
	<meta name="ROBOTS" content="ALL" />

	<?=$link?>
	
	<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
				
	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
	
	<script type="text/javascript" src="/core/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>

	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
	
	<?
	$headerManager = HeaderManager::getInstance();
	?>
	
</head>
<body>
	<noscript>
		<div class="noscript-message"><?=self::renderContent(Util::getLiteral('no_script_message'))?></div>
	</noscript>
	
	<div id="container" class="container0">
		
		<div id="container2">		
			
			<div id="container3a">		    
				
				<div id="interior-container-02">			
					
					<div id="interior-container">				
						
						<div id="interior-container-0"></div>				
						
						<div id="interior-content">
							
							<div id="content-detail">
							
								<div class="central-content">
									
									<div id="center-div" class="center-div-04">
									
										<div id="especific-content">
											
												<? 
												echo $render;
												?>
											
											<div style="clear:both;"></div>
											
										</div>
									
									</div>
									
								</div>

							</div>
    												
						</div>
						
					</div>
					
					<div id="footer-mix">
							
					</div>
					
				</div>
				
			</div>
			
			<div id="container4a">
				
				<div class="footer-content">
					
					<div id="footer">
						<?
						$footerManager=FooterManager::getInstance();
						$footerLink = $footerManager->getFooterLinks();
						$lastItem=count($footerLink);
						$count=1;
						foreach ($footerLink as $link) {
						?>
							<a <?=$link['target'];?> class="<?=$link['link_class'];?>" href="<?=$link['url'];?>" title="<?=self::renderContent($link['link_title']);?>"><?=self::renderContent($link['link_title']);?></a>				
						<?
							if ($count<$lastItem) {
						?>
								&nbsp; <span>|</span>	
						<?
							}
							$count++;
						}
						?>
						<br /><br />
							
					</div>
					
				</div>
				
			</div>
			
 		</div>
 		
	</div>
	
	<script type="text/javascript" src="/core/js/actionResponse.js"></script>
	<script type="text/javascript" src="/core/js/allPopup.js"></script>
	<script type="text/javascript" src="/core/js/util.js"></script>
	<script type="text/javascript" src="/core/js/scripts.js"></script>
	<script type="text/javascript" src="/core/js/login.js"></script>
	<script type="text/javascript" src="/core/js/EnumsJS.js"></script>
	
</body>
</html>
<?php
		return ob_get_clean();
    }
}