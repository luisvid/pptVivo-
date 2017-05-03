<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/db/UsersDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/User.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/UserType.class.php');

class UserManager implements ModuleManager {
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		
		if (! isset ( UserManager::$instance )) {
			self::$instance = new UserManager ();
		}
		
		return UserManager::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	/**
	 * 
	 * Get the user detail by its login
	 * @author Gabriel Guzman
	 * @param int $begin
	 * @param int $count
	 * @param int $businessUnitId
	 * @param array $filters
	 * @param string $orderField
	 * @param string $orderType
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function getUserByLogin($login, $checkActive = false) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $login ) || $login == null) {
			self::$logger->error ( 'Username parameter expected' );
			throw new InvalidArgumentException ( 'Username parameter expected' );
		}
		
		$query = UsersDB::getFullUserDataByLogin ( $login, $checkActive );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$userRS = $connectionManager->select ( $query );
		
		$user = array ();
		
		foreach ( $userRS as $userElement ) {
			$user [] = new User ( $userElement );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $user;
	}
	
	/**
	 * Retrieves user data according to agiven filters
	 * @param Filter array $filters
	 * @return User array
	 */
	public function getUser($filters){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = UsersDB::getUser ( $filters );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$userRS = $connectionManager->select ( $query );
		
		$user = array ();
		
		foreach ( $userRS as $userElement ) {
			$user [] = new User ( $userElement );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $user;
		
	} 
	
	/**
	 * Get a user by its id
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return User array
	 */
	public function getUserById($userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::getUserById ( $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$userRS = $connectionManager->select ( $query );
		
		$user = array ();
		
		foreach ( $userRS as $userElement ) {
			$user [] = new User ( $userElement );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $user;
	}
	
	/**
	 * Get a list of users
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return User array
	 */
	public function getUsersList($begin, $count, $filters) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}
		
		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}
		
		$userList = array ();
		
		$query = UsersDB::getUsers ( $begin, $count, $filters );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$usersRS = $connectionManager->select ( $query );
		
		foreach ( $usersRS as $userElement ) {
			$userObj = new User ( $userElement );
			$userList [] = $userObj;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $userList;
	
	}
	
	/**
	 * Counts users
	 * @param arrau $filters
	 * @return number
	 */
	public function getUsersCount($filters) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$usersCount = 0;
		
		$query = UsersDB::getUsersCount ( $filters );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$usersCountRS = $connectionManager->select ( $query );
		
		if (isset ( $usersCountRS [0] ['numrows'] ))
			$usersCount = ( int ) $usersCountRS [0] ['numrows'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $usersCount;
	
	}
	
	/**
	 * Get all the user types
	 * @return UserType array
	 */
	public function getUserTypes() {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$userTypesList = array ();
		
		$query = UsersDB::getUserTypes ();
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$userTypesRS = $connectionManager->select ( $query );
		
		foreach ( $userTypesRS as $userType ) {
			
			$userTypeObj = new UserType ( $userType );
			
			$userTypesList [] = $userTypeObj;
		
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $userTypesList;
	
	}
	
	/**
	 * Creates a user
	 * @param array $fields
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public function insertUser($fields) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fields ['control_userName'] ) || $fields ['control_userName'] == null) {
			self::$logger->error ( 'userName parameter expected' );
			throw new InvalidArgumentException ( 'userName parameter expected' );
		}
		
		if (! isset ( $fields ['control_userLogin'] ) || $fields ['control_userLogin'] == null) {
			self::$logger->error ( 'userLogin parameter expected' );
			throw new InvalidArgumentException ( 'userLogin parameter expected' );
		}
		
		if (! isset ( $fields ['control_userTypeId'] ) || $fields ['control_userTypeId'] == null) {
			self::$logger->error ( 'userTypeId parameter expected' );
			throw new InvalidArgumentException ( 'userTypeId parameter expected' );
		}
		
		$filters = array();
		
		if(isset($fields ['control_userLogin']) && $fields ['control_userLogin'] != null){
		
			//Check if user exists
			$loginFilter = new TextFilter('userlogin', '', null, 'userlogin');
			$loginFilter->setSelectedValue($fields ['control_userLogin']);
			$filters [] = $loginFilter;
			
			$user = $this->getUser($filters);
			
			if (isset ( $user [0] ) && is_object ( $user [0] ) && $user [0]->getUserlogin () == $fields ['control_userLogin']) {
				self::$logger->error ( Util::getLiteral ( 'username_already_exists' ) );
				throw new InvalidArgumentException ( Util::getLiteral ( 'username_already_exists' ) );
			}
			else{
				
				if(isset($fields ['control_userEmail']) && $fields ['control_userEmail'] != null){
				
					$mailFilter = new TextFilter('useremail', '', null, 'useremail');
					$mailFilter->setSelectedValue($fields ['control_userEmail']);
					
					$filters = array();
					$filters [] = $mailFilter;
				
					$user = $this->getUser($filters);
					
					if(isset ( $user [0] ) && is_object ( $user [0] ) && $user [0]->getUseremail () == $fields ['control_userEmail']){
						self::$logger->error ( Util::getLiteral ( 'email_already_exists' ) );
						throw new InvalidArgumentException ( Util::getLiteral ( 'email_already_exists' ) );
					}
				}
			}
		}
		
		$query = UsersDB::insertUser ( $fields );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query, true );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
	
	}
	
	/**
	 * Updates user data
	 * @param int $userId
	 * @param int $fields
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function updateUser($userId, $fields) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fields ['control_userName'] ) || $fields ['control_userName'] == null) {
			self::$logger->error ( 'userName parameter expected' );
			throw new InvalidArgumentException ( 'userName parameter expected' );
		}
		
		if (! isset ( $fields ['control_userSurname'] ) || $fields ['control_userSurname'] == null) {
			self::$logger->error ( 'userSurname parameter expected' );
			throw new InvalidArgumentException ( 'userSurname parameter expected' );
		}
		
		if (! isset ( $fields ['control_userEmail'] ) || $fields ['control_userEmail'] == null) {
			self::$logger->error ( 'userEmail parameter expected' );
			throw new InvalidArgumentException ( 'userEmail parameter expected' );
		}
		
		if (! isset ( $fields ['control_userLogin'] ) || $fields ['control_userLogin'] == null) {
			self::$logger->error ( 'userLogin parameter expected' );
			throw new InvalidArgumentException ( 'userLogin parameter expected' );
		}
		
		if (! isset ( $fields ['control_userTypeId'] ) || $fields ['control_userTypeId'] == null) {
			self::$logger->error ( 'userTypeId parameter expected' );
			throw new InvalidArgumentException ( 'userTypeId parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::updateUser ( $userId, $fields );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
	
	}
	
	/**
	 * Deletes a user from database
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteUser($userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::deleteUser ( $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		if ($result) {
			
			$user = $this->getUserByid ( $userId );
			
			if (is_object ( $user ) && $user->getId () == $userId) {
				$return = false;
			} else {
				$return = $result;
			}
		
		} else {
			$return = $result;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $return;
	
	}

	/**
	 * Inserts additional user data
	 * @param array $fields
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function insertUserData($fields){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fields ['userId'] ) || $fields ['userId'] == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		if (! isset ( $fields ['control_plan'] ) || $fields ['control_plan'] == null) {
			self::$logger->error ( 'plan parameter expected' );
			throw new InvalidArgumentException ( 'plan parameter expected' );
		}
		
		$query = UsersDB::insertUserData($fields);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
	}
	
	/**
	 * Activates a user
	 * @param array $fields
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function activeUser($fields){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fields ['userId'] ) || $fields ['userId'] == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::activeUser($fields);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
	}
	
	/**
	 * Inserts the login type for a user
	 * @param array $fields
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function insertUserLoginType($fields){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fields ['userId'] ) || $fields ['userId'] == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		if (! isset ( $fields ['loginTypeId'] ) || $fields ['loginTypeId'] == null) {
			self::$logger->error ( 'loginTypeId parameter expected' );
			throw new InvalidArgumentException ( 'loginTypeId parameter expected' );
		}
		
		$query = UsersDB::insertUserLoginType($fields);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
	}
	
	/**
	 * Deletes additional user data
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteUserData($userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::deleteUserData ( $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
	
	}
	
	/**
	 * Deletes login type of a given user
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteUserLoginType($userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = UsersDB::deleteUserLoginType ( $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->executeTransaction ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
	
	}
	
}