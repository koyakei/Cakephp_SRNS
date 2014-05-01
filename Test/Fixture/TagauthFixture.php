<?php
/**
 * TagauthFixture
 *
 */
class TagauthFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 255, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
		'quant' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 255, 'comment' => '個人の動かせる量'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
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
			'user_id' => 'Lorem ipsum dolor sit amet',
			'tag_id' => 1,
			'quant' => 1,
			'modified' => 1398867682,
			'username' => 'Lorem ipsum dolor sit amet'
		),
	);

}
