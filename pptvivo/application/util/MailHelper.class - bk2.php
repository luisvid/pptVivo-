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
	 *Sends a test email, only for test pouposes
	 */
	function sendTestMail () {
		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		require_once 'PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//Server: smtp.postmarkapp.com
		//Ports: 25, 2525, or 587
		//Username/Password: 209abebf-ce04-4c74-a2eb-fa70fe3035ca
		//Authentication: Plain text, CRAM-MD5, or TLS
		
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.postmarkapp.com';  					// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = '209abebf-ce04-4c74-a2eb-fa70fe3035ca';                 // SMTP username
		$mail->Password = '209abebf-ce04-4c74-a2eb-fa70fe3035ca';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('hello@pptvivo.com', 'Hello');
		$mail->addAddress('luisvid@gmail.com', 'Luis Videla');     // Add a recipient
		$mail->addAddress('luis.videla@outlook.com');               // Name is optional
		$mail->addReplyTo('pptvivo@gmail.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Here is the subject';
		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}

		
		$this->logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
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
		
		$this->sendTestMail();

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
		
		//fix: multiple-or-malformed-newlines-found-in-additional-header
		//(1) removed all the multi-part stuff from the headers into $message. 
		//(2) removed all the "\r\n" stuff and added $eol = PHP_EOL; to the code.

		$eol = PHP_EOL;

		// Basic headers
		$header = "From: ".$nameFrom." <".$mailFrom.">".$eol;
		$header .= "Reply-To: ".$mailFrom.$eol;
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";

		// Put everything else in $message

		//$header .= "This is a multi-part message in MIME format.\r\n";
		//$header .= "--" . $uid . "\r\n";
		//$header .= "Content-type:text/html; charset=utf-8\r\n";
		//$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		//$header .= $messageBody . "\r\n\r\n";
		//$header .= "--" . $uid . "\r\n";

		$message .= "This is a multi-part message in MIME format.".$eol;
		$message .= "--" . $uid.$eol;
		$message .= "Content-type:text/html; charset=utf-8".$eol;
		$message .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
		$message .= $messageBody.$eol;
		$message .= "--" . $uid.$eol;

		
		//Attachments inclusion
		if($attachments != null){		
			//$header .= "Content-Type: application/octet-stream; name=\"" . $attachments . "\"\r\n";
			//$header .= "Content-Transfer-Encoding: base64\r\n";
			//$header .= "Content-Disposition: attachment; filename=\"" . $attachments . "\"\r\n\r\n";

			$message .= "Content-Type: application/pdf; name=\"".$attachments."\"".$eol;
			$message .= "Content-Transfer-Encoding: base64".$eol;
			$message .= "Content-Disposition: attachment; filename=\"".$attachments."\"".$eol;
		}
		
		//$header .= $mailContent . "\r\n\r\n";
		//$header .= "--" . $uid . "--";
		
		$message .= $mailContent.$eol;
		$message .= "--".$uid."--";
		
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