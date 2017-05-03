<?php
if (array_key_exists ( "login", $_GET )) {
	
	try{
	
		$oauth_provider = $_GET ['oauth_provider'];
		
		if ($oauth_provider == 'twitter') {
			header ( "Location: /services/social_networks_login/login-twitter.php" );
		}
		else if ($oauth_provider == 'facebook') {
			header ( "Location: /services/social_networks_login/login-facebook.php" );
		}
		
	}
	catch(Exception $e){
		header ( "Location: /?showerror=1&errormsg=" . base64_encode($e->getMessage()) );
	}
}
else{
	header ( "Location: /" );
}