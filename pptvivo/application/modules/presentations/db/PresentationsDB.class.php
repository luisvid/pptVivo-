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
				$query = PresentationsMysql::getPresentations($begin, $count, $filters, $userId);
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
				$query = PresentationsMysql::getPresentationsCount($filters, $userId);
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
	
	public static function deletePresentation($presentationId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deletePresentation($presentationId);
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
	
	public static function deleteExposition($presentationId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deleteExposition($presentationId);
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
	
	public static function deleteExpositionQuestions($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deleteExpositionQuestions($filters);
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
	
	public static function deleteExpositionNotes($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deleteExpositionNotes($filters);
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
				$query = PresentationsMysql::getPresentationById($presentationId);
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
	
	public static function insertPresentation($fieldsData) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertPresentation($fieldsData);
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
	
	public static function deleteExpositionAttendants($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deleteExpositionAttendants($filters);
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
	
	public static function getPresentationsAttended($begin, $count, $filters, $userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationsAttended($begin, $count, $filters, $userId);
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
	
	public static function getPresentationByName($name, $userId) {
	
		$query = '';
	
		Util::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationByName($name, $userId);
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
	
	public static function getPresentationsAttendedCount($filters, $userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationsAttendedCount($filters, $userId);
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
	
	public static function getAttendances($userId, $presentationId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getAttendances($userId, $presentationId);
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
	
	public static function getAttendanceComments($expositionId, $userId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getAttendanceComments($expositionId, $userId);
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

	public static function getPresentationsExposures($begin, $count, $filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationsExposures($begin, $count, $filters);
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
	
	public static function getPresentationsExposuresCount($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getPresentationsExposuresCount($filters);
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
	
	public static function getExpositionAttendants($filters) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getExpositionAttendants($filters);
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
	
	public static function insertExposition($presentationId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertExposition($presentationId);
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
	
	public static function updateExposition($expositionId, $shortUrl, $qrCode){

		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::updateExposition($expositionId, $shortUrl, $qrCode);
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

	public static function cancelExposition($expositionId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::cancelExposition($expositionId);
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
	
	public static function getExpositionQuestions($expositionId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::getExpositionQuestions($expositionId);
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
	
	public static function updateExpositionSlide($expositionId, $slideId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::updateExpositionSlide($expositionId, $slideId);
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
	
	public static function insertExpositionSlide($expositionId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::insertExpositionSlide($expositionId);
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
	
	public static function deleteExpositionSlide($expositionId) {
		
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = PresentationsMysql::deleteExpositionSlide($expositionId);
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