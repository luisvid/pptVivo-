<?php
/**
 *  MasterView
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  CALLED BY: url.php
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/Render.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/CssManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/JsManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Header.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Footer.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Menu.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/PageTitle.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/ContentTools.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Content.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/BreadcrumbManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/HeaderManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/FooterManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/ContentManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/exceptions/BreadcrumbException.class.php');

class MasterView extends Render {
    
    public function render (&$render) {
        
        $link = '';	
		
		foreach ($_SESSION['s_languages'] as $language){
			$link .= '<link rel="alternate" type="text/html" href="/'.$language->getIso().'" hreflang="'.$language->getIso().'" lang="'.$language->getIso().'" title="'.$_SESSION['s_parameters']['site_title'].'" />'."\n";
		}
		
		$isHome = preg_match('/home/', $_REQUEST['currentContent']['menukey'])>0  ? true : false ;
		
		ob_start();
		       
?>
<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=$_SESSION['s_languageIso']?>"> <!--<![endif]-->
<head>
	<title><?= $_REQUEST['currentContent']['title']?> | <?=$_SESSION['s_parameters']['site_title']?></title>
	
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="cache-control" content="public" />
	
	<meta name="ROBOTS" content="ALL" />
	<?=$link?>
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
	<?php 
	
	//Array with all the css to be load.
	$css = array(/*"/core/css/normalize.css",
				 "/core/css/main.css",
				 "/core/css/popup.css",
				"/core/css/interior.css",
				"/core/css/jquery-ui-1.8.16.custom.css",
				"/core/css/treeSelector.css",*/
				);
				
	$configurator=Configurator::getInstance();
	
	/*
	if ($configurator->getMinimiceCss()) {
		
		//to avoid multiple disk access
		if(! isset($_SERVER['cssToInclude'])){
			
			//Add document root to all css.
			foreach ($css as $key=>$singleCss) {
				$css[$key]=$_SERVER['DOCUMENT_ROOT'].$singleCss;					 
			}
	
			$cssManager = new CssManager($css);
			
			$cssToInclude = $cssManager->getCssFile($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
			
			if(! $cssToInclude){
				
				$cssManager->mergeFiles($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
				
				$cssToInclude = $cssManager->getCssFile($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
				
			}
			
			$_SERVER['cssToInclude'] = $cssToInclude;
			
			?>
			<link href="<?= $_SERVER['cssToInclude'] ?>" rel="stylesheet" type="text/css" />
			<?
		}
	} else {
		foreach ($css as $singleCss) {
			?>
			<link href="<?= $singleCss ?>" rel="stylesheet" type="text/css" />
			<?
			}
		}
		
		*/
	 
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/css/custom.css')){
			echo '<link href="/core/css/custom.css" rel="stylesheet" type="text/css" />';	
	    }
	    
	    /*
		 * STYLES
		 * NOTE: Always put styles before JavaScripts for performance
		 */
		if(isset($_REQUEST['currentContent']['modulename']) && $_REQUEST['currentContent']['modulename']!=''){
			$filePath = '/modules/'.$_REQUEST['currentContent']['modulename'].'/css/'.$_REQUEST['currentContent']['modulename'].'.css';
			if (file_exists($_SERVER['DOCUMENT_ROOT'].$filePath)){
				echo '<link href="'.$filePath.'" rel="stylesheet" type="text/css" />';
			}
		}
	?>
	
	<script type="text/javascript" src="/core/js/main.js"></script>
	<script type="text/javascript" src="/core/js/plugins.js"></script>
	<script type="text/javascript" src="/core/js/actionResponse.js"></script>
	<script type="text/javascript" src="/core/js/allPopup.js"></script>
	<script type="text/javascript" src="/core/js/util.js"></script>
	<script type="text/javascript" src="/core/js/scripts.js"></script>
	<script type="text/javascript" src="/core/js/EnumsJS.js"></script>
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
	
	       <?
				echo Header::render();
			?>
	
	<div id="content" class="clearfix">
		 
		 <div class="section-content clearfix">
	
				<div class="wrapper clearfix">
                   <?php echo PageTitle::render();?>
                   
	                   <div class="left-col-220">
	                       <nav>
	                           <ul id="account-nav">
								  <?=Menu::renderHeaderMenu();?>
	                            </ul>
	                       </nav>
	                   </div>
	                   
	                   <div class="right-col-690">
	                   		<?php
							echo $render;
							?>
	                   </div>
    			</div>
		</div>
	</div>
	
	<?
		echo FooterView::render();
	?>

				
<?

$jsArray = array(
			"/core/js/allPopup.js",
			"/core/js/util.js",
			"/core/js/scripts.js",
			"/core/js/EnumsJS.js",
			"/core/js/jquery-ui-1.8.16.custom.min.js"
			);
			
$jsCalendarTranslationFile = $_SERVER['DOCUMENT_ROOT'] . "/core/js/jquery.ui.datepicker-".$_SESSION['s_languageIso'].".js";
		
if(file_exists($jsCalendarTranslationFile)){
	$jsArray[] = "/core/js/jquery.ui.datepicker-".$_SESSION['s_languageIso'].".js";
}
			
			
if ($configurator->getMinimiceJs()) {
	//to avoid multiple disk access
	if(!isset($_SESSION['scriptToInclude'])){
		//Add document root to all css.
		foreach ($jsArray as $key=>$js) {
			$jsArray[$key]=$_SERVER['DOCUMENT_ROOT'].$js;					 
		}
		
		$jsManager = new JsManager($jsArray);
	
		$scriptToInclude = $jsManager->getJsFile($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
		
		if(! $scriptToInclude){
			
			$jsManager->mergeFiles($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
			
			$scriptToInclude = $jsManager->getJsFile($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
		}
		
		$_SESSION['scriptToInclude'] = $scriptToInclude;
		
	}
	echo '<script type="text/javascript" src="'.$_SESSION['scriptToInclude'].'"></script>';
} else {
	foreach ($jsArray as $key=>$js) {
		echo '<script type="text/javascript" src="'.$js.'"></script>';					 
	}
}	

if (isset($_REQUEST['jsToLoad']) && $_REQUEST['jsToLoad']!='') {
	$scripts = array_unique($_REQUEST['jsToLoad']);
	
	foreach($scripts as $scriptSource){
		echo '<script type="text/javascript" src="'.$scriptSource.'"></script>';
	}
}
	
if (isset($_SESSION['s_parameters']['google_analytics_key']) && $_SESSION['s_parameters']['google_analytics_key']!='') {
?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', '<?=$_SESSION['s_parameters']['google_analytics_key']?>']);
  		_gaq.push(['_trackPageview']);

		(function() {
    	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
	</script>
<?}?>	
</body>
</html>      
<?php
		return ob_get_clean();
    }
}