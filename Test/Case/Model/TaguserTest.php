<?php
App::uses('Taguser', 'Model');

/**
 * Taguser Test Case
 *
 */
class TaguserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.taguser',
		'app.user',
		'app.article',
		'app.follow',
		'app.link',
		'app.social',
		'app.tag',
		'app.whiteuser',
		'app.user_detail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Taguser = ClassRegistry::init('Taguser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Taguser);

		parent::tearDown();
	}

}
