<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * filter control for dates range inputs
 * @author gabriel.guzman
 *
 */
class DateRangeFilter extends FilterControl{
    
    /**
     * Left input value
     * @var string (date formatted)
     */
    private $leftValue;
    
    /**
     * Right input value
     * @var string (date formatted)
     */
    private $rightValue;
	
	function __construct($fieldName, $label='', $fieldToSearch=''){
	    
	    parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setFieldToSearch($fieldToSearch);
	
	}
	
    public function drawHtml() {
		
		$html = '
				<table width="100%">
    				<tr>
        	    		<td width="25%">
        	    			' . parent::getLabel () . '
        	    		</td>';
		        
        	    $html .= '
        	    		<td align="left" colspan="2" width="75%">
        	    			<div class="date-range-container">
            	    			<input type="text"
            	    				   id="filter_date_left_' . parent::getFieldName () . '" 
            	    				   name="filter_date_left_' . parent::getFieldName () . '" 
            	    				   value="' . $this->leftValue . '" 
            	    				   class="input-date-range-validate datepicker"
            	    				   readonly="readonly" />
    	    				   
    	    				   <input type="text"
            	    				   id="filter_date_right_' . parent::getFieldName () . '" 
            	    				   name="filter_date_right_' . parent::getFieldName () . '" 
            	    				   value="' . $this->rightValue . '" 
            	    				   class="input-date-range-validate datepicker"
            	    				   readonly="readonly" />
	    				   </div>
	    				   
	    				   <script type="text/javascript">
                    			$(document).ready(function(){
                    
                    				/*
                    				$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker({
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					defaultDate: \''.$this->leftValue.'\'
                    				});
                    				
                    				$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker({
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					defaultDate: \''.$this->rightValue.'\'
                    				});
                    				*/
                    				
                    				var dates = $( \'#filter_date_left_'.parent::getFieldName().', #filter_date_right_'.parent::getFieldName().'\' ).datepicker({
                    					defaultDate: "+0d",
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					maxDate: null,
                            			onSelect: function( selectedDate ) {
                            				var option = this.id == "filter_date_left_'.parent::getFieldName().'" ? "minDate" : "maxDate",
                            					instance = $( this ).data( "datepicker" ),
                            					date = $.datepicker.parseDate(
                            						instance.settings.dateFormat ||
                            						$.datepicker._defaults.dateFormat,
                            						selectedDate, instance.settings );
                            				dates.not( this ).datepicker( "option", option, date );
                            				
                            				otherDate = dates.not( this ).datepicker( "getDate" );
                            				
                            				if(otherDate == \'\' || otherDate == null){
                            					otherDate = dates.not( this ).datepicker( "setDate", date );
                            				}
                            			} 
                            		});
                            		
                            		//Default Values
                            		$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker("setDate", \''.$this->leftValue.'\');
                            		
                            		$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker("setDate", \''.$this->rightValue.'\');
                            		
                            		';
        	    
        	                        //Range validations
            	                    if($this->leftValue != ''){
            	                        $html .= '	$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker("option", "minDate", \''.$this->leftValue.'\');';        	                        
            	                    }
        	                    
            	                    if($this->rightValue != ''){
            	                        $html .= '$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker("option", "maxDate", \''.$this->rightValue.'\');';
            	                    }
                                    else{
                                        $html .= '$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker();';
                                    }
                            		
                            		$html .= '
                    				
                    			});
                    		</script>
	    				   
        	    		</td>
    	    		</tr>
	    		</table>
	    		';
	    
	    return $html;
	
	}
	
	public function getCriteriaQuery(){
	    
	    $criteriaQuery = '';
	    
	    if($this->leftValue != '' && $this->rightValue != ''){
	        
            $leftValue = str_replace('/', '-', $this->leftValue);
	        $rightValue =  str_replace('/', '-', $this->rightValue);
	        
			if (parent::getFieldToSearch () != '') {
				$fieldToSearch = parent::getFieldToSearch ();
			} else {
				$fieldToSearch = parent::getFieldName ();
			}
	        
	        $criteriaQuery .= '
	        					AND ( ' . $fieldToSearch . ' between \'' . $leftValue . '\' and \'' . $rightValue . '\' )
        					';
	        
	    }
	    
	    return $criteriaQuery;
	    
	}
	
	/**
	 * @return the $leftValue
	 */
	public function getLeftValue() {
		return $this->leftValue;
	}

	/**
	 * @param string $leftValue
	 */
	public function setLeftValue($leftValue) {
		$this->leftValue = $leftValue;
	}

	/**
	 * @return the $rightValue
	 */
	public function getRightValue() {
		return $this->rightValue;
	}

	/**
	 * @param string $rightValue
	 */
	public function setRightValue($rightValue) {
		$this->rightValue = $rightValue;
	}

}

?>