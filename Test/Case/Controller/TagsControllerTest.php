<?php
App::uses('TagsController', 'Controller');
App::uses('Tag','Model');

/**
 * TagsController Test Case
 *
 */
class TagsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tag'
	);
	public $autoRender = FALSE;

// 	public function testReplysingle() {
// 		// テストデータを準備
// 		$andSet_ids = array (1);


// 		// テスト対象メソッドを呼び出す
// 		$result = $this->Tag->replysingle($andSet_ids , null);

// 		// 期待される結果が得られたか？
// 		debug($result);
// 	}
	public function testTest() {
// 		$Posts = $this->generate('Tags', array(
// 				'models' => array(
// 						'isAuthorized'=>true
// 				),

// 		));
		$test = 1;
		$this->assertContains($test, $result);
	}
}
