<?php
App::uses('AppController', 'Controller');
/**
 * Keys Controller
 *
 * @property Key $Key
 * @property PaginatorComponent $Paginator
 */
class KeysController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
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
	public $components = array('Search.Prg','Paginator','Common','Basic','Cookie','Session');
	public $helpers = array(
			'Html',
			'Session'
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Key->recursive = 0;
		$this->set('keys', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Key->exists($id)) {
			throw new NotFoundException(__('Invalid key'));
		}
		$options = array('conditions' => array('Key.' . $this->Key->primaryKey => $id));
		$this->set('key', $this->Key->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Key->create();
			if ($this->Key->save($this->request->data)) {
				$this->Session->setFlash(__('The key has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The key could not be saved. Please, try again.'));
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
		if (!$this->Key->exists($id)) {
			throw new NotFoundException(__('Invalid key'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Key->save($this->request->data)) {
				$this->Session->setFlash(__('The key has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The key could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Key.' . $this->Key->primaryKey => $id));
			$this->request->data = $this->Key->find('first', $options);
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
		$this->Key->id = $id;
		if (!$this->Key->exists()) {
			throw new NotFoundException(__('Invalid key'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Key->delete()) {
			$this->Session->setFlash(__('The key has been deleted.'));
		} else {
			$this->Session->setFlash(__('The key could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
