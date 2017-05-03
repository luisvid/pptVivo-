<?php
class FooterView extends Render {

    static public function render () {
    	
		ob_start();
		
?>
		<footer>
			<div id="footer-brand">			<img src="/core/img/html5/pptvivo-footer.png" alt="" />		</div>
			<div id="footer-links">
				© 2012 ppt Vivo! All right reserved.  -  <a href="#">Terms of use</a>  -  <a href="#">Features</a>  -  <a href="#">How it works</a>  -  <a href="#">Contact</a>  -  <a href="#">Facebook</a>  -  <a href="#">Twitter</a>
			</div>
		</footer>
<?php 		
		return ob_get_clean();
    }
    
}