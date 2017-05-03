<?php
class User{
	
	private $id;
	
	private $username;
	
	private $usersurname;
	
	private $useremail;
	
	private $userlogin;
	
	private $userpassword;
	
	private $usertypeid;
	
	private $usertypename;
	
	private $active;
	
	public function __construct($user = null){
		
		if ($user != null) {
			$this->autoLoad ( $user );
		}
	
	}
	
	/**
	 * Auto load of the object with existent data
	 * @author Gabriel Guzman
	 * @param array $user
	 */
	private function autoLoad($user) {
		
		Util::autoMapEntity ( $this, $user );
	
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param field_type $username
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
	 * @param field_type $usersurname
	 */
	public function setUsersurname($usersurname) {
		$this->usersurname = $usersurname;
	}

	/**
	 * @return the $useremail
	 */
	public function getUseremail() {
		return $this->useremail;
	}

	/**
	 * @param field_type $useremail
	 */
	public function setUseremail($useremail) {
		$this->useremail = $useremail;
	}

	/**
	 * @return the $userlogin
	 */
	public function getUserlogin() {
		return $this->userlogin;
	}

	/**
	 * @param field_type $userlogin
	 */
	public function setUserlogin($userlogin) {
		$this->userlogin = $userlogin;
	}

	/**
	 * @return the $userpassword
	 */
	public function getUserpassword() {
		return $this->userpassword;
	}

	/**
	 * @param field_type $userpassword
	 */
	public function setUserpassword($userpassword) {
		$this->userpassword = $userpassword;
	}

	/**
	 * @return the $usertypeid
	 */
	public function getUsertypeid() {
		return $this->usertypeid;
	}

	/**
	 * @param field_type $usertypeid
	 */
	public function setUsertypeid($usertypeid) {
		$this->usertypeid = $usertypeid;
	}

	/**
	 * @return the $usertypename
	 */
	public function getUsertypename() {
		return $this->usertypename;
	}

	/**
	 * @param field_type $usertypename
	 */
	public function setUsertypename($usertypename) {
		$this->usertypename = $usertypename;
	}
	/**
	 * @return the $active
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * @param field_type $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}
	
}