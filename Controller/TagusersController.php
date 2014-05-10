<?php
App::uses('AppController', 'Controller');
/**
 * Tagusers Controller
 *
 * @property Taguser $Taguser
 * @property PaginatorComponent $Paginator
 */
class TagusersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Basic','Common');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Taguser->recursive = 0;
		$this->set('tagusers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Taguser->exists($id)) {
			throw new NotFoundException(__('Invalid taguser'));
		}
		$options = array('conditions' => array('Taguser.' . $this->Taguser->primaryKey => $id));
		$this->set('taguser', $this->Taguser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Taguser->create();
			if ($this->Taguser->save($this->request->data)) {
				$this->Session->setFlash(__('The taguser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The taguser could not be saved. Please, try again.'));
			}
		}
		$users = $this->Taguser->User->find('list');
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
		if (!$this->Taguser->exists($id)) {
			throw new NotFoundException(__('Invalid taguser'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Taguser->save($this->request->data)) {
				$this->Session->setFlash(__('The taguser has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The taguser could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Taguser.' . $this->Taguser->primaryKey => $id));
			$this->request->data = $this->Taguser->find('first', $options);
		}
		$users = $this->Taguser->User->find('list');
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
		$this->Taguser->id = $id;
		if (!$this->Taguser->exists()) {
			throw new NotFoundException(__('Invalid taguser'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Taguser->delete()) {
			$this->Session->setFlash(__('The taguser has been deleted.'));
		} else {
			$this->Session->setFlash(__('The taguser could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function auto_complete() {
		$terms = $this->Taguser->find('all', array(
				'conditions' => array(
						'Taguser.name LIKE BINARY' => '%'.$this->params['url']['autoCompleteText'].'%'
				),
				'fields' => array('ID' ,'name','username'),
				'limit' => 3,
				'recursive'=>1,
		));
		$terms = Set::Extract($terms,'{n}.Taguser');
		$this->set('terms', $terms);
		        	$this->layout = 'ajax';
	}
	public function mapt($id = null){
			$this->set('id',$id);
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */

	public function map() {
// 		$to = $this->Link->find('all',
// 				array('conditions' => array('Taguser.'. $this->primaryKey => $id) //from と　toに分けるか？
// 		));
		$FT['Article'] = $this->Basic->tribasicfiderbyid($that,null,"Article","Article.ID",$this->params['url']['id']);
		$FT['Tag'] = $this->Basic->tribasicfiderbyid($that,null,"Tag","Tag.ID",$id);
// 		$TF['Tag'] = $this->Basic->tribasicfiderbyidTF($that,null,"Tag","Tag.ID",$id);
// 		$TF['Article'] = $this->Basic->tribasicfiderbyidTF($that,null,"Article","Article.ID",$id);
		//制限要素　user_id.trikey_id

// 		$this->set('TF', $TF);
		$this->set('FT', $FT);
		$this->layout = 'ajax';
	}

}
