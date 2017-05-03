<?php

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/phpqrcode/qrlib.php';


class Presentation
{	
	/**
	 * Presentation id
	 * @var int
	 */
	private $id;
	
	/**
	 * Presentation title
	 * @var string
	 */
	private $title;
	
	/**
	 * Presentation description
	 * @var string
	 */
	private $description;
	
	/**
	 * Presentation filename
	 * @var string
	 */
	private $filename;
	
	/**
	 * Presentation owner
	 * @var int
	 */
	private $userid;
	
	/**
	 * Presentation creation date
	 * @var string
	 */
	private $creationdate;
	
	/**
	 * List of presentations expositions
	 * @var Expositions Array
	 */
	private $expositions;
	
	public function __construct($presentation = null){
		
		if ($presentation != null) {
			$this->autoLoad ( $presentation );
		}
	
	}
	
	/**
	 * Auto load of the object with existent data
	 * @author Gabriel Guzman
	 * @param array $presentation
	 */
	private function autoLoad($presentation) {
		
		Util::autoMapEntity ( $this, $presentation );
	
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return the $filename
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * @param string $filename
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
	}

	/**
	 * @return the $userId
	 */
	public function getUserid() {
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserid($userId) {
		$this->userid = $userId;
	}

	/**
	 * @return the $expositions
	 */
	public function getExpositions() {
		return $this->expositions;
	}

	/**
	 * @param Expositions $expositions
	 */
	public function setExpositions($expositions) {
		$this->expositions = $expositions;
	}
	
	/**
	 * Add an exposition to list
	 * @param Exposition $exposition
	 */
	public function addExposition($exposition){
		$this->expositions [] = $exposition;
	}
	
	/**
	 * @return the $creationdate
	 */
	public function getCreationdate() {
		return $this->creationdate;
	}

	/**
	 * @param string $creationdate
	 */
	public function setCreationdate($creationdate) {
		$this->creationdate = $creationdate;
	}
	
	/**
	 * Gets a QR code image url.
	 * 
	 * @param string $url
	 * @return string
	 */
	public static function getQR($url) {
		$configurator = Configurator::getInstance ();
		$presentationsPathBase = $configurator->getPresentationsPath ();
		$presentationsPathFilesPublic = $configurator->getPresentationsPathFilesPublic(). $_SESSION ['loggedUser']->getUserlogin () . '/';
		$userPresentationsPath = $presentationsPathBase . $_SESSION ['loggedUser']->getUserlogin () . '/';
		$path = str_replace('/', '-', str_replace('http://', '',$url)).'.png';
		if (!file_exists($userPresentationsPath . $path)) {
			QRcode::png($url, $userPresentationsPath . $path, 'L', 16, 2);
		}
		
		return 'http://'.$_SERVER['HTTP_HOST'].$presentationsPathFilesPublic.$path;
	}

}