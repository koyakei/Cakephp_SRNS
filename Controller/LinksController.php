<?php
App::uses('AppController', 'Controller');
App::uses('TagauthsController', 'Controller');
App::uses('BasicComponent', 'Controller/Component', 'Follow/Component');
Configure::load("static");

/**
 * Links Controller
 *
 * @property Link $Link
 * @property PaginatorComponent $Paginator
 */
class LinksController extends AppController {
	public $presetVars = array(
			'user_id' => array('type' => 'value'),
			'keyword' => array('type' => 'value'),
			'andor' => array('type' => 'value'),
			'from' => array('type' => 'value'),
			'to' => array('type' => 'value'),
	);
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('logout');
		$this->Auth->authenticate = array(
				'Basic' => array('user' => array('admin'
						//,'registered'
		)),
				//'Form' => array('user' => 'Member')
		);

		$this->Security->validateOnce = false;
		$this->Security->validatePost = false;
		$this->Security->csrfCheck = false;
	}
	public function triLinkAdd($from =NULL,$to = null){
		debug($this->request->query);
		$options['key'] = $this->request->query['keyid'];
		if (empty($options['key'])){
			$options['key'] = Configure::read("tagID.reply");
		}
		$root_ids = $this->request->query['root_ids'];

		$to = $this->request->query['to'];
		$user_id = $this->request->query['user_id'];
		if (empty($user_id)){
			$user_id = $this->Auth->user('id');
		}
		$parent_ids = $this->request->query['parent_ids'];
		if ($user_id = null){
			$user_id = $this->Auth->user('id');
		}
		$this->Common->nestedAdd($this,$root_ids,$options['key'],
				$parent_ids,$to);
		$this->Basic->social($this,$this->Auth->user('id'));
// 		$this->redirect($this->referer());
	}
	public function isAuthorized($user) {

		// 投稿のオーナーは編集や削除ができる
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = $this->request->params['pass'][0];
			if ($this->Link->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}
/**
 * Components
 *
 * @var array
 */
	public $components = array('Auth','Search.Prg','Paginator','Common','Basic','Cookie','Session','Security');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Link->recursive = 0;
		$this->set('links', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Link->exists($id)) {
			throw new NotFoundException(__('Invalid link'));
		}
		$options = array('conditions' => array('Link.' . $this->Link->primaryKey => $id));
		$this->set('link', $this->Link->find('first', $options));
		if($this->request->data['Article']['name'] != null){
			$this->keyid = $this->request->data['Article']['keyid'];
			$this->Common->triarticleAdd($this,'Article',1);
		}
		if($this->request->data['Tag']['name'] != null){
			$this->keyid = $this->request->data['Tag']['keyid'];
			$this->Common->tritagAdd($this,"Tag",1);
		}
		$this->set('upperIdeas', $this->returntribasic);
		$this->taghashgen = $this->Link->find('first',array('conditions' => array('Link.' . $this->Link->primaryKey => $id)));
		$this->Link->read(null,$id);
		$this->set('idre', $id);
		$this->i = 0;
		$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
		$this->set('link',$this->taghashgen);
		$this->Common->SecondDem($this,"Tag","Tag.ID",$trikeyID,$id);
		$this->set('headresults', $this->returntribasic);
		$this->set('headtaghashes', $this->taghash);
		$targetID = $id;
		$this->Common->trifinderbyid($this);
		$this->loadModel('User');
		$this->loadModel('Key');
		$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
		$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
		debug($this->Auth->user('id'));
		$this->set('currentUserID', $this->Auth->user('id'));
	}
/**
 * transmitter method
 *
 * @return void
 */
	public function transmitter($id = null){// 渡されるのが一つだけでいいのか？

	}
/**
 * add method
 *TODO:Follow 追加
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Link->create();
			if ($this->Link->save($this->request->data)) {
				$this->Follow->add($this,$this->request->data("Link.target"));
				$this->Session->setFlash(__('The link has been saved.'));
// 				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		}
	}

	public function linkdel($id = NULL){
		$this->request->onlyAllow('post', 'linkdel');
		if ($this->Link->delete()) {
			$this->Session->setFlash(__('The link has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link could not be deleted. Please, try again.'));
		}
		$this->redirect($this->referer());
	}
	public function edgedel(){
		$id = $_REQUEST['id'];
		$this->response->type('json');
		$this->layout = 'ajax';
		$this->Link->id = $id;
		$result = $this->Link->find('first',array('conditions' => array('Link.ID' => $id),'fields' => array('Link.user_id')));
		if ($this->Auth->user('id') == $result['Link']['user_id']) {
			if ($this->Link->delete()) {
				$this->set('res',true);
			} else {
				$this->set('res',false);
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Link->exists($id)) {
			throw new NotFoundException(__('Invalid link'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Link->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Link.' . $this->Link->primaryKey => $id));
			$this->request->data = $this->Link->find('first', $options);
		}
	}

//一個ずつ　
//   array(array("link_id","taglink_id")...)
//TODO: history への追加を実装する。
	public function nestedDelete($ids = null) {
		if (is_null($ids)){
			$ids =+ $this->request->data("trilink_id.Link.ID");//これだけじゃあ配列になってない。
			$ids =+ $this->request->data("trilink_id.TagLink.ID");
		}
		self::delQueryBuilder($ids);
	}
	private function delQueryBuilder($id){
		if (is_array($ids)){
			foreach ($ids as $id){
				self::delQueryBuilder($id);
			}
		} else {
			self::delete($id);
		}
	}
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = NULL) {
		if (is_null($id)){
			$id =$this->request->data("Link.trikey_id");
		}
// 		$this->request->onlyAllow('post', 'delete');
		$this->loadModel('Tagauth');
			$this->Link->id = $id;
			if (!$this->Link->exists()) {
				throw new NotFoundException(__('Invalid link'));
			}
			$result = $this->Link->find('first',array('conditions' => array('Link.ID' => $id),'fields' => array('Link.user_id')));
			if ($this->Auth->user('id') == $result['Link']['user_id'] && $this->Link->find('first',
				array('conditions' => array('Link.ID' => $id),'fields' => array('Link.user_id'))
			)) {
				if ($this->Link->delete()) {
					//TODO: 次はここいら辺のフォロー関係と並列関係
// 					$this->Follow->add($this,$this->request->data("Link.target"));
					$this->Session->setFlash(__('The link has been deleted.'));
					$this->redirect($this->referer());
					return true;

				} else {
					$this->Session->setFlash(__('The link could not be deleted. Please, try again.'));
					return false;
				}
			}
// 		return $this->redirect($this->referer());
	}
 // trikey の使用許可をどう管理するのか考えるのをすっかり忘れていた。
	public function delete2(){
		debug($this->request->data);
		if (is_null($id)){
			$id =$this->request->data("Link.trikey_id");
		}
		self::delete($id);

	}
/**
 *
 * 予定　@param mix options　権限を確かめる予定
 */
	function addTriLink(){
		$this->set('json', $this->Basic->trilinkAdd($this,$_REQUEST['from'],$_REQUEST['to'],$_REQUEST['trikey_id'],$options));
		$this->layout = 'ajax';
	}
/**
 * singlelink method
 *
 *
 * @param string $id
 * @return void
 */
	public function singlelink($id = NULL) {
		$this->request->data['Link']['user_id'] = $this->Auth->user('ID');
		$this->request->data['Link']['quant'] = 1;
		$this->request->data['Link']['created'] = date("Y-m-d H:i:s");
		$this->request->data['Link']['modified'] = date("Y-m-d H:i:s");
		debug($this->request->data['Link']);
		$this->Link->create();
		if ($this->Link->save($this->request->data)) {
			$this->Session->setFlash(__('Single link was created.'));
		} else {
			$this->Session->setFlash(__('Fail.'));
		}
		return $this->redirect($this->referer());
	}
}
