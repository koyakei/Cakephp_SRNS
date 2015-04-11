<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('BasicComponent', 'Controller/Component');
class TagController extends Controller {
	public $paginate = null;
}

class BasicComponentTest extends CakeTestCase {
	public $BasicComponent = null;
	public $Controller = null;


public function setUp() {
        parent::setUp();
        // コンポーネントと偽のテストコントローラをセットアップする
        $Collection = new ComponentCollection();
        $this->BasicComponent = new BasicComponent($Collection);
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new TagController($CakeRequest, $CakeResponse);
        $this->BasicComponent->startup($this->Controller);
    }

    public function testTribasicfiderbyidAndSe() {
    	$andSet_ids = array(
	(int) 0 => array(
		(int) 0 => '2140',
		(int) 1 => ''
	),
	(int) 1 => array(
		(int) 0 => '2178',
		(int) 1 => ''
	)
);
    	$option['key'] = Configure::read('tagID.search');
        // 異なる値の設定を用いてadjustメソッドをテストする
        $res = $this->BasicComponent->tribasicfiderbyidAndSet($this,$option['key'],"Article","Article.ID",$andSet_ids);
        $res += $this->BasicComponent->tribasicfiderbyidAndSet($this,$option['key'],"Tag","Tag.ID",$andSet_ids);
        debug($res);
//         $this->assertEquals(20, $this->Controller->paginate['limit']);
    }
    public function tearDown() {
    	parent::tearDown();
    	// 終了した後のお掃除
    	unset($this->BasicComponent);
    	unset($this->Controller);
    }
}