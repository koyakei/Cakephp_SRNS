<?php
App::uses('AppController', 'Controller');
/**
 * Socialusers Controller
 *
 * @property Socialuser $Socialuser
 * @property PaginatorComponent $Paginator
 */
class SocialusersController extends AppController {

/*	public $paginate = array(
			'order' => array('Socialuser.created =' => 'desc'),

	);*/

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('logout');
		$this->Auth->authenticate = array(
				'Basic' => array('user' => 'admin'),
				//'Form' => array('user' => 'Member')
		);
		$this->Security->validateOnce = false;
		$this->Security->validatePost = false;
		$this->Security->csrfCheck = false;

	}
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
/**
 * myfollow method
 *
 * @return void
 */

	public function myfollow() {
		$this->Paginator->settings = array(

				'conditions' => array(
						"Socialuser.user_id" => $this->Auth->user('id')),
				'order' => array('Socialuser.created' => 'desc')
		);
		$this->set('socialusers', $this->Paginator->paginate());
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Socialuser->recursive = 0;
		$this->set('socialusers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Socialuser->exists($id)) {
			throw new NotFoundException(__('Invalid socialuser'));
		}
		$options = array('conditions' => array('Socialuser.' . $this->Socialuser->primaryKey => $id));
		$this->set('socialuser', $this->Socialuser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Socialuser->create();
			if ($this->Socialuser->save($this->request->data)) {
				$this->Session->setFlash(__('The socialuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The socialuser could not be saved. Please, try again.'));
			}
		}
		$users = $this->Socialuser->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Socialuser->exists($id)) {
			throw new NotFoundException(__('Invalid socialuser'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Socialuser->save($this->request->data)) {
				$this->Session->setFlash(__('The socialuser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The socialuser could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Socialuser.' . $this->Socialuser->primaryKey => $id));
			$this->request->data = $this->Socialuser->find('first', $options);
		}
		$users = $this->Socialuser->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Socialuser->id = $id;
		if (!$this->Socialuser->exists()) {
			throw new NotFoundException(__('Invalid socialuser'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Socialuser->delete()) {
			$this->Session->setFlash(__('The socialuser has been deleted.'));
		} else {
			$this->Session->setFlash(__('The socialuser could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
