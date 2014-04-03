<?php
App::uses('Whiteuser', 'Model');

/**
 * Whiteuser Test Case
 *
 */
class WhiteuserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.whiteuser'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Whiteuser = ClassRegistry::init('Whiteuser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Whiteuser);

		parent::tearDown();
	}

}
