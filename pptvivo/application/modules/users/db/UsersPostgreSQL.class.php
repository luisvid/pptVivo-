<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';

class UsersPostgreSQL extends UtilPostgreSQL {
	
	public static function getUserByLogin($login) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from systemuser
					where userlogin = \'' . $login . '\'';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getUserById($userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from systemuser
					where id = ' . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getUsers($begin, $count, $filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select user.*, usertype.typename usertypename
					from systemuser user
					inner join usertype
					on usertype.id = user.usertypeid
					where userlogin <> \'admin\'
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '			
					order by user.userlogin ASC
					LIMIT ' . $begin . ',' . $count . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getUsersCount($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select count(*) numrows
					from systemuser user
					inner join usertype
					on usertype.id = user.usertypeid
					where userlogin <> \'admin\'
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function getUserTypes() {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from usertype
					order by typename
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function insertUser($fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "insert into
					systemuser 
	    			(username, usersurname, useremail, userlogin, userpassword, usertypeid)
	    			values ('" . $fields ['control_userName'] . "',
	    					'" . $fields ['control_userSurname'] . "',
	    					'" . $fields ['control_userEmail'] . "',
	    					'" . $fields ['control_userLogin'] . "',
	    					'" . crypt ( $fields ['control_userPassword'] ) . "',
	    					 " . $fields ['control_userTypeId'] . "
	    				   )
	    			";
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function updateUser($userId, $fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "update
					systemuser 
	    			set username = '" . $fields ['control_userName'] . "',
	    				usersurname = '" . $fields ['control_userSurname'] . "',
	    				useremail = '" . $fields ['control_userEmail'] . "',
	    				userlogin = '" . $fields ['control_userLogin'] . "',
	    				usertypeid = " . $fields ['control_userTypeId'] . "
	    				";
		
		if (isset ( $fields ['control_userPassword'] ) && $fields ['control_userPassword'] != '') {
			
			$query .= ",userpassword = '" . crypt ( $fields ['control_userPassword'] ) . "'";
		
		}
		
		$query .= "	
	    			where id = " . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function deleteUser($userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "delete
					from systemuser
	    			where id = " . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}

}