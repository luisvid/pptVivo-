<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/managers/PresentationsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/BooleanFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/DateRangeFilter.class.php';
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/User.class.php');

$configurator = Configurator::getInstance ();

session_start ();

//Logger
$_SESSION ['logger'] = MyLogger::getInstance ();

class SlideSynchronizer {
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		
		if (! isset ( SlideSynchronizer::$instance )) {
			self::$instance = new SlideSynchronizer ();
		}
		
		return SlideSynchronizer::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	public function updateSlide($expositionId, $slideId){
		
		$response = 'false';
		
		try{
		
			$presentationsManager = PresentationsManager::getInstance();
			
			$result = $presentationsManager->updateExpositionSlide($expositionId, $slideId);
			
			if($result){
				$response = 'true';
			}
		
		}
		catch (Exception $e){
			/**
			 * @todo: error logging
			 */
		}
		
		$xmlString = '
						<presentationSync>
							<response value="'.$response.'"></response>
						</presentationSync>
						';
			
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
	public function getExpositionId($presentationName, $authorId){
		
		$expositionId = 0;
		
		try{
		
			$filters = array ();
				
			$presentationFilter = new TextFilter('filename', '', null, 'presentation.filename');
			$presentationFilter->setSelectedValue($presentationName);
			$filters [] = $presentationFilter;
			
			$authorFilter = new NumberFilter('author', '', null, 'presentation.userid');
			$authorFilter->setSelectedValue($authorId);
			$filters [] = $authorFilter;
			
			$activeFilter = new BooleanFilter('active', '', 'exposition.active');
			$activeFilter->setSelectedValue(true);
			$filters [] = $activeFilter;
			
			$presentationsManager = PresentationsManager::getInstance();
			
			$expositionRS = $presentationsManager->getPresentationsExposures(0, 1, $filters, false, false);
			
			$expositionId = 0;
			$presentationId = 0;
			if(is_array($expositionRS) && count($expositionRS) > 0){
				$expositionId = $expositionRS[0]->getId();
				$presentationId = $expositionRS[0]->getPresentationId();
			}
		
		}
		catch(Exception $e){
			/**
			 * @todo: error logging
			 */
		}
		
		$xmlString = '
						<expositionData>
							<expositionId value="'.$expositionId.'"></expositionId>
							<presentationId value="'.$presentationId.'"></presentationId>
						</expositionData>
					';
			
		$xml = simplexml_load_string($xmlString);
		
		return $xml->asXML();
		
	}
	
}

if(isset($_GET['action']) || $_GET['action'] != null){
	
	switch ($_GET['action']) {
		
		case 'getExpositionId':
		{
			if(isset($_GET['presentationName']) && $_GET['presentationName'] != null && isset($_GET['authorId']) && $_GET['authorId'] != null)
			{
				$slideUpdater = SlideSynchronizer::getInstance();
				echo $slideUpdater->getExpositionId($_GET['presentationName'], $_GET['authorId']);
			}
			break;
		}
		case 'updateSlide':
		{
			if(isset($_GET['expositionId']) && $_GET['expositionId'] != null && isset($_GET['slideId']) && $_GET['slideId'] != null)
			{
				$slideUpdater = SlideSynchronizer::getInstance();
				echo $slideUpdater->updateSlide($_GET['expositionId'], $_GET['slideId']);
			}	
		}
		
		default:
			;
		break;
	}
	
}