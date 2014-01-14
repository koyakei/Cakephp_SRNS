<?php
App::uses('AppController', 'Controller');
App::uses('Link','Model');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends AppController {
	public $uses = array('link'j
	public $paginate = array( 'limit' => 25);
	 public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
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
			$this->request->data['article']['owner_id'] = $this->Auth->user('ID');
			if ($this->Article->save($this->request->data)) {
				$last_id = $this->Article->getLastInsertID();
				if ($this->Link->save($this->data)) {
					
					$this->Session->setFlash(__('The article has been saved.'));
					return $this->redirect(array('action' => 'index'));
				
				} else {
					$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
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
	$this->set('article', $this->Article->find('first', $options));
	$this->Paginator->settings = array(
		'conditions'=> array(
		        	"link.LFrom = $targetID"
	        	 ),
		'fields' => array('article.*', 'link.*'),
		'joins'
		 => array(
		array(
                     'table' => 'link',
                    //'alias' => 'usr',
                    'type' => 'INNER',
                    'conditions' => array("link.LTo = Article.ID")
                ),
		array(
                    'table' => 'link',
                    'alias' => 'taglink',
                    'type' => 'INNER',
                    'conditions' => array(
			array("link.ID = taglink.LTo"),
			array("tagConst()['relyID'] = taglink.LFrom")
			)
                ),
		)
	);
	$this->set('results',$this->Paginator->paginate());
debug($this->Paginator->paginate());
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
