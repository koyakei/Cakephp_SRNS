<?php
App::uses('Key', 'Model');

/**
 * Key Test Case
 *
 */
class KeyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.key'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Key = ClassRegistry::init('Key');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Key);

		parent::tearDown();
	}

}
