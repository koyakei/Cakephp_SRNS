<?php
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
/**
 * Tag Model
 *
 * @property Owner $Owner
 */
class Trilink extends Date {




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
	public $primaryKey = 'ID';

/**
 * Validation rules
 *
 * @var array
 */
	public $hasOne= array(
			'Tag' => array(
					'className' => 'Tag',
					'foreignKey' => FALSE,
					'dependent' => false,
					'conditions' => array('`Tag.ID = Trilink.Link_LTo`'),
					),
			'Article' => array(
					'className' => 'Article',
					'foreignKey' => FALSE,
					'dependent' => false,
					'conditions' => array('`Article.ID = Trilink.Link_LTo`'),
			),
			);
}
