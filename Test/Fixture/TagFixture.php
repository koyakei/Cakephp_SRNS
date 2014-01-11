<?php
/**
 * TagFixture
 *
 */
class TagFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'tag';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 128, 'key' => 'primary', 'comment' => '物理ID	 タグ記事リンクで一意'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => '論理名	 オーナー名とペアで一意', 'charset' => 'utf8'),
		'owner_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '作成日時'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'ID' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'ID' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'owner_id' => 1,
			'created' => 1389335594,
			'modified' => '2014-01-10 07:33:14'
		),
	);

}
