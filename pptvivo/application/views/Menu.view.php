<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/MenuManager.class.php');

class Menu extends Render {
    
	static public function renderHeaderMenu () {
		
		MenuManager::setDefaultMenu();
    	
		ob_start();
		
    	?>
				
			<?php
			if(isset($_SESSION['basicMenu']) && is_array($_SESSION['basicMenu']) && count($_SESSION['basicMenu']) > 0){
			
				$html='';
				$existActive = false;
				
				foreach ($_SESSION['basicMenu'] as $level1){
					
					$activo='';
					$liactivo = '';
					
					$actionUrl = strstr($level1['url'],'action=');
					
					if($actionUrl !== false){
						$actionUrl = str_replace('action=', '', $actionUrl);
					}
					
					$existLogin = strstr($actionUrl, '&loginRequired');
					
					if($existLogin !== false){
						$actionUrl = str_replace($existLogin, '', $actionUrl);
					}
					
					if(isset($_REQUEST['action']) && $_REQUEST['action'] == $actionUrl && !$existActive){
						$activo = 'active';
						$liactivo = 'active';
						$existActive = true;
					} elseif(isset($level1['id']) && $level1['id'] == $_REQUEST['currentContent']['id'] && !isset($_REQUEST['action'])){
						$activo = 'active';
						$liactivo = 'active';
						$existActive = true;
					}
					
					$html.='<li class="top '.$liactivo.'">';
					
					$target ='';
					
					$href ='/'.$_SESSION['s_languageIsoUrl'].'/'.$level1['url'];
					
					$html.='<a class="'.$activo.' top_link" href="'.$href.'" '.$target.'><span class="down">'.$level1['title'].'</span><!--[if gte IE 7]><!--></a><!--<![endif]-->';							
					
					if(isset($level1['submenu']) && $level1['submenu']!=''){
						$html .= self::drawMultiLevelMenuTree($level1["submenu"],$level1["id"],$_SESSION['s_languageIsoUrl'],1,$level1['id']);
					}	
					$html.='</li>';
				}
				echo $html;
			}
			?>
				
		<?
		return ob_get_clean();
    }
      
 	static public function renderMenu () {
		
 		$menu = MenuManager::getFullMenu();
		
 		if (!isset($menu) || count($menu) == 0){
			return;
		}
		
    	ob_start();
    	?> 
		<div class="top-menu-01">
			<h2 class="tit-menu-lat"><?=$_REQUEST['BreadcrumbParent']['content_title']?></h2>
		</div>
			
		<div class="content-menu-lat">	
			
			<div class="menu-lat">		
				
				<ul class="menu-left">
				<?php
				//Dibujo el primer nivel del menú
				if(is_array($menu)){
					
					foreach($menu as $key => $value){
						
						$selected = '';
						$button_class = 'expand_button';				
						
						if(in_array($value['id'], $_REQUEST['section_selected'])){
							
							$button_class = 'collapse_button';
							
							end($_REQUEST['section_selected']);
								
							if($value['id'] == current($_REQUEST['section_selected'])){
								$selected = ' selected_item ';
							}	
						}
						
						echo "<li id='submenu_item_lvl_".$value['id']."' class='submenu_item_lvl_1 submenu_item base-blue'>";        
				      	
						if(isset($value['submenu']) and is_array($value['submenu']) and count($value['submenu'])>0){
							echo "<div class='".$button_class."' onclick=\"toggleMenuItem('submenu_".$value['id']."');\">&nbsp;</div>";
						}
						
						else{
							echo "<div class='no_button' onclick=\"\">&nbsp;</div>";
						}
						
						echo "<a href='/".$_SESSION['s_languageIsoUrl']."/".$value['url']."' class='base-blue".$selected."'>".$value['title']."</a>";
						
						if(isset($value['submenu'])){
					    	self::drawTree($value['submenu'],$_REQUEST['section_selected'],$value['id'],$_SESSION['s_languageIsoUrl']);
					    }
					    echo "</li>";
					}
				}	
				?>

				</ul>
		
			</div>
	
		</div>    	
		<?
		
		return ob_get_clean();
    }    	       

    //Dibuja el árbol de menú de la forma "primero en profundidad"
    private static function drawTree($node, $section_selected, $parentId, $siteUrl){
		
    	if(is_array($node) and count($node) > 0){
			
    		$isSelected = false;
			
    		foreach($node as $value){
				
    			if(in_array($value['id'], $section_selected) || in_array($value['parentid'], $section_selected)){           
					echo "<ul id='submenu_".$parentId."' class='submenu_subitem selected base-dark-grey'>";
					$isSelected = true;
					break;
				}    
			}
			
			if(! $isSelected){
				echo "<ul id='submenu_".$parentId."' class='submenu_subitem base-dark-grey' style='display:none;'>";
			}
			                  
			foreach($node as $key => $value){
				
				$selected = '';
				$button_class = 'expand_button';
				
				if(in_array($value['id'], $section_selected)){           
					
					$button_class = 'collapse_button';
					
					end($section_selected);
					
					if($value['id'] == current($section_selected)){
						$selected = ' selected_item ';
					}	
				}
				
				echo "<li id='submenu_item_lvl_".$value['id']."' class='submenu_item_lvl_2 submenu_item base-dark-grey'>";          
				
				if(isset($value['submenu']) and is_array($value['submenu']) and count($value['submenu'])>0){
					echo "<div class='".$button_class."' onclick=\"toggleMenuItem('submenu_".$value['id']."');\">&nbsp;</div>";
				}else{
					echo "<div class='no_button' onclick=\"\">&nbsp;</div>";
				}
			    
				echo "<a href='/".$siteUrl."/".$value['url']."' class='base-dark-grey".$selected."'>".$value['title']."</a>";
			    
				if(isset($value['submenu'])){
					self::drawTree($value['submenu'],$section_selected,$value['id'], $siteUrl);
				}
				
			    echo "</li>";
			    
			}
			
			echo "</ul>";
			     
		}
	}
    
	private static function drawMultiLevelMenuTree($node, $parentId, $lang, $level, $section_pfwid){
		
		$html='';
		
		if(is_array($node) and count($node) > 0){
			
			$level++;
			
			$html.='<ul class="sub">';
			
			foreach($node as $key => $value){
				
				$activo = '';
				$classBlue = '';
				
				if($value["id"] == $section_pfwid){
					$activo = 'submenu-activo';
				}
				
				$html.='<li class="webmap0'.$level.' imgmap0'.$level.'">';
					
				if(isset($value['submenu']) && count($value['submenu'])>0){
					$classBlue = 'blue';
				}					
				
				$html.='<a class="'.$activo.' '.$classBlue.'" href="/'.$lang.'/'.$value['url'].'">';
				
				$html.=$value['title'];
				
				$html.='</a>';
				
				if(isset($value['submenu'])){
					$html.=self::drawMultiLevelMenuTree($value['submenu'], $value['id'], $lang, $level, $section_pfwid);
				}
				
				$html.='</li>';
				
			}
			
			$html.='</ul>';
			
		}
		
		return $html;
		
	}
    
}