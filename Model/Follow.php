<?php
App::uses('Date', 'Model');
/**
 * Follow Model
 *
 * @property User $User
 */
class Follow extends Date {


/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'follow';

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
		'target' => array(
			'numeric' => array(
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'notEmpty' => array(
					'rule' => array('notEmpty')
			),
			'unique' => array(
				'rule' => array('checkUnique', array('target', 'user_id'),
					'message' => 'Already followed'
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
}
