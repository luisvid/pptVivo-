<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/MailHelper.class.php';

class usersActionManager extends ModuleActionManager {
	
	protected $manager;
	
	public function __construct() {
		
		$this->manager = UserManager::getInstance ();
	
	}
	
	protected function getUserTypesFilter($subConcept) {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$userTypesList = $this->manager->getUserTypes ();
		
		$userTypesFilter = new SelectFilter ( 'userTypeId', $_SESSION ['s_message'] ['usertype'], 'usertypeid', false, '', true, false );
		
		foreach ( $userTypesList as $userType ) {
			$userTypesFilter->addValue ( $userType->getId (), $userType->getTypename () );
		}
		
		if (isset ( $_REQUEST ['filter_userTypeId'] )) {
			$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] = $_REQUEST ['filter_userTypeId'];
		} else {
			if (isset ( $_POST ['filter_name'] )) {
				$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] = '';
			}
		}
		
		if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] != '') {
			$userTypesFilter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] );
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		return $userTypesFilter;
	
	}
	
	public function getList($maxQuantity) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'usersList';
		
		//Pager variables
		$count = $_SESSION ['s_parameters'] ['page_size'];
		
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] != '' && is_numeric ( $_REQUEST ['page'] )) {
			$page = $_REQUEST ['page'];
		} else {
			$page = '';
		}
		
		if ($page == '') {
			$begin = 0;
			$page = 1;
		} else {
			$begin = ($page - 1) * $count;
		}
		
		$filters = array ();
		
		//name filter
		$filters [] = $this->getTextFilter('name', $_SESSION ['s_message'] ['name'], 50, 'username', $subConcept);
		
		//surname filter
		$filters [] = $this->getTextFilter('surname', $_SESSION ['s_message'] ['surname'], 50, 'usersurname', $subConcept);
		
		//e-mail filter
		$filters [] =  $this->getTextFilter('email', $_SESSION ['s_message'] ['email'], 255, 'useremail', $subConcept);
		
		//usertypes filter
		//$filters [] = $this->getUserTypesFilter ( $subConcept );
		
		//Count
		$numrows = $this->manager->getUsersCount ( $filters );
		
		$usersList = array();
		
		if($numrows > 0){
			//List
			$usersList = $this->manager->getUsersList ( $begin, $count, $filters );
		}
		
		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'usersFilter', '', '', '', 3 );
		$filterGroup->setFiltersList ( $filters );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/usersList.view.php';
		
		$render = usersList::render ( $usersList, $filterGroup, $pager );
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function delete() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$userId = $_REQUEST ['userId'];
		
		try {
			$result = $this->manager->deleteUser ( $userId );
			
			if ($result) {
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
			} else {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_deleting_user'], null, $_SESSION ['s_message'] ['error'] );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_user'] );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_deleting_user'], null, $_SESSION ['s_message'] ['error'] );
		}
	
	}
	
	public function create() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try {

			foreach ($_POST as $key => $val){
				$_POST[$key] = htmlentities($val,ENT_NOQUOTES,'UTF-8');
			}
			
			//update
			if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
				
				$result = $this->manager->updateUser ( $_REQUEST ['userId'], $_POST );
				
				if ($result) {
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
				} else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_updating_user'], null, $_SESSION ['s_message'] ['error'] );
				}
			
			} //insert
			else {
				
				//Default usertype (registered user)
				$_POST['control_userTypeId'] = pptvivoConstants::USERTYPE_USER;
				
				//Remove spaces from name
				$_POST ['control_userLogin'] = str_replace(' ', '_', trim($_POST ['control_userLogin']));
				
				$result = $this->manager->insertUser ( $_POST );
				
				if ($result) {
					
					//Save additional user data
					$_POST['userId'] = $result;
					$_POST['control_plan'] = pptvivoConstants::PLAN_GOLD;
					$resultData = $this->manager->insertUserData($_POST);
					
					if($resultData){
						
						$_POST['loginTypeId'] = pptvivoConstants::LOGIN_TYPE_NATIVE;
						
						//Insert Login type
						$resultLoginType = $this->manager->insertUserLoginType($_POST);
						
						if($resultLoginType){
						
							//Send activation mail
							$mailHelper = new MailHelper();
							
							$vars = array();
							$vars [] = $_POST['control_userName'] . ' ' . $_POST ['control_userSurname'];
							
							//Users module url
							$usersUrl = Util::getContentUrl(array('users'), $_SESSION['s_languageId']);
							
							$fullUsersUrl = getCurrenProtocol(). '/'.$usersUrl.'?action=activateUser&key='.base64_encode($result);
							
							$vars [] = $fullUsersUrl;
							
							$mailSend = $mailHelper->sendMail(
																array($_POST['control_userEmail']), 
																$_SESSION['s_parameters']['mail_from'], 
																$_SESSION['s_parameters']['mail_from_name'], 
																null, 
																'activate_account',
																$vars
															);
	
							$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
							return new AjaxRender('<div class="success-result">'.'<br />' . Util::getLiteral('register_user_success') . '</div>');
						
						}
						else{
							//Delete user data
							$deleteResult2 = $this->manager->deleteUserData($result);
							
							//Delete created user
							$deleteResult = $this->manager->deleteUser($result);
						}
					}
					else{
						//Delete created user
						$deleteResult = $this->manager->deleteUser($result);
					}
					
				} else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxRender('<div class="error-result">'.'<br />' . $_SESSION ['s_message'] ['error_inserting_user'].'</div>');
				}
			
			}
		
		} catch ( Exception $e ) {
			
			if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRender('<div class="error-result">'.'<br />' . $_SESSION ['s_message'] ['error_updating_user'] . '<br />' . $e->getMessage().'</div>');
			} else {
				
				if(isset($result) && $result > 0){
					//Delete user login type
					$deleteResult3 = $this->manager->deleteUserLoginType($result);
					
					//Delete user data
					$deleteResult2 = $this->manager->deleteUserData($result);
					
					//Delete created user
					$deleteResult = $this->manager->deleteUser($result);
				}
				
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRender('<div class="error-result">'.'<br />' . $_SESSION ['s_message'] ['error_inserting_user'] . '<br />' . $e->getMessage().'</div>');
			}
		}
	
	}
	
	public function createUser(){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    $fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', $_SESSION['s_message']['name'], 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', $_SESSION['s_message']['surname'], 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', $_SESSION['s_message']['email'], 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(false, 'userLogin', $_SESSION['s_message']['user'], 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(true);
	    
	    //Usertype field
	    $fields ['usertype'] = $this->getSelectControl('userTypeId', $_SESSION['s_message']['usertype'], false, '', false, true, true);
	    
	    $userTypes = $this->manager->getUserTypes();
	    
	    foreach ($userTypes as $userType){
	    	$fields ['usertype']->addValue($userType->getId(), $userType->getTypeName());
	    }
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/createUser.view.php';
	    
	    $render = createUser::render($fields, null, false);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['create_user'] );
	    
	}
	
	public function editUser(){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/createUser.view.php';
	    
	    $fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', $_SESSION['s_message']['name'], 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', $_SESSION['s_message']['surname'], 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', $_SESSION['s_message']['email'], 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(true, 'userLogin', $_SESSION['s_message']['user'], 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(false);
	    
	    //Usertype field
	    $fields ['usertype'] = $this->getSelectControl('userTypeId', $_SESSION['s_message']['usertype'], false, '', false, true, true);
	    
	    $userTypes = $this->manager->getUserTypes();
	    
	    foreach ($userTypes as $userType){
	    	$fields ['usertype']->addValue($userType->getId(), $userType->getTypeName());
	    }
	    
	    //getUserData
	    $user = $this->manager->getUserById($_REQUEST['userId']);
	    
	    $render = createUser::render($fields, $user[0], false);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['edit_user'] );
		
	}

	public function registerUser(){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    $fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', Util::getLiteral('name'), 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', Util::getLiteral('surname'), 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', Util::getLiteral('email'), 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(false, 'userLogin', Util::getLiteral('user'), 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(true);
	    
	    //Plan field
	    $fields['plan'] = $this->getSelectControl('plan', Util::getLiteral('plan'), false, '', false, true, true);
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/Register.view.php';
	    
	    $render = Register::render($fields);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, Util::getLiteral('register_user') );
		
	}
	
	public function activateUser(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
		
			$fields ['userId'] = base64_decode($_REQUEST['key']);
			
			$result = $this->manager->activeUser($fields);
			
			if($result){
				
				//Create user folder
				$createFolder = $this->createUserFolder($fields ['userId']);
				
				$message = base64_encode(Util::getLiteral('user_activate_success'));
				
			}
			else{
				$message = base64_encode(Util::getLiteral('user_activate_error'));
			}
			
			$redirectUrl = '/' . $_SESSION ['s_languageIsoUrl'] . '?action=view&showerror=1&errormsg='.$message.'&recentlyActivatedUser=1';
			
			sleep(2);
			
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new RedirectActionResponse ( $redirectUrl );
		
		}
		catch(Exception $e){
			$_SESSION ['logger']->error ( $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( $e->getMessage(), null, Util::getLiteral('error') );
		}
		
	}
	
	public function createUserFolder($userId){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$user = $this->manager->getUserById($userId);
		
		$configurator=Configurator::getInstance();
		$presentationsPathBase = $configurator->getPresentationsPath();
		
		$newFolder = $presentationsPathBase . $user[0]->getUserlogin();
		
		if(!mkdir($newFolder)){
			throw new Exception(Util::getLiteral('error_creating_user_folder'));
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;
		
	}
	
	public function insertExternalUser($userData){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			
			$uidFilter = new NumberFilter('oauthid', '', null, 'userlogintype.oauthid');
			$uidFilter->setSelectedValue($userData['oauthId']);		
			
			$providerFilter = new NumberFilter('logintypeid', '', null, 'userlogintype.logintypeid');
			$providerFilter->setSelectedValue($userData['loginTypeId']);
			
			$filters = array($uidFilter, $providerFilter);
			
			$existentUsers = $this->manager->getUser($filters);
			
			//Insert user
			if(!is_array($existentUsers) || count ($existentUsers) < 1){
				
				//Default usertype (registered user)
				$userData['control_userTypeId'] = pptvivoConstants::USERTYPE_USER;
				
				if(isset($userData['first_name']) && $userData['first_name'] != null){
					$userData ['control_userName'] = $userData ['first_name'];
				}
				else{
					$userData ['control_userName'] = $userData ['name'];
				}
				
				if(isset($userData['last_name']) && $userData['last_name'] != null){
					$userData ['control_userSurname'] = $userData ['last_name'];
				}
				else{
					$userData ['control_userSurname'] = '';
				}
				
				if(isset($userData['email']) && $userData['email'] != null){
					$userData ['control_userEmail'] = $userData ['email'];
				}
				else {
					$userData ['control_userEmail'] = '';				
				}

				$userData ['control_userLogin'] = $userData ['oauth_provider'] . '_' . $userData['oauthId'];
				$userData ['control_userPassword'] = '';
				
				$result = $this->manager->insertUser ( $userData );
					
				if ($result) {
					
					//Save additional user data
					$userData['userId'] = $result;
					$userData['control_plan'] = pptvivoConstants::PLAN_GOLD;
					$userData['active'] = 1;
					
					$resultData = $this->manager->insertUserData($userData);
					
					if($resultData){
						
						//Insert Login type
						$resultLoginType = $this->manager->insertUserLoginType($userData);
						
						if($resultLoginType){
							
							//Create user folder
							$createFolder = $this->createUserFolder($userData['userId']);
							
							
							$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
							return true;
						}
						else{
							//Delete user data
							$deleteResult2 = $this->manager->deleteUserData($result);
							
							//Delete created user
							$deleteResult = $this->manager->deleteUser($result);
							
							$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						}
					}
					else{
						//Delete created user
						$deleteResult = $this->manager->deleteUser($result);
						
						$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					}
				}
				else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					$error = '<br />' . $_SESSION ['s_message'] ['error_inserting_user'];
					throw new Exception($error);					
				}
				
			}
			elseif(count($existentUsers) == 1){
				return true;
			}
			else{
				return false;
			}
		}
		catch (Exception $e){
			
			if(isset($result) && $result > 0){
				//Delete user login type
				$deleteResult3 = $this->manager->deleteUserLoginType($result);
				
				//Delete user data
				$deleteResult2 = $this->manager->deleteUserData($result);
				
				//Delete created user
				$deleteResult = $this->manager->deleteUser($result);
			}
			
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return false;
			
		}
		
	}

	public function forgotPassword(){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    $fields = array();
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', Util::getLiteral('email'), 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/ForgotPassword.view.php';
	    
	    $render = ForgotPassword::render($fields);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, Util::getLiteral('forgot_your_password') );
		
	}
	
	public function loginFormPopup() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/PopupLoginForm.view.php';
		
		$view = PopupLoginForm::render();
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxRender($view);
		
	}

	public function restorePasswordMail(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try {
			
			$mailFilter = new TextFilter('useremail', '', null, 'useremail');
			$mailFilter->setSelectedValue($_REQUEST ['control_userEmail']);
			
			$activeFilter = new BooleanFilter('active', '', 'userdata.active');
			$activeFilter->setSelectedValue(true);
			
			$filters = array($mailFilter, $activeFilter);
			
			$user = $this->manager->getUser($filters);
			
			if(is_array($user) && count($user) > 0){
				
				//Send activation mail
				$mailHelper = new MailHelper();
				
				$vars = array();
				$vars [] = $user[0]->getUserLogin();
				
				//Users module url
				$usersUrl = Util::getContentUrl(array('users'), $_SESSION['s_languageId']);
				
				$fullUsersUrl = getCurrenProtocol(). '/'.$usersUrl.'?action=restorePassword&key='.base64_encode($user[0]->getId());
				
				$vars [] = $fullUsersUrl;
				$vars [] = $fullUsersUrl;
				$vars [] = $fullUsersUrl;
				
				$mailSend = $mailHelper->sendMail(
													array($user[0]->getUseremail()), 
													$_SESSION['s_parameters']['mail_from'], 
													$_SESSION['s_parameters']['mail_from_name'], 
													null, 
													'restore_password',
													$vars
												);

				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRender(Util::getLiteral('forgot_password_request_success'));				
				
			}
			else{
				throw new Exception(Util::getLiteral('email_nonexistent'));
			}
			
		
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( $e->getMessage(), null, Util::getLiteral('error') );
		}
			
	}
	
	public function restorePassword(){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    $fields = array();
	    
		//Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(true);
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/RestorePassword.view.php';
	    
	    $render = RestorePassword::render($fields);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getSingleMaster ();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}
	
	public function resetPassword(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			
			$userId = base64_decode($_REQUEST['key']);
			
			$user = $this->manager->getUserById($userId);
			
			if(isset($user[0]) && is_object($user[0])){
				
				$fields ['control_userName'] = $user[0]->getUsername();
				$fields ['control_userSurname'] = $user[0]->getUsersurname();
				$fields ['control_userEmail'] = $user[0]->getUseremail();
				$fields ['control_userLogin'] = $user[0]->getUserlogin();
				$fields ['control_userTypeId'] = $user[0]->getUsertypeid();
				$fields ['control_userPassword'] = $_REQUEST['control_userPassword'];
				
				$result = $this->manager->updateUser($userId, $fields);
				
				if($result){
					
					$message = base64_encode(Util::getLiteral('success_reset_password'));
					
					$redirectUrl = '/' . $_SESSION ['s_languageIsoUrl'] . '?action=view&showerror=1&errormsg='.$message;
					
					sleep(2);
		
					$_SESSION['logger']->debug ( __METHOD__ . ' end' );
					
					return new RedirectActionResponse ( $redirectUrl );
					
				}
				else{
					throw new Exception(Util::getLiteral('error_reset_password'));
				}
			}
			else{
				throw new Exception(Util::getLiteral('user_nonexistent'));
			}
			
		}
		catch (Exception $e){
			$_SESSION ['logger']->error ( $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
	}
	
	public function accountOptions(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/AccountOptions.view.php';
		
		$render = AccountOptions::render();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}
	
	public function presentationOptions(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/PresentationOptions.view.php';
		
		$render = PresentationOptions::render();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}
	
	public function accountAnalytics(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/AccountAnalytics.view.php';
		
		$render = AccountAnalytics::render();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}
	
	public function accountDetail(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', $_SESSION['s_message']['name'], 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', $_SESSION['s_message']['surname'], 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(true, 'userEmail', $_SESSION['s_message']['email'], 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(true, 'userLogin', $_SESSION['s_message']['user'], 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(false);
	    
	    //Usertype field
	    $fields ['usertype'] = $this->getSelectControl('userTypeId', $_SESSION['s_message']['usertype'], false, '', true, true, true);
	    
	    $userTypes = $this->manager->getUserTypes();
	    
	    foreach ($userTypes as $userType){
	    	$fields ['usertype']->addValue($userType->getId(), $userType->getTypeName());
	    }
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/AccountDetail.view.php';
		
		$render = AccountDetail::render($fields);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}

	public function updateAccountDetail(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try {

			foreach ($_POST as $key => $val){
				$_POST[$key] = htmlentities($val,ENT_NOQUOTES,'UTF-8');
			}
			
			if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
				
				$result = $this->manager->updateUser ( $_REQUEST ['userId'], $_POST );
				
				if ($result) {
					
					$updatedUser = $this->manager->getUserById($_REQUEST['userId']);
					
					$_SESSION['loggedUser'] = $updatedUser[0];
					
					$succesMessage = $_SESSION['s_message']['update_account_success'];
					
				} else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
					$errorMessage = $_SESSION ['s_message'] ['error_updating_user'];
				}
			
			}
			
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
			$errorMessage = $_SESSION ['s_message'] ['error_updating_user'];
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		if(isset($succesMessage)){
			return new RedirectActionResponse( $_SERVER ['HTTP_REFERER'] . '&successMessage=' . base64_encode($succesMessage) );
		} elseif(isset($errorMessage)){
			return new RedirectActionResponse( $_SERVER ['HTTP_REFERER'] . '&errorMessage=' . base64_encode($errorMessage) );
		}
		
	}
	
	protected function downloadInfo(){
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/UserDownloadInfo.view.php';
		
		$render = UserDownloadInfo::render();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster();
			
		$view = $masterView->render ( $render );
			
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
		
	}

}