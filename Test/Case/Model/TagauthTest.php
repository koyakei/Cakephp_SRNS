<?php
App::uses('Tagauth', 'Model');

/**
 * Tagauth Test Case
 *
 */
class TagauthTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tagauth',
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
		$this->Tagauth = ClassRegistry::init('Tagauth');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tagauth);

		parent::tearDown();
	}

}
