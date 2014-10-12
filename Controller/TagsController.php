<?php
App::import('Vendor', 'DebugKit.FireCake');
App::uses('AppController', 'Controller');
App::uses('Link', 'Model');
App::uses('User', 'Model');
App::uses('Tagauthcounts', 'Model');
Configure::load("static");
App::uses('Article','Model');
App::uses('Tagauthcount','Model');
App::uses('Tagauth','Model');
App::uses('Key','Model');


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
			'Security','Authpaginator','Users.RememberMe');
public $presetVars = array(
		'user_id' => array('type' => 'value'),
		'keyword' => array('type' => 'value'),
		'andor' => array('type' => 'value'),
		'from' => array('type' => 'value'),
		'to' => array('type' => 'value'),
);
public function beforeFilter() {
	parent::beforeFilter();

	$this->Security->validateOnce = false;
	$this->Security->validatePost = false;
	$this->Security->csrfCheck = false;
}


	public function isAuthorized($user) {
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
			parent::index();
			//$this->paginate->setting = array('order'=> array('Tag.modified' => 'DESC'));
			$this->set('tags', $this->paginate('Tag'));
		}
		public function test($test){
			return $test;
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
        	parent::view($id);
        	$this->request->data['keyid']['keyid'] =$trikeyID;
        	if ($trikeyID == NULL){
        		$trikeyID = Configure::read('tagID.search');
        	}
        	$this->set('upperIdeas', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Tag",$id));
        	$this->set('extends', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.extend'),"Tag",$id));
        	$this->set('trikeyID', $trikeyID);
        }
        /**
         * view2 method
         * 全部GETで情報を渡す
         * POSTだとリンクで同じタグを表示できない。
         * REQUEST array Searching
         * array tags 検索中のタグ
         * 	array("OR"=> (array("AND"=> (int $tag_id ,) ),"NOT" => array()),
         * array users
         * ユーザーのホワイト/ブラックリストの方式を考える必要がある。
         * REQUEST array Sorting
         * array tags 並べ替え中のタグ
         * array users 優先表示するユーザー
         * array colmun modified or created or id
         * タグの当たりをつけるための全文検索　検索に使用したタグを投稿
         *  array(int tag_id)
         * @return void
         *
         */
        public function view2($id) {
        	$this->loadModel("User");
        	if ($id ==null) {
        		$id = $this->request->query["id"];;
        	}
        	$result = $this->get_specified_reply_by_id_and_trikey($id,Configure::read("tagID.reply"));
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('tableresults',$result);
        	$this->set('sorting_tags',$sorting_tags);
        	$this->set('taghash',$result["taghash"]);

        }
        public function search2(){
        	;
        }
        /**
         * publish excange method
         *
         * @throws NotFoundException
         * @param string $id
         * @return boolean
         */
        public function exchange($id = NULL){
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tagauth'));
        	}
			$this->set('headresults',$this->headview($id));
        	$this->set('idre', $id);
        	$this->Tagauthcount = new Tagauthcount();
        	$this->set('myauthresult',$this->Tagauthcount->find('first',array(
        			'conditions' => array('Tagauthcount.tag_id'=> $id,
        					'Tagauthcount.user_id'=> $this->Auth->user('id')
        			))));
        	debug($id);
        	$this->loadModel('Tagauth');
        	$this->Paginator->setting = array(
        			"Tagauth.tag_id" => $id);
        	$tagauth = $this->paginate('Tagauth',$this->Paginator->setting);
        	$this->set('tagauths',$tagauth
        			);

        	//表示部分ここまで
        	//以下権限変更部分


        	if ($this->request->is(array('post', 'put'))) {
        		$targetTagauthcounts=$this->Tagauth->find('first',array('conditions'=>array('Tagauthcount' => array('tag_id'=>$id,
        			'username'=> $this->request->data['username']))))['Tagauth']['id'];
        	//max_quant を超えないようにするチェック　いつも全部の行を合計する処理は重たいのでやらない。一回一回の処理の整合性を取っていく。
	        	if ($this->Basic->tagAuthCountdown($this,$id,$targetTagauthcounts,$this->request->data['Tagauthcount'][`quant`])) {//相手が特定できているか
	           		$that->Session->setFlash(__('The tag has been saved.'));
	        		return true;
	        	} else {
	        			$this->Session->setFlash(__('The tagauth could not be saved. Please, try again.'));
	        	}
	        } else {
	        		$this->request->data = $this->headview($id);
        	}
//         	$users = $this->Tagauth->User->find('list');
//         	$tags = $this->Tagauth->Tag->find('list');
//         	$this->set(compact('users', 'tags'));



        }

        /**
         * publish anonymous_view method
         *
         * @throws NotFoundException
         * @param string $id
         * @param string $trikeyID
         * @return void
         */
        public function anonymous_view($id = null) {
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
        	$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id));
        	$tag = $this->Tag->find('first', $options);
        	$this->set('tag', $tag);
        	$this->pageTitle = $tag["Tag"]['name'];
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
        	$this->set('tableresults', $tableresults);
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
        				$options = array('key' => $rightKeyID);
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
			$this->loadModel('Key');
			$this->loadModel('User');
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
        		$data['Tagauthcount'] =array('user_id' => $this->request->data['Tag']['user_id'],'tag_id' =>$this->last_id,'quant' => $max_quant);
        		$this->loadModel('Tagauthcount');
        		$this->Tagauthcount->create();
        		$this->Tagauthcount->save($data);
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
        			return $this->redirect(array('action' => 'view' ,$id));
        		} else {
        			$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
        		}
        	} else {
        		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id),'order'=>'Tag.ID');
        		$this->request->data = $this->Tag->find('first', $options);
        		$this->set('users', $this->request->data['W']);
        	}
        }
        function replysingle(){
        	$options = array('key' => Configure::read('tagID.reply'));
        	debug($this->Common->trifinderbyidAndSet($this,array(1),$options));
        }

        // 			$this->laysout = "";
        //     		$this->autoRender = false;
        public function GET_all_search(){
        	$this->loadModel('User');
        	$tableresults = [];
        	$i = $this->request->query['searching_tag_ids'];
        	$sorting_tags = array($i[0][0],$i[0][1],$i[1][0],$i[1][1]);
        	$taghash = array();
			foreach ($this->request->query['searching_tag_ids'] as $and_set){

				$result = $this->serchFinder($and_set,$sorting_tags,$taghash);
				array_push($tableresults, $result);

			}
			$this->set('currentUserID', $this->Auth->user('id'));
			$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
			$this->set('array_tableresults',$tableresults);
			$this->set('sorting_tags',$sorting_tags);
			$this->set('taghash',$taghash);

        }

        public function searchFinder($andSet_ids = null ,$sorting_tags = null,&$taghash) {
        	if(is_null($andSet_ids)){
        		$andSet_ids = $this->request->data['andSet_ids'];
        	}
        	if(is_null($sorting_tags)){

        	}

        	$options = array('key' => Configure::read('tagID.search'));
        	$temp  = $this->Common->trifinderbyidAndSet($this,$andSet_ids,$options);
        	$taghash = $temp['taghash'];
        	$sorter_mended_results['article'] = $this->sorting_taghash_gen($temp['articleparentres'],$taghash,$sorting_tags);
        	$sorter_mended_results['tag'] = $this->sorting_taghash_gen($temp['tagparentres'],$taghash,$sorting_tags);


        	$tableresults = array(
        			'articleparentres' =>$sorter_mended_results['article']['results']
        			,'tagparentres'=>$sorter_mended_results['tag']['results']);

        	$currentUserID = $this->Auth->user('id');
        	return $tableresults;
        }
		/**
		 * 一回のSQLで全部のネスト構造を一度に取ってくる
		 * 与えられるのは検索タグの集合
		 * まずは　tag_hash 以外を取ってくる
		 * view でネストの塊を定義しておいて,
		 * associationで引っ張ってみるか？
		 * replyのview化
		 *
        	"SELECT * FROM tag where";
		 */
        public function GET_all_reply_and_nest($id = null){
        	if ($id ==null) {
        		$id = $this->request->query["id"];;
        	}
        	$result = $this->get_specified_reply_by_id_and_trikey($id,Configure::read("tagID.reply"));
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('tableresults',$result);
        	$this->set('sorting_tags',$sorting_tags);
        	$this->set('taghash',$result["taghash"]);

        }
        /**
         * replyFinder method
         * @var andSet_ids
         *  array
         * @var sorting_tags
         * @return results
         *
         */
        function replyFinder($id = null ,$sorting_tags = null,&$taghash) {
        	if(is_null($id)){
        		$id = $this->request->data['id'];
        	}
        	if(is_null($sorting_tags)){

        	}
        	$options = array('key' => Configure::read('tagID.reply'));
        	$temp  = $this->Common->trifinderbyid($this,$id,$options);
        	$taghash = $temp['taghash'];
        	$sorter_mended_results['article'] = $this->sorting_taghash_gen($temp['articleparentres'],$taghash,$sorting_tags);
        	$sorter_mended_results['tag'] = $this->sorting_taghash_gen($temp['tagparentres'],$taghash,$sorting_tags);
        	$tableresults = array(
        			'articleparentres' =>$sorter_mended_results['article']['results']
        			,'tagparentres'=>$sorter_mended_results['tag']['results']);

        	$currentUserID = $this->Auth->user('id');
        	return $tableresults;
        }
        /**
         *
         * @param int $id
         * @param int $trikey
         * @return html <results, table>
         *
         */
        public function get_specified_reply_by_id_and_trikey($id,$trikey){
        	$option['key'] = $trikey;
			return $this->Common->trifinderbyid($this,$id,$option);
        }

        /**
         * autoSuggest method
         *
         * @throws NotFoundException
         * @param string $id
         * @return void
         */
        public function autoSuggest() {
        	$this->layout = 'ajax';
        	$data = ''; $json = '';
        	if(!empty($this->params['url']['q'])){
        		$options = array(
        				'field'     =>array('Tag.ID','Tag.name'),
        				'conditions' => array('or'=> array(
        						array('Tag.name LIKE ?' => $this->params['url']['q'].'%')
        				),
        				),
        				'limit'     =>10
        		);
        		$datas = $this->Tag->find('list', $options);

        		foreach($datas as $key=>$val){
        			$data .= $val.'|'.$key."\n";
        		}
        	}
        	$this->set('json', $data);
        	$this->render('ajax_suggest');
        }

		public function ac(){

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

        public function search() {
        	$this->psearch($this);
        	$tags = $this->paginate();
        	$this->set('tags', $tags);

        }

       public function auto_complete() {
        	$terms = $this->Tag->find('all', array(
        			'conditions' => array(
        					'Tag.name LIKE BINARY' => '%'.$this->params['url']['autoCompleteText'].'%'
        			),
        			'fields' => array('name','user_id'),
        			'limit' => 3,
        			'recursive'=>1,
        	));
        	debug($terms);
        	$terms = Set::Extract($terms,'{n}.Tag');
//         	$terms += Set::Extract($terms,'{n}.Tag.name');
        	$this->set('terms', $terms);
//         	$this->layout = 'ajax';
        }
        /**
         * articletransmitter method
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



        public function singletrikeytable($id = null,$trikey = null){
        	parent::singletrikeytable($id,$trikey);
        }

        public function tagdel($id = NULL) {
//         	debug($id);
//         	debug($this->request->data());
        	$this->Link = new Link();
        	//$options = array('conditions' => array('.'.$this->Aurh->primaryKey => $this->request->data['Tag']['']));
//         	$Link->find('all');

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
        	//$this->redirect($this->referer());
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


