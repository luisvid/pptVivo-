<?php

class ExpositionQuestion {
	
	/**
	 * Question detail
	 * @var string
	 */
	private $question;
	
	/**
	 * Slide where the question belongs
	 * @var int
	 */
	private $slide;
	
	public function __construct($question, $slide){
	
		$this->question = $question;
		
		$this->slide = $slide;
		
	}
	
	/**
	 * @return the $question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @param string $question
	 */
	public function setQuestion($question) {
		$this->question = $question;
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