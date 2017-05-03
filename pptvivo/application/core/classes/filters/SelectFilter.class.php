<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/SelectFilterType.class.php';

/**
 * Filter control for select values (combo box)
 * @author gabriel.guzman
 *
 */
class SelectFilter extends FilterControl {
    
    /**
     * List of values
     * @var array
     */
    private $values;
   
    /**
     * Is multiple select?
     * @var boolean
     */
    private $isMultiple;
    
    /**
     * What happens when a value is chosen?
     * @var string
     */
    private $onchangeFunction;
    
    /**
     * If the 'select an option' value must be shown in the combo box
     * @var boolean
     */
    private $showDefaultEmptyValue;
    
    function __construct($fieldName, $label='', $fieldToSearch='', $isMultiple, $onchangeFunction = '', $showDefaultEmptyValue = false, $isMandatory = false) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$filterTypes = new SelectFilterType();
		
		parent::setFilterType($filterTypes);
		
		parent::setFieldToSearch($fieldToSearch);
		
		$this->isMultiple = $isMultiple;
		
		$this->onchangeFunction = $onchangeFunction;
		
		$this->showDefaultEmptyValue = $showDefaultEmptyValue;
		
		parent::setIsMandatory($isMandatory);
	
	}
	
	public function drawHtml() {
		
		$html = '
				<table width="100%">
    				<tr>
        	    		<td width="25%" style="vertical-align: top;">
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
		
		        if($this->isMultiple){
		            $isMultiple = 'multiple="multiple"';
		            $size = 'size="4"';
		            $name = 'filter_' . parent::getFieldName () . '[]';
		        }
		        else{
		            $isMultiple = '';
		            $size = '';
		            $name = 'filter_' . parent::getFieldName ();
		        }
		        
		        if(parent::getIsMandatory()){
		            $mandatoryClass = 'mandatory-input';
		        }
		        else{
		            $mandatoryClass = '';
		        }
        	    		
        	    $html .= '
        	    		<td align="left" width="75%" style="vertical-align: top;">
        	    			<select id="filter_' . parent::getFieldName () . '" 
        	    				   name="'.$name.'" 
        	    				   class="'.$mandatoryClass.'" 
        	    				   '.$isMultiple.'
        	    				   '.$size.'
        	    				   onchange="'.$this->onchangeFunction.'"
        	    				   >';
        	    
                    	    if($this->showDefaultEmptyValue && count($this->values) > 0){
        	                    $html .= '<option value="">'.$_SESSION['s_message']['select_an_option'].'</option>';
        	                }
        	    
        	                $selectedValues = parent::getSelectedValue();
        	    
            	            foreach ($this->values as $valueId => $value){
            	                
            	                if(isset($selectedValues) && is_array($selectedValues)){
            	                
                	                if(in_array($valueId,parent::getSelectedValue())){            	                
                	                    $selected = 'selected="selected"';
                	                }
                	                else{
                	                    $selected = '';
                	                }
            	                }
            	                else{
            	                    if($selectedValues != ''){
            	                        if($valueId == $selectedValues){
            	                            $selected = 'selected="selected"';
            	                        }
            	                        else{
            	                            $selected = '';
            	                        }
            	                    }
            	                    else{
                                        $selected = '';
            	                    }
                                }
            	                
            	                $html .= '<option '.$selected.' value="'.$valueId.'">'.$value.'</option>';
            	                
            	            }        
        	    
        	    $html .= '
	    				   	</select>
        	    		</td>
    	    		</tr>
	    		</table>
	    		';
	    
	    return $html;
	    
	}
	
	public function getCriteriaQuery(){
	    
	    $criteriaQuery = '';
	    
	    $selectedValues = parent::getSelectedValue();
	    
	    /**
         * @todo: hacer un switch con los tipos de filtros: Fase 2
         */
        
        if(parent::getFieldToSearch() != ''){	        
            $fieldToSearch = parent::getFieldToSearch(); 
        }
        else{
            $fieldToSearch = parent::getFieldName();
        }
	    
	    if(is_array($selectedValues) && count($selectedValues) > 0 ){
	        
	        $criteriaQuery .= '
	        					AND '.$fieldToSearch.' in (';

	            foreach ( parent::getSelectedValue() as $valueId => $value){
                    $criteriaQuery .= $value.', ';
                }
                					 
            $criteriaQuery .= '
            					)
                	        ';
	    }
	    elseif (!is_array($selectedValues) && $selectedValues != ''){
	        
	        $criteriaQuery .= '
	        					AND '.$fieldToSearch.' = '.parent::getSelectedValue().'
                	        ';
	        
	    }
	    
	    return $criteriaQuery;
	    
	}
	
	/**
	 * @return the $values
	 */
	public function getValues() {
		return $this->values;
	}

	/**
	 * @param array $values
	 */
	public function setValues($values) {
		$this->values = $values;
	}
	
	public function addValue($id, $value){
	    $this->values[$id] = $value;
	}

}