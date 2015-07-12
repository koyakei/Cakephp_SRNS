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
					'foreignKey' => "Link_LTo",
					'associationForeignKey' => 'Link_LTo',
					'dependent' => false,
					'conditions'=> array(
							"`Search.LFrom = 2146`",
					),
		),
			// 自らの結果に存在するか調査
			//ajaxで取得した時に　関連性を追加するからっこでは不適当なのか？
			//foreachで回すのめんどうさすぎる　何とかして　assosiation で自己三章でkないものか。
			//belongsTo にしようか　
		'Parallel' => array(
			'className' => 'Trilink',
// 			'foreignKey' =>array("AND" =>array("Link_LTo","Link_LFrom" )) ,// "Link_LTo" ,//array('Link_LTo',"Link_LFrom"),
// 			'associationForeignKey' =>array("AND" =>array("Link_LTo","Link_LFrom" )) ,
			'fields' => array("Parallel.ID"),
			'foreignKey' => "Link_LTo",
// 				'associationForeignKey' => 'Link_LTo',
			'dependent' => false,
			'conditions' => array(
// 					'AND' => array(
// 							array(
									'Parallel.Link_LFrom = ({$__cakeID__$})'

// 							),
// 							array('Parallel.Link_LTo' => '{$__cakeID__$}')
// 					)
			),
		),

	);
}
