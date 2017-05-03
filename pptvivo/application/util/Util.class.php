<?php
/**
 * Common methods and helpers
 * @package util
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 13/03/2012
 * UPDATE LIST
 * * UPDATE: 
 */

require_once 'UtilMysql.class.php';
require_once 'UtilOracle.class.php';
require_once 'UtilPostgreSQL.class.php';

class Util {
	
	const DB_ORACLE = 'oracle';
	const DB_MYSQL = 'mysql';
	const DB_SQLSERVER = 'sqlserver';
	const DB_POSTGRESQL = 'postgresql';
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	/**
	 * Assign the PFW Connection ID to a session variable s_dbConnectionId
	 *
	 * @param String $connectionName Connection name to determinate the connection id.
	 *
	 * @return Integer Connection identity number.
	 */
	public static function getConnectionType() {
		
		self::initializeSession ();
		
		if (! isset ( $_SESSION ['s_dbConnectionType'] ) || $_SESSION ['s_dbConnectionType'] == '') {
			
			$_SESSION ['s_dbConnectionType'] = 'mysql';
			
			self::$logger->debug ( 'DBConnectionType loaded:  ' . $_SESSION ['s_dbConnectionType'] );
		
		}
		
		return $_SESSION ['s_dbConnectionType'];
	}
	
	/**
	 * Get SQL Query for literals.
	 * 
	 * @param int $languageId if false, use session language
	 * this brings one language literals and if not defined de default values
	 */
	public static function getLiteralsQuery($languageId = false) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLiteralsQuery ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLiteralsQuery ( $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLiteralsQuery ( $languageId );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to get all modules configuration
	 * @return String  SELECT statement to get all modules information
	 */
	public static function getContentsQuery($languageIso, $contentURL, $error) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
		}
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all languages from database.
	 */
	public static function getLanguages() {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLanguages ();
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLanguages ();
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLanguages ();
				break;
		}
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all params from database.
	 */
	public static function getParameters() {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getParameters ();
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getParameters ();
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getParameters ();
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to get one content's page in the specific language
	 * @return String  SELECT tatement to get one content's page in the specific language
	 */
	public static function getContentsLanguageResource($contentId, $languageId) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getContentsLanguageResource ( $contentId, $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getContentsLanguageResource ( $contentId, $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getContentsLanguageResource ( $contentId, $languageId );
				break;
		}
		return $query;
	}
	
	public static function getLanguageUrlmapping($url) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLanguageUrlmapping ( $url );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLanguageUrlmapping ( $url );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLanguageUrlmapping ( $url );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * Return SELECT statement to specific content with concrete Lang and SideId.
	 * @param $contentArray: Array with content key's required.
	 * @param $siteId: Site Identification
	 * @param $lanId: Language Identification
	 */
	public static function getDefaultContentsInfo($contentArray, $langId) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getDefaultContentsInfo ( $contentArray, $langId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getDefaultContentsInfo ( $contentArray, $langId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getDefaultContentsInfo ( $contentArray, $langId );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to specific content with concrete Lang and SideId.
	 * @param int $starLevel start level for the menu
	 * @param int $endLevel: last level for the menu
	 */
	public static function getMenuContents($languageId, $userTypeId, $startLevel, $endLevel = null) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT content information from content id
	 * @param int $idSite site to search in
	 * @param int $idContent: content to search in
	 * @param int $languageIso: language to show
	 */
	public static function getCrumb($idContent, $languageIso) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getCrumb ( $idContent, $languageIso );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getCrumb ( $idContent, $languageIso );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getCrumb ( $idContent, $languageIso );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * 
	 * Checks if the literals changed
	 * @param int $languageId
	 */
	public static function getLiteralChanges($languageId) {
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLiteralChanges ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLiteralChanges ( $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLiteralChanges ( $languageId );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * 
	 * Remove the mark of literals changed for a specific language
	 * @param int $languageId
	 */
	public static function removeLiteralChangesMark($languageId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::removeLiteralChangesMark ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::removeLiteralChangesMark ( $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::removeLiteralChangesMark ( $languageId );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * this function is responsible for getting provided literal, if not found, return the same literal
	 * betwen doublecolons, if default given return default.
	 * @param literalS string defines the name of the literal
	 * @param default  string defines the default literal if no literal found
	 * @return String
	 */
	public static function getLiteral($literal, $default = '') {
		
		if (isset ( $_SESSION ['s_message'] [$literal] )) {
			$literal_to_return = $_SESSION ['s_message'] [$literal];
		} else {
			$literal_to_return = $default != '' ? $default : '[' . $literal . ']';
		}
		
		return $literal_to_return;
	}
	
	/**
	 * 
	 * Devuelve la URL actual.
	 */
	public function getCurrenProtocol() {
		$pageURL = 'http';
		if (isset ( $_SERVER ["HTTPS"] ) && $_SERVER ["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER ["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"]; //.$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER ["SERVER_NAME"]; //.$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	/**
	 * 
	 * Get the query for content check permissions.
	 * @param unknown_type $userId
	 * @param unknown_type $contentId
	 * @param unknown_type $siteId
	 */
	public static function getCheckPermissions($userTypeId, $menuId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getCheckPermissions ( $userTypeId, $menuId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getCheckPermissions ( $userTypeId, $menuId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getCheckPermissions ( $userTypeId, $menuId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * 
	 * Check if current content have a child with content and return his url in current language.
	 * @param unknown_type $userId
	 * @param unknown_type $contentId
	 * @param unknown_type $siteId
	 */
	public static function getUrlChild($content, $language = "") {
		
		self::$logger->debug ( __METHOD__ . ' start' );
		
		$language = $language == '' ? $_SESSION ['s_languageIso'] : $language;
		
		$query = self::getChild ( $content, $language );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$child = $connectionManager->select ( $query );
		
		//SI EL CONTENIDO NO TIENE CONTENIDOS CHILD, RETURN SU PROPIA URL.
		if (isset ( $child ) && count ( $child ) <= 0) {
			$return_url = false;
		} else {
			$return_url = $child [0] ['content_url'];
		}
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $return_url;
	}
	
	/**
	 * 
	 * Get the query for first child of content
	 * @param unknown_type $content
	 * @param unknown_type $language
	 * @return string
	 */
	public static function getChild($contentId, $languageId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getChild ( $contentId, $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getChild ( $contentId, $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getChild ( $contentId, $languageId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * This method performs an automatic mapping of any class using data from array
	 * checks if the object attributes exists as index of the array and invokes the setter to assign the value.
	 * @author gabriel.guzman
	 * @param object $entityObject
	 * @param array $entityData
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public static function autoMapEntity(&$entityObject, $entityData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		if (is_array ( $entityData ) && count ( $entityData ) > 0) {
			
			if (is_object ( $entityObject )) {
				
				$entityType = get_class ( $entityObject );
				
				$reflectionClass = new ReflectionClass ( $entityType );
				
				$entityProperties = $reflectionClass->getDefaultProperties ();
				
				if (is_array ( $entityProperties ) && count ( $entityProperties ) > 0) {
					
					foreach ( $entityProperties as $property => $propertyValue ) {
						
						if (isset ( $entityData [$property] ) && $entityData [$property] != '') {
							
							$valueForSetter = ucfirst ( $property );
							
							$reflectionMethod = new ReflectionMethod ( $entityType, "set" . $valueForSetter );
							
							$invokeResult = $reflectionMethod->invoke ( $entityObject, $entityData [$property] );
							
							self::$logger->debug ( __METHOD__ . ' end' );
						
						}
					}
				} else {
					self::$logger->error ( "The object passed doesn't have attributes" );
					throw new Exception ( "The object passed doesn't have attributes" );
				}
			} else {
				self::$logger->error ( "Object expected" );
				throw new InvalidArgumentException ( "Object expected" );
			}
		} else {
			self::$logger->error ( "The entity array must content data" );
			throw new Exception ( "The entity array must content data" );
		}
	
	}
	
	/**
	 * Returns a pager
	 * @author Gabriel Guzman
	 * @param int $numrows
	 * @param int $begin
	 * @param int $page
	 * @param int $count
	 * @return string
	 */
	public static function getPager($numrows, $begin, $page, $count) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$pager = '';
		
		if ($count < $numrows) {
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/PagerManager.class.php';
			$pagerManager = PagerManager::getInstance ();
			$pager = $pagerManager->setPager ( $count, $numrows, $page );
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $pager;
	
	}
	
	/**
	 * Cleans a string
	 * @param string $string
	 * @return string
	 */
	public static function cleanString($string) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$string = strtolower ( trim ( $string ) );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $string;
	
	}
	
	public static function getAssignedDate($refDate) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$now = new DateTime ( date ( "Y-m-d" ) );
		$ref = new DateTime ( $refDate );
		$diff = $now->diff ( $ref );
		
		$years = $diff->y;
		$months = $diff->m;
		$days = $diff->d;
		
		$html = '';
		
		if ($years == 0 && $months == 0 && $days == 0) {
			$html .= 'Hoy';
		} else {
			$html .= 'Hace: ';
			
			if (isset ( $years ) && $years != 0) {
				$html .= $years . ' ' . ($years == 1 ? 'año ' : 'años ');
			}
			if (isset ( $months ) && $months != 0) {
				$html .= $months . ' ' . ($months == 1 ? 'mes ' : 'meses ');
			}
			if (isset ( $days ) && $days != 0) {
				$html .= $days . ' ' . ($days == 1 ? 'día' : 'días');
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $html;
	
	}
	
	/**
	 * Gets a template for e-mail
	 * @param string $template
	 * @param int $languageId
	 * @return string
	 */
	public static function getMailTemplate($template, $languageId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getMailTemplate ( $template, $languageId );
				break;
			case self::DB_ORACLE :
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				break;
		}
		
		return $query;
	}
	
	public static function getContentUrl($contentArray, $langId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = self::getDefaultContentsInfo ( $contentArray, $langId );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->select ( $query );
		
		$url = '';
		
		if (isset ( $result ) && count ( $result ) > 0) {
			$url = $result [0] ['url'];
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $url;
	
	}
	
	/**
	 * Parse and load presentation path information
	 * @param Presentation $presentation
	 */
	public static function getPresentationPathData($presentation) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$presentationPathData = array();
		
		$configurator = Configurator::getInstance ();
		$presentationsPathBase = $configurator->getPresentationsPath ();
		$presentationsPathUsers = $configurator->getPresentationsPathUsers();
		$outputFormat = $configurator->getPresentationsOutputFormat ();
		
		$presentationPathData['presentationName'] = substr ( $presentation->getFilename (), 0, strrpos ( $presentation->getFilename (), '.' ) );
		$presentationPathData['presentationsPath'] = $presentationsPathBase . $_SESSION ['loggedUser']->getUserlogin () . '/' . $presentationPathData['presentationName'] . '/';
		//$presentationPathData['fileExtension'] = substr(strrchr($presentation->getFilename(), '.'), 1 );
		$presentationPathData['previewFile'] = $presentationPathData['presentationName'] . '-small-0.' . $outputFormat;
		$presentationPathData['previewSrc'] = $presentationPathData['presentationsPath'] . $presentationPathData['previewFile'];
		
		$presentationPathData['previewImgPath'] = '/files/' . $presentationsPathUsers . $_SESSION ['loggedUser']->getUserlogin () . '/' . $presentationPathData['presentationName'] . '/' . $presentationPathData['previewFile'];
		
		$presentationPathData['previewImgPath'] = str_replace('\\', '/', $presentationPathData['previewImgPath']);
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $presentationPathData;
		
	}
	
	public static function getShortenUrl($longUrl){
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$configurator = Configurator::getInstance ();
		
		$apiKey = $configurator->getGoogleApiKey();
		
		$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
		$jsonData = json_encode($postData);
		
		$curlObj = curl_init();
		
		//curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
		
		$response = curl_exec($curlObj);
		
		//change the response json string to object
		$json = json_decode($response);
		
		curl_close($curlObj);
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		if(!isset($json->id) || $json->id == null || $json->id == ''){
			return $longUrl;
		}
		else{
			return $json->id;
		}
		
	}

	/**
	 * Get the domain name from an url
	 * @param string $url
	 * @return string
	 */
	public static function getDomain($url) {
		$nowww = preg_replace('/www./','',$url);
		$domain = parse_url($nowww);
		if(!empty($domain["path"]))	{
			return $domain["path"];
		} else {
			return false;
		}
	}
	
}
