<?php
App::uses('Date', 'Model');
/**
 * Link Model
 *
 * @property LinkID_LinkTo $LinkID_LinkTo
 * @property LinkID_LinkFrom $LinkID_LinkFrom
 */
class Link extends Date {
	public $actsAs = array('Search.Searchable');


/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'link';

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
	public $displayField = 'quant';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'ID' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'LFrom' => array(
			'naturalNumber' => array(
				'rule' =>
// 						'notEmpty',
						array( 'isUniqueWith', array('LTo','user_id'))
				,
				//'message' => 'Your custom message here',
				'allowEmpty' => FALSE,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'LTo' => array(
			'naturalNumber' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => FALSE,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'naturalNumber' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => FALSE,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasOne= array(
//         'LO' => array(
// 		'className' => 'User',
// 		'foreignKey' => 'ID',
// 		'dependent' => false,
// 		'conditions' => 'LO.ID = Link.user_id',
// 		'type' => 'inner'
//         )
    );
//     public $hasMany= array(
//         'AI_LT' => array(
// 		'className' => 'Article',
// 		'foreignKey' => 'ID',
// 		'dependent' => false,
// 		'conditions' => 'Article.ID = link.LTo',
// 		//'type' => 'inner'
//         )
//     );
/*public $hasAndBelongsToMany= array(
        'LinkTo_ArticleID' => array(
		'className' => 'article',
		'foreignKey' => 'LTo',
		'dependent' => false,
		'conditions' => '',
        )
    );*/

/*
	public $hasMany = array(
		'LinkTo_ArticleID' => array(
			'className' => 'LinkTo_ArticleID',
			'foreignKey' => 'to_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'LinkID_LinkTo' => array(
			'className' => 'LinkID_LinkTo',
			'foreignKey' => 'to_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'LinkID_LinkFrom' => array(
			'className' => 'LinkID_LinkFrom',
			'foreignKey' => 'from_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);*/

}
