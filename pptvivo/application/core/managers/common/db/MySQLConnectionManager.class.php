<?php
/** 
 * MYSQL connection and transactions management 
 * @package classes
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 25/06/2010
 * UPDATE LIST
 * * UPDATE:
 * PURPOSE: This class allows to establish and close mysql connections, execute and fecth queries.
 * CALLED BY: 
 */

class MySQLConnectionManager {
	
	private static $instance;
	private $dbms;
	private $dbserver;
	private $dbuser;
	private $dbpass;
	private $dbname;
	private $link;
	
	public static function getInstance() {
		if (! isset ( MySQLConnectionManager::$instance )) {
			MySQLConnectionManager::$instance = new MySQLConnectionManager ();
		}
		return MySQLConnectionManager::$instance;
	}
	
	function __construct() {
		
		$conf = parse_ini_file ( $_SERVER ['DOCUMENT_ROOT'] . '/../application/configs/config.ini' );
		
		$this->dbms = $conf ['dbms'];
		$this->dbserver = $conf ['dbserver'];
		$this->dbuser = $conf ['dbuser'];
		$this->dbpass = $conf ['dbpass'];
		$this->dbname = $conf ['dbname'];
	
	}
	
	/**
	 * Establishes a mysql connection
	 */
	private function connect() {
		
		self::getInstance ();
		
		try {
			
			$this->link = mysqli_connect ( $this->dbserver, $this->dbuser, $this->dbpass, $this->dbname );
			
			mysqli_set_charset($this->link, 'utf8');
			
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	
	}
	
	/**
	 * Closes a mysql connection
	 */
	private function disconnect() {
		mysqli_close ( $this->link );
	}
	
	/**
	 * Fetch a MySQL Resultset
	 * @param ResultSet $rs MySQL ResultSet
	 * @param Integer $row
	 * @return Array with query result
	 */
	public function fetch($rs, $row = null) {
		
		if (isset ( $row )) {
			if (! mysqli_data_seek ( $rs, $row ))
				return false;
		}
		
		return mysqli_fetch_array ( $rs );
	
	}
	
	/**
	 * Retrieves number of rows of a query
	 * @param ResultSet $rs MySQL ResultSet
	 * @return Integer number of rows
	 */
	private function numrows($rs) {
		
		if ($rs)
			return mysqli_num_rows ( $rs );
		else
			return false;
	
	}
	
	/**
	 * Executes a mysql query, calls fetch method and retrieves array with result.
	 * @param String $query SELECT query to execute
	 * @param String $objectid
	 * @return Array with query result
	 */
	public function select($query, $objectid = "") {
		
		self::connect ();
		
		try {
			$queryRS = mysqli_query ( $this->link, $query );
		} catch ( Exception $e ) {
			self::disconnect ();
			echo $e->getMessage ();
		}
		
		if (! $queryRS) {
			self::disconnect ();
			return false;
		} else {
			
			$numrows = self::numrows ( $queryRS );
			$result = array ();
			$finalArray = array ();
			
			for($i = 0; $i < $numrows; $i ++) {
				$thisrow = self::fetch ( $queryRS, $i );
				if (trim ( $objectid ) != "") {
					$finalArray [$objectid] [$thisrow [$objectid]] = $thisrow;
				}
				$result [] = $thisrow;
			}
			
			self::disconnect ();
			return $result;
		
		}
	
	}
	
	public function exec($query) {
		
		self::connect ();
		
		try {
			$queryRS = mysqli_query ( $this->link, $query );
		} catch ( Exception $e ) {
			self::disconnect ();
			throw new Exception($e->getMessage ());
		}
		
		if (! $queryRS) {
			self::disconnect ();
			return false;
		}
		
		self::disconnect ();
		return $queryRS;
	
	}
	
	public function executeTransaction($query, $getLastInsertedId = false) {
		
		$dsn = $this->dbms . ':dbname=' . $this->dbname . ';host=' . $this->dbserver;
		
		try {
			
			$dbh = new PDO ( $dsn, $this->dbuser, $this->dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'') );
		
		} catch ( PDOException $e ) {
			
			echo 'Connection failed: ' . $e->getMessage ();
			
			$result = false;
		
		}
		
		try {
			
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			$dbh->beginTransaction ();
			
			$dbh->exec ( $query );
			
			if($getLastInsertedId){
				$result = $dbh->lastInsertId();
				$dbh->commit ();
			}
			else{
				$result = $dbh->commit (); 
			}			
		
		} catch ( Exception $e ) {
			
			$dbh->rollBack ();
			
			throw new Exception("Failed: " . $e->getMessage ());
			 
		}
		
		return $result;
	
	}

}