<?php
/**
 * SocialFixture
 *
 */
class SocialFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'social';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
		'ctrl' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'view' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'page_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
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
			'user_id' => 1,
			'ctrl' => 'Lorem ipsum dolor sit amet',
			'view' => 'Lorem ipsum dolor sit amet',
			'page_id' => 1
		),
	);

}
