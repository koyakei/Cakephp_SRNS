<?php
App::uses('Date', 'Model');
Configure::load("static");
/**
 * Tag Model
 *
 * @property Owner $Owner
 */
class Tag extends Date {

/*
	public function setValue($plugin = null,$name = null,$action = null,$view = null) {
		debug($action);
		debug($this->cachedName);
		$aname = $this->cachedName;
		debug($aname);
	}*/
	//public $uses = array('Article','Link','User','Tag');
	public function beforeFind($query){
// 		debug($query);
//  		$query = array('order'=> array('Tag.modified' => 'DESC'));
// 		return $query;
	}
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
	//public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
 function checkUnique($data, $fields) {
    if (!is_array($fields)) {
        $fields = array($fields);
    }
    foreach($fields as $key) {
        $tmp[$key] = $this->data[$this->name][$key];
    }
    return $this->isUnique($tmp, false);

 }
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
   public $belongsTo= array(
        'TO' => array(
		'className' => 'User',
		'foreignKey' => 'user_id',
		'dependent' => false,
		'conditions' => '',
		//'type' => 'inner'
        )
    );
   public $hasMany= array(
   		'W' => array(
   				'className' => 'Whiteuser',
   				'foreignKey' => 'entity_id',
   				'dependent' => false,
   				'conditions' => '',
   				//'type' => 'inner'
   		)
   );
}
