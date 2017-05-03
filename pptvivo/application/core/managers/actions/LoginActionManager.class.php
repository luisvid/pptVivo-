<?php
/**
 * Implements Login actions
 *
 * @package core.managers.actions
 * @author Gabriel Guzman
 * @version 1.0
 *
 * DATE OF CREATION: 15/03/2012
 * UPDATE LIST
 * 
 * CALLED BY: ActionManager execute
 */

$configurator = Configurator::getInstance ();

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ActionManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/RenderActionResponse.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/RedirectActionResponse.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/Login.view.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/LoginCaptcha.view.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/ChangePass.view.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/Master.view.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/MessageBoxType.enum.php');

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/actionManagers/usersActionManager.class.php');

class LoginActionManager extends ActionManager {
	
	protected $defaultAction = "view";
	
	protected static $instance;
	
	public function __construct() {
	}
	
	protected function popupLogin(){
		
		$currentUrl = urldecode ( $_REQUEST ['REQUEST_URI'] );
		
		$view = PopupLogin::render();
		
		$actionResponse = new RenderActionResponse ( $view, $currentUrl );
		
		return $actionResponse;
		
	}
	
	protected function view($showerror = false, $errormsg = null) {
		
		$currentUrl = urldecode ( $_REQUEST ['REQUEST_URI'] );
		
		if(isset($_REQUEST['showerror']) && $_REQUEST['showerror'] != null){
			$showerror = $_REQUEST['showerror'];
		}
		
		if(isset($_REQUEST['errormsg']) && $_REQUEST['errormsg'] != null){
			$errormsg = base64_decode($_REQUEST['errormsg']);
		}
		
		$view = Login::render ( $showerror, $currentUrl, $_REQUEST ['returnUrl'], $_REQUEST ['returnAction'], $errormsg );
		
		$actionResponse = new RenderActionResponse ( $view, $currentUrl );
		
		return $actionResponse;
		
	}
	
	protected function login() {
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		try{
		
			$userManager = UserManager::getInstance();
			
			$user = $userManager->getUserByLogin($_REQUEST['login_user'], true);
			
			if(!isset($user[0]) || !is_object($user[0]) ){
			    throw new LoginException(Util::getLiteral('login_error_user_not_found'));
			}
			
			if (crypt(trim($_REQUEST['login_password']), $user[0]->getUserPassword()) != trim($user[0]->getUserPassword())) {
			    throw new LoginException(Util::getLiteral('login_error_password_incorrect'));
			}
			
			$_SESSION ['loggedUser'] = $user[0];
			
			$urlhome = $this->getUrl ();
			
			$actionResponse = new RedirectActionResponse ( $urlhome );
		
		}
		catch (LoginException $e){
			$_SESSION['logger']->error($e->getMessage());
			$actionResponse = $this->view(true, $e->getMessage());						
		}
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $actionResponse;
		
	}
	
	protected function loginAjax(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		try{
		
			$userManager = UserManager::getInstance();
			
			$user = $userManager->getUserByLogin($_REQUEST['login_user'], true);
			
			if(!isset($user[0]) || !is_object($user[0]) ){
			    throw new LoginException(Util::getLiteral('login_error_user_not_found'));
			}
			
			if (crypt(trim($_REQUEST['login_password']), $user[0]->getUserPassword()) != trim($user[0]->getUserPassword())) {
			    throw new LoginException(Util::getLiteral('login_error_password_incorrect'));
			}
			
			$_SESSION ['loggedUser'] = $user[0];
			
			$html = '<div id="errorCodeAjax">0</div>';
			
			$actionResponse = new AjaxRender($html);
		
		}
		catch (LoginException $e){
			$_SESSION['logger']->error($e->getMessage());
			
			$html = '<div id="error">' . $e->getMessage() . '</div>';
			
			$actionResponse = new AjaxRender($html);						
		}
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $actionResponse;
		
	}
	
	protected function logout() {
		
	    if (! session_id ()) {
			session_start ();
		}
		
		$this->operationLogout ();
		
		$actionresponse = new RedirectActionResponse ( '/' . $_SESSION ['s_languageIso'] . '/login?logout=1' );
		
		return $actionresponse;
	}
	
	private function operationLogout() {
		
		$actualLanguageCode = $_SESSION ['s_languageIso'];
		
		$actualLanguageId = $_SESSION ['s_languageId'];
		
		unset($_SESSION);
		
		session_destroy();		
		
		$_SESSION ['s_languageIso'] = $actualLanguageCode;
		
		$_SESSION ['s_languageId'] = $actualLanguageId;
		
		$_SESSION ['logger'] = MyLogger::getInstance ();
		
	}
	
	private function getUrl() {
		
		$sectionName = '';
		
		if (isset ( $_REQUEST ['urlargs'] ) && count ( $_REQUEST ['urlargs'] ) > 1) {
			$sectionName = $_REQUEST ['urlargs'] [1];
		}
		
		$_SESSION['logger']->info ( "correct login process end" );
		
		if (isset ( $_SERVER ['HTTP_REFERER'] ) && $_SERVER ['HTTP_REFERER'] != '') {
			$refererURI = parse_url ( $_SERVER ['HTTP_REFERER'] );
		}
		
		if (isset ( $_REQUEST ['returnUrl'] ) && $_REQUEST ['returnUrl'] != '') {
			$returnURI = parse_url ( $_REQUEST ['returnUrl'] );
		}
		
		if (isset ( $_REQUEST ['REQUEST_URI'] ) && $_REQUEST ['REQUEST_URI'] != '') {
			$requestURI = parse_url ( $_REQUEST ['REQUEST_URI'] );
		}
		
		if (isset ( $_REQUEST ['returnUrl'] ) && $_REQUEST ['returnUrl'] != '' && strpos ( $_REQUEST ['returnUrl'], '/' . $_SESSION ['s_languageIsoUrl'] . '/' . $sectionName ) === false && $returnURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl'] . '/' && $returnURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl']) {
			$urlhome = $_REQUEST ['returnUrl'];
		} else if (isset ( $_SERVER ['HTTP_REFERER'] ) && strpos ( $_SERVER ['HTTP_REFERER'], '/' . $_SESSION ['s_languageIsoUrl'] . '/' . $sectionName ) === false && $refererURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl'] . '/' && $refererURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl']) {
			$urlhome = $_SERVER ['HTTP_REFERER'];
		} else if (isset ( $_REQUEST ['REQUEST_URI'] ) && strpos ( $_REQUEST ['REQUEST_URI'], '/' . $_SESSION ['s_languageIsoUrl'] . '/login' ) === false && $requestURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl'] . '/' && $requestURI ['path'] != '/' . $_SESSION ['s_languageIsoUrl']) {
			$urlArr = explode ( '?', $_SERVER ['REQUEST_URI'] );
			$params = '';
			foreach ( $_GET as $key => $val ) {
				if ($key != 'passport') {
					if ($params != '') {
						$params .= '&';
					} else {
						$params = '?';
					}
					$params .= $key . '=' . $val;
				}
			}
			$urlhome = $urlArr [0] . $params;
		
		} else {
			if ((isset ( $_REQUEST ['language'] ) && $_REQUEST ['language'] == LoginActionManagerActions::DEFAULTUSER) || (isset ( $_SERVER ['REMOTE_USER'] ) && $_SERVER ['REMOTE_USER'] != '')) {
				if (array_key_exists ( $_SESSION ['PFW_USRLNG'], $_SESSION ['s_GUI_languages'] )) {
					$userLanguage = $_SESSION ['PFW_USRLNG'];
				} else {
					$userLanguage = $_SESSION ['s_defaultLanguageCode'];
				}
			} else {
				$userLanguage = $_SESSION ['s_languageIsoUrl'];
			}
			$urlhome = '/' . $userLanguage . '/';
		}
		
		return $urlhome;
		
	}
	
	protected function registerUser(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->registerUser();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function register(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->create();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	public function errorMessage(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new CommonActionManager ();
		
		$render = $actionManager->errorMessage();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function activateUser(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->activateUser();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function externalLogin(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		try{
		
			$uidFilter = new NumberFilter('oauthid', '', null, 'userlogintype.oauthid');
			$uidFilter->setSelectedValue($_SESSION['s_oauthId']);		
			
			$providerFilter = new NumberFilter('logintypeid', '', null, 'userlogintype.logintypeid');
			$providerFilter->setSelectedValue($_SESSION ['s_oauthProviderId']);
			
			$filters = array($uidFilter, $providerFilter);
			
			$userManager = UserManager::getInstance();
			
			$user = $userManager->getUser($filters);
			
			if(!isset($user[0]) || !is_object($user[0]) ){
			    throw new LoginException(Util::getLiteral('login_error_user_not_found'));
			}
			
			$_SESSION ['loggedUser'] = $user[0];
			
			$urlhome = $this->getUrl ();
			
			$actionResponse = new RedirectActionResponse ( $urlhome );
		
		}
		catch (LoginException $e){
			$_SESSION['logger']->error($e->getMessage());
			$actionResponse = $this->view(true, $e->getMessage());						
		}
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $actionResponse;
		
	}

	protected function forgotPassword(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->forgotPassword();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function loginFormPopup(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->loginFormPopup();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function restorePasswordMail(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->restorePasswordMail();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function restorePassword(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->restorePassword();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
	protected function resetPassword(){
		
		$_SESSION['logger']->debug ( __METHOD__ . " begin" );
		
		$actionManager = new usersActionManager();
		
		$render = $actionManager->resetPassword();
		
		$_SESSION['logger']->debug ( __METHOD__ . " end" );
		
		return $render;
		
	}
	
}