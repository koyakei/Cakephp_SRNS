<?php
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
/**
 * Tag Model
 *
 * @property Owner $Owner
 */
class Stag extends Date {

/*
	public function setValue($plugin = null,$name = null,$action = null,$view = null) {
		debug($action);
		debug($this->cachedName);
		$aname = $this->cachedName;
		debug($aname);
	}*/
	//public $uses = array('Article','Link','User','Tag');

// 	public $order = array('Tag.created ASC');
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
        'word' => array(
		//'name' => 'name',
		 'type' => 'like'
		, 'field' => array('Tag.name')
		, 'connectorAnd' => '+', 'connectorOr' => ','
		),
	);
	public function multipleKeywords($keyword, $andor = null) {
		$connector = ($andor === 'or') ? ',' : '+';
		$keyword = preg_replace('/\s+/', $connector, trim(mb_convert_kana($keyword, 's', 'UTF-8')));
		return $keyword;
	}


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
	//public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
			'unique' => array(
				'rule' => array('checkUnique', array('name', 'user_id'),
				'message' => 'A contact with that name already exists for that
institution'
				)
			)
		),
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
			'unique' => array(
				'rule' => array('checkUnique', array('name', 'user_id'),
				'message' => 'A contact with that name already exists for that
institution'
				)
			)
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
   public $hasOne= array(
        'O' => array(
		'className' => 'User',
		'foreignKey' => FALSE,
		'dependent' => false,
		'conditions' => array('`O.id = Tag.user_id`')
		,
		//'type' => 'inner'
        ),
//    		'URL' => array(
//    				'className' => 'Link',
//    				'foreignKey' => 'LFrom',
//    				'dependent' => false,
// //    				'conditions' => array(),
// //    				'type' => 'inner',
//    				'joins' => array(
// 				array(
// 		                    'table' => 'link',
// 		                    'alias' => 'Link',
// 		                    'type' => 'INNER',
// 		                    'conditions' => array(
// 					array( '2299 = Link.LFrom')
// 					)
// 		                ),
// 				),
//    		)
    );
   public $hasAndBelongsToMany= array(
//    		'URL' => array(  'with', 'foreignKey', 'associationForeignKey', 'conditions', 'fields', 'offset', 'unique', 'finderQuery',
//    				'className' => 'Link',
//    				'foreignKey' => 'LFrom',
//    				'dependent' => false,
// //     				'conditions' => array(),
// //    				'type' => 'inner',
//    				'joinTable'
// 				 => array(
// 				array(
// 		                    'table' => 'link',
// 		                    'alias' => 'Link',
// 		                    'type' => 'INNER',
// 		                    'conditions' => array(
// 					array( '2299 = Link.LFrom')
// 					)
// 		                ),
// 				),
//    		)

   	);

}
