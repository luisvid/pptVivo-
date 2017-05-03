<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/actionManagers/usersActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once 'twitter/twitteroauth.php';
require_once 'config/twconfig.php';

session_start ();

//Check twitter session data
if (! empty ( $_GET ['oauth_verifier'] ) && ! empty ( $_SESSION ['oauth_token'] ) && ! empty ( $_SESSION ['oauth_token_secret'] )) {
	
	try{
	
		// We've got everything we need
		$twitteroauth = new TwitterOAuth ( YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION ['oauth_token'], $_SESSION ['oauth_token_secret'] );
		
		// Let's request the access token
		$access_token = $twitteroauth->getAccessToken ( $_GET ['oauth_verifier'] );
		
		// Save it in a session var
		$_SESSION ['access_token'] = $access_token;
		
		// Let's get the user's info
		$user_info = $twitteroauth->get ( 'account/verify_credentials' );
		
		if (isset ( $user_info->error )) {
			// Something's wrong, go back to square 1  
			header ( 'Location: login-twitter.php' );
		} 
		else {
	
			//Insert user in local app
			$userActionManager = new usersActionManager();
			
			$userData ['oauth_provider'] = 'twitter';
			$userData ['oauthId'] = $user_info->id;
			$userData ['name'] = $user_info->name;
			$userData ['loginTypeId'] = constant('pptvivoConstants::LOGIN_TYPE_'.strtoupper($userData['oauth_provider']));
			
			$result = $userActionManager->insertExternalUser($userData);
			
			//Succesfull inserting - Session variables creation
			if ($result) {
				$_SESSION ['s_externalLoginId'] = $user_info->id;
				$_SESSION ['s_oauthId'] = $user_info->id;
				$_SESSION ['s_externalLoginUsername'] = $user_info->name;
				$_SESSION ['s_oauthProvider'] = $userData ['oauth_provider'];
				$_SESSION ['s_oauthProviderId'] = $userData ['loginTypeId'];
				
				header ( "Location: /?action=externalLogin" );
				
			}
			else{
				throw new Exception(Util::getLiteral('error_inserting_user'));
			}
		}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
}
else {
	// Something's missing, go back to square 1
	header ( 'Location: login-twitter.php' );
}