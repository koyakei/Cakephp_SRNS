<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('CommonComponent', 'Controller/Component');
class TagController extends Controller {
	public $paginate = null;
}

class CommonComponentTest extends CakeTestCase {
	public $CommonComponent = null;
	public $Controller = null;


public function setUp() {
        parent::setUp();
        // コンポーネントと偽のテストコントローラをセットアップする
        $Collection = new ComponentCollection();
        $this->CommonComponent = new CommonComponent($Collection);
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new TagController($CakeRequest, $CakeResponse);
        $this->CommonComponent->startup($this->Controller);
    }

    public function testTrifinderbyidAndSet() {
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
        debug($this->CommonComponent->trifinderbyidAndSet($this,$andSet_ids,$option));
//         $this->assertEquals(20, $this->Controller->paginate['limit']);
    }
    public function tearDown() {
    	parent::tearDown();
    	// 終了した後のお掃除
    	unset($this->CommonComponent);
    	unset($this->Controller);
    }
}