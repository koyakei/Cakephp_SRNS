<?php
App::uses('Social', 'Model');

/**
 * Social Test Case
 *
 */
class SocialTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.social',
		'app.user',
		'app.article',
		'app.link'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Social = ClassRegistry::init('Social');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Social);

		parent::tearDown();
	}

}
