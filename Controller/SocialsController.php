<?php
App::uses('AppController', 'Controller');
Configure::load('static');
/**
 * Socials Controller
 *
 * @property Social $Social
 * @property PaginatorComponent $Paginator
 */
class SocialsController extends AppController {
	public $uses = array(//'Tag','Article','Link','User'
	);
	 public function beforeFilter(){
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
	public $components = array('Auth','Search.Prg','Paginator','Common','Basic','Cookie','Session',
			'Security',
			'Search.Prg','Users.RememberMe');

/**
 * index method
 *
 * @return void
 */
	public function myfollow() {

		debug($this->Auth->user('id'));
		$this->Social->recursive = 0;
			$this->Paginator->settings = array(
				'condition' => array(
				"user_id = Configure::read('acountID.admin')"
			)
		);
		$this->set('socials', $this->Paginator->paginate());
	}

/**
 * index method
 *
 * @return void
 */
	public function test(){
		//$this->redirect($this->referer());
		$this->Basic->test($this);
	}
	public function index() {
		$this->Social->recursive = 0;
		$this->set('socials', $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Social->exists($id)) {
			throw new NotFoundException(__('Invalid social'));
		}
		$options = array('conditions' => array('Social.' . $this->Social->primaryKey => $id));
		$this->set('social', $this->Social->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Social->create();
			if ($this->Social->save($this->request->data)) {
				$this->Session->setFlash(__('The social has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The social could not be saved. Please, try again.'));
			}
		}
		$users = $this->Social->User->find('list');
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
		if (!$this->Social->exists($id)) {
			throw new NotFoundException(__('Invalid social'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Social->save($this->request->data)) {
				$this->Session->setFlash(__('The social has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The social could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Social.' . $this->Social->primaryKey => $id));
			$this->request->data = $this->Social->find('first', $options);
		}
		$users = $this->Social->User->find('list');
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
		$this->Social->id = $id;
		if (!$this->Social->exists()) {
			throw new NotFoundException(__('Invalid social'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Social->delete()) {
			$this->Session->setFlash(__('The social has been deleted.'));
		} else {
			$this->Session->setFlash(__('The social could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
