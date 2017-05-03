<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/actionManagers/usersActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once 'facebook/facebook.php';
require_once 'config/fbconfig.php';

session_start();

$facebook = new Facebook ( array ('appId' => APP_ID, 'secret' => APP_SECRET, 'cookie' => true ) );

$user = $facebook->getUser();

if (! empty ( $user )) {
	
	# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
	try {
		
		//Facebook user data loading
		$uid = $user;
		$user = $facebook->api ( '/me' );
	
		if (! empty ( $user )) {
	
			//Insert user in local app
			$userActionManager = new usersActionManager();
			
			$userData ['oauth_provider'] = 'facebook';
			$userData ['oauthId'] = $uid;
			$userData ['first_name'] = $user ['first_name'];
			$userData ['last_name'] = $user ['last_name'];
			$userData ['email'] = $user ['email']; 
			$userData ['loginTypeId'] = constant('pptvivoConstants::LOGIN_TYPE_'.strtoupper($userData['oauth_provider']));
			
			$result = $userActionManager->insertExternalUser($userData);
			
			//Succesfull inserting - Session variables creation
			if ($result) {
				$_SESSION ['s_externalLoginId'] = $uid;
				$_SESSION ['s_oauthId'] = $uid;
				$_SESSION ['s_externalLoginUsername'] = $user ['name'];
				$_SESSION ['s_oauthProvider'] = $userData ['oauth_provider'];
				$_SESSION ['s_oauthProviderId'] = $userData ['loginTypeId'];

				header ( "Location: /?action=externalLogin" );
				
			}
			else{
				/**
				 * TODO: VERIFICAR DE VOLVER A LA PANTALLA DE INICIO, EN LO POSIBLE AL POPUP,
				 * O BIEN SOLO VOLVER A LA PANTALLA DE INICIO CON UN POPUP DE ERROR
				 *       EL POSIBLE VALOR PARA MOSTRAR EN EL POPUP ES showerror, VERIFICAR/DEBUGUEAR
				 * PARA VER POR QUE NO SE MUESTRA EL MENSAJE EN EL CUERPO DEL POPUP
				 *       VERIFICAR LA FORMA DE HACER LOGOUT DE FACEBOOK PARA QUE EL SDK DESTRUYA LAS
				 * COOKIES, SINO QUEDA PEGADO EL USUARIO DE FACEBOOK Y NO DEJA INTRESAR UNO NUEVO PARA
				 * PROBAR CON OTRA CUENTA.
				 */
				//showerror=".Util::getLiteral('email_already_exists')
				//."&
				//errormsg=".Util::getLiteral('error_inserting_user') );
				//header ( "Location: /?showerror=email_already_exists" );
				throw new Exception(Util::getLiteral('error_inserting_user'));
			}
		}
		//Unsuccessful login
		else {
			throw new Exception(Util::getLiteral('facebook_login_error'));
		}
	}
	catch ( Exception $e ) {
		echo $e->getMessage ();
	}
}
else {
	# There's no active session, let's generate one
	if(Util::getDomain($_SERVER['SERVER_NAME'])) {
		$redirect_uri = 'http://www.'.Util::getDomain($_SERVER['SERVER_NAME']);
	} else {
		throw new Exception(Util::getLiteral('facebook_login_error'));
	}
	$login_url = $facebook->getLoginUrl (array(
		'scope'			=> 'email',
		'redirect_uri'	=> $redirect_uri.'/services/social_networks_login/login-facebook.php'
	));
	header ( "Location: " . $login_url );
}
