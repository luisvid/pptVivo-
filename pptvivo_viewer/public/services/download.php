<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/managers/PresentationsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilter.class.php';
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/User.class.php');

$configurator = Configurator::getInstance ();

session_start ();

//Logger
$_SESSION ['logger'] = MyLogger::getInstance ();

class Download{

	public function render($file){
		
		if (file_exists ( $file )) {
			header ( 'Content-Description: File Transfer' );
			header ( 'Content-Type: application/octet-stream' );
			header ( 'Content-Disposition: attachment; filename=' . basename ( $file ) );
			header ( 'Content-Transfer-Encoding: binary' );
			header ( 'Expires: 0' );
			header ( 'Cache-Control: must-revalidate' );
			header ( 'Pragma: public' );
			header ( 'Content-Length: ' . filesize ( $file ) );
			ob_clean ();
			flush ();
			readfile ( $file );
			exit ();
		}

	}

}
		
try{
	
	$filters = array ();
	
	$presentationFilter = new NumberFilter('presentationid', '', null, 'presentation.id');
	$presentationFilter->setSelectedValue($_REQUEST['presentationId']);
	$filters [] = $presentationFilter;
	
	//Presentation Data
	$presentationsManager = PresentationsManager::getInstance();
	$presentation = $presentationsManager->getPresentationsList(0, 1, $filters, $_SESSION ['loggedUser']->getId());
	
	if(!is_object($presentation[0])){
		throw new Exception('Presentation doesn\'t exist in data base');
	}
	
	$presentationPathData = Util::getPresentationPathData($presentation[0]);
	
	$fileName = $presentationPathData['presentationsPath'] .$presentation[0]->getFilename();
	
	if(!file_exists($fileName)){
		throw new Exception('Presentation file doesn\'t exist');
	}
	
	$download = new Download();

	echo $download->render($fileName);
	
}
catch (Exception $e){
	
	$_SESSION ['logger']->error ( $e->getMessage() );
	$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );	
	
}