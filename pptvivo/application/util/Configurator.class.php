<?php
/**
 * Load Site configuration
 * @package util
 * @author Gabriel Guzmán 
 * @version 
 * DATE OF CREATION: 13-03-2012
 * UPDATE LIST
 * * UPDATE: 
 * CALLED BY: url.php
 */
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Filesystem.class.php';

class Configurator {
	
	private static $instance;
	
	private $configuration;
	
	/**
	 * Get an instance of Configurator
	 *
	 * @return Configurator configurator instance
	 */
	public static function getInstance() {
		
		if (! isset ( self::$instance )) {
			self::$instance = new Configurator ();
			$configPath = $_SERVER ['DOCUMENT_ROOT'] . "/../application/configs/config.ini";
			if (! is_array ( self::$instance->loadConfiguration ( $configPath ) )) {
				self::$instance = null;
				throw new Exception ( "unable to load config file in: " . $configPath );
			}
		
		}
		return self::$instance;
	}
	
	/**
	 * Read the config file and get the application configuration
	 */
	private function loadConfiguration($configPath) {
		
		$result = $this->configuration = parse_ini_file ( $configPath );
		
		//true if configuration load process OK
		return $result;
	}
	
	/**
	 * Get the Dev / Prod file mapping directory
	 * @param   int     environment
	 * @return  string  PfwFileMappingDirectory
	 */
	public function getPfwFileMappingDirectory() {
		
		if (isset ( $this->configuration ['app.fileMappingDirectory'] ) && $this->configuration ['app.fileMappingDirectory'] != '') {
			
			$pfwFileMappingDirectory = $this->configuration ['app.fileMappingDirectory'];
			
			$result = $this->removeLastSlash ( $pfwFileMappingDirectory );
			
			if (! Filesystem::is_dir ( $result )) {
				throw new Exception ( "app.fileMappingDirectory must exist whit the real location of the folder" );
			}
			
			return $result;
		
		} else {
			throw new Exception ( "app.fileMappingDirectory must be present in the config.ini file" );
		}
	}
	
	private function removeLastSlash($path) {
		
		if ($path [strlen ( $path ) - 1] == "/" or $path [strlen ( $path ) - 1] == "\\") {
			return substr ( $path, 0, - 1 );
		}
		
		return $path;
	}
	
	/**
	 * Get the Minimice Css option
	 * @return boolean.
	 */
	public function getMinimiceCss() {
		
		if (isset ( $this->configuration ['minimice.css'] ) && $this->configuration ['minimice.css'] != '') {
			if ($this->configuration ['minimice.css'] == 1) {
				$minimiceCss = true;
			} elseif ($this->configuration ['minimice.css'] == 0) {
				$minimiceCss = false;
			} else {
				throw new Exception ( "minimice.css must be 1(true) or 0(false)" );
			}
		} else {
			throw new Exception ( "minimice.css must be filled" );
		}
		return $minimiceCss;
	
	}
	
	/**
	 * Get the Minimice Js option
	 * @return boolean.
	 */
	public function getMinimiceJs() {
		
		if (isset ( $this->configuration ['minimice.js'] ) && $this->configuration ['minimice.js'] != '') {
			if ($this->configuration ['minimice.js'] == 1) {
				$minimiceCss = true;
			} elseif ($this->configuration ['minimice.js'] == 0) {
				$minimiceCss = false;
			} else {
				throw new Exception ( "minimice.js must be 1(true) or 0(false)" );
			}
		} else {
			throw new Exception ( "minimice.js must be filled" );
		}
		return $minimiceCss;
	
	}
	
	/**
	 * Get the presentations path
	 * @throws Exception
	 * @return string
	 */
	public function getPresentationsPath(){
		
		if(isset($this->configuration ['presentations.path.alias']) && $this->configuration ['presentations.path.alias'] != null
			&& isset($this->configuration ['presentations.path.users']) && $this->configuration ['presentations.path.users'] != null){
				$presentationsPath = $this->configuration ['presentations.path.alias'].$this->configuration['presentations.path.users'];
		}
		else{
			throw new Exception('presentations.path.alias and presentations.path.users must be filled');
		}
		
		return $presentationsPath;
		
	}
	
	public function getPresentationsPathFilesPublic(){
		
		if(isset($this->configuration ['presentations.path.users.files.public']) && $this->configuration ['presentations.path.users.files.public'] != null){
				$presentationsPathFilesPublic = $this->configuration ['presentations.path.users.files.public'];
		}
		else{
			throw new Exception('presentations.path.users.files.public');
		}
		
		return $presentationsPathFilesPublic;
		
	}
	
	
	
	/**
	 * Get the presentations output format
	 * @throws Exception
	 * @return string
	 */
	public function getPresentationsOutputFormat(){
		
		if(isset($this->configuration ['output.format']) && $this->configuration ['output.format'] != null){
			$outputFormat = $this->configuration ['output.format'];
		}
		else{
			throw new Exception('output.format must be filled');
		}
		
		return $outputFormat;
		
	}
	
	/**
	 * Get the presentations intermediate conversion format
	 * @throws Exception
	 * @return string
	 */
	public function getPresentationsIntermediateFormat(){
		
		if(isset($this->configuration ['intermediate.format']) && $this->configuration ['intermediate.format'] != null){
			$intermediateFormat = $this->configuration ['intermediate.format'];
		}
		else{
			throw new Exception('intermediate.format must be filled');
		}
		
		return $intermediateFormat;
		
	}
	
	/**
	 * Get the default configured timezone
	 * @return string
	 */
	public function getDefaultTimeZone(){
		
		if(isset($this->configuration ['default.timezone']) && $this->configuration ['default.timezone'] != null){
			$defaultTimezone = $this->configuration ['default.timezone'];
		}
		else{
			$defaultTimezone = ini_get('date.timezone');
		}
		
		return $defaultTimezone;
		
	}
	
	/**
	 * Get the path for converter utility
	 * @throws Exception
	 * @return unknown
	 */
	public function getConverterPath(){
		
		if(isset($this->configuration ['convert.command.path']) && $this->configuration ['convert.command.path'] != null){
			$converterPath = $this->configuration ['convert.command.path'];
		}
		else{
			throw new Exception('convert.command.path must be filled');
		}
		
		return $converterPath;
		
	}
	
	/**
	 * Get Facebook App Id
	 * @throws Exception
	 * @return unknown
	 */
	public function getFacebookAppId(){
		
		if(isset($this->configuration ['facebook.app.id']) && $this->configuration ['facebook.app.id'] != null){
			$facebookAppId = $this->configuration ['facebook.app.id'];
		}
		else{
			throw new Exception('facebook.app.id must be filled');
		}
		
		return $facebookAppId;
		
	}
	
	/**
	 * Get Facebook App Secret
	 * @throws Exception
	 * @return unknown
	 */
	public function getFacebookAppSecret(){
		
		if(isset($this->configuration ['facebook.app.secret']) && $this->configuration ['facebook.app.secret'] != null){
			$facebookAppSecret = $this->configuration ['facebook.app.secret'];
		}
		else{
			throw new Exception('facebook.app.secret must be filled');
		}
		
		return $facebookAppSecret;
		
	}
	
	/**
	 * Get Twitter consumer key
	 * @throws Exception
	 * @return unknown
	 */
	public function getTwitterConsumerKey(){
		
		if(isset($this->configuration ['twitter.consumer.key']) && $this->configuration ['twitter.consumer.key'] != null){
			$twitterConsumerKey = $this->configuration ['twitter.consumer.key'];
		}
		else{
			throw new Exception('twitter.consumer.key must be filled');
		}
		
		return $twitterConsumerKey;
		
	}
	
	/**
	 * Get Twitter consumer secret
	 * @throws Exception
	 * @return unknown
	 */
	public function getTwitterConsumerSecret(){
		
		if(isset($this->configuration ['twitter.consumer.secret']) && $this->configuration ['twitter.consumer.secret'] != null){
			$twitterConsumerSecret = $this->configuration ['twitter.consumer.secret'];
		}
		else{
			throw new Exception('twitter.consumer.secret must be filled');
		}
		
		return $twitterConsumerSecret;
		
	}
	
	public function getPresentationsPathAlias(){
		
		if(isset($this->configuration ['presentations.path.alias']) && $this->configuration ['presentations.path.alias'] != null){
			$presentationsPathAlias = $this->configuration ['presentations.path.alias'];
		}
		else{
			throw new Exception('presentations.path.alias must be filled');
		}
		
		return $presentationsPathAlias;
		
	}
	
	public function getPresentationsPathUsers(){
		
		if(isset($this->configuration ['presentations.path.users']) && $this->configuration ['presentations.path.users'] != null){
			$presentationsPathUsers = $this->configuration ['presentations.path.users'];
		}
		else{
			throw new Exception('presentations.path.users must be filled');
		}
		
		return $presentationsPathUsers;
		
	}
	
	public function getGoogleApiKey(){
		
		if(isset($this->configuration ['google.api.key']) && $this->configuration ['google.api.key'] != null){
			$googleApiKey = $this->configuration ['google.api.key'];
		}
		else{
			throw new Exception('google api key must be filled');
		}
		
		return $googleApiKey;
		
	}
	
}
