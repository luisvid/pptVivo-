<?php

/** 
 * @author Gabriel Guzman
 * Mail Helper functions
 * 
 */
class MailHelper {
	
	private $logger;
	
	function __construct() {
	
		$this->logger = $_SESSION ['logger'];
		
	}
	
	/**
	 * Send an e-mail with optional attachments
	 * @param array $mailTo
	 * @param string $mailFrom
	 * @param string $nameFrom
	 * @param string $attachments
	 * @param string $template
	 * @param array $vars
	 * @return boolean
	 */
	public function sendMail($mailTo, $mailFrom, $nameFrom, $attachments = null, $template = null, $vars = array()) {
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$mailContent = '';
		
		//Load attachments
		if (isset ( $attachments ) && $attachments != null) {
			$fileSize = filesize ( $attachments );
			$handle = fopen ( $attachments, "r" );
			$content = fread ( $handle, $fileSize );
			fclose ( $handle );
			$mailContent = chunk_split ( base64_encode ( $content ) );
		}
		
		//uid for mail headers
		$uid = md5 ( uniqid ( time () ) );
		
		//Load and draw mail template
		$mailTemplate = $this->getMailTemplate($template);
		$message = $this->replaceTemplateVars($vars, $mailTemplate['body']);
		$subject = $mailTemplate['subject'];
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/mailTemplate.view.php';		
		$messageBody = mailTemplate::render($subject, $message);
		
		//Mail headers
		$header = "From: " . $nameFrom . " <" . $mailFrom . ">\r\n";
		$header .= "Reply-To: " . $mailFrom . "\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--" . $uid . "\r\n";
		$header .= "Content-type:text/html; charset=utf-8\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $messageBody . "\r\n\r\n";
		$header .= "--" . $uid . "\r\n";
		
		//Attachments inclusion
		if($attachments != null){		
			$header .= "Content-Type: application/octet-stream; name=\"" . $attachments . "\"\r\n";
			$header .= "Content-Transfer-Encoding: base64\r\n";
			$header .= "Content-Disposition: attachment; filename=\"" . $attachments . "\"\r\n\r\n";
		}
		
		$header .= $mailContent . "\r\n\r\n";
		$header .= "--" . $uid . "--";
		
		//Receivers
		$toEmails = '';
		foreach ($mailTo as $key => $mail){
			if($key == (count($mailTo)-1)){
				$toEmails .= $mail;
			}
			else{
				$toEmails .= $mail . ',';
			} 
		}
		
		//Sending
		if (mail ( $toEmails, $subject, $message, $header )) {
			$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return true;
		} else {
			$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return false;
		}
	
	}
	
	/**
	 * Loads a mail template from database
	 * @param string $template
	 * @return array
	 */
	protected function getMailTemplate($template){
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $template ) || $template == null) {
			self::$logger->error ( 'template parameter expected' );
			throw new InvalidArgumentException ( 'template parameter expected' );
		}
		
		$query = Util::getMailTemplate($template, $_SESSION ['s_languageId']);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$result = $connectionManager->select ( $query );
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result[0];
		
	}
	
	/**
	 * Replaces a template from database with predefined variables
	 * @param array $vars
	 * @param string $target
	 * @throws InvalidArgumentException
	 * @return string
	 */
	protected function replaceTemplateVars($vars, $target){
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if (! isset ( $target ) || $target == null) {
			self::$logger->error ( 'target parameter expected' );
			throw new InvalidArgumentException ( 'target parameter expected' );
		}
		
		$text = vsprintf($target, $vars);
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $text;
		
	}

}