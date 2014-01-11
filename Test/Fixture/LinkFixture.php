<?php
/**
 * LinkFixture
 *
 */
class LinkFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'link';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 128, 'key' => 'primary', 'comment' => '物理ID	 記事タグも含めて一意'),
		'from_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 128, 'comment' => 'リンク元'),
		'to_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 128, 'comment' => 'リンク先'),
		'quant' => array('type' => 'integer', 'null' => false, 'default' => null),
		'owner_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '作成日時'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
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
			'from_id' => 1,
			'to_id' => 1,
			'quant' => 1,
			'owner_id' => 1,
			'created' => 1389431219,
			'modified' => '2014-01-11 10:06:59'
		),
	);

}
