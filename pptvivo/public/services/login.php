<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/LoginException.exception.php';

$configurator = Configurator::getInstance ();

session_start ();

//Logger
$_SESSION ['logger'] = MyLogger::getInstance ();

class userLogin{
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		
		if (! isset ( userLogin::$instance )) {
			self::$instance = new userLogin ();
		}
		
		return userLogin::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	public function performLogin($login, $password){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		try{
			
			if (! isset ( $login ) || $login == null) {
				$_SESSION['logger']->error ( 'Username parameter expected' );
				throw new InvalidArgumentException ( 'Username parameter expected' );
			}
		
			if (! isset ( $password ) || $password == null) {
				$_SESSION['logger']->error ( 'Password parameter expected' );
				throw new InvalidArgumentException ( 'Password parameter expected' );
			}
			
			$userManager = UserManager::getInstance();
			
			$user = $userManager->getUserByLogin($login, true);
			
			if(!isset($user[0]) || !is_object($user[0]) ){
				$_SESSION['logger']->error ('User not found');
			    throw new LoginException('User not found');
			}
			
			if (crypt(trim($password), $user[0]->getUserPassword()) != trim($user[0]->getUserPassword())) {
				$_SESSION['logger']->error ('Password incorrect');
			    throw new LoginException('Password incorrect');
			}
			
			$response = $user[0]->getId();
			$message = '';
		
		}
		catch (Exception $e){
			$response = 0;
			$message = $e->getMessage();
		}
		
		$xmlString = '
						<loginService>
							<response value="'.$response.'" message="'.trim($message).'"></response>
						</loginService>
						';
			
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
	}
	
}

$userLogin = userLogin::getInstance();

echo $userLogin->performLogin($_REQUEST['userLogin'], $_REQUEST['userPassword']);