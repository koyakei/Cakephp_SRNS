<?php
App::uses('AppController', 'Controller');

/**
 * Links Controller
 *
 * @property Link $Link
 * @property PaginatorComponent $Paginator
 */
class LinksController extends AppController {
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
	public $components = array('Search.Prg','Paginator','Common','Basic');

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
	}}
