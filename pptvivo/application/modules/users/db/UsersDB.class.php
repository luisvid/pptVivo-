<?php
/**
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 19/03/2012
 * UPDATE LIST
 * PURPOSE: Common methods and helpers
 * CALLED BY: UserManager
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersMysql.class.php";
require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersOracle.class.php";
require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersPostgreSQL.class.php";

class UsersDB extends Util {
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	public static function getUserByLogin($login) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserByLogin ( $login );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserByLogin ( $login );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = UsersPostgreSQL::getUserByLogin ( $login );
				break;
		}
		
		return $query;
	
	}
	
	public static function getUser($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUser ( $filters );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getFullUserDataByLogin($login, $checkActive) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getFullUserDataByLogin ( $login, $checkActive );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getUserById($userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserById ( $userId );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserById ( $userId );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getUsers($begin, $count, $filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUsers ( $begin, $count, $filters );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUsers ( $begin, $count, $filters );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getUsersCount($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUsersCount ( $filters );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUsersCount ( $filters );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getUserTypes() {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserTypes ();
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserTypes ();
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function insertUser($fields) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::insertUser ( $fields );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::insertUser ( $fields );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function updateUser($userId, $fields) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::updateUser ( $userId, $fields );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::updateUser ( $userId, $fields );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function deleteUser($userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::deleteUser ( $userId );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::deleteUser ( $userId );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function getFirstAdminUser() {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getFirstAdminUser ();
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getFirstAdminUser ();
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function insertUserData($fields) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::insertUserData ( $fields );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function activeUser($fields) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::activeUser ( $fields );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function insertUserLoginType($fields) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::insertUserLoginType ( $fields );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function deleteUserData($userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::deleteUserData ( $userId );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
	public static function deleteUserLoginType($userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::deleteUserLoginType ( $userId );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}
		
		return $query;
	
	}
	
}