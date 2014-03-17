<?php
App::uses('Socialuser', 'Model');

/**
 * Socialuser Test Case
 *
 */
class SocialuserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.socialuser'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Socialuser = ClassRegistry::init('Socialuser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Socialuser);

		parent::tearDown();
	}

}
