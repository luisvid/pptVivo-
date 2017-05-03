<?php
class Exposition {
	
	/**
	 * Exposition id
	 * @var int
	 */
	private $id;
	
	/**
	 * Exposure date
	 * @var DateTime
	 */
	private $exposuredate;
	
	/**
	 * Exposition notes
	 * @var ExpositionNote array
	 */
	private $notes;
	
	/**
	 * Exposition questions
	 * @var ExpositionQuestion array
	 */
	private $questions;
	
	/**
	 * Exposition attendants
	 * @var User array
	 */
	private $attendants;
	
	/**
	 * Presentation id
	 * @var int
	 */
	private $presentationId;
	
	/**
	 * Exposition QR code
	 * @var string
	 */
	private $qrCode;
	
	/**
	 * Exposition short url
	 * @var string
	 */
	private $shortUrl;
	
	public function __construct($exposition = null) {
		
		if ($exposition != null) {
			$this->autoLoad ( $exposition );
		}
	
	}
	
	/**
	 * Auto load of the object with existent data
	 * @author Gabriel Guzman
	 * @param array $exposition
	 */
	private function autoLoad($exposition) {
		
		Util::autoMapEntity ( $this, $exposition );
	
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
	 * @return the $exposuredate
	 */
	public function getExposuredate() {
		return $this->exposuredate;
	}
	
	/**
	 * @param DateTime $exposuredate
	 */
	public function setExposuredate($exposuredate) {
		$this->exposuredate = $exposuredate;
	}
	
	/**
	 * @return the $notes
	 */
	public function getNotes() {
		return $this->notes;
	}
	
	/**
	 * @param ExpositionNote $notes
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
	}
	
	/**
	 * Adds a note
	 * @param ExpositionNote $note
	 */
	public function addNote($note) {
		$this->notes [] = $note;
	}
	
	/**
	 * @return the $questions
	 */
	public function getQuestions() {
		return $this->questions;
	}
	
	/**
	 * @param ExpositionQuestion $questions
	 */
	public function setQuestions($questions) {
		$this->questions = $questions;
	}
	
	/**
	 * Adds a question
	 * @param ExpositionQuestion $question
	 */
	public function addQuestion($question) {
		$this->questions [] = $question;
	}
	
	/**
	 * @return the $attendants
	 */
	public function getAttendants() {
		return $this->attendants;
	}
	
	/**
	 * @param Attendant array $attendants
	 */
	public function setAttendants($attendants) {
		$this->attendants = $attendants;
	}
	
	/**
	 * Adds an attendant to list
	 * @param User $attendant
	 */
	public function addAttendant($attendant) {
		$this->attendants [] = $attendant;
	}

	/**
	 * @return the $presentationId
	 */
	public function getPresentationId() {
		return $this->presentationId;
	}
	
	/**
	 * @param int $presentationId
	 */
	public function setPresentationId($presentationId) {
		$this->presentationId = $presentationId;
	}

	/**
	 * @return the $qrCode
	 */
	public function getQrCode() {
		return $this->qrCode;
	}
	
	/**
	 * @param string $qrCode
	 */
	public function setQrCode($qrCode) {
		$this->qrCode = $qrCode;
	}
	
	/**
	 * @return the $shortUrl
	 */
	public function getShortUrl() {
		return $this->shortUrl;
	}
	
	/**
	 * @param string $shortUrl
	 */
	public function setShortUrl($shortUrl) {
		$this->shortUrl = $shortUrl;
	}
	
}