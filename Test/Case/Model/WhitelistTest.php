<?php
App::uses('Whitelist', 'Model');

/**
 * Whitelist Test Case
 *
 */
class WhitelistTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.whitelist'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Whitelist = ClassRegistry::init('Whitelist');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Whitelist);

		parent::tearDown();
	}

}
