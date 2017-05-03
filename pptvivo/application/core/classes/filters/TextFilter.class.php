<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilterType.class.php';

/**
 * Filter control for text values
 * @author gabriel.guzman
 *
 */
class TextFilter extends FilterControl {
	
	private $length;
	
	function __construct($fieldName, $label = '', $length = null, $fieldToSearch = '') {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$filterTypes = new TextFilterType ();
		
		parent::setFilterType ( $filterTypes );
		
		$this->length = $length;
		
		parent::setFieldToSearch ( $fieldToSearch );
	
	}
	
	public function drawHtml() {
		
		$html = '
				<table width="100%">
    				<tr>
        	    		<td width="25%">
        	    			' . parent::getLabel () . '
        	    		</td>';
		$html .= '
        	    		<td align="left" width="75%">
        	    			<input type="text" 
        	    				   id="filter_' . parent::getFieldName () . '" 
        	    				   name="filter_' . parent::getFieldName () . '" 
        	    				   value="' . parent::getSelectedValue () . '" 
        	    				   maxlength="' . $this->getLength () . '" 
        	    				   class="input-text-validate" />
        	    		</td>
    	    		</tr>
	    		</table>
	    		';
		
		return $html;
	
	}
	
	/**
	 * Criteria query for Web service
	 * @author gabriel.guzman
	 * @return string
	 */
	public function getCriteriaQuery() {
		
		$criteriaQuery = '';
		
		if (parent::getSelectedValue () != '') {
			
			if (parent::getFieldToSearch () != '') {
				$fieldToSearch = parent::getFieldToSearch ();
			} else {
				$fieldToSearch = parent::getFieldName ();
			}
			
			$rawTextToSearch = htmlspecialchars ( parent::getSelectedValue (), ENT_NOQUOTES, "UTF-8" );
			$textToSearch = str_replace ( "&", "&amp;", $rawTextToSearch );
			
			switch ($_SESSION ['s_dbConnectionType']) {
				case Util::DB_MYSQL :
					$criteriaQuery .= '
	        				AND ( ' . $fieldToSearch . ' LIKE \'%' . $textToSearch . '%\' OR ' . $fieldToSearch . ' LIKE \'%' . $rawTextToSearch . '%\' )
					        ';
					break;
				case Util::DB_ORACLE :
					break;
				case Util::DB_SQLSERVER :
					break;
				case Util::DB_POSTGRESQL :
					
					$textToSearch = str_replace('\'', '\'\'', $textToSearch);
					$textToSearch = str_replace('"', '""', $textToSearch);
					
					$rawTextToSearch = str_replace('\'', '\'\'', $rawTextToSearch);
					$rawTextToSearch = str_replace('"', '""', $rawTextToSearch);
					
					$criteriaQuery .= '
	        				AND ( lower(' . $fieldToSearch . ') LIKE \'%' . strtolower($textToSearch) . '%\' OR lower(' . $fieldToSearch . ') LIKE \'%' . strtolower($rawTextToSearch) . '%\' )
					        ';
					break;
				default:
					$criteriaQuery .= '
	        				AND ( ' . $fieldToSearch . ' LIKE \'%' . $textToSearch . '%\' OR ' . $fieldToSearch . ' LIKE \'%' . $rawTextToSearch . '%\' )
					        ';
					break;
			}
		
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
	 * @param field_type $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

}