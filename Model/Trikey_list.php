<?php
App::uses('Date', 'Model');
/**
 * Link Model
 *
 * @property LinkID_LinkTo $LinkID_LinkTo
 * @property LinkID_LinkFrom $LinkID_LinkFrom
 */
class Trikey_list extends Date {
	public $actsAs = array('Search.Searchable');


/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'trikey_list';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
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
}
