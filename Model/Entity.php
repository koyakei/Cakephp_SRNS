<?php
App::uses('Date', 'Model');
Configure::load("static");
/**
 * Article Model
 *
 */
class Entity extends Date {

	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
			'word' => array(
	    	'type' => 'value'
		, 	'field' => array('tag.name')
			, 'connectorAnd' => '+', 'connectorOr' => ','
),
	);


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






public $base_sql = null;


/**
 * Validation rules
 *
 * @var array
 */
public $validate = array(
		'user_id' => array(
				'notEmpty' => array(
						'rule' => array('notEmpty'),
						//'message' => 'Your custom message here',
						//'allowEmpty' => false,
						//'required' => false,
						//'last' => false, // Stop validation after this rule
						//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
		),
);

   public $hasOne= array(
        'O' => array(
	        'fields' => 'username',
			'className' => 'User',
			'foreignKey' => FALSE,
			'dependent' => false,
			'conditions' => array('`O.id = Article.user_id`')
			,
		//'type' => 'inner'
        ),
//    		'URL' => array(
//    				'fields' => 'name',
//    				'className' => 'Link',
//    				'foreignKey' => FALSE,
//    				'dependent' => false,
//    				'conditions' => array('`URL.FromID = Article.ID`',)
//    				,
//    				'type' => 'inner',
//    				'joins' => array()
//    		)
    );
}
