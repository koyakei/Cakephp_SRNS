<?php
App::uses('AppController', 'Controller');
/**
 * Tagauths Controller
 *
 * @property Tagauth $Tagauth
 * @property PaginatorComponent $Paginator
 */
class TagauthsController extends AppController {

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
		$this->Tagauth->recursive = 0;
		$this->set('tagauths', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tagauth->exists($id)) {
			throw new NotFoundException(__('Invalid tagauth'));
		}
		$options = array('conditions' => array('Tagauth.' . $this->Tagauth->primaryKey => $id));
		$this->set('tagauth', $this->Tagauth->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tagauth->create();
			if ($this->Tagauth->save($this->request->data)) {
				$this->Session->setFlash(__('The tagauth has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tagauth could not be saved. Please, try again.'));
			}
		}
		$users = $this->Tagauth->User->find('list');
		$tags = $this->Tagauth->Tag->find('list');
		$this->set(compact('users', 'tags'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Tagauth->exists($id)) {
			throw new NotFoundException(__('Invalid tagauth'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tagauth->save($this->request->data)) {
				$this->Session->setFlash(__('The tagauth has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tagauth could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tagauth.' . $this->Tagauth->primaryKey => $id));
			$this->request->data = $this->Tagauth->find('first', $options);
		}
		$users = $this->Tagauth->User->find('list');
		$tags = $this->Tagauth->Tag->find('list');
		$this->set(compact('users', 'tags'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Tagauth->id = $id;
		if (!$this->Tagauth->exists()) {
			throw new NotFoundException(__('Invalid tagauth'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tagauth->delete()) {
			$this->Session->setFlash(__('The tagauth has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tagauth could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
