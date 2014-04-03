<?php
App::import('Vendor', 'DebugKit.FireCake');
App::uses('AppController', 'Controller');
App::uses('Link', 'Model');
App::uses('User', 'Model');
Configure::load("static");
App::uses('Article','Model');
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
	//public $pagination =  $this->paginator->sort('modified', 'desc');

/**
 * Components
 *
 * @var array
 */
public $components = array('Auth','Search.Prg','Paginator','Common','Basic','Cookie','Session',
			'Security','Authpaginator',
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
	App::import('Model', 'User');
	User::store($this->Auth->user());
	$this->Auth->allow('logout','search');
	$this->Auth->authenticate = array(
			'Basic' => array('user' => 'admin'),
			//'Form' => array('user' => 'Member')
	);
	$this->Security->validateOnce = false;
	$this->Security->validatePost = false;
	$this->Security->csrfCheck = false;

}
	public function isAuthorized($user) {

		// 投稿のオーナーは編集や削除ができる
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = $this->request->params['pass'][0];
			if ($this->Tag->isOwnedBy($postId, $user['id'])) {
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

		/**
		 * index method
		 *
		 * @return void
		 */

		public function index() {
			$this->loadModel('Article');
// 			$query = array('order'=> array('Tag.modified' => 'DESC'));
			$this->set('tags', $this->paginate('Article',array('order'=> array('Tag.modified' => 'DESC'))));
		}
        /**
         * view method
         *
         * @throws NotFoundException
         * @param string $id
         * @param string $trikeyID
         * @return void
         */
        public function view($id = null) {
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
        	$resultForChange = $this->Tag->find('first', $options);
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
        		$options['key'] = $this->request->data['Article']['keyid'];
        		debug($this->request->data);
        		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Tag']['name'] != null){
        		debug($this->request->data);
        		$options['key'] = $this->request->data['Tag']['keyid'];
        		$this->Common->tritagAdd($this,"Tag",$this->request->data['Tag']['user_id'],$id,$options);
        		$this->Basic->social($this);
        	}
        	$this->set('idre', $id);
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	$this->request->data['keyid']['keyid'] =$trikeyID;
        	if ($trikeyID == NULL){//$serchID;//tagConst()['searchID'];
        		$trikeyID = Configure::read('tagID.search');
        	}
        	$this->Common->SecondDem($this,"Tag","Tag.ID",Configure::read('tagID.search'),$id);
        	$this->set('headresults', $this->returntribasic);
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
        	$this->set('tag', $this->Tag->find('first', $options));
        	$this->set('currentUserID', $this->Auth->user('id'));

        	$this->Session->write('userselected',$this->request->data['Tag']['user_id'] );
        	$this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Tag",$id);
        	$this->set('upperIdeas', $this->returntribasic);
        	$this->set('trikeyID', $trikeyID);
        	$this->loadModel('User');
        	$this->loadModel('Key');
        	$key = $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name')));
        	$this->set( 'keylist', $key);
        	$i = 0;
        	foreach ($key as $key => $value){
        		$options = array('key' => $key);
        		$this->Common->trifinderbyid($this,$id,$options);
	        	$tableresults[$i] = array('ID'=>$key,'name' => $value ,'head' =>$this->taghash,'tag' =>$this->articleparentres, 'article'=>$this->tagparentres);
	        	$i++;
        	}
        	$this->set('tableresults', $tableresults);;

        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));

        }
        /**
         * transmitter method
         *
         * @return void
         */
        public function transmitter($leftID = null,$leftKeyID = null,$rightID = null,$rightKeyID = null ){
			//view method を読み込む　左
			//左右を同じelemrnt で構成する　その画面を呼び出す方法を考える。
			//ページを固定したまま検索する方法を考える。
			//togetter の左は編集先になっている。
			//debug($this->request->data['to']);
        	//debug($this->request->data['from']);
        	debug($this->request->data);
        	$model_name = array_slice($this->request->data['from'], 0,0);

        		$this->Common->trasmitterDiff($this,$leftID,$leftKeyID,$model_name);


        	if($this->request->data['Tag']['lr'] == "left"){
        		$leftID = null;
        		$leftKeyID = null;
				$this->psearch($this);

				$this->set('lefttagresults', $this->Paginator->paginate());
				//left $leftID $leftKeyID del
        	}elseif ($this->request->data['Tag']['lr'] == "right") {
        		debug("isrs");
        		$rghitID = null;
        		$rightKeyID = null;
        		$this->psearch($this);
        		$this->set('righttagresults', $this->Paginator->paginate());
				//left $rightID $rightKeyID del
        	}//else{
        		$this->loadModel('Article');
        		if($rightID == null ){
        			$newart = $this->Article->find('all',array('order'=> array('Article.modified' => 'desc'),'limit' => 30));
        			$this->set('rightarticleresults', //$this->paginate('Article',$options)
        					$newart
        			);
        		} else {
        			if ($rightID != null or $rightID != 0) {
        				$options = array('key' => $leftKeyID);
        				$this->Common->trifinderbyid($this,$rightID,$options);
        				$this->set('righttaghashes', $this->taghash);
        				$this->set('rightarticleresults', $this->articleparentres);
        				$this->set('righttagresults', $this->tagparentres);
        				if ($rightID <= 100000) {
	        				$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $rightID),'order' => array('Tag.ID'));
	        				$rightheadresults = $this->Tag->find('first', $options);
        				} else {
        					$options = array('conditions' => array('Article.'.$this->Article->primaryKey => $rightID),'order' => array('Article.ID'));
        					$rightheadresults = $this->Article->find('first', $options);
        				}
        				$this->set('rightheadresults', $rightheadresults);
        				if(array_key_exists ( 'Tag' , $rightheadresults )){
        					$this->set('rightheadmodel', 'Tag');
        				}else {
        					$this->set('rightheadmodel', 'Article');
        				}
        			}

        		}
        	//}
    			if ($leftID != null and $leftID != 0) {
					$options = array('key' => $leftKeyID);
		        	$this->Common->trifinderbyid($this,$leftID,$options);
		        	$this->set('lefttaghashes', $this->taghash);
		        	$this->set('leftarticleresults', $this->articleparentres);
		        	$this->set('lefttagresults', $this->tagparentres);
		        		if ($leftID < 100000) {
	        				$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $leftID),'order' => array('Tag.ID'));
	        				$leftheadresults = $this->Tag->find('first', $options);
        				} else {
        					$options = array('conditions' => array('Article.'.$this->Article->primaryKey => $leftID),'order' => array('Article.ID'));
        					$leftheadresults = $this->Article->find('first', $options);
        				}
					$this->set('leftheadresults', $leftheadresults);
					if(array_key_exists ( 'Tag' , $leftheadresults )){
						$this->set('leftheadmodel', 'Tag');
					}else {
						$this->set('leftheadmodel', 'Article');
					}
				}

			/*$options = array('order' => array(
            'Article.modified' => 'desc'
        ));*/

        	//}
        	$this->loadModel('User');
        	$this->loadModel('Key');
        	$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('leftID', $leftID);
        	$this->set('leftKeyID', $leftKeyID);
        	$this->set('rightID', $rightID);
        	$this->set('rightKeyID', $rightKeyID);
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
        		$data['Auth'] =array('user_id' => $this->request->data['Tag']['user_id'],'tag_id' =>$this->last_id,'quant' => $max_quant);
        		$this->loadModel('Auth');
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
        	//$this->set('idre', $id);
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
        		debug($this->request->data['W']);
        		$this->set('users', $this->request->data['W']);
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
        	print_r("戻るで戻って");
        	return $this->redirect($this->referer());
        }
        public function articleview($id) {
        	$this->redirect($this->referer());
        }

        /**
         * psearch method
         *
         * @return $tagresult
         */
        private function psearch(&$that){
        	$req = $that->passedArgs;
        	if (!empty($that->request->data['Tag']['keyword'])) {
        		$andor = !empty($that->request->data['Tag']['andor']) ? $that->request->data['Tag']['andor'] : null;
        		$word = $that->Tag->multipleKeywords($that->request->data['Tag']['keyword'], $andor);
        		$req = array_merge($req, array("word" => $word));
        	}
        	$that->paginate = array(
        			'Tag' =>
        			array(
        					'conditions' => array(
        							$that->Tag->parseCriteria($req),
        					)

        			)
        	);

        }
        /**
         * articlelist method
         *
         * @return void
         */
public function articletransmitter($leftID = null,$leftKeyID = null){
			//view method を読み込む　左
			//左右を同じelemrnt で構成する　その画面を呼び出す方法を考える。
			//ページを固定したまま検索する方法を考える。
			//togetter の左は編集先になっている。
        	if($this->request->data['from'] == null){
        		$this->request->data['from'] = array();
        	}
        	if($this->request->data['to'] == null){
        		$this->request->data['to'] = array();
        	}
        	$diff =array_diff ($this->request->data['to']['Article'],$this->request->data['from']['Article'] );
        	debug($diff);
        	$options['key'] = $leftKeyID;
			foreach ($diff as $var){
				debug($var['ID']);
				 $ToID= $var['ID'];
				$this->Common->triAddbyid($this,$this->Auth->user('id'),$leftID,$ToID,$options);
			}
        	if($this->request->data['Tag']['lr'] == "left"){
        		$leftID = null;
        		$leftKeyID = null;
				$this->psearch($this);
				$this->set('lefttagresults', $this->Paginator->paginate());
				//left $leftID $leftKeyID del
        	}
    		if ($leftID != null and $leftID != 0) {
				$options = array('key' => $leftKeyID);
	        	$this->Common->trifinderbyid($this,$leftID,$options);
	        	$this->set('lefttaghashes', $this->taghash);
	        	$this->set('leftarticleresults', $this->articleparentres);
	        	$this->set('lefttagresults', $this->tagparentres);
				$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $leftID),'order' => array('Tag.ID'));
				$this->set('leftheadresults', $this->Tag->find('first', $options));
			}
			//$this->Article->recursive = 0;
			//$conditions = array();//array('order' => array('Article.modified' => 'asc'));

			//$this->set('rightarticleresults', $this->paginate('Article',array()));
			$this->loadModel('Article');
			if($rightID == null ){
				$this->set('rightarticleresults', //$this->paginate('Article',$options)
						$this->Article->find('all',array('order'=> array('Article.modified' => 'desc'),'limit' => 30))
				);
			}
        	$this->loadModel('User');
        	$this->loadModel('Key');
        	$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('leftID', $leftID);
        	$this->set('leftKeyID', $leftKeyID);
        }



        /**
         * search method
         *
         * @return $tagresult
         */

        public function search() {
        	$this->psearch($this);
        	$this->set('tags', $this->Authpaginator->paginate());

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
        	//$options = array('conditions' => array('.'.$this->Aurh->primaryKey => $this->request->data['Tag']['']));
        	//$this->Link->find('first',$option);
        	debug($this->request->data('Link.ID'));
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

        public function result($id = null) {
        	$this->Common->trifinder($this);
        	$this->set('idre', $id);
        }
        public function replytagadd($id = null) {

        }

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
}