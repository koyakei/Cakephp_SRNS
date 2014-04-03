<?php
App::uses('AppController', 'Controller');
/**
 * Whiteusers Controller
 *
 * @property Whiteuser $Whiteuser
 * @property PaginatorComponent $Paginator
 */
class WhiteusersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function isAuthorized($user) {
		// 登録済ユーザーは投稿できる
		if ($this->action === 'add'|| $this->action === 'transmitter') {
			return true;
		}

		// 投稿のオーナーは編集や削除ができる
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = (int) $this->request->params['pass'][0];
			if ($this->Article->isOwnedBy($postId, $user['id'])) {
				return true;
			}else {
				$this->redirect($this->referer());
			}
		}

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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Whiteuser->recursive = 0;
		$this->set('whiteusers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Whiteuser->exists($id)) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		$options = array('conditions' => array('Whiteuser.' . $this->Whiteuser->primaryKey => $id));
		$this->set('whiteuser', $this->Whiteuser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Whiteuser->create();
			if ($this->Whiteuser->save($this->request->data)) {
				$this->Session->setFlash(__('The whiteuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whiteuser could not be saved. Please, try again.'));
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
		if (!$this->Whiteuser->exists($id)) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Whiteuser->save($this->request->data)) {
				$this->Session->setFlash(__('The whiteuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whiteuser could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Whiteuser.' . $this->Whiteuser->primaryKey => $id));
			$this->request->data = $this->Whiteuser->find('first', $options);
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
		$this->Whiteuser->id = $id;
		if (!$this->Whiteuser->exists()) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Whiteuser->delete()) {
			$this->Session->setFlash(__('The whiteuser has been deleted.'));
		} else {
			$this->Session->setFlash(__('The whiteuser could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Whiteuser->recursive = 0;
		$this->set('whiteusers', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Whiteuser->exists($id)) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		$options = array('conditions' => array('Whiteuser.' . $this->Whiteuser->primaryKey => $id));
		$this->set('whiteuser', $this->Whiteuser->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Whiteuser->create();
			if ($this->Whiteuser->save($this->request->data)) {
				$this->Session->setFlash(__('The whiteuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whiteuser could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Whiteuser->exists($id)) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Whiteuser->save($this->request->data)) {
				$this->Session->setFlash(__('The whiteuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The whiteuser could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Whiteuser.' . $this->Whiteuser->primaryKey => $id));
			$this->request->data = $this->Whiteuser->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Whiteuser->id = $id;
		if (!$this->Whiteuser->exists()) {
			throw new NotFoundException(__('Invalid whiteuser'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Whiteuser->delete()) {
			$this->Session->setFlash(__('The whiteuser has been deleted.'));
		} else {
			$this->Session->setFlash(__('The whiteuser could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
