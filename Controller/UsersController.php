<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Security->validatePost = false;
		$this->Auth->allow('logout');
		$this->Auth->authenticate = array(
				'Basic' => array('user' => 'admin'),
				//'Form' => array('user' => 'Member')
		);
	}

	public function index() {
		debug($this->Auth->user('id'));
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	function search(){
		if ( $this->RequestHandler->isAjax() ) {
			Configure::write ( 'debug', 0 );
			$this->autoRender=false;
			$users=$this->User->find('all',array('conditions'=>array('User.username LIKE'=>'%'.$_GET['term'].'%')));
			$i=0;
			foreach($users as $user){
				$response[$i]['value']=$user['User']['username'];
				$response[$i]['label']="<img class=\"avatar\" width=\"24\" height=\"24\" src=".$user['User']['profile_pictures']."/><span class=\"username\">".$user['User']['username']."</span>";
				$i++;
			}
			echo json_encode($response);
		}else{
			if (!empty($this->data)) {
				$this->set('users',$this->paginate(array('User.username LIKE'=>'%'.$this->data['User']['username'].'%')));
			}
		}
	}
	/**
	 * follow method
	 *
	 * @throws NotFoundException
	 * There is not such user.
	 * @param string $user_id
	 * I will follow this.
	 * @return true
	 * already followed
	 * @return false
	 * can't follow
	 */
	public function follow($user_id){
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
// 		if ($this->followCheck($this->Auth->user('id'),$user_id)) {
			$Follow = new Follow();
			return $Follow->save(
				array('Follow' =>
					array(
						'user_id'=> $user_id,
						'target' => $this->Auth->user('id')
					)
				)
			);
// 		}
		return false;
	}

	/**
	 * followCheck method
	 *
	 *
	 * @param string $user_id
	 * I will follow this.
	 * @return true
	 * already followed
	 * @return false
	 * can't follow
	 */
	private function followCheck(&$follow_target,&$follower){
		$Follow = new Follow();
		return $Follow->find('first',array(
				'conditions' => array('Follow.user_id' => $follower,'Follow.target'=>$follow_target)
			)
		);
	}



	public function autoSuggest() {
		$this->layout = 'ajax';
		$data = ''; $json = '';
		if(!empty($this->params['url']['q'])){
			$options = array(
					'field'     =>array('User.id','User.name'),
					'conditions' => array('or'=> array(
							array('User.kana LIKE ?' => $this->params['url']['q'].'%'),
							array('User.name LIKE ?' => $this->params['url']['q'].'%')
					),
					),
					'limit'     =>10
			);
			$datas = $this->User->find('list', $options);

			foreach($datas as $key=>$val){
				$data .= $val.'|'.$key."\n";
			}
		}
		$this->set('json', $data);
		$this->render('ajax_suggest');
	}
}
