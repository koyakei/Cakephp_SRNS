<?php
App::uses('AppModel', 'Model');
/**
 * Article Model
 *
 */
class Article extends AppModel {
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
	        'word' => array(
//'name' => 'name',
 'type' => 'value'
, 'field' => array('tag.name')
, 'connectorAnd' => '+', 'connectorOr' => ','
),
	);
/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'test';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'article';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
