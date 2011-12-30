<?php
/**
 * Automatic generation of HTML FORMs from given data.
 *
 * Used for scaffolding.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('FormHelper', 'View/Helper');
/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1383/Form
 */



class MongoFormHelper extends FormHelper {
	
/**
 * Parses MongoDate Object then returns FormHelper date
 *
 */

 
	function dateTime($fieldName, $dateFormat = 'DMY', $timeFormat = '12', $attributes = array()) {
		
		if (empty($attributes['value'])) {
			$attributes = $this->value($attributes, $fieldName);
		}
		if (!empty($attributes['value'])) {
			
			$attributes['value'] = $attributes['value']->sec;
		}
		return parent::dateTime($fieldName, $dateFormat, $timeFormat, $attributes);
	}
}