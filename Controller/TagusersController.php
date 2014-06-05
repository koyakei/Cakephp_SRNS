<?php
App::uses('AppController', 'Controller');
App::uses('Article','Model');
App::uses('Tag','Model');
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
	public $components = array('Paginator','Basic','Common','RequestHandler');

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
			if ($id < Configure::read('tagID.End')) {
				$firstModel = 'Tag';

			}else {
				$firstModel = 'Article';
			}
			$this->loadModel($firstModel);
			$headresult = $this->{$firstModel}->find('first',
					array('conditions' => array(
							$firstModel.'.ID' => $id)));
			$this->set('headresult', $headresult);
			$this->set('firstModel',$firstModel);
	}
	public function anonymous_mapt($id = null){
		$this->set('id',$id);
	}
	public function addentity(){
// 		$_REQUEST[$entitiy];
// 		$this->Taguser->find('all',array('conditions' => array('Tagusers.ID' => $_REQUEST[$entitiy])));
		if($_REQUEST['trikey_username'] ==null){
			$res = $this->Taguser->find('first',
						array('conditions' =>
								array('Taguser.name' =>$_REQUEST['label'])
						)
				);
	}else {
			$this->Taguser->find('first',

					array('conditions' =>
							array('Taguser.name' =>$_REQUEST['label'],'Taguser.username'=>$_REQUEST['trikey_username'])
					)
			);
	}
		$options['authCheck'] = false;

			//成功したら、成功した情報を返す。
// 		$this->render('addEntity', 'ajax');
		$this->set('json', $this->Basic->trilinkAdd($this,$_REQUEST['from'],$_REQUEST['to'],$res['Taguser']['ID'],$options));
		$this->layout = 'ajax';

	}
	/**
	 * addnode method
	 * ft tf return both
	 * @throws NotFoundException
	 * @param int $this->params['url']['id']
	 * @param int $this->params['url']['keyid']
	 * @return ajax
	 */

	public function addnode(){

	}

	/**
	 * map method
	 * ft tf return both
	 * @throws NotFoundException
	 * @param int $this->params['url']['id']
	 * @param int $this->params['url']['keyid']
	 * @return ajax
	 */

	public function map() {
// 		$to = $this->Link->find('all',
// 				array('conditions' => array('Taguser.'. $this->primaryKey => $id) //from と　toに分けるか？
// 		));
		$FT['Article'] = $this->Basic->tribasicfiderbyid($that,null,"Article","Article.ID",$this->params['url']['id']);
		$FT['Tag'] = $this->Basic->tribasicfiderbyid($that,null,"Tag","Tag.ID",$this->params['url']['id']);
		foreach ($this->Basic->tribasicfiderbyidTF($that,null,"Tag","Tag.ID",$this->params['url']['id']) as $val ){$FT['Tag'][] = $val;}
		foreach ($this->Basic->tribasicfiderbyidTF($that,null,"Article","Article.ID",$this->params['url']['id']) as $val ){$FT['Article'][] = $val;}
// array_merge($FT['Tag'],$this->Basic->tribasicfiderbyidTF($that,null,"Tag","Tag.ID",$this->params['url']['id']));
// array_merge($FT['Article'],$this->Basic->tribasicfiderbyidTF($that,null,"Article","Article.ID",$this->params['url']['id']));
// 		$FT['Article'] = $this->Basic->tribasicfiderbyidFTTF($that,null,"Tag","Tag.ID",$this->params['url']['id']);
// 		$FT['Article'] = $this->Basic->tribasicfiderbyidFTTF($that,null,"Article","Article.ID",$this->params['url']['id']);
		//制限要素　user_id.trikey_id

// 		$this->set('TF', $TF);
		$this->set('FT', $FT);
		$this->response->type('json');
		$this->layout = 'ajax';
	}
	/**
	 * venn method
	 *
	 * @param string $id
	 * @return array
	 */
	public function venn($id = NULL){
		$this->Taguser->find('all',array('conditions' => ));
		$this->set('results', $results);
		$this->response->type('json');
		$this->layout = 'ajax';
	}

	public function vennt($id = NULL){
		$this->set('id',$id);
	}

	public function maptf() {
		$this->set('TF', $TF);
		$this->response->type('json');
		$this->layout = 'ajax';
	}
	/**
	 * map method
	 * ft tf return both
	 * @throws NotFoundException
	 * @param int $this->params['url']['id']
	 * @param int $this->params['url']['keyid']
	 * @return ajax
	 */
	public function mapft() {
		if ($id >= Configure::read('tagID.End')) {
			$this->Basic->tribasicfiderbyid($that,$this->params['url']['keyid'],"Article","Article.ID",$this->params['url']['id']);
		}else {
			$this->Basic->tribasicfiderbyid($that,$this->params['url']['keyid'],"Tag","Tag.ID",$this->params['url']['id']);
		}
		$JSON = array('ID'=>$this->params['url']['keyid'],'name' => $value ,'head' =>$this->taghash,'tag' =>$this->articleparentres, 'article'=>$this->tagparentres);
		$this->set('JSON', $JSON);
		$this->response->type('json');
		$this->layout = 'ajax';
	}


}
