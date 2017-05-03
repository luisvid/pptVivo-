<?php

require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/presentations/db/PresentationsMysql.class.php";

class PresentationsDB extends Util {
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	public static function getPresentations($begin, $count, $filters, $userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentations ( $begin, $count, $filters, $userId );
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
	
	public static function getPresentationsCount($filters, $userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationsCount ( $filters, $userId );
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
	
	public static function getPresentationById($presentationId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationById ( $presentationId );
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
	
	public static function getExpositionSlide($expositionId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getExpositionSlide ( $expositionId );
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
	
	public static function insertExpositionNote($fieldsData) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertExpositionNote ( $fieldsData );
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
	
	public static function insertExpositionAttendance($fieldsData) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertExpositionAttendance ( $fieldsData );
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
	
	public static function checkExpositionAttendance($fieldsData) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::checkExpositionAttendance ( $fieldsData );
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
	
	public static function insertExpositionQuestion($fieldsData) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertExpositionQuestion ( $fieldsData );
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
	
	public static function getExposures($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getExposures($filters);
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

}