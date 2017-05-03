<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/Render.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/CssManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/JsManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/ContentManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Header.view.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Footer.view.php');

class MasterView extends Render {
    
    public function render (&$render) {
        
        $link = '';	
        
        $siteTitle = isset($_SESSION['s_parameters']['site_title']) ? $_SESSION['s_parameters']['site_title'] : '';
		
		foreach ($_SESSION['s_languages'] as $language){
			$link .= '<link rel="alternate" type="text/html" href="/'.$language->getIso().'" hreflang="'.$language->getIso().'" lang="'.$language->getIso().'" title="'.$siteTitle.'" />'."\n";
		}
		
		ob_start();
		       
?>
<!DOCTYPE html>
<html class="no-js" lang="<?=$_SESSION['s_languageIso']?>">
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
	<link rel="stylesheet" type="text/css" href="/core/css/docs.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/pptvivo.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/login.css" />
	<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
	
	<?php
	if(isset($_REQUEST['currentContent']['modulename']) && $_REQUEST['currentContent']['modulename']!=''){
		$filePath = '/modules/'.$_REQUEST['currentContent']['modulename'].'/css/'.$_REQUEST['currentContent']['modulename'].'.css';
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$filePath)){
			echo '<link href="'.$filePath.'" rel="stylesheet" type="text/css" />';
		}
	} 
	?>
				
	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
	
	<script type="text/javascript" src="/core/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/core/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>

	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
	
</head>
<body>
	<noscript>
		<div class="noscript-message"><?=self::renderContent(Util::getLiteral('no_script_message'))?></div>
	</noscript>
	<!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

	<header>
		<h1><a class="ir brand" href="#"><img src="/core/img/html5/pptvivo.png" alt="" /></a></h1>
		 <?
				echo Header::render();

			?>
	</header>
		
	<div id="container" class="clearfix">
		<div id="container2" class="section-content clearfix" >
		
		<!-- Facebook Share container - Don't delete them, is used in Player.view.php -->
		<div id="fb-root"></div>
			
			<div id="container3a" class="wrapper clearfix">		    
				
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
							
					</div>
					
				</div>
				
			</div>
			
 		</div>
 		
	</div>
	
	<?
		echo FooterView::render();
	?>
	
	<script type="text/javascript" src="/core/js/main.js"></script>
	<script type="text/javascript" src="/core/js/plugins.js"></script>
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