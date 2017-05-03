<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/popup/PopupBasic.view.php';

abstract class Popup extends AjaxMessageBox{
	
	protected $title;
		
	/**
	 * 
	 * Draw the popup
	 */
	public abstract function draw();
	
	/**
	 * 
	 * Popup title
	 * @return string popup title
	 */
	protected function getTitle(){
		return $this->title;
	}	

}