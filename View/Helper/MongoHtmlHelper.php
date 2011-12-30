<?php
/**
 * Html Helper class file.
 *
 * Simplifies the construction of HTML elements.
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
 * @since         CakePHP(tm) v 0.9.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('HtmlHelper', 'View/Helper');
/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1434/HTML
 */
class MongoHtmlHelper extends HtmlHelper {

	function mongoDate($mongoDateTime = null, $format = 'Y-m-d h:i:s'){
		$splitter = split(" ",$mongoDateTime);
		return date($format,$splitter[1]);
	}
		
}
	