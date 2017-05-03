<?php
class FooterView extends Render {

    static public function render () {
    	
		ob_start();
		
?>
		<footer>
			<div id="footer-brand">
				<img src="/core/img/html5/pptvivo-footer.png" alt="" />
			</div>
			<div id="footer-links">
				© 2013 ppt Vivo! All right reserved.  -  
				<a href="?action=termsOfService">Terms of Service</a>  -
				<a href="?action=privacy">Privacy</a>  - 
				
				<?php
           		if($_REQUEST['REQUEST_URI'] === '/' . $_SESSION['s_languageIsoUrl']){
				?>
				<a href="#features">Features</a> - 
				<a href="#howitworks">How it works</a> - 
				<?php
				}
				else{
				?>
				<a href="?action=features">Features</a> - 
				<a href="?action=howitworks">How it works</a> -
				<?php
           		} 
           		?>
				<a href="mailto:hello@pptvivo.com">Contact</a>  -  
				<a href="https://www.facebook.com/pptvivo" target="_blank">Facebook</a>  -  
				<a href="https://twitter.com/pptvivo" target="_blank">Twitter</a>
			</div>
		</footer>
<?php 		
		return ob_get_clean();
    }
    
}