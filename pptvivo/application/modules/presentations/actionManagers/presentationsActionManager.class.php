<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/managers/PresentationsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';

class presentationsActionManager extends ModuleActionManager {
	
	protected $manager;
	
	public function __construct() {
		
		$this->manager = PresentationsManager::getInstance();
	
	}
	
	public function getList($maxQuantity) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'presentationsList';
		
		//Pager variables
		$count = $_SESSION ['s_parameters'] ['page_size'];
		
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] != '' && is_numeric ( $_REQUEST ['page'] )) {
			$page = $_REQUEST ['page'];
		} else {
			$page = '';
		}
		
		if ($page == '') {
			$begin = 0;
			$page = 1;
		} else {
			$begin = ($page - 1) * $count;
		}
		
		$filters = array ();
		
		//Count
		$numrows = $this->manager->getPresentationsCount($filters, $_SESSION ['loggedUser']->getId());
		
		$list = array();
		
		if($numrows > 0){
			//List
			$list = $this->manager->getPresentationsList($begin, $count, $filters, $_SESSION ['loggedUser']->getId());
		}
		
		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'presentationsFilter', '', '', '', 3 );
		$filterGroup->setFiltersList ( $filters );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/PresentationsList.view.php';
		
		$render = PresentationsList::render ( $list, $filterGroup, $pager );
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function delete() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$presentationId = $_REQUEST ['presentationId'];
		
		try {
			$result = $this->manager->deletePresentation($presentationId);
			
			if ($result) {
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
			} else {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_presentation'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_deleting_presentation'], null, $_SESSION ['s_message'] ['error'] );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_presentation'] . ' ' . $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_deleting_presentation'] . '<br />' . $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
		}
	
	}
	
	public function create() {

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			
			$_POST['control_userId'] = $_SESSION['loggedUser']->getId();
			
			$result = $this->manager->createPresentation($_POST, $_FILES['control_file']);
			
			if($result){
				return new RedirectActionResponse( '/'.$_REQUEST['urlargs'][0].'/'.$_REQUEST['urlargs'][1] );
			}
			else{
				throw  new Exception('');	
			}
			
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_creating_presentation'] . ': ' . $e->getMessage() );
			
			$html = '<br />' . $_SESSION ['s_message'] ['error_creating_presentation'] . '<br />' . $e->getMessage();
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
			$masterView = MasterFactory::getMaster ();
				
			$view = $masterView->render ( $html );
				
			$render = new RenderActionResponse ( $view );
			
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return $render;	
			
		}
		
	}
	
	public function createPresentation(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/Create.view.php';
		
		try {
			
			$fields = array();
			
			$fields ['title'] = $this->getTextControl(false, 'title', Util::getLiteral('title'), '100', true);
			
			$fields ['description'] = $this->getTextAreaControl(false, 'description', Util::getLiteral('description'), false);
			
			$html = Create::render($fields);
				
		} catch (Exception $e) {
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$html = ErrorMessageView::render ( $e->getMessage () );
			
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $render;	
		
	}
	
	public function viewAttendances() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'attendancesList';
		
		//Pager variables
		$count = $_SESSION ['s_parameters'] ['page_size'];
		
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] != '' && is_numeric ( $_REQUEST ['page'] )) {
			$page = $_REQUEST ['page'];
		} else {
			$page = '';
		}
		
		if ($page == '') {
			$begin = 0;
			$page = 1;
		} else {
			$begin = ($page - 1) * $count;
		}
		
		$filters = array ();
		
		//Count
		$numrows = $this->manager->getPresentationsAttendancesCount($filters, $_SESSION ['loggedUser']->getId());
		
		$list = array();
		
		if($numrows > 0){
			//List
			$list = $this->manager->getPresentationsAttendancesList($begin, $count, $filters, $_SESSION ['loggedUser']->getId());
		}
		
		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'attendancesFilter', '', '', '', 3 );
		$filterGroup->setFiltersList ( $filters );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/AttendancesList.view.php';
		
		$html = AttendancesList::render ( $list, $filterGroup, $pager );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function viewAttendanceComments(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$list = $this->manager->getAttendanceComments($_REQUEST['expositionId'], $_SESSION ['loggedUser']->getId());
		
		$presentation = $this->manager->getPresentationById($_REQUEST['presentationId']);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/AttendanceCommentsList.view.php';
		
		$render = AttendanceCommentsList::Render($list, $presentation);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['attendance_comments'] );
		
	}
	
	public function deleteAttendedPresentation(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$presentationId = $_REQUEST ['presentationId'];
		$userId = $_SESSION ['loggedUser']->getId();
		
		try {
			$result = $this->manager->deleteExpositionAttendance($userId, $presentationId);
			
			if ($result) {
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRedirect ( '/'.$_REQUEST['urlargs'][0].'/'.$_REQUEST['urlargs'][1] . '?action=viewAttendances' );
			} else {
				$_SESSION ['logger']->error ( Util::getLiteral('error_deleting_attendance') );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( Util::getLiteral('error_deleting_attendance'), null, $_SESSION ['s_message'] ['error'] );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( Util::getLiteral('error_deleting_attendance') . ' ' . $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( '<br />' . Util::getLiteral('error_deleting_attendance') . '<br />' . $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
		}
	
	}

	public function getDetail() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		try{
			
			if(!isset($_REQUEST['urlargs'][2]) || $_REQUEST['urlargs'][2] == null){
				throw new InvalidArgumentException('Presentation id shouldn\'t be null');
			}
		
			$subConcept = 'expositionsList';
			
			//Pager variables
			$count = $_SESSION ['s_parameters'] ['page_size'];
			
			if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] != '' && is_numeric ( $_REQUEST ['page'] )) {
				$page = $_REQUEST ['page'];
			} else {
				$page = '';
			}
			
			if ($page == '') {
				$begin = 0;
				$page = 1;
			} else {
				$begin = ($page - 1) * $count;
			}
			
			$filters = array ();
			
			$presentationFilter = new NumberFilter('presentationid', '', null, 'presentation.id');
			$presentationFilter->setSelectedValue($_REQUEST['urlargs'][2]);
			$filters [] = $presentationFilter;
					
			//Count
			$numrows = $this->manager->getPresentationsExposuresCount($filters);
			
			$list = array();
			
			if($numrows > 0){
				//List
				$list = $this->manager->getPresentationsExposures($begin, $count, $filters, true, true);
			}
			
			//Pager
			$pager = Util::getPager ( $numrows, $begin, $page, $count );
			
			//Presentation Data
			$presentation = $this->manager->getPresentationsList(0, 1, $filters, $_SESSION ['loggedUser']->getId());
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/ExpositionsList.view.php';
			
			$html = ExpositionsList::render ( $list, $pager, $presentation[0] );
		
		}
		catch(Exception $e){
			$_SESSION ['logger']->error ( $e->getMessage() );		
			$html = $e->getMessage();			
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function createExposition(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try{
			$expositionId = $this->manager->createExposition($_REQUEST['presentationId']);
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $e->getMessage() );
			
			$message = '<br />' . $e->getMessage();
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new AjaxMessageBox ( ErrorMessageView::render ( $message ), null, Util::getLiteral('error') );
			
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxRender(trim($expositionId));
		
	}
	
	public function viewQR(){
		
		try {
			
			if(!isset($_REQUEST['qrPath']) || $_REQUEST['qrPath'] == null){
				throw new InvalidArgumentException("QR path empty");
			}
			
			if(!isset($_REQUEST['expositionUrl']) || $_REQUEST['expositionUrl'] == null){
				throw new InvalidArgumentException("Exposition URL empty");
			}
			
			$qrPath = base64_decode($_REQUEST['qrPath']);
			
			$shortenExpositionUrl = base64_decode($_REQUEST['expositionUrl']);
			
			$html = '<div class="qrcode-container">';
			$html .= Util::getLiteral('qr_code_text');
			$html .= '<br />';
			$html .= '<a target="_blank" href="' . $shortenExpositionUrl . '" target="_blank">' . $shortenExpositionUrl . '</a>';
			$html .= '<br />';
			$html .= Util::getLiteral('qr_code_text_2');
			$html .= '<br />';
			$html .=  '<img src="' . $qrPath . '" alt="QR Code" />';
			$html .= '<br />';
			$html .= '<a title="'.Util::getLiteral("download").'" href="/services/download.php?fileToDownload='.$_REQUEST['qrPath'].'">'.Util::getLiteral("download").'</a>';
			$html .= '</div>';
			$html .= '<br /><br /><br />';
			$html .= '<a href="/'.$_REQUEST['urlargs'][0].'/'.$_REQUEST['urlargs'][1].'">'.Util::getLiteral('back').'</a>';
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
			$masterView = MasterFactory::getMaster ();
				
			$view = $masterView->render ( $html );
				
			$render = new RenderActionResponse ( $view );
			
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return $render;
		}
		catch (Exception $e){
			
			$_SESSION ['logger']->error ( $e->getMessage() );
			
			$message = '<br />' . $e->getMessage();
			
			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			
			return new AjaxMessageBox ( ErrorMessageView::render ( $message ), null, Util::getLiteral('error') );
			
		}
		
	}

	public function cancelExposition(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$expositionId = $_REQUEST ['expositionId'];
		
		try {
			$result = $this->manager->cancelExposition($expositionId);
			
			if ($result) {
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
			} else {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_canceling_exposition'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_canceling_exposition'], null, $_SESSION ['s_message'] ['error'] );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_canceling_exposition'] . ' ' . $e->getMessage() );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_canceling_exposition'] . '<br />' . $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
		}
		
	}

	public function showBigImage(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/presentations/views/ShowBigImage.view.php';
		
		$render = ShowBigImage::Render($_REQUEST['imagePath']);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['attendance_comments'] );
		
	}

	public function checkExistingFile(){

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' ############## begin ##############' );
		
		try {
			$presentationFileName = $_REQUEST['fileName'];
			$loggedUserId = $_SESSION ['loggedUser']->getId();
			
			if( !isset($presentationFileName) || $presentationFileName == '' ) {
				$_SESSION ['logger']->error ( 'fileName parameter expected ' );
				throw new InvalidArgumentException ( 'fileName parameter expected ' );
			}

			$exists = $this->manager->checkPresentationByName($presentationFileName, $loggedUserId);
			
			if($exists == 'true') {
				$_SESSION ['logger']->error ( Util::getLiteral('error_existing_file') );
				throw new InvalidArgumentException ( Util::getLiteral('error_existing_file') );
			} else {
				$result = true;
				$message = 'It\'s OK, go ahead';
			}

		}
		catch (Exception $e) {
			$message = $e->getMessage();
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' ############## error ##############' );
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render($message, $result);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender($html);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' ############## end ##############' );
		
		return $render;

	}

}