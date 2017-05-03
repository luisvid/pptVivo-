<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilterType.class.php';

/**
 * Filter control for numeric values
 * @author gabriel.guzman
 *
 */
class NumberFilter extends FilterControl {
	
	/**
	 * Field length
	 * @var int
	 */
	private $length;
	
	/**
	 * If filter supports decimal values
	 * @var boolean
	 */
	protected $decimal;
	
	function __construct($fieldName, $label = '', $length = null, $fieldToSearch) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$filterTypes = new NumberFilterType ();
		
		parent::setFilterType ( $filterTypes );
		
		$this->length = $length;
		
		parent::setFieldToSearch ( $fieldToSearch );
		
		$this->decimal = true;
	
	}
	
	public function drawHtml() {
		
		$html = '
	    		<table width="100%">
    				<tr>
        	    		<td width="25%">
        	    			' . parent::getLabel () . '
        	    		</td>';
		/*
        	    $html .= '
        	    		<td align="left" width="35%">
        	    			<select name="'.parent::getFieldName ().'_filter">';
        		
        		            foreach (parent::getFilterType()->getValues() as $filterTypeId => $filterType){
        		                
        		                if(parent::getSelectedValue() == $filterTypeId){
        		                    $selected = 'selected="selected"';
        		                }
        		                else{
        		                    $selected = '';
        		                }
        		                
        		                $html .= '<option '.$selected.' value="'.$filterTypeId.'">'.$_SESSION['s_message'][$filterType].'</option>';
        		                
        		            }
        	    			
        	    $html .= '
        	    			</select>
        	    		</td>';
        	    */
		
		$htmlClass = "input-number-validate";
		
		if (! $this->decimal)
			$htmlClass = "input-naturalNumber-validate";
		
		$html .= '
        	    		<td align="left" width="75%">
        	    			<input type="text" 
        	    				   id="filter_' . parent::getFieldName () . '" 
        	    				   name="filter_' . parent::getFieldName () . '" 
        	    				   value="' . parent::getSelectedValue () . '" 
        	    				   maxlength="' . $this->getLength () . '" 
        	    				   class="' . $htmlClass . '" />
        	    		</td>
        	    	</tr>
        	    </table>
	    		';
		
		return $html;
	
	}
	
	/**
	 * Criteria query for web service
	 * @author gabriel.guzman
	 * @return string
	 */
	public function getCriteriaQuery() {
		
		$criteriaQuery = '';
		
		if (parent::getSelectedValue () != '') {
			
			/**
			 * @todo: hacer un switch con los tipos de filtros: Fase 2
			 */
			if (parent::getFieldToSearch () != '') {
				$fieldToSearch = parent::getFieldToSearch ();
			} else {
				$fieldToSearch = parent::getFieldName ();
			}
			
			$selectedValue = parent::getSelectedValue ();
			
			if (! $this->decimal)
				$selectedValue = floor ( parent::getSelectedValue () );
			
			$criteriaQuery .= '
	        				AND ' . $fieldToSearch . ' = ' . $selectedValue . '
        					';
		
		}
		
		return $criteriaQuery;
	
	}
	
	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}
	
	/**
	 * @param int $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}
	/**
	 * @return the $decimal
	 */
	public function getDecimal() {
		return $this->decimal;
	}
	
	/**
	 * @param boolean $decimal
	 */
	public function setDecimal($decimal) {
		$this->decimal = $decimal;
	}

}