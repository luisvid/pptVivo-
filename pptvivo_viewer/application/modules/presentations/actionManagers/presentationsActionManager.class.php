<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/managers/PresentationsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';

class presentationsActionManager extends ModuleActionManager {
	
	protected $manager;
	
	public function __construct() {
		
		$this->manager = PresentationsManager::getInstance();
	
	}
	
	/* (non-PHPdoc)
	 * @see ModuleActionManager::getList()
	 */
	public function getList() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( Util::getLiteral('invalid_presentation_url') );
			
		$render = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $render;
		
	}
	
	/* (non-PHPdoc)
	 * @see ModuleActionManager::getDetail()
	 * View presentation
	 */
	public function getDetail() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			
			if(!isset($_REQUEST['urlargs'][2]) || $_REQUEST['urlargs'][2] == null){
				throw new InvalidArgumentException('Username in URL shouldn\'t be null');
			}
			
			if(!isset($_REQUEST['urlargs'][3]) || $_REQUEST['urlargs'][3] == null){
				throw new InvalidArgumentException('Presentation id in URL shouldn\'t be null');
			}
			
			if(!isset($_REQUEST['urlargs'][4]) || $_REQUEST['urlargs'][4] == null){
				throw new InvalidArgumentException('Exposition id in URL shouldn\'t be null');
			}
			
			//Exposition data
			$expositionId = trim($_REQUEST['urlargs'][4]);
			
			//Check exposition existance
			$expositionFilters = array();
			$expositionFilter = new NumberFilter('expositionid', '', null, 'exposition.id');
			$expositionFilter->setSelectedValue($expositionId);
			$expositionFilters [] = $expositionFilter;
			$exposition = $this->manager->getExposures($expositionFilters);
			
			if(!is_array($exposition) || count($exposition) <= 0 || !is_object($exposition [0])){
				throw new Exception('Error retrieving exposition. Please verify data in URL');
			}
			
			//Presentation filters
			$presentationId = trim($_REQUEST['urlargs'][3]);			
			$presentationFilter = new NumberFilter('presentationid', '', null, 'presentation.id');
			$presentationFilter->setSelectedValue($presentationId);
			$filters [] = $presentationFilter;
			
			//Author data
			$userLogin = trim($_REQUEST['urlargs'][2]);
			$userManager = UserManager::getInstance();
			$author = $userManager->getUserByLogin($userLogin, true);
			
			if(!is_array($author) || count($author) <= 0 || !is_object($author [0])){
				throw new Exception('Error retrieving author. Please verify data in URL');
			}
			
			$authorId = $author[0]->getId();
			
			//get Presentation
			$presentation = $this->manager->getPresentationsList(0, 1, $filters, $authorId);
			
			if(!is_array($presentation) || count($presentation) <= 0 || !is_object($presentation[0])){
				throw new Exception('Error retrieving presentation. Please verify data in URL');
			}
			
			//Copy presentation into user folder
			$presentationPathData = Util::getPresentationPathData($presentation[0], $author[0]->getUserlogin());
			
			$configurator = Configurator::getInstance();
			
			$userCurrentPresentationPath = $configurator->getPresentationsPath() . $_SESSION ['loggedUser']->getUserlogin() . '\\' . $presentationPathData ['presentationName'] . '';
			
			//Create folder
			if(!is_dir($userCurrentPresentationPath)){
				if (! mkdir ( $userCurrentPresentationPath )) {
					$_SESSION ['logger']->error ( Util::getLiteral ( 'error_creating_presentation_folder' ) . ': ' .$userCurrentPresentationPath );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new Exception ( Util::getLiteral ( 'error_creating_presentation_folder' ) . ': ' . $userCurrentPresentationPath );
				}
			}
			
			//Copy presentation
			$userTargetFile = $userCurrentPresentationPath . '/' . $presentation[0]->getFilename();
			$userSourceFile = $presentationPathData['presentationsPath'] . $presentation[0]->getFilename();  
			if(!file_exists($userTargetFile)){
				if (!copy($userSourceFile, $userTargetFile)) {
					$_SESSION ['logger']->error ( Util::getLiteral ( 'error_copying_file' ) . ': ' .$userSourceFile );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					throw new Exception ( Util::getLiteral ( 'error_copying_file' ) . ': ' . $userSourceFile );
				}	
			}
			
			//Current slide
			$currentSlide = $this->manager->getExpositionSlide($expositionId);
			
			//Player view		
			require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/Player.view.php';
			$html = Player::render($presentation[0], $presentationPathData, $configurator, $author[0], $expositionId, $currentSlide);
			
			//Insert exposition attendance
			$insertAttendance = $this->insertExpositionAttendance($expositionId, $_SESSION ['loggedUser']->getId());
		
		}
		catch(Exception $e){
			$_SESSION ['logger']->error ( $e->getMessage() );		
			$html = $e->getMessage();			
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getSingleMaster();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function checkExpositionUpdates(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			$currentSlide = $this->manager->getExpositionSlide($_REQUEST['expositionId']);
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $e->getMessage() );
			
			$message = '<br />' . $e->getMessage();
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new AjaxMessageBox ( ErrorMessageView::render ( $message ), null, Util::getLiteral('error') );
			
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxRender(trim($currentSlide));
		
	}
	
	public function createExpositionNote(){

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			$result = $this->manager->insertExpositionNote($_REQUEST['expositionId'], Render::renderContent($_REQUEST['note']), $_REQUEST['slide'], $_SESSION ['loggedUser']->getId());
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $e->getMessage() );
			
			$message = '<br />' . $e->getMessage();
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new AjaxMessageBox ( ErrorMessageView::render ( $message ), null, Util::getLiteral('error') );
			
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxRender('true');
		
	}
	
	public function addExpositionNote(){
		
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/AddNote.view.php';
		
		$render = AddNote::render();
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxMessageBox ( $render, null, Util::getLiteral('add_note') );
		
	}
	
	protected function insertExpositionAttendance($expositionId, $userId){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$result = true;
		
		if(!$this->existAttendance($expositionId, $userId)){
			
			$result = $this->manager->insertExpositionAttendance($expositionId, $userId);
			
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
	}
	
	protected function existAttendance($expositionId, $userId){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$result = $this->manager->existAttendance($expositionId, $userId);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
	}
	
	public function createExpositionQuestion(){

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			$result = $this->manager->insertExpositionQuestion($_REQUEST['expositionId'], Render::renderContent($_REQUEST['question']), $_REQUEST['slide'], $_SESSION ['loggedUser']->getId());
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $e->getMessage() );
			
			$message = '<br />' . $e->getMessage();
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new AjaxMessageBox ( ErrorMessageView::render ( $message ), null, Util::getLiteral('error') );
			
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxRender('true');
		
	}
	
	public function addExpositionQuestion(){
		
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/AddQuestion.view.php';
		
		$render = AddQuestion::render();
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxMessageBox ( $render, null, Util::getLiteral('add_question') );
		
	}
}