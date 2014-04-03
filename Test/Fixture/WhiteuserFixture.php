<?php
/**
 * WhiteuserFixture
 *
 */
class WhiteuserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255, 'key' => 'primary'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
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
			'id' => 1,
			'entity_id' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'created' => 1396446942,
			'username' => 'Lorem ipsum dolor sit amet'
		),
	);

}
