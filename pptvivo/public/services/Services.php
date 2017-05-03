<?php
header("Content-type:text/html; charset=utf-8");
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/LoginException.exception.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/managers/PresentationsManager.class.php';

$configurator = Configurator::getInstance ();

session_start ();

//Time zone
date_default_timezone_set($configurator->getDefaultTimeZone());

//Logger
$_SESSION ['logger'] = MyLogger::getInstance ();

class Services {
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		
		if (! isset ( Services::$instance )) {
			self::$instance = new Services ();
		}
		
		return Services::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	public function getExpositionQuestions(){
		
		$questions = '';
		
		if(isset($_GET['expositionId']) && $_GET['expositionId'] != null){
			
			$presentationsManager = PresentationsManager::getInstance();
			$questionsList = $presentationsManager->getExpositionQuestions($_GET['expositionId']);
			
			$response = '1';
			$questions .= "<questions>";
			
			if(count($questionsList) > 0){
				foreach ($questionsList as $question){
					
					$userName = '';
					$questionUsername = $question->getUsername();
					$questionUserSurname = $question->getUsersurname();
					if(isset($questionUsername) && $questionUsername != null){
						$userName .= $question->getUsername();
					}
					if(isset($questionUserSurname) && $questionUserSurname != null){
						$userName .= ' ' . $question->getUsersurname();
					}
					
					if($userName == ''){
						$userName .= $question->getUserlogin();
					}
					
					$questions .= '<question>
										<description>'.$question->getQuestion().'</description>
										<slide>'.$question->getSlide().'</slide>
										<username>'.htmlentities($userName).'</username>
								   </question>';	
				}
			}
			$questions .= "</questions>";
		}
		else {
			$response = 'error';
		}
		
		$xmlString = '
			<presentationData>
				<response value="'.$response.'">
					'.$questions.'
				</response>
			</presentationData>
			';
		
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
	public function createExposition(){
		
		if(isset($_GET['presentationId']) && $_GET['presentationId'] != null){
			$presentationsManager = PresentationsManager::getInstance();
			$response = $presentationsManager->createExposition($_GET['presentationId']);
		}
		else{
			$response = 'error';
		}
		
		$xmlString = '
			<presentationData>
				<response value="'.$response.'"></response>
			</presentationData>
			';
		
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
	public function uploadFile(){
		
		if(isset($_REQUEST['login']) && $_REQUEST['login'] != null && isset($_REQUEST['password']) && $_REQUEST['password'] != null){
			
			try{
				$this->internalLogin($_REQUEST['login'], $_REQUEST['password']);
				
				$_POST['control_userId'] = $_SESSION['loggedUser']->getId();
				$_POST['control_title'] = $_REQUEST['presentationTitle'];
				$_POST['control_description'] = $_REQUEST['prsentationDescription'];
				
				$presentationsManager = PresentationsManager::getInstance();
				
				$result = $presentationsManager->createPresentation($_POST, $_FILES['file']);
				
				if($result){
					$response = '1';
				}
				else{
					$response = 'Error uploading file';
				}
				
			}
			catch (Exception $e){
				$response = $e->getMessage();
			}
			
		} else {
			$response = 'Username and password are required';
		}
		
		$xmlString = '
			<presentationData>
				<response value="'.$response.'">
				</response>
			</presentationData>
			';
		
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
	public function getExpositionUrl(){
		
		$qrCode = '';
		
		if(isset($_GET['login']) && $_GET['login'] != null && isset($_GET['password']) && $_GET['password'] != null){
			try{
				$this->internalLogin($_GET['login'], $_GET['password']);
				
				if(isset($_GET['presentationId']) && $_GET['presentationId'] != null){
					$presentationsManager = PresentationsManager::getInstance();
					
					$presentation = $presentationsManager->getPresentationById($_GET['presentationId']);
					
					if(!$presentation){
						$response = 'Error. Invalid presentation Id';
					} else{
						$expositionId = $presentationsManager->createExposition($_GET['presentationId']);
						
						$contentUrl = Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);
						$presentationUrl = $_SESSION['s_parameters']['player_url'] . $contentUrl . '/' . $_SESSION ['loggedUser']->getUserlogin () . '/' . $presentation->getId();
						$expositionUrl = $presentationUrl . '/' . $expositionId;
						
						$response = Util::getShortenUrl($expositionUrl);
						
						$qrCode .= Util::getCurrenProtocol() . '/' . $contentUrl . '?action=viewQR&qrPath=' . base64_encode(Presentation::getQR($expositionUrl));
						
					}
					
				}
				else{
					$response = 'Error. Invalid presentation Id';
				}
				
			}
			catch (Exception $e){
				$response = $e->getMessage();
			}
		} else {
			$response = 'Username and password are required';
		}
		
		$xmlString = '
			<presentationData>
				<response>
					<url value="'.$response.'"></url>
					<qrcode value="'.urlencode($qrCode).'"></qrcode>
				</response>
			</presentationData>
			';
		
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
	protected function internalLogin($login, $password){
			
		$userManager = UserManager::getInstance();
		
		if (! isset ( $login ) || $login == null) {
			$_SESSION['logger']->error ( 'Username parameter expected' );
			throw new InvalidArgumentException ( 'Username parameter expected' );
		}
	
		if (! isset ( $password ) || $password == null) {
			$_SESSION['logger']->error ( 'Password parameter expected' );
			throw new InvalidArgumentException ( 'Password parameter expected' );
		}
		
		$user = $userManager->getUserByLogin($login, true);
		
		if(!isset($user[0]) || !is_object($user[0]) ){
		    throw new LoginException(Util::getLiteral('login_error_user_not_found'));
		}
		
		if (crypt(trim($password), $user[0]->getUserPassword()) != trim($user[0]->getUserPassword())) {
		    throw new LoginException(Util::getLiteral('login_error_password_incorrect'));
		}
		
		$_SESSION ['loggedUser'] = $user[0];
			
	} 

}

if(isset($_GET['action']) && $_GET['action'] != null){
	
	$services = Services::getInstance();
	
	if(method_exists($services, $_GET['action'])){
		echo $services->$_GET['action']();	
	}
	
}