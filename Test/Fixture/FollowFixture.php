<?php
/**
 * FollowFixture
 *
 */
class FollowFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'follow';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
		'target' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
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
			'target' => 1
		),
	);

}
