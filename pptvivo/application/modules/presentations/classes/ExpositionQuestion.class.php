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
	
	/**
	 * Question author userlogin
	 * @var string
	 */
	private $userlogin;
	
	/**
	 * Question author name
	 * @var string
	 */
	private $username;
	
	/**
	 * Question author surname
	 * @var string
	 */
	private $usersurname;
	
	public function __construct($question, $slide, $userLogin){
	
		$this->question = $question;
		
		$this->slide = $slide;
		
		$this->userlogin = $userLogin;
		
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
	
	/**
	 * @return the $userlogin
	 */
	public function getUserlogin() {
		return $this->userlogin;
	}

	/**
	 * @param string $userlogin
	 */
	public function setUserlogin($userlogin) {
		$this->userlogin = $userlogin;
	}
	
	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return the $usersurname
	 */
	public function getUsersurname() {
		return $this->usersurname;
	}

	/**
	 * @param string $usersurname
	 */
	public function setUsersurname($usersurname) {
		$this->usersurname = $usersurname;
	}

}