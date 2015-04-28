<?php
App::uses('AppController', 'Controller');

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
	public function testSorting_taghash_gen(){
		$temp['articleparentres'] = array(
		(int) 0 => array(
			'Article' => array(
				'ID' => '100031',
				'name' => 'タグ通貨',
				'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
				'created' => '2013-12-21 15:10:44',
				'modified' => '2014-01-09 23:01:55',
				'auth' => '0'
			),
			'O' => array(
				'password' => '*****',
				'id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
				'username' => 'koyakei',
				'slug' => 'koyakei',
				'password_token' => null,
				'email' => 'koyakeiaaaaa@hotmail.com',
				'email_verified' => true,
				'email_token' => 'cv9dmzxlah',
				'email_token_expires' => '2014-02-09 17:05:07',
				'tos' => true,
				'active' => true,
				'last_login' => '2014-02-09 21:31:26',
				'last_action' => null,
				'is_admin' => true,
				'role' => 'admin',
				'created' => '2014-02-08 17:05:07',
				'modified' => '2014-10-15 16:46:52',
				'tlimit' => '753',
				'tag_id' => '0'
			),
			'Link' => array(
				'ID' => '2000059',
				'LFrom' => '2140',
				'LTo' => '100031',
				'quant' => '1',
				'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
				'created' => '2013-12-23 12:48:48',
				'modified' => '2014-01-09 23:00:43',
				'auth' => '0',
				'quantize_id' => '0'
			),
			'taglink' => array(
				'name' => 'Search',
				'tag_user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
				'tag_modified' => '0000-00-00 00:00:00',
				'tag_created' => '2013-12-31 14:41:50',
				'ID' => '2000712',
				'LFrom' => '2146',
				'LTo' => '2000059',
				'quant' => '1',
				'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
				'created' => '2013-12-31 17:35:37',
				'modified' => '2014-01-09 23:00:43',
				'auth' => '0'
			),
			'subtag' => array(
				(int) 2140 => array(
					'Tag' => array(
						'ID' => '2140',
						'name' => 'SRNS',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-23 12:48:48',
						'modified' => '0000-00-00 00:00:00',
						'max_quant' => '1000',
						'auth' => '0'
					),
					'O' => array(
						'password' => '*****',
						'id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'username' => 'koyakei',
						'slug' => 'koyakei',
						'password_token' => null,
						'email' => 'koyakeiaaaaa@hotmail.com',
						'email_verified' => true,
						'email_token' => 'cv9dmzxlah',
						'email_token_expires' => '2014-02-09 17:05:07',
						'tos' => true,
						'active' => true,
						'last_login' => '2014-02-09 21:31:26',
						'last_action' => null,
						'is_admin' => true,
						'role' => 'admin',
						'created' => '2014-02-08 17:05:07',
						'modified' => '2014-10-15 16:46:52',
						'tlimit' => '753',
						'tag_id' => '0'
					),
					'Link' => array(
						'ID' => '2000059',
						'LFrom' => '2140',
						'LTo' => '100031',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-23 12:48:48',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0',
						'quantize_id' => '0'
					),
					'taglink' => array(
						'name' => 'Search',
						'tag_user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'tag_modified' => '0000-00-00 00:00:00',
						'tag_created' => '2013-12-31 14:41:50',
						'ID' => '2000712',
						'LFrom' => '2146',
						'LTo' => '2000059',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 17:35:37',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0'
					),
					'W' => array()
				),
				(int) 2145 => array(
					'Tag' => array(
						'ID' => '2145',
						'name' => '出現順',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 11:39:20',
						'modified' => '0000-00-00 00:00:00',
						'max_quant' => '1000',
						'auth' => '0'
					),
					'O' => array(
						'password' => '*****',
						'id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'username' => 'koyakei',
						'slug' => 'koyakei',
						'password_token' => null,
						'email' => 'koyakeiaaaaa@hotmail.com',
						'email_verified' => true,
						'email_token' => 'cv9dmzxlah',
						'email_token_expires' => '2014-02-09 17:05:07',
						'tos' => true,
						'active' => true,
						'last_login' => '2014-02-09 21:31:26',
						'last_action' => null,
						'is_admin' => true,
						'role' => 'admin',
						'created' => '2014-02-08 17:05:07',
						'modified' => '2014-10-15 16:46:52',
						'tlimit' => '753',
						'tag_id' => '0'
					),
					'Link' => array(
						'ID' => '2000156',
						'LFrom' => '2145',
						'LTo' => '100031',
						'quant' => '5',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 11:39:20',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0',
						'quantize_id' => '0'
					),
					'taglink' => array(
						'name' => 'Search',
						'tag_user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'tag_modified' => '0000-00-00 00:00:00',
						'tag_created' => '2013-12-31 14:41:50',
						'ID' => '2000796',
						'LFrom' => '2146',
						'LTo' => '2000156',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 17:35:37',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0'
					),
					'W' => array()
				)
			),
			'no_sort_subtag' => array(
				(int) 2140 => array(
					'Tag' => array(
						'ID' => '2140',
						'name' => 'SRNS',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-23 12:48:48',
						'modified' => '0000-00-00 00:00:00',
						'max_quant' => '1000',
						'auth' => '0'
					),
					'O' => array(
						'password' => '*****',
						'id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'username' => 'koyakei',
						'slug' => 'koyakei',
						'password_token' => null,
						'email' => 'koyakeiaaaaa@hotmail.com',
						'email_verified' => true,
						'email_token' => 'cv9dmzxlah',
						'email_token_expires' => '2014-02-09 17:05:07',
						'tos' => true,
						'active' => true,
						'last_login' => '2014-02-09 21:31:26',
						'last_action' => null,
						'is_admin' => true,
						'role' => 'admin',
						'created' => '2014-02-08 17:05:07',
						'modified' => '2014-10-15 16:46:52',
						'tlimit' => '753',
						'tag_id' => '0'
					),
					'Link' => array(
						'ID' => '2000059',
						'LFrom' => '2140',
						'LTo' => '100031',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-23 12:48:48',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0',
						'quantize_id' => '0'
					),
					'taglink' => array(
						'name' => 'Search',
						'tag_user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'tag_modified' => '0000-00-00 00:00:00',
						'tag_created' => '2013-12-31 14:41:50',
						'ID' => '2000712',
						'LFrom' => '2146',
						'LTo' => '2000059',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 17:35:37',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0'
					),
					'W' => array()
				),
				(int) 2145 => array(
					'Tag' => array(
						'ID' => '2145',
						'name' => '出現順',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 11:39:20',
						'modified' => '0000-00-00 00:00:00',
						'max_quant' => '1000',
						'auth' => '0'
					),
					'O' => array(
						'password' => '*****',
						'id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'username' => 'koyakei',
						'slug' => 'koyakei',
						'password_token' => null,
						'email' => 'koyakeiaaaaa@hotmail.com',
						'email_verified' => true,
						'email_token' => 'cv9dmzxlah',
						'email_token_expires' => '2014-02-09 17:05:07',
						'tos' => true,
						'active' => true,
						'last_login' => '2014-02-09 21:31:26',
						'last_action' => null,
						'is_admin' => true,
						'role' => 'admin',
						'created' => '2014-02-08 17:05:07',
						'modified' => '2014-10-15 16:46:52',
						'tlimit' => '753',
						'tag_id' => '0'
					),
					'Link' => array(
						'ID' => '2000156',
						'LFrom' => '2145',
						'LTo' => '100031',
						'quant' => '5',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 11:39:20',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0',
						'quantize_id' => '0'
					),
					'taglink' => array(
						'name' => 'Search',
						'tag_user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'tag_modified' => '0000-00-00 00:00:00',
						'tag_created' => '2013-12-31 14:41:50',
						'ID' => '2000796',
						'LFrom' => '2146',
						'LTo' => '2000156',
						'quant' => '1',
						'user_id' => '52f5e533-0280-4b40-878a-0194e0e4e673',
						'created' => '2013-12-31 17:35:37',
						'modified' => '2014-01-09 23:00:43',
						'auth' => '0'
					),
					'W' => array()
				)
			)
		),
			);

		$taghash =array(
	(int) 2140 => array(
		'ID' => '2140',
		'name' => 'SRNS'
	),
	(int) 2145 => array(
		'ID' => '2145',
		'name' => '出現順'
	),
	(int) 2260 => array(
		'ID' => '2260',
		'name' => 'togetter like'
	),
	(int) 2178 => array(
		'ID' => '2178',
		'name' => 'タスク'
	),
	(int) 2179 => array(
		'ID' => '2179',
		'name' => 'UI'
	),
	(int) 2300 => array(
		'ID' => '2300',
		'name' => '現状問題構造ツリー'
	),
	(int) 2319 => array(
		'ID' => '2319',
		'name' => '説得'
	),
	(int) 2545 => array(
		'ID' => '2545',
		'name' => 'SRNSの物語'
	),
	(int) 2349 => array(
		'ID' => '2349',
		'name' => '中期目標'
	),
	(int) 2396 => array(
		'ID' => '2396',
		'name' => 'mind map'
	),
	(int) 2457 => array(
		'ID' => '2457',
		'name' => 'IF文'
	),
	(int) 2520 => array(
		'ID' => '2520',
		'name' => 'googleの利用'
	),
	(int) 2550 => array(
		'ID' => '2550',
		'name' => '3D'
	),
	(int) 2182 => array(
		'ID' => '2182',
		'name' => 'プロトコル'
	),
	(int) 2192 => array(
		'ID' => '2192',
		'name' => '自由参入・退出'
	),
	(int) 2198 => array(
		'ID' => '2198',
		'name' => '自由参入難易度'
	),
	(int) 2360 => array(
		'ID' => '2360',
		'name' => '使い方'
	),
	(int) 2467 => array(
		'ID' => '2467',
		'name' => 'SRNSのエンティティ'
	)
);
		$sorting_tags = array();
		$res = $this->AppController->sorting_taghash_gen($temp['articleparentres'],$taghash,$sorting_tags);
		debug($res);
	}
	public function testTaghashes_cutter(){
		$taghashes = array(
	(int) 2140 => array(
		'ID' => '2140',
		'name' => 'SRNS'
	),
	(int) 2145 => array(
		'ID' => '2145',
		'name' => '出現順'
	),
				);
		$sorting_tags = array(2140);
		$taghashes = $this->AppController->taghashes_cutter($taghashes,$sorting_tags);
		debug($taghashes);
	}
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
