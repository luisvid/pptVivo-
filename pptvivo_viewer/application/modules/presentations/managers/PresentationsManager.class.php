<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/db/PresentationsDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/Presentation.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/Exposition.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/ExpositionNote.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/ExpositionNote.class.php');

class PresentationsManager implements ModuleManager {
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		
		if (! isset ( PresentationsManager::$instance )) {
			self::$instance = new PresentationsManager ();
		}
		
		return PresentationsManager::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	/**
	 * Get the presentations for current user
	 * @param int $begin
	 * @param int $count
	 * @param FilterControl array $filters
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return Presentation array
	 */
	public function getPresentationsList($begin, $count, $filters, $userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}
		
		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}
		
		$list = array ();
		
		$query = PresentationsDB::getPresentations ( $begin, $count, $filters, $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$obj = new Presentation ( $element );
			$list [] = $obj;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}
	
	/**
	 * Get the presentations count for current user
	 * @param FilterControl array $filters
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return number
	 */
	public function getPresentationsCount($filters, $userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$count = 0;
		
		$query = PresentationsDB::getPresentationsCount ( $filters, $userId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if (isset ( $rs [0] ['numrows'] ))
			$count = ( int ) $rs [0] ['numrows'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $count;
	
	}
	
	/**
	 * Get current exposition slide
	 * @param int $expositionId
	 * @throws InvalidArgumentException
	 * @return number
	 */
	public function getExpositionSlide($expositionId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$currentSlide = 1;
		
		$query = PresentationsDB::getExpositionSlide($expositionId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if (isset ( $rs [0] ['slideid'] ))
			$currentSlide = ( int ) $rs [0] ['slideid'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $currentSlide;
		
	}
	
	/**
	 * Adds a note to an exposition slide
	 * @param int $expositionId
	 * @param string $note
	 * @param int $slide
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function insertExpositionNote($expositionId, $note, $slide, $userId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		if (! isset ( $note ) || $note == null) {
			self::$logger->error ( 'note parameter expected' );
			throw new InvalidArgumentException ( 'note parameter expected' );
		}
		
		if (! isset ( $slide ) || $slide == null) {
			self::$logger->error ( 'slide parameter expected' );
			throw new InvalidArgumentException ( 'slide parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$fieldsData = array();
		
		$fieldsData ['expositionId'] = $expositionId; 
		$fieldsData ['note'] = $note;
		$fieldsData ['slide'] = $slide;
		$fieldsData ['userId'] = $userId;
		
		$insertQuery = PresentationsDB::insertExpositionNote($fieldsData);
		
		$connectionManager = ConnectionManager::getInstance ();
			
		$insertRS = $connectionManager->executeTransaction ( $insertQuery, true );
			
		if ($insertRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition_note' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition_note' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $insertRS;
		
	}
	
	/**
	 * Adds an exposition attendance for current user
	 * @param int $expositionId
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function insertExpositionAttendance($expositionId, $userId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$fieldsData = array();
		
		$fieldsData ['expositionId'] = $expositionId; 
		$fieldsData ['userId'] = $userId;
		
		$insertQuery = PresentationsDB::insertExpositionAttendance($fieldsData);
		
		$connectionManager = ConnectionManager::getInstance ();
			
		$insertRS = $connectionManager->executeTransaction ( $insertQuery, true );
			
		if ($insertRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition_attendance' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition_attendance' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $insertRS;
		
	}
	
	/**
	 * Checks if an attendance exist in database
	 * @param int $expositionId
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function existAttendance($expositionId, $userId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$fieldsData = array();
		
		$fieldsData ['expositionId'] = $expositionId; 
		$fieldsData ['userId'] = $userId;
		
		$result = false;
		
		$query = PresentationsDB::checkExpositionAttendance($fieldsData);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if(is_array($rs) && count($rs) > 0){
			$result = true;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
	}
	
	/**
	 * Inserts an exposition question
	 * @param int $expositionId
	 * @param string $question
	 * @param int $slide
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function insertExpositionQuestion($expositionId, $question, $slide, $userId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		if (! isset ( $question ) || $question == null) {
			self::$logger->error ( 'question parameter expected' );
			throw new InvalidArgumentException ( 'question parameter expected' );
		}
		
		if (! isset ( $slide ) || $slide == null) {
			self::$logger->error ( 'slide parameter expected' );
			throw new InvalidArgumentException ( 'slide parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$fieldsData = array();
		
		$fieldsData ['expositionId'] = $expositionId; 
		$fieldsData ['question'] = $question;
		$fieldsData ['slide'] = $slide;
		$fieldsData ['userId'] = $userId;
		
		$insertQuery = PresentationsDB::insertExpositionQuestion($fieldsData);
		
		$connectionManager = ConnectionManager::getInstance ();
			
		$insertRS = $connectionManager->executeTransaction ( $insertQuery, true );
			
		if ($insertRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition_question' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition_question' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $insertRS;
		
	}
	
	/**
	 * Get a list of exposures
	 * @param array $filters
	 * @return Exposition array
	 */
	public function getExposures($filters){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$list = array ();
		
		$query = PresentationsDB::getExposures($filters);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ($rs as $element){
			$obj = new Exposition($element);
			$list [] = $obj;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
		
	}
	
}