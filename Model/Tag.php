<?php
App::uses('AppModel', 'Model');
/**
 * Tag Model
 *
 * @property Owner $Owner
 */
class Tag extends AppModel {
	public $order = array('Post.id DESC');
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
	        'word' => array(
//'name' => 'name',
 'type' => 'value'
, 'field' => array('tag.name')
, 'connectorAnd' => '+', 'connectorOr' => ','
),
	);
	public function multipleKeywords($keyword, $andor = null) {
		$connector = ($andor === 'or') ? ',' : '+';
		$keyword = preg_replace('/\s+/', $connector, trim(mb_convert_kana($keyword, 's', 'UTF-8')));
		return $keyword;
	}

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
	public $useTable = 'tag';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'owner_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
/*
	public $belongsTo = array(
		'Owner' => array(
			'className' => 'Owner',
			'foreignKey' => 'owner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
*/
}
