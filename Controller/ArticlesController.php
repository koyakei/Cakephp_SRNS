<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends AppController {
	public $uses = array('Article');
	public $paginate = array( 'limit' => 25);
	 public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('view');
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
		$this->Article->recursive = 0;
		$this->set('articles', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if ($this->request->is('post')) {
			$this->Article->create();
			$this->userID = $this->Auth->user('ID');
			debug($this->Auth->user());
			$this->request->data['article']['user_id'] = $this->userID;
			debug($this->userID);
			if ($this->Article->save($this->request->data)) {
				$this->last_id = $this->Article->getLastInsertID();
				$this->request->data = null;
				$this->request->data['Link'] = array(
					'user_id' => 1,
					'LFrom' => $id,//2138
					'LTo' => $this->last_id,
					'quant' => 1,
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
				);
				$this->Link->create();
				if ($this->Link->save($this->request->data)) {
				$this->last_id = $this->Link->getLastInsertID();
				$this->request->data = null;
				$this->request->data['Link'] = array(
					'user_id' => 1,
					'LFrom' => 2138,//
					'LTo' => $this->last_id,
					'quant' => 1,
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
				);
				$this->Link->create();
					if ($this->Link->save($this->request->data)) {
						$this->Session->setFlash(__('The article has been saved.'));
					
					} else {
						$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
					}
				}
			}
		}
	$this->Article->recursive = 3;

		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
	$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
	$this->Article->read(null,$id);
	$targetID = $id;
	$trikeyID = tagConst()['replyID'];
	$this->set('article', $this->Article->find('first', $options));
	$this->Paginator->settings = array(
		'conditions'=> array(
		        	"Link.LFrom = $targetID"
	        	 ),
		'fields' => array('Article.*', 'Link.*'),
		'joins'
		 => array(
		array(
                     'table' => 'Link',
                    //'alias' => 'Link',
                    'type' => 'INNER',
                    'conditions' => array("Link.LTo = Article.ID")
                ),
		array(
                    'table' => 'Link',
                    'alias' => 'taglink',
                    'type' => 'INNER',
                    'conditions' => array(
			array("Link.ID = taglink.LTo"),
			array("$trikeyID = taglink.LFrom")
			)
                ),
		)
	);
	$this->set('results',$this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Article->create();
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
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
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
			$this->request->data = $this->Article->find('first', $options);
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
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Article->delete()) {
			$this->Session->setFlash(__('The article has been deleted.'));
		} else {
			$this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
