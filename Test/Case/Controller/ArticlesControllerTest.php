<?php
App::uses('ArticlesController', 'Controller');

/**
 * ArticlesController Test Case
 *
 */
class ArticlesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.article'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$result = $this->Article->index();
		debug($result);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
