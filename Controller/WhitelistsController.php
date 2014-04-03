<?php
App::uses('AppController', 'Controller');
/**
 * Whitelists Controller
 *
 * @property Whitelist $Whitelist
 * @property PaginatorComponent $Paginator
 */
class WhitelistsController extends AppController {
	public function isAuthorized($user) {
		// 登録済ユーザーは投稿できる
		if ($this->action === 'add'|| $this->action === 'transmitter') {
			return true;
		}

		// 投稿のオーナーは編集や削除ができる
// 		if (in_array($this->action, array('edit', 'delete'))) {
// 			$postId = (int) $this->request->params['pass'][0];
// 			if ($this->Article->isOwnedBy($postId, $user['id'])) {
// 				return true;
// 			}else {
// 				$this->redirect($this->referer());
// 			}
// 		}

		return parent::isAuthorized($user);
	}
	public $presetVars = array(
			'user_id' => array('type' => 'value'),
			'keyword' => array('type' => 'value'),
			'andor' => array('type' => 'value'),
			'from' => array('type' => 'value'),
			'to' => array('type' => 'value'),
	);
	//public $uses = array('Article');
	//public $paginate = array( 'limit' => 25);
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->validateOnce = false;
		$this->Security->validatePost = false;
		$this->Security->csrfCheck = false;
		$this->Auth->allow('logout');
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
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Whitelist->recursive = 0;
		$this->set('whitelists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Whitelist->exists($id)) {
			throw new NotFoundException(__('Invalid whitelist'));
		}
		$options = array('conditions' => array('Whitelist.' . $this->Whitelist->primaryKey => $id));
		$this->set('whitelist', $this->Whitelist->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Whitelist->create();
			if ($this->Whitelist->save($this->request->data)) {
				$this->Session->setFlash(__('The whitelist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whitelist could not be saved. Please, try again.'));
			}
		}
		$entities = $this->Whitelist->Entity->find('list');
		$users = $this->Whitelist->User->find('list');
		$this->set(compact('entities', 'users'));
	}
/**
 * add_by username method
 *
 * @return void
 */
	public function addbyname() {
		debug($this->request->data);
		$this->loadModel('User');
		$this->request->data['Whitelist']['user_id']=$this->User->find('first',array('conditions' => array('User.username' => $this->request->data['Whitelist']['username'])))['User']['id'];
		debug($this->request->data);
		if ($this->request->is('post') && !is_null($this->request->data['Whitelist']['user_id'])) {
			$this->Whitelist->create();
			if ($this->Whitelist->save($this->request->data)) {
				$this->Session->setFlash(__('The whitelist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whitelist could not be saved. Please, try again.'));
			}
		}
		$entities = $this->Whitelist->Entity->find('list');
		$users = $this->Whitelist->User->find('list');
		$this->set(compact('entities', 'users'));
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
		if (!$this->Whitelist->exists($id)) {
			throw new NotFoundException(__('Invalid whitelist'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Whitelist->save($this->request->data)) {
				$this->Session->setFlash(__('The whitelist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whitelist could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Whitelist.' . $this->Whitelist->primaryKey => $id));
			$this->request->data = $this->Whitelist->find('first', $options);
		}
		$entities = $this->Whitelist->Entity->find('list');
		$users = $this->Whitelist->User->find('list');
		$this->set(compact('entities', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Whitelist->id = $id;
		if (!$this->Whitelist->exists()) {
			throw new NotFoundException(__('Invalid whitelist'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Whitelist->delete()) {
			$this->Session->setFlash(__('The whitelist has been deleted.'));
		} else {
			$this->Session->setFlash(__('The whitelist could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
