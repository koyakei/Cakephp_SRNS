<?php
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
/**
 * Tag Model
 *
 * @property Owner $Owner
 */
class Strilink extends Date {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'trilinks';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'Link_LFrom';

/**
 * Validation rules
 *
 * @var array
 */
	public $hasOne= array(
		'Stag' => array(
			'className' => 'Tag',
			'foreignKey' => "ID",
			'dependent' => false,
// 			'conditions' => array('`STag.ID = Strilink.Link_LTo`'),
		),
	);
}
