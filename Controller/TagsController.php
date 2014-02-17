<?php

App::uses('AppController', 'Controller');/*
App::uses('Link', 'Model');
App::uses('User', 'Model');*/
Configure::load("static");
/*App::uses('Article', 'Model');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 */
/*class AppSession {
	public $usermode = 1;
	public $selected = 2138;

}*/

class TagsController extends AppController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Auth','Search.Prg','Paginator','Common','Basic','Cookie','Session',
			'Security',
			'Search.Prg','Users.RememberMe');
public $presetVars = array(
		'user_id' => array('type' => 'value'),
		'keyword' => array('type' => 'value'),
		'andor' => array('type' => 'value'),
		'from' => array('type' => 'value'),
		'to' => array('type' => 'value'),
);
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
	if ($this->request->data['keyid']['keyid'] == null){
		$this->request->data['keyid']['keyid'] = Configure::read('tagID.reply');
	}
	if ($this->request->data['keyid']['keyid'] != null){
		$this->Session->write("selected",$this->request->data['keyid']['keyid']);
		debug("case1");
	}/*elseif ($this->request->data['Tag']['keyid'] != null){
	$this->Session->write("selected",$this->request->data['Tag']['keyid']);
	echo "case2";
	}elseif ($this->request->data['Article']['keyid'] != null){
	$_SESSION['selected'] = $this->request->data['Article']['keyid'];
	echo "case3";
	}elseif ($_SESSION['selected'] == null){
	$_SESSION['selected'] = '2138';
	echo "case4";
	}*//*
	if ($this->request->data['keyid']['keyid'] == null){
	$this->request->data['keyid']['keyid'] = Configure::read('tagID.reply');
	}
	*/
	//$appSession = $this->Session->read('appSession');

}
public function isAuthorized($user) {
	if ($this->action === 'add') {
		return true;
	}

	// 投稿のオーナーは編集や削除ができる
	if (in_array($this->action, array('edit', 'delete'))) {
		$postId = $this->request->params['pass'][0];
		if ($this->Post->isOwnedBy($postId, $user['id'])) {
			return true;
		}
	}

	return parent::isAuthorized($user);
}
public $helpers = array(
 'Html',
		'Session'
);
//        public $presetVars = true;

        public function admin_view($id = null) {
        	debug("admin view");
        	$this->id =$id;
        	$this->Tag->cachedName = $this->name;
        	if($this->request->data['tagRadd']['add'] == true){
        		$this->Basic->tagRadd($this);
        		$this->Basic->social($this);
        		$this->redirect($this->referer());
        	}
        	$userID = $this->Auth->user('id');
        	if($this->request->data['Link']['quant'] != null){
        		//$this->UserID = $this->request->data['Link']['user_id'];
        		$this->Basic->quant($this);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Article']['name'] != null){
        		$this->keyid = $this->request->data['Article']['keyid'];
        		$this->Common->triarticleAdd($this,'Article',$this->request->data['Tag']['user_id']);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Tag']['name'] != null){
        		$this->keyid = $this->request->data['Tag']['keyid'];
        		$this->Common->tritagAdd($this,"Tag",$this->request->data['Tag']['user_id'],$this->request->params['pass'][0]);
        		$this->Basic->social($this);
        	}
        	$this->set('idre', $id);
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	$trikeyID = Configure::read('tagID.search');//$serchID;//tagConst()['searchID'];
        	$this->Common->SecondDem($this,"Tag","Tag.ID",$trikeyID,$id);
        	$this->set('headresults', $this->returntribasic);
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
        	$this->Tag->unbindModel(array('hasOne'=>array('TO')), false);
        	$this->set('tag', $this->Tag->find('first', $options));
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->Common->trifinderbyid($this);
        	$this->Session->write('userselected',$this->request->data['Tag']['user_id'] );
        	$this->Basic->triupperfiderbyid($this,"2183","Tag",$this->request['pass'][0]);
        	$this->set('upperIdeas', $this->returntribasic);
        }

        public function view($id = null) {
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
        	$resultForChange = $this->Tag->find('first', $options);
        	debug("no admin view");
        	$this->id =$id;
        	$this->Tag->cachedName = $this->name;
        	$userID = $this->Auth->user('id');
        	if($this->request->data['tagRadd']['add'] == true){
        		$this->Basic->tagRadd($this);
        		$this->Basic->social($this);
        		$this->redirect($this->referer());
        	}elseif ($this->request->data['Tag']['max_quant'] != null){
        		if ($this->Auth->user('id')==$resultForChange['Tag']['user_id']) {
        			$this->Tag->save($this->request->data());
        		}else {
        			debug("fail no Auth");
        		}
        	}
        	if($this->request->data['Link']['quant'] != null){
        		$this->Basic->quant($this);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Article']['name'] != null){
        		$this->keyid = $this->request->data['Article']['keyid'];
        		$this->Common->triarticleAdd($this,'Article',$this->request->data['Tag']['user_id']);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Tag']['name'] != null){
        		$this->keyid = $this->request->data['Tag']['keyid'];
        		$this->Common->tritagAdd($this,"Tag",$this->request->data['Tag']['user_id'],$this->request->params['pass'][0]);
        		$this->Basic->social($this);
        	}
        	$this->set('idre', $id);
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	$trikeyID = Configure::read('tagID.search');//$serchID;//tagConst()['searchID'];
        	$this->Common->SecondDem($this,"Tag","Tag.ID",$trikeyID,$id);
        	$this->set('headresults', $this->returntribasic);
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
        	$this->set('tag', $this->Tag->find('first', $options));
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->Common->trifinderbyid($this);
        	$this->Session->write('userselected',$this->request->data['Tag']['user_id'] );
        	$this->Basic->triupperfiderbyid($this,"2183","Tag",$this->request['pass'][0]);
        	$this->set('upperIdeas', $this->returntribasic);
        }

        /**
         * add method
         *
         * @return void
         */
        public function add() {
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->loadModel('User');
        	$max_quant = 1000;
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	if ($this->request->is('post')) {
        		$this->Tag->create();
        		$this->request->data['Tag'] += array(
        				'created' => date("Y-m-d H:i:s"),
        				'modified' => date("Y-m-d H:i:s"),
        				'max_quant' => $max_quant,
        		);
        		$this->Basic->taglimitcountup($this);
        		$this->loadModel('Auth');
        		$data['Auth'] =array('user_id' => $this->request->data['Tag']['user_id'],'tag_id' =>$this->last_id,'quant' => $max_quant);
        		$this->Auth->create();
        		$this->Auth->save($data);
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
        	$this->set('userinfo', array('ID' => $this->Auth->user('ID')));
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	if ($this->request->is(array('post', 'put'))) {
        		$this->Tag->id = $id;
        		if ($this->Tag->save($this->request->data)) {
        			$this->Session->setFlash(__('The tag has been saved.'));
        			return $this->redirect(array('action' => 'index'));
        		} else {
        			$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
        		}
        	} else {
        		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id),'order'=>'Tag.ID');
        		$this->request->data = $this->Tag->find('first', $options);
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
        	$options = array('conditions' => array(
        			'Tag.'.$this->Tag->primaryKey => $id),
        			'order' => array('Tag.ID'),
        	);
        	$reslut = $this->Tag->find('first', $options);
        	if ($reslut['Tag']['user_id'] == $this->Auth->user('id')) {
	        	$this->Tag->id = $id;
	        	if (!$this->Tag->exists()) {
	        		throw new NotFoundException(__('Invalid tag'));
	        	}
	        	$this->request->onlyAllow('post', 'delete');
	        	$this->loadModel('User');

	        	if ($this->Tag->delete()){
	        		$this->Session->setFlash(__('The article has been deleted.'));
	        		$data['User']['tlimit'] = $this->Auth->user('tlimit') + 1;
	        		$data['User']['id'] = $this->request->data['Tag']['user_id'];
	        		if($this->User->save($data)){
	        			$this->Session->setFlash(__('The tag has been deleted.残りタグ数'.$this->Auth->user('tlimit')));
	        		}else {
	        			$this->Session->setFlash(__('deleted but can not count up..残りタグ数'.$this->Auth->user('tlimit')));
	        		}
	        	} else {
	        		$this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
	        	}
        	}
        	debug($this->referer());
        	return $this->redirect($this->referer());
        }
        public function articleview($id) {
        	$this->redirect($this->referer());
        }
        /**
         * index method
         *
         * @return void
         */

        public function index() {
        	$this->Tag->recursive = 0;
        	$this->set('tags', $this->Paginator->paginate());
        }

        public function search() {
        	debug($this->Auth->user('id'));
        	$req = $this->passedArgs;
        	if (!empty($this->request->data['Tag']['keyword'])) {
        		$andor = !empty($this->request->data['Tag']['andor']) ? $this->request->data['Tag']['andor'] : null;
        		$word = $this->Tag->multipleKeywords($this->request->data['Tag']['keyword'], $andor);
        		$req = array_merge($req, array("word" => $word));
        	}
        	$this->paginate = array(
        			'Tag' =>
        			array(
        					'conditions' => array(
        							$this->Tag->parseCriteria($req),
        					)

        			)
        	);
        	$this->set('tags', $this->Paginator->paginate());
        }

        public function quant($id = null) {
        	if ($this->request->is('post')) {
        		$this->userID = $this->Auth->user('id');
        		if ($this->userID == null) {
        			$this->userID = Configure::read('acountID.admin');
        		}
        		if($this->request->data['Link']['user_id'] == $this->userID){
        			$this->loadModel('Link');
        			if ($this->Link->save($this->request->data)) {

        				$this->Session->setFlash(__('The article has been saved.'));
        			} else {
        				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
        			}
        		}
        	}
        	$this->redirect($this->referer());
        }

        public function tagdel($id = null) {
        	$this->loadModel('Link');
        	if ($this->Link->delete($this->request->data('Link.ID'))){
        		if($this->Basic->taglimitcountup($this)){
        			$this->Session->setFlash(__('削除完了.'));
        			debug("sucsess");
        		}else{
        			debug("auth fail");
        		}
        	} else {
        		$this->Session->setFlash(__('削除失敗.'));
        		debug("fail");
        	}
        	$this->redirect($this->referer());
        }

        public function tagRadd($id = null) {
        	debug($this->request->data['Link']['LTo']);
        	debug($this->request->data['tag']['userid']
        	);
        	$this->keyid = Configure::read('tagID.search');
        	$this->request->data['Tag']['user_id'] = $this->request->data['tag']['userid'];
        	$this->request->data['Link']['user_id'] = $this->request->data['tag']['userid'];
        	$LinkLTo=$this->request->data['Link']['LTo'];
        	if (!empty($this->request->data['Tag']['name'])) {
        		$this->loadModel('Tag');
        		$tagID = $this->Tag->find('first',
        				array(
        						'conditions' => array('name' => $this->request->data['Tag']['name'],
        								'user_id' => $this->request->data['Tag']['user_id']),
        						'fields' => array('Tag.ID'),
        						'order' => 'Tag.ID'
        				)
        		);
        		if($tagID == null){
        			$this->Tag->create();
        			$this->Tag->save($this->request->data);
        			$last_id = $this->Tag->getLastInsertID();
        			$this->Basic->trilinkAdd($this,$last_id,$LinkLTo,Configure::read('tagID.search'));
        			$this->Session->setFlash(__('タグがなかった.'));
        		}else {
        			$this->loadModel('Link');
        			$this->Tag->unbindModel(array('hasOne'=>array('TO')), false);
        			$this->Link->unbindModel(array('hasOne'=>array('LO')), false);
        			$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
        			$this->Basic->tribasicfixverifybyid($this,$trikeyID,$LinkLTo);
        			$LE = $this->returntribasic;
        			if(null == $LE){
        				$tagIDd = $tagID['Tag']['ID'];
        				$this->Basic->trilinkAdd($this,$tagIDd,$LinkLTo,$trikeyID);
        				$this->Session->setFlash(__('タグ既存リンク追加'));
        			}else{
        				$this->Session->setFlash(__('関連付け済み'));
        			}
        		}
        	}else {
        		$this->Session->setFlash(__('データなし'));
        	}

        	//$this->redirect(array('controller' => 'tags','action'=>'view',$this->request->data['tag']['idre']));
        	//$this->redirect($this->referer());
        }

        public function result($id = null) {
        	$this->Common->trifinder($this);
        	$this->set('idre', $id);
        }

        /*
         public function reply($articleID) {
        if (!$this->Tag->exists($tagID)) {
        throw new NotFoundException(__('関連タグが存在しない'));
        }
        $sql = "SELECT  `article` . *, `LINK`.`ID` AS LinkID FROM  `LINK` INNER JOIN  `LINK` AS tagLink ON  `LINK`.`ID` = `tagLink`.`LTo`, `article`  WHERE  `LINK`.`LFrom` =$tagID AND `tagLink`.`LFrom` =2138  AND `article` . `ID` = `LINK` . `LTo`";
        $sqlres = $this->Tag->query($sql);
        $this->set('results', $sqlres);
        }
        */
        public function replytagadd($id = null) {

        }
        /**
         * view method
         *
         * @throws NotFoundException
         * @param string $id
         * @return void
         */
        public function triarticleadd($id = null) {
        	$this->Common->triarticleAdd($this);
        	$this->redirect($this->referer());
        }
        public function logout() {
        	$user = $this->Auth->user();
        	$this->Cookie->destroy();
        	$this->Session->destroy();
        	if (isset($_COOKIE[$this->Cookie->name])) {
        		$this->Cookie->destroy();
        	}
        	$this->RememberMe->destroyCookie();
        	$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged out'), $user[$this->{$this->modelClass}->displayField]));
        	$this->redirect("/tags/search");
        }
        public function test2(&$that){
        	debug($that->referer());
        	$that->redirect($that->referer());
        }
        public function test(){
        	debug($this->referer());
        	$this->redirect($this->referer());
        }
}
