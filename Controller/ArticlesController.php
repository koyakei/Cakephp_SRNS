<?php
App::uses('AppController', 'Controller');
/*App::uses('Tag', 'Model');
App::uses('User', 'Model');*/
App::uses('Link', 'Model');
//Configure::load("static");
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends AppController {
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
 * Components
 *
 * @var array
 */
	public $components = array('Search.Prg','Paginator','Common','Basic','Cookie');
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
		debug($this->Auth->user('id'));
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
		debug($this->Auth->user('id'));

		if($this->request->data['Article']['name'] != null){
			$this->Common->triarticleAdd($this,'Article',$this->Auth->user('id'),$id,$options);
			$this->Basic->social($this);
		}
		if($this->request->data['Tag']['name'] != null){
			$this->keyid = $this->request->data['Tag']['keyid'];
			$this->Common->tritagAdd($this,"Tag",$this->Auth->user('id'),$this->request->params['pass'][0]);
			$this->Basic->social($this);
		}

		$this->set('idre', $id);
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->taghashgen = $this->Article->find('first',array('conditions' => array('Article.' . $this->Article->primaryKey => $id)));

		$this->pageTitle = $this->taghashgen["Article"]['name'];
		$this->Article->read(null,$id);
		$this->set('idre', $id);
		$this->i = 0;
		$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
		$this->set('article',$this->taghashgen);
		$this->Common->SecondDem($this,"Tag","Tag.ID",$trikeyID,$id);
		$this->set('headresults', $this->returntribasic);
		$this->set('headtaghashes', $this->taghash);
		$targetID = $id;
		$this->Common->trifinderbyid($this,$id);
		$this->loadModel('User');
		$this->loadModel('Key');
		$this->set('articleresults', $this->articleparentres);
		$this->set('tagresults', $this->tagparentres);
		$this->set('taghashes', $this->taghash);
		$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
		$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
		$this->set('currentUserID', $this->Auth->user('id'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->set('currentUserID', $this->Auth->user('id'));
		$this->loadModel('User');
		$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
		if ($this->request->is('post')) {
			debug($this->request->data['Article']);
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				//return $this->redirect(array('action' => 'index'));
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
// 		if ($this->Auth->user('id') == $this->taghashgen['owner_id'] && $this->request->data('auth') !) {
// 			$this->Article->save($this->request->data('auth'));
// 		}
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
		//return $this->redirect(array('action' => 'index'));
		return $this->redirect($this->referer());
	}}
