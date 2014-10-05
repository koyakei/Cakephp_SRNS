<?php
App::uses('TagsController', 'Controller');

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

// 	public function testReplysingle() {
// 		// テストデータを準備
// 		$andSet_ids = array (1);


// 		// テスト対象メソッドを呼び出す
// 		$result = $this->Tag->replysingle($andSet_ids , null);

// 		// 期待される結果が得られたか？
// 		debug($result);
// 	}
	public function testIndex() {
		$result = $this->testAction('/tags/index');
		debug($result);
	}
}
