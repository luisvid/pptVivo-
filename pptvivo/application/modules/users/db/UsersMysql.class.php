<?php
/**
 * Common methods and helpers for mysql
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 19/03/2012
 * UPDATE LIST  
 * CALLED BY: 
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilMysql.class.php';

class UsersMysql extends UtilMysql {
	
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
	
	public static function getUser($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from systemuser
					inner join userdata
					on userdata.userid = systemuser.id
					inner join userlogintype
					on userlogintype.userid = systemuser.id
					where 1 ';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getFullUserDataByLogin($login, $checkActive){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from systemuser
					inner join userdata
					on userdata.userid = systemuser.id
					where userlogin = \'' . $login . '\'';
		
		if($checkActive){
		$query .= '
					and userdata.active = 1
					';
		}
		
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
	    			(
		    			 username
		    			,usersurname
		    			,useremail
		    			,userlogin
		    			,userpassword
		    			,usertypeid
	    			)
	    			values 
	    			(
	    			";
			
		if(isset($fields ['control_userName']) && $fields ['control_userName'] != null){
			$query .= "'".$fields ['control_userName']."'";
		}
		else{
			$query .= ",NULL";
		}
		
		if(isset($fields ['control_userSurname']) && $fields ['control_userSurname'] != null){
			$query .= ",'".$fields ['control_userSurname']."'";
		}
		else{
			$query .= ",NULL";
		}
		
		if(isset($fields ['control_userEmail']) && $fields ['control_userEmail'] != null){
			$query .= ",'".$fields ['control_userEmail']."'";
		}
		else{
			$query .= ",NULL";
		}
		
		if(isset($fields ['control_userLogin']) && $fields ['control_userLogin'] != null){
			$query .= ",'".$fields ['control_userLogin']."'";
		}
		else{
			$query .= ",NULL";
		}
		
		if(isset($fields ['control_userPassword']) && $fields ['control_userPassword'] != null){
			$query .= ",'".crypt ( $fields ['control_userPassword'] )."'";
		}
		else{
			$query .= ",NULL";
		}
		
		
		$query .= "
						," . $fields ['control_userTypeId'] . "
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

	public static function insertUserData($fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		if(isset($fields ['active']) && $fields ['active'] != null){
			$active = $fields ['active'];
		}
		else{
			$active = '0';
		}
		
		$query = "insert into
					userdata 
	    			(
	    				userid
	    				,planid
	    				,active
	    			)
	    			values (
	    				'" . $fields ['userId'] . "'
	    				,'" . $fields ['control_plan'] . "'
	    				," . $active . "
					)
	    			";
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function activeUser($fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "update
					userdata 
	    			set active = 1
	    			where userid = " . $fields['userId'];
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function insertUserLoginType($fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "insert into
					userlogintype 
	    			(
	    				userid
	    				,logintypeid
	    				";
		
		if(isset($fields['oauthId']) && $fields['oauthId'] != null){
			$query .= ",oauthid";
		}
		
	    $query .= "
	    			)
	    			values (
	    					'" . $fields ['userId'] . "',
	    					'" . $fields ['loginTypeId'] . "'
	    					";
	    
		if(isset($fields['oauthId']) && $fields['oauthId'] != null){
			$query .= "," . $fields ['oauthId'] . "";
		}

	    $query .= "
	    				   )
	    			";
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public function deleteUserData($userId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "delete
					from userdata
	    			where userid = " . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public function deleteUserLoginType($userId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "delete
					from userlogintype
	    			where userid = " . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
}