<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/db/PresentationsDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/Presentation.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/Exposition.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/ExpositionNote.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/classes/ExpositionQuestion.class.php');
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/DateRangeFilter.class.php';

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
	public function getPresentationsList($begin, $count, $filters, $userId, $dowload = false) {
		
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
		
		$query = PresentationsDB::getPresentations ( $begin, $count, $filters, $userId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$obj = new Presentation ( $element );

			if($dowload == false) {
				
				$exposuresFilters = array();
				$dateFilter = new DateRangeFilter('exposuredate', '', 'exposition.exposuredate');
				$dateFilter->setLeftValue(date("Y-m-d"));
				$dateFilter->setRightValue(date("Y-m-d"));
	
				$filterId = new NumberFilter('presentationid', '', null, 'presentation.id');
				$filterId->setSelectedValue($obj->getId());
				
				array_push($exposuresFilters, $filterId);
				
				$activeFilter = new BooleanFilter('active', '', 'exposition.active');
				$activeFilter->setSelectedValue(true);
				
				array_push($exposuresFilters, $activeFilter);
				
				//array_push($exposuresFilters, $dateFilter);
				
				//Exposures
				$expositions = $this->getPresentationsExposures(0, 10, $exposuresFilters, false, false);
				$obj->setExpositions($expositions);
			
			}

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
	
	public function getPresentationById($presentationId){
		
		$presentationQuery = PresentationsDB::getPresentationById ( $presentationId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $presentationQuery );
		
		if (is_array ( $rs ) && count ( $rs ) > 0) {
			$presentation = new Presentation ( $rs [0] );
			return $presentation;
		}
		
		return false;
		
	}
	
	/**
	 * Deletes a presentation from database and disk
	 * @param int $presentationId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deletePresentation($presentationId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $presentationId ) || $presentationId == null) {
			self::$logger->error ( 'presentationId parameter expected' );
			throw new InvalidArgumentException ( 'presentationId parameter expected' );
		}
		
		//Get presentation information and related data
		$presentationQuery = PresentationsDB::getPresentationById ( $presentationId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $presentationQuery );
		
		if (is_array ( $rs ) && count ( $rs ) > 0) {
			
			//Related expositions
			$expositionRef = null;
			$expositions = array ();
			
			foreach ( $rs as $elem ) {
				if ($elem ['expositionid'] != $expositionRef) {
					$expositions [] = $elem ['expositionid'];
				}
				$expositionRef = $elem ['expositionid'];
			}
			
			if (count ( $expositions ) > 0) {
				
				//Delete related expositions information
				foreach ( $expositions as $exp ) {
					
					$expFilter = new NumberFilter('expositionid', '', null, 'expositionid');
					$expFilter->setSelectedValue($exp);
					$filters = array($expFilter);
					
					//Delete notes
					$deleteExpositionNotesQuery = PresentationsDB::deleteExpositionNotes ( $filters );
					
					$deleteExpositionNotesRS = $connectionManager->executeTransaction ( $deleteExpositionNotesQuery );
					
					if ($deleteExpositionNotesRS === false) {
						self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_notes' ) );
						self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_notes' ) );
					}
					
					//Delete questions
					$deleteExpositionQuestionsQuery = PresentationsDB::deleteExpositionQuestions ( $filters );
					
					$deleteExpositionQuestionsRS = $connectionManager->executeTransaction ( $deleteExpositionQuestionsQuery );
					
					if ($deleteExpositionQuestionsRS === false) {
						self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_questions' ) );
						self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_questions' ) );
					}
					
					//Delete exposition attendants
					$deleteExpositionAttendantsQuery = PresentationsDB::deleteExpositionAttendants($filters);
					
					$deleteExpositionAttendantsRS = $connectionManager->executeTransaction ( $deleteExpositionAttendantsQuery );
					
					if ($deleteExpositionAttendantsRS === false) {
						self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_attendants' ) );
						self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_attendants' ) );
					}
					
					//Delete exposition slides
					$deleteExpositionSlideQuery = PresentationsDB::deleteExpositionSlide($exp);
					
					$deleteExpositionSlideRS = $connectionManager->executeTransaction ( $deleteExpositionSlideQuery );
					
					if ($deleteExpositionSlideRS === false) {
						self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_slide' ) );
						self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_slide' ) );
					}
				
				}
				
				//Delete expositions
				$deleteExpositionQuery = PresentationsDB::deleteExposition ( $presentationId );
				
				$deleteExpositionRS = $connectionManager->executeTransaction ( $deleteExpositionQuery );
				
				if ($deleteExpositionRS === false) {
					self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition' ) );
					self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition' ) );
				}
			
			}
			
			//Delete presentation
			$deletePresentationQuery = PresentationsDB::deletePresentation ( $presentationId );
			
			$deletePresentationRS = $connectionManager->executeTransaction ( $deletePresentationQuery );
			
			if ($deletePresentationRS === false) {
				self::$logger->error ( Util::getLiteral ( 'error_deleting_presentation' ) );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_presentation' ) );
			}
			
			//Delete presentation file
			$presentation = new Presentation ( $rs [0] );
			$presentationPathData = Util::getPresentationPathData ( $presentation );
			$absolutePath = $presentationPathData ['presentationsPath'];
			
			if (is_dir ( $absolutePath )) {
				
				//Delete all presentation files
				$dh = opendir ( $absolutePath );
				while ( $file = readdir ( $dh ) ) {
					if (! is_dir ( $file )) {
						if (! unlink ( $absolutePath . '/' . $file )) {
							self::$logger->error ( Util::getLiteral ( 'error_deleting_file' ) . ': ' . $file );
							self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
							throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_file' ) . ': ' . $file );
						}
					}
				}
				closedir ( $dh );
				
				//Delete directory
				if (! rmdir ( $absolutePath )) {
					self::$logger->error ( Util::getLiteral ( 'error_deleting_presentation_folder' ) );
					self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_presentation_folder' ) );
				}
			
			}
		
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;
	
	}
	
	/**
	 * Uploads a presentation and creates all its related data
	 * @param array $fieldsData
	 * @param array $file
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function createPresentation($fieldsData, $file) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $fieldsData ['control_title'] ) || $fieldsData ['control_title'] == null) {
			self::$logger->error ( 'title parameter expected' );
			throw new InvalidArgumentException ( 'title parameter expected' );
		}
		
		if (! isset ( $fieldsData ['control_userId'] ) || $fieldsData ['control_userId'] == null) {
			self::$logger->error ( 'user id parameter expected' );
			throw new InvalidArgumentException ( 'user id parameter expected' );
		}
		
		if (! isset ( $fieldsData ['control_description'] ) || $fieldsData ['control_description'] == null) {
			$fieldsData ['control_description'] = '';
		}
		
		set_time_limit(0);
		
		//Upload file
		if (isset ( $file ["tmp_name"] ) && $file ["tmp_name"] != '' && $file ['error'] == UPLOAD_ERR_OK) {
			
			$pathInfo = pathinfo ( $file ["name"] );
			
			$configurator = Configurator::getInstance ();
			$presentationsPathBase = $configurator->getPresentationsPath ();
			$userPresentationsPath = $presentationsPathBase . $_SESSION ['loggedUser']->getUserlogin () . '/';
			
			//$presentationName = str_replace ( ' ', '_', $pathInfo ['filename'] );
			$presentationName = $pathInfo ['filename'];
			
			//Create presentation folder
			$currentPresentationPath = $userPresentationsPath . $presentationName;
			
			if(is_dir($currentPresentationPath)){
				
				if ($handle = opendir($currentPresentationPath)) {
								
					while (false !== ($entry = readdir($handle))) {
						if (!is_dir($entry) && ($entry != '.' || $entry != '..'))
							unlink($currentPresentationPath . '/' . $entry);	
				    }    
				
				    closedir($handle);
				}
				rmdir($currentPresentationPath);
			}
			
			if (! mkdir ( $currentPresentationPath )) {
				self::$logger->error ( Util::getLiteral ( 'error_creating_presentation_folder' ) . ': ' .$currentPresentationPath );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'error_creating_presentation_folder' ) . ': ' . $currentPresentationPath );
			}
			
			//Move presentation into new folder
			$fileName = $presentationName . '.' . $pathInfo ['extension'];
			$currentPresentationPathAndFileName = $currentPresentationPath . '/' . $fileName;
			
			if (! move_uploaded_file ( $file ['tmp_name'], $currentPresentationPathAndFileName )) {
				self::$logger->error ( Util::getLiteral ( 'error_copying_file' ) . ' to: ' . $currentPresentationPathAndFileName );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'error_copying_file' ) . ' to: ' . $currentPresentationPathAndFileName );
			}
			
			//Generate previews
			if(!file_exists( $currentPresentationPathAndFileName )){
				self::$logger->error ( Util::getLiteral ( 'file_nonexistent' ) . ': ' . $currentPresentationPathAndFileName );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'file_nonexistent' ) . ': ' . $currentPresentationPathAndFileName );		
			}
			
			//Shell command
			$convertCommand = $configurator->getConverterPath().' ';
			
			//Arguments
			$sourceName = $currentPresentationPath . '/' . $presentationName;
			$sourceExtention = $pathInfo ['extension'];
			$intermediateFormat = $configurator->getPresentationsIntermediateFormat();
			$outputformat = $configurator->getPresentationsOutputFormat();
			$args = '"' . $sourceName . '" ' . $sourceExtention . ' ' . $intermediateFormat . ' ' . $outputformat;
			
			//Execution
			self::$logger->debug ( 'Executing: ' . $convertCommand . $args );
			$resultExec = exec($convertCommand . $args);
			
			//Insert presentation in DB
			$fieldsData ['control_filename'] = $fileName;
			$insertQuery = PresentationsDB::insertPresentation ( $fieldsData );
			
			$connectionManager = ConnectionManager::getInstance ();
			
			$insertRS = $connectionManager->executeTransaction ( $insertQuery, true );
			
			if ($insertRS === false) {
				self::$logger->error ( Util::getLiteral ( 'error_inserting_presentation' ) );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_presentation' ) );
			}
		
		} else {
			self::$logger->error ( Util::getLiteral ( 'upload_file_error' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'upload_file_error' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;
	
	}
	
	/**
	 * Checks the given presentation exists
	 * @param string $presentationName
	 * @param int $userId
	 * @return boolean
	 */
	public function checkPresentationByName($presentationName, $userId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$exist = false;
		
		if (! isset ( $presentationName ) || $presentationName == null) {
			self::$logger->error ( 'presentationName parameter expected' );
			throw new InvalidArgumentException ( 'presentationName parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$query = PresentationsDB::getPresentationByName($presentationName, $userId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if(is_array($rs) && count($rs) > 0) {

			$exist = true;
			
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $exist;
		
	}
	
	
	/**
	 * Get the list of presentations attended
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return Presentation array
	 */
	public function getPresentationsAttendancesList($begin, $count, $filters, $userId) {
		
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
		
		$query = PresentationsDB::getPresentationsAttended($begin, $count, $filters, $userId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$presentation = new Presentation ( $element );
			$attendances = $this->getAttendances($userId, $presentation->getId());
			$presentation->setExpositions($attendances);
			$list [] = $presentation;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}

	/**
	 * Get the count of presentations attended
	 * @param array $filters
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return number
	 */
	public function getPresentationsAttendancesCount($filters, $userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		$count = 0;
		
		$query = PresentationsDB::getPresentationsAttendedCount($filters, $userId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if (isset ( $rs [0] ['numrows'] ))
			$count = ( int ) $rs [0] ['numrows'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $count;
	
	}
	
	/**
	 * Get all the expositions which the current user has attended
	 * @param int $userId
	 * @param int $presentationId
	 * @throws InvalidArgumentException
	 * @return Exposition array
	 */
	protected function getAttendances($userId, $presentationId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		if (! isset ( $presentationId ) || $presentationId == null) {
			self::$logger->error ( 'presentationId parameter expected' );
			throw new InvalidArgumentException ( 'presentationId parameter expected' );
		}
		
		$list = array ();
		
		$query = PresentationsDB::getAttendances($userId, $presentationId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$exposition = new Exposition ($element);
			$exposition->setId($element['expositionid']);
			$list [] = $exposition;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
		
	}
	
	/**
	 * Get all the comments of an exposition of the current user
	 * @param int $expositionId
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return ExpositionNote array
	 */
	public function getAttendanceComments($expositionId, $userId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$list = array ();
		
		$query = PresentationsDB::getAttendanceComments($expositionId, $userId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			if(isset($element['note']) && $element['note'] != null && isset($element['slide']) && $element['slide'] != null){
				$noteObj = new ExpositionNote($element['note'], $element['slide']);
				$list [] = $noteObj;
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}

	/**
	 * Deletes a presentation which the current user has attended from database and disk
	 * @param int $userId
	 * @param int $presentationId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteExpositionAttendance($userId, $presentationId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $presentationId ) || $presentationId == null) {
			self::$logger->error ( 'presentationId parameter expected' );
			throw new InvalidArgumentException ( 'presentationId parameter expected' );
		}
		
		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}
		
		//Presentation object
		$presentationQuery = PresentationsDB::getPresentationById ( $presentationId );
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select ( $presentationQuery );
		
		//Related expositions
		$expositionRef = null;
		$expositions = array ();
		
		foreach ( $rs as $elem ) {
			if ($elem ['expositionid'] != $expositionRef) {
				$expositions [] = $elem ['expositionid'];
			}
			$expositionRef = $elem ['expositionid'];
		}
		
		//User filter
		$userFilter = new NumberFilter('userid', '', null, 'userid');
		$userFilter->setSelectedValue($userId);
		
		if (count ( $expositions ) > 0) {
				
			//Delete related expositions information
			foreach ( $expositions as $exp ) {
				
				$expFilter = new NumberFilter('expositionid', '', null, 'expositionid');
				$expFilter->setSelectedValue($exp);
				
				$filters = array($expFilter, $userFilter);
				
				$connectionManager = ConnectionManager::getInstance ();
				
				//Delete notes
				$deleteExpositionNotesQuery = PresentationsDB::deleteExpositionNotes ( $filters );
				
				$deleteExpositionNotesRS = $connectionManager->executeTransaction ( $deleteExpositionNotesQuery );
				
				if ($deleteExpositionNotesRS === false) {
					self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_notes' ) );
					self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_notes' ) );
				}
				
				//Delete exposition attendants
				$deleteExpositionAttendantsQuery = PresentationsDB::deleteExpositionAttendants($filters);
				
				$deleteExpositionAttendantsRS = $connectionManager->executeTransaction ( $deleteExpositionAttendantsQuery );
				
				if ($deleteExpositionAttendantsRS === false) {
					self::$logger->error ( Util::getLiteral ( 'error_deleting_exposition_attendants' ) );
					self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_exposition_attendants' ) );
				}		
				
			}
			
		}
		
		//Delete presentation file
		$presentation = new Presentation ( $rs [0] );
		$presentationPathData = Util::getPresentationPathData ( $presentation );
		$absolutePath = $presentationPathData ['presentationsPath'];
		
		if (is_dir ( $absolutePath )) {
			
			//Delete all presentation files
			$dh = opendir ( $absolutePath );
			while ( $file = readdir ( $dh ) ) {
				if (! is_dir ( $file )) {
					if (! unlink ( $absolutePath . '/' . $file )) {
						self::$logger->error ( Util::getLiteral ( 'error_deleting_file' ) . ': ' . $file );
						self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
						throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_file' ) . ': ' . $file );
					}
				}
			}
			closedir ( $dh );
			
			//Delete directory
			if (! rmdir ( $absolutePath )) {
				self::$logger->error ( Util::getLiteral ( 'error_deleting_presentation_folder' ) );
				self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				throw new InvalidArgumentException ( Util::getLiteral ( 'error_deleting_presentation_folder' ) );
			}
		
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;
	
	}
	
	/**
	 * Get all the exposures of a presentation
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return Exposition array
	 */
	public function getPresentationsExposures($begin, $count, $filters, $getAttendants = true, $getQuestions = true) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}
		
		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}
		
		$list = array ();
		
		$query = PresentationsDB::getPresentationsExposures($begin, $count, $filters);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			//Expositon
			$exposition = new Exposition($element);
			
			//Atendants
			if($getAttendants){
				$attendants = $this->getExpositionAttendants($exposition->getId());
				$exposition->setAttendants($attendants);
			}
			
			//Questions
			if($getQuestions){
				$questions = $this->getExpositionQuestions($exposition->getId());
				$exposition->setQuestions($questions);
			}
			
			$exposition->setQrCode($element['qrcode']);
			
			$exposition->setShortUrl($element['shorturl']);
			
			$list [] = $exposition;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}

	/**
	 * Get the presentation exposures' count
	 * @param array $filters
	 * @return number
	 */
	public function getPresentationsExposuresCount($filters) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$count = 0;
		
		$query = PresentationsDB::getPresentationsExposuresCount($filters);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		if (isset ( $rs [0] ['numrows'] ))
			$count = ( int ) $rs [0] ['numrows'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $count;
	
	}
	
	/**
	 * Get all the attendants of an exposition
	 * @param int $expositionId
	 * @throws InvalidArgumentException
	 * @return User array
	 */
	protected function getExpositionAttendants($expositionId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$list = array ();
		
		$expositionFilter = new NumberFilter('expositionid', '', null, 'attendant.expositionid');
		$expositionFilter->setSelectedValue($expositionId);
		$filters = array($expositionFilter);
		
		$query = PresentationsDB::getExpositionAttendants($filters);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$userObj = new User($element);
			$list [] = $userObj;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}
	
	/**
	 * Creates an exposition
	 * @param int $presentationId
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public function createExposition($presentationId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $presentationId ) || $presentationId == null) {
			self::$logger->error ( 'presentationId parameter expected' );
			throw new InvalidArgumentException ( 'presentationId parameter expected' );
		}

		//Insert first part of the exposition
		$insertQuery = PresentationsDB::insertExposition($presentationId);
			
		$connectionManager = ConnectionManager::getInstance ();
			
		$insertRS = $connectionManager->executeTransaction ( $insertQuery, true );
		
		if ($insertRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition' ) );
		}
		
		//Insert exposition-slide temporary record
		$rs = $this->createExpositionSlide($insertRS);
		
		//Complete the exposition
		$contentUrl = Util::getContentUrl(array('presentations'), $_SESSION['s_languageId']);

		$presentationUrl = $_SESSION['s_parameters']['player_url'] . $contentUrl . '/' . $_SESSION ['loggedUser']->getUserlogin () . '/' . $presentationId;
		
		$expositionShortUrl = Util::getShortenUrl($presentationUrl . '/' . $insertRS);

		$qrCode = Presentation::getQR($expositionShortUrl);

		//Insert the second part of the exposition
		$updateQuery = PresentationsDB::updateExposition($insertRS, $expositionShortUrl, $qrCode);
			
		$connectionManager = ConnectionManager::getInstance ();
			
		$updateRS = $connectionManager->executeTransaction ( $updateQuery, false );

		if ($updateRS == false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $insertRS;
		
	}
	
	/**
	 * Get all the questions for an exposition
	 * @param int $expositionId
	 * @throws InvalidArgumentException
	 * @return ExpositionQuestion array
	 */
	public function getExpositionQuestions($expositionId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$list = array ();
		
		$query = PresentationsDB::getExpositionQuestions($expositionId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$expositionObj = new ExpositionQuestion($element['question'], $element['slide'], $element['userlogin']);
			$expositionObj->setUsername($element['username']);
			$expositionObj->setUsersurname($element['usersurname']);
			$list [] = $expositionObj;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	
	}
	
	/**
	 * Updates exposition slide from PPT sync
	 * @param int $expositionId
	 * @param int $slideId
	 * @throws InvalidArgumentException
	 * @return number
	 */
	public function updateExpositionSlide($expositionId, $slideId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		if (! isset ( $slideId ) || $slideId == null) {
			self::$logger->error ( 'slideId parameter expected' );
			throw new InvalidArgumentException ( 'slideId parameter expected' );
		}
		
		$list = array ();
		
		$query = PresentationsDB::updateExpositionSlide($expositionId, $slideId);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$updateRS = $connectionManager->executeTransaction ( $query );
		
		if ($updateRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_updating_exposition_slide' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_updating_exposition_slide' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $updateRS;
	
	}
	
	/**
	 * Inserts the temporary record for an exposition
	 * @param int $expositionId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	protected function createExpositionSlide($expositionId){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$insertQuery = PresentationsDB::insertExpositionSlide($expositionId);
			
		$connectionManager = ConnectionManager::getInstance ();
			
		$insertRS = $connectionManager->executeTransaction ( $insertQuery );
		
		if ($insertRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_inserting_exposition' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_inserting_exposition' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $insertRS;
		
	}
	
	/**
	 * Cancels an exposition from database
	 * @param int $expositionId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function cancelExposition($expositionId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $expositionId ) || $expositionId == null) {
			self::$logger->error ( 'expositionId parameter expected' );
			throw new InvalidArgumentException ( 'expositionId parameter expected' );
		}
		
		$connectionManager = ConnectionManager::getInstance ();
		
		//Delete exposition attendants
		$cancelExpositionQuery = PresentationsDB::cancelExposition($expositionId);
		
		$cancelExpositionRS = $connectionManager->executeTransaction ( $cancelExpositionQuery );
		
		if ($cancelExpositionRS === false) {
			self::$logger->error ( Util::getLiteral ( 'error_canceling_exposition' ) );
			self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			throw new InvalidArgumentException ( Util::getLiteral ( 'error_canceling_exposition' ) );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;
	
	}
}