<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 * @description Create a simple HTML canvas with title and body.
 */

class PopupBasic extends Popup {
	
	private $html;
	
	/**
	 * 
	 * Constructor
	 * @param string $html
	 */
	public function __construct($html, $title) {
		
		$this->html = $html;
		
		$this->title = $title;
	
	}
	
	/**
	 * @see Popup::draw()
	 */
	public function draw() {
		
		$output = '<div class="positionNone popup ">
						<div class="basic-popup">';
		
		if (isset ( $this->title ) && $this->title != '') {
			$output .= '<div class="borderPopupActive top">';
				$output .= $this->getTitle ();
			$output .= '</div>';
		}
		$output .= '<div class="popup-content">';
			$output .= $this->html;
		$output .= '</div>';
				
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}

}