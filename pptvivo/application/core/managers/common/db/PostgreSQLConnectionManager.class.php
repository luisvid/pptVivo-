<?php
/** 
 * PostgreSQL connection and transactions management 
 * @package classes
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 18/06/2012
 * UPDATE LIST
 * * UPDATE:
 * PURPOSE: This class allows to establish and close PostgreSQL connections, execute and fecth queries.
 * CALLED BY: 
 */

class PostgreSQLConnectionManager {
	
	private static $instance;
	private $dbms;
	private $dbserver;
	private $dbuser;
	private $dbpass;
	private $dbname;
	private $link;
	
	public static function getInstance() {
		if (! isset ( PostgreSQLConnectionManager::$instance )) {
			PostgreSQLConnectionManager::$instance = new PostgreSQLConnectionManager ();
		}
		return PostgreSQLConnectionManager::$instance;
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
	 * Establishes a PostgreSQL connection
	 */
	private function connect() {
		
		self::getInstance ();
		
		try {
			
			$connection_string = "host = " . $this->dbserver;
			
			$connection_string .= " dbname = " . $this->dbname;
			
			$connection_string .= " user = " . $this->dbuser;
			
			$connection_string .= " password = " . $this->dbpass;
			
			$this->link = pg_connect($connection_string);
			
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	
	}
	
	/**
	 * Closes a PostgreSQL connection
	 */
	private function disconnect() {
		
		try{
			pg_close ( $this->link );
		}
		catch ( Exception $e ){
			echo $e->getMessage ();
		}
	}
	
	/**
	 * Fetch a PostgreSQL Resultset
	 * @param ResultSet $rs PostgreSQL ResultSet
	 * @param Integer $row
	 * @return Array with query result
	 */
	public function fetch($rs, $row = null) {
		
		if (isset ( $row )) {
			if (! pg_result_seek ( $rs, $row ))
				return false;
		}
		
		return pg_fetch_array ( $rs );
	
	}
	
	/**
	 * Retrieves number of rows of a query
	 * @param ResultSet $rs PostgreSQL ResultSet
	 * @return Integer number of rows
	 */
	private function numrows($rs) {
		
		if ($rs)
			return pg_num_rows ( $rs );
		else
			return false;
	
	}
	
	/**
	 * Executes a PostgreSQL query, calls fetch method and retrieves array with result.
	 * @param String $query SELECT query to execute
	 * @param String $objectid
	 * @return Array with query result
	 */
	public function select($query, $objectid = "") {
		
		self::connect ();
		
		try {
			$queryRS = pg_query ( $this->link, $query );
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
			$queryRS = pg_query ( $this->link, $query );
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
	
	public function executeTransaction($query, $getLastInsertedId = false, $sequenceName = null) {
		
		$dsn = $this->dbms . ':dbname=' . $this->dbname . ';host=' . $this->dbserver. ';user='. $this->dbuser . ';password=' . $this->dbpass;
		
		try {
			
			$dbh = new PDO ( $dsn );
		
		} catch ( PDOException $e ) {
			
			echo 'Connection failed: ' . $e->getMessage ();
			
			$result = false;
		
		}
		
		try {
			
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			$dbh->beginTransaction ();
			
			$dbh->exec ( $query );
			
			if($getLastInsertedId){
				$result = $dbh->lastInsertId($sequenceName);
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
?>