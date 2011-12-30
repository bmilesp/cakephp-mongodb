<?php
/**
 * SubCollection behavior.
 *
 * Adds functionality specific to MongoDB/SubCollection dbs
 * Ability to create a model from a subdocument. This will add appropriate functionality to queries
 * in order to achieve model functionalty on a subCollection
 * 
 * for this behavior to work correctly, the SubCollection model should have a primary key 
 * associated with it. This is necessary to be able to treat the model as a separate entity from the parent
 * without having to assign a foreign_key.
 *
 * PHP version 5
 *
 * Copyright (c) 2011, Brandon Plasters
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright (c) 2011, Brandon Plasters
 * @link          blog.brandonplasters.com
 * @package       mongodb
 * @subpackage    mongodb.models.behaviors
 * @since         v 1.0 (24-May-2010)
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * SubCollectionBehavior class
 *
 * @uses          ModelBehavior
 * @package       mongodb
 * @subpackage    mongodb.models.behaviors
 */
class SubCollectionBehavior extends ModelBehavior {
	
/**
 * name property
 *
 * @var string 'SubCollection'
 * @access public
 */
	public $name = 'SubCollection';

/**
 * parentCollectionName property
 *
 * @var string
 * @access public
 */
	public $parentCollectionName = '';
	
	
/**
 * parentModelModel property
 *
 * @var Model
 * @access public
 */
	public $parentModel = null;
	
	public function setup(&$Model, $config = array()) {
		if(!empty($Model->parentCollection)){
			$this->parentCollectionName = $Model->parentCollection;
			
			if($parentModel = ClassRegistry::init($this->parentCollectionName)){
				$Model->useTable = $parentModel->useTable;
			}else{
				trigger_error('No Parent Collection defined in Model or Config/bootstrap.php' . $Model->name);
			}
			
		}else{
			trigger_error('No Parent Collection Selected For Sub Collection ' . $Model->name);
		}
	}
	
	public function beforeFind($model, $query){
		//append model->name to fields to limit collection to defined subCollection
		$appendQuery = array($model->name);
		if(is_array($query['fields'])){
			$query['fields'] = array_merge($appendQuery,$query['fields']);
		}else if(!empty($query['fields'])){
			$query['fields'] = $appendQuery[] = $query['fields'];
		}else{
			$query['fields'] = $appendQuery;
		}
		//debug($model->query("db.orders.find({},{'Job' : 1});"));
		$return =  parent::beforeFind($this->parentModel, $query);
	}
	
	public function afterFind($model, $results, $primary){
		$extract = "{$model->name}.{$model->name}";
		$results = $this->array_flatten(Set::extract('{n}.'.$extract, $results));
		foreach ($results as &$result){
			$result = array(
				$model->name => $result
			);
		}
		return $results;
	}
	
	function array_flatten($a) {
    	foreach($a as $k=>$v) $a[$k]=(array)$v;
    	return call_user_func_array('array_merge',$a);
  	}
}

	