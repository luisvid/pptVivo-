<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/Master.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/SingleMaster.view.php';
/**
 * 
 * Factory to split between diferent Master Views.
 * @author Gabriel Guzman
 *
 */

class MasterFactory {
	
	static public function getMaster () {
		
		$masterObject = new MasterView();		
		
		return $masterObject;
	}
	
	static public function getSingleMaster () {
		
		$masterObject = new SingleMasterView();		
		
		return $masterObject;
	}
	
}