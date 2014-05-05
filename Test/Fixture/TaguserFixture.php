<?php
/**
 * TaguserFixture
 *
 */
class TaguserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 128, 'comment' => '物理ID	 タグ記事リンクで一意'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => '論理名	 オーナー名とペアで一意', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => '52f5e533-0280-4b40-878a-0194e0e4e673', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '作成日時'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'max_quant' => array('type' => 'integer', 'null' => false, 'default' => '1000', 'length' => 255, 'comment' => '総発行量'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
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
			'user_id' => 'Lorem ipsum dolor sit amet',
			'created' => 1399260708,
			'modified' => 1399260708,
			'max_quant' => 1,
			'username' => 'Lorem ipsum dolor sit amet'
		),
	);

}
