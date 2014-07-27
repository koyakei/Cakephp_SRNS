<?php
App::uses('AppController', 'Controller');
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
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Link->create();
			if ($this->Link->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved.'));
				return $this->redirect(array('action' => 'index'));
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

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Link->id = $id;
		if (!$this->Link->exists()) {
			throw new NotFoundException(__('Invalid link'));
		}
		$this->request->onlyAllow('post', 'delete');
		$result = $this->Link->find('first',array('conditions' => array('Link.ID' => $id),'fields' => array('Link.user_id')));
		if ($this->Auth->user('id') == $result['Link']['user_id'] && $this->Tagauth->find('first',
			array('conditions' => array('Tagauth.ID' => $id),'fields' => array('Link.user_id'))
		)) {
			if ($this->Link->delete()) {
				$this->Session->setFlash(__('The link has been deleted.'));
				return true;

			} else {
				$this->Session->setFlash(__('The link could not be deleted. Please, try again.'));
				return false;
			}
		}
		debug($this->referer());
		print_r("戻るで戻って");
		return $this->redirect($this->referer());
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
