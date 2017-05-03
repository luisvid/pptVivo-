<?php

class ExpositionNote {
	
	/**
	 * Note detail
	 * @var string
	 */
	private $note;
	
	/**
	 * Exposition slide where the note belongs
	 * @var int
	 */
	private $slide;
	
	public function __construct($note, $slide){
	
		$this->note = $note;
		
		$this->slide = $slide;
		
	}
	
	/**
	 * @return the $note
	 */
	public function getNote() {
		return $this->note;
	}

	/**
	 * @param string $note
	 */
	public function setNote($note) {
		$this->note = $note;
	}

	/**
	 * @return the $slide
	 */
	public function getSlide() {
		return $this->slide;
	}

	/**
	 * @param int $slide
	 */
	public function setSlide($slide) {
		$this->slide = $slide;
	}


}