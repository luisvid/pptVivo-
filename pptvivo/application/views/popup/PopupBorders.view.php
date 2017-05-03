<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 * @description Add borders for popup
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/popup/PopupDecorator.class.php';

class PopupBorders extends PopupDecorator {
	
	private $output;
	
	/**
	 * 
	 * Create scroll bars
	 * @param Popup $popup
	 */
	public function __construct(&$popup) {
		
		$this->popup = $popup;
		
		$this->output = '';
		
	}
	
	public function draw() {
		
		$this->output .= $this->popup->draw ();
		
		return $this->output;
	}

}