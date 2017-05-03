<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/SelectFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/SelectionPopupFilterGeneric.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/BooleanFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/DateRangeFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/Order.class.php';

/**
 * This class contains the entire form to filter any selection popup
 * @author gabriel.guzman
 *
 */
class FilterGroup {
	
	/**
	 * List of filters
	 * @var array
	 */
	private $filtersList;
	
	/**
	 * Form action
	 * @var string
	 */
	private $formUrlAction;
	
	/**
	 * Form id
	 * @var string
	 */
	private $formId;
	
	/**
	 * Action manager action which will response the submit
	 * @var string
	 */
	private $actionManagerAction;
	
	/**
	 * HTML element id where the response will be shown
	 * @var string
	 */
	private $returnElementId;
	
	private $columns;
	
	function __construct($formId, $formUrlAction, $actionManagerAction, $returnElementId, $columns = 2) {
		
		$this->formId = $formId;
		
		$this->formUrlAction = $formUrlAction;
		
		$this->actionManagerAction = $actionManagerAction;
		
		$this->returnElementId = $returnElementId;
		
		$this->columns = $columns;
	
	}
	
	public function drawForm() {
		
		$html = '<div class="bt_filtro" onclick="showFilters(this);">' . $_SESSION ['s_message'] ['filters'] . '</div>
        		 
        		 <div class="popup-filters" style="">
        		 
        		 <br />
        		 	
        		 	<fieldset>
        		 	
        		 	<form 
        					id="frm_' . $this->formId . '" 
        					name="frm_' . $this->formId . '" 
        					method="post" 
        					action="' . $this->formUrlAction . '"
        					enctype="multipart/form-data"
        					class="filter_group_form">
        					
    	    			<div style="width: 100%;">';
		
		foreach ( $this->filtersList as $filter ) {
			
			$html .= '	<div id="frm_' . $this->formId . '_filter_container_' . $filter->getFieldName () . '" class="filter_cell">
                        				' . $filter->draw () . '
                    			</div>
                    		  	';
		
		}
		
		$html .= '
        	    			<div style="clear: both;">
        	    				
        	    				<div style="float: left;">
        	    					';
		
		//Selection popup filter
		if ($this->actionManagerAction != '') {
			
			$clickFunction = 'reloadSelectionListTable(\'' . $this->formUrlAction . '\', ' . $this->actionManagerAction . ', \'frm_' . $this->formId . '\', \'' . $this->returnElementId . '\', \'reloading_container_' . $this->formId . '\');';
			
			$html .= '
        	                        <input
        	                        	style="float: left; margin-right: 2px;" 
        	    						type="button"
        	    						class="form_bt" 
        	    						value="' . $_SESSION ['s_message'] ['filter_apply'] . '"
        	    						onclick="' . $clickFunction . '" />';
		} //Built-in-page filter
		else {
			
			$clickFunction = 'sendFilters(\'frm_' . $this->formId . '\');';
			
			$html .= '
        	                        <input 
        	                        	style="float: left; margin-right: 2px;"
        	    						type="button"
        	    						id="filterSearch"
        	    						class="form_bt"
        	    						onclick="' . $clickFunction . '" 
        	    						value="' . $_SESSION ['s_message'] ['filter_apply'] . '"
        	    					/>';
		}
		
		$html .= '
        	    					<input type="button"
        	    						style="float: left; margin-right: 2px;"
        	    						class="form_bt"
        	    						id="filterClear"
        	    						value="' . $_SESSION ['s_message'] ['clear'] . '"
        	    						onclick="resetForm(\'frm_' . $this->formId . '\');" />
        	    					
        	    					<div style="float: left;" id="reloading_container_' . $this->formId . '"></div>
    	    					
    	    					</div>
        	    			
        	    			</div>
        	    		
        	    		</div>
        	    		
        	    		<input type="hidden" name="page" id="page" value=""/>
        	    		
        	    		<!-- Hack to avoid double sending of the form when there is only one input text -->
        	    		<input type="text" style="display: none;" name="dummy" id="dummy" value=""/>
        	    		
    	    		</form>
    	    		
    	    		<script type="text/javascript">
    	    		
    	    			$(\'#frm_' . $this->formId . ':last input[type="text"]\').keydown(function(event){
    	    			
    	    				keynum = noNumbers(event);
                        	
                        	if(keynum == "13"){
                        		' . $clickFunction . '
                        	}
                        	
                        });
    	    		
    	    		</script>
    	    		
    	    		</fieldset>
    	    	</div>';
		
		return $html;
	
	}
	
	/**
	 * @return the $filtersList
	 */
	public function getFiltersList() {
		return $this->filtersList;
	}
	
	/**
	 * @param array $filtersList
	 */
	public function setFiltersList($filtersList) {
		$this->filtersList = $filtersList;
	}
	
	public function addFilter($filter) {
		$this->filtersList [] = $filter;
	}
	
	/**
	 * @return the $formId
	 */
	public function getFormId() {
		return $this->formId;
	}
	
	/**
	 * @param string $formId
	 */
	public function setFormId($formId) {
		$this->formId = $formId;
	}
	
	/**
	 * @return the $formUrlAction
	 */
	public function getFormUrlAction() {
		return $this->formUrlAction;
	}
	
	/**
	 * @param string $formUrlAction
	 */
	public function setFormUrlAction($formUrlAction) {
		$this->formUrlAction = $formUrlAction;
	}
	
	/**
	 * @return the $actionManagerAction
	 */
	public function getActionManagerAction() {
		return $this->actionManagerAction;
	}
	
	/**
	 * @param string $actionManagerAction
	 */
	public function setActionManagerAction($actionManagerAction) {
		$this->actionManagerAction = $actionManagerAction;
	}

}
?>