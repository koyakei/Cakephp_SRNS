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
	/*public $actsAs = array(
		'Srns'
	);*/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('logout','');
		$this->Auth->authenticate = array(
				'Basic' => array('user' => 'admin'),
				//'Form' => array('user' => 'Member')
		);
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Search.Prg','Paginator','Common','Basic','Cookie','Session');

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
		if ($this->Link->delete()) {
			$this->Session->setFlash(__('The link has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link could not be deleted. Please, try again.'));
		}
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
