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
	public $cacheQueries = true;

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
	public $primaryKey = 'Link_LTo';
	public $actsAs = array('Containable');

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
	public $hasMany= array(
			'Search' => array(
					'className' => 'Strilink',
// 					'table' => 'trilinks',
// 									                    'alias' => 'Strilink',
					'foreignKey' => "Link_LTo",
					'associationForeignKey' => 'Link_LTo',
					'dependent' => false,
					'conditions'=> array(
// 							"`Search.Link_LTo = Strilink.Link_LTo`",
							"`Search.LFrom = 2146`",//TODO:valuable in assosiation conditions
					),
// 									'fields' => array('Tag.ID'),
// 					'joins'
// 					 => array(
// 	                    'table' => 'tag',
// 	                    'alias' => 'Tag',
// // 	                    'type' => 'LEFT',
// 	                    'conditions' => array(
// 			                "`Tag.ID = Search.Link_LFrom`",
// 					)
// 			)
		),
	);
}
