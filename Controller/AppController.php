<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('User', 'Model');
App::uses('Key', 'Model');
App::uses('Article','Model');
App::uses('Tag','Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
// 	public $paginate = array(
// 			'conditions' => array('order' =>
// 					'modified DESC'
// 				)
// 			);
	public function triArticleAdd(){
		$options['key'] = $this->request->data['Article']['keyid'];
		$this->Common->triarticleAdd($this,'Article',
				$this->request->data['Article']['user_id'],$this->request->data("id"),$options);
		$this->Basic->social($this);
		$this->redirect($this->referer());
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

	 *現在の$id からすべてリプライする　replt@who 現在のtrikey 条件を　reply demand $ trikeys (array)に渡す
	 *
	 */

	public function view2($id,$lower_id = null//テーブル2つ表示の時これ使う？
	) {
		$that = $this;
		if ($id ==null) {
			$id = $this->request->query["id"];
		}
		$base_trikey = $this->request->query('trikey_filter'); //トライキーのフィルター
		//         	デフォルトで"リプライ"だけ読む
		if ($base_trikey == null) {
			$base_trikey = Configure::read("tagID.reply");
		}
		$all_node = null;//全部の情報
		$this->loadModel("User");
		$this->loadModel("Trikey_list");
		$all_trikeis = $this->allKeyList();//すべてのトライキーを取得
		//         	$all_node = $this->get_child("Base_trikey_entity",$all_node,$id,$base_id,$base_trikey);
		//base_trikeyのみに関連付けられているエンティティーを取得

		$option = array('key' => Configure::read("tagID.reply"));
		$index =null;
		$root = $this->Common->trifinderbyid($that,$id,$option,$index);

		$tableresults = $this->Common->nestfinderbyid(
				$that, $root, $sorting_tags = null, $id, $root);
// 		debug( $tableresults);
		$this->set('headresults',$headresults);
		$this->set('tableresults', $tableresults);
		$this->set('base_trikey' ,$base_trikey);
		$this->set('currentUserID', $this->Auth->user('id'));
		$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
		$this->set('sorting_tags',$sorting_tags);
		$this->set('taghash',$tableresults["taghash"]);
		$this->set('id',$id);
	}

	public $helpers = array('Js','AutoComplete');
	public $components = array('Auth','Search.Prg','Paginator','Common','Demand','Basic','Cookie','Session',
			'Security','Authpaginator','Users.RememberMe',
    'Session',
    'Auth' => array(
// 		        'loginAction' => array(
// 		            'controller' => 'users',
// 		            'action' => 'login',
// 		            'plugin' => 'users'
// 		        ),
// 		        'authError' => 'Did you really think you are allowed to see that?',
// 		        'authenticate' => array(
// 		            'Form' => array(
// 		                'fields' => array('username' => 'email')
// 		            )
// 		        ),

// 	        'loginRedirect' => array('controller' => 'tags', 'action' => 'search'),
	        'logoutRedirect' => array(
	        		'controller' => 'articles', 'action' => 'index'
	    	),
        'authorize' => array('Controller')
    ),
	'Security' => array(
	'csrfCheck' => false
	)
);
	public function isAuthorized($user) {

	    if ((isset($user['role']) && $user['role'] === 'admin') or (isset($user['role']) && $user['role'] === 'registered')) {
	 		return true;
	    }
	    return false;
    }



    public function beforeFilter() {
    	parent::beforeFilter();
    	$this->Auth->authenticate = array(
			'Basic' => array('user' => 'admin'),
		);
        $this->Auth->allow('login','anonymous_view','logout','ac');
//         if (empty($this->params['registerd'])) {
//         	// adminルーティングではない場合、認証を通さない（allow）
//         	$this->Auth->allow($this->params['action']);
//         }
    }
    /**
     * beforeRender method
     * 今は記事名+SRNSをページタイトルに表示するようにしている。
     *
     * @return void
     *
     */
    function beforeRender() {
    	$this->set('title_for_layout', $this->pageTitle);
    }






    /**
     *
     * @param array $taghashes
     * @param array $sorting_tags
     * $sorting_tags= array ('ID');
     * @return array
     */
function taghashes_cutter(&$taghashes,$sorting_tags){
// 		if (!is_array($taghashes)) {
// 			return NotFoundException("no taghash array");
// 		}
// 		if (!is_array($sorting_tags)) {
// // 			return NotFoundException("no sorting_tags array" + $sorting_tags);;
// 		}else{
			foreach ($taghashes as $taghash_key => $taghash_val){
				foreach ($sorting_tags as $sorting_tag){
					if ($sorting_tag != $taghash_val['ID']){
						unset($taghashes[$taghash_key]);
					}
				}
			}
// 		}
		return $taghashes;
	}

    /**
     *
     * @param int $target_ids
     * @param int $trikey
     * @param int $user_id
     */
	function addArticles(
			$target_ids= NULL,
			$trikey= NULL,$user_id= NULL,$name= NULL,$options = NULL){

		$last_id = addSingleArticle($name,$user_id,$options);
		$options['key'] = $trikey;
		foreach ($target_ids as $target_id){
			$this->Common->triAddbyid($this,
					$user_id,
					$target_id
					,$last_id,
					$options);
			//$this->Basic->social2($this);
		}
	}
	/**
	 *
	 * @param string $name
	 * @param int $user_id
	 */
	function addSingleArticle($name,$user_id,$options= null){
		$data['Article'] = array('name' =>$name,'users_id'=>$user_id,'auth'=> $options['auth']);
		$Article = new Article();
		$Article->create;
		$Article->save($data);
		return $Article->getLastInsertID();
	}
	/**
	 *
	 * @param array $target_ids
	 * @param int $trikey
	 * @param int $user_id
	 */
	function linker($target_ids,$trikey,$user_id){
		$options['key'] = $trikey;
		foreach ($target_ids as $target_id){
			$this->Common->triAddbyid($this,
					$user_id,
					$target_id['from']
					,$target_id['to'],
					$options);
		}
	}

    /**
     * ソートタグに合わせてタグハッシュを切り詰める
     * js でやることにした。クエリが飛びすぎる。
     * @param results 結果
     * @param taghashes
     * この二つに分けると思ったが上だけでいい
     * $targetParent[$i]['no_sort_subtag'][$that->subtagID]['Tag']['ID']
     * //$targetParent[$i]['sort_subtag'][$that->subtagID]['Tag']['ID']
     * @return array('results','taghashes')
     *
     */
    public function sorting_taghash_gen($results,&$taghashes,$sorting_tags){
    	$i =0;
    	if (!is_array($results)) return Exception("not array");
    	foreach  ($results as $result){
    		if (!is_null($result['subtag'])){
	    		foreach ($result['subtag'] as $sub_tag_key => $sub_tag_val){
	    			foreach ($sorting_tags as $hashval){
		    			if ($results[$i]['subtag'][$sub_tag_key]['Tag']['ID']
		    			!== $hashval) {
		    				$results[$i]['no_sort_subtag'][$sub_tag_key]
		    				= $results[$i]['subtag'][$sub_tag_key];
		    			}
	    			}
	    		}
    		}
    		$i++;
    	}
    	$taghashes = $this->taghashes_cutter($taghashes,$sorting_tags);
    	return array('results'=> $results,'taghashes'=>$taghashes);
    }

    /**
     * GET_reply method
     * 読み込まれた情報の中にすでにあるのか判定
     *
     * @return bool
     *
     */
    function dobbled_info() {

		$bool = array_search($needle, $haystack);
    	return $bool;
    }

    /**
     * searchTagAndText method
     * 全部ポストで情報を渡す
     * post array tag_id
     *　REQUEST array Searching_strings
     * @return void
     *
     */
    function searchTagAndText() {
    }
    /**
     * headview method
     * 記事とタグに共通する情報を返す。
     * @param string $id
     * @return string
     */

    public function headview($id = NULL){
    			return $this->{$this->modelClass}->find('first',
    					 array('conditions' => array(
    					 		$this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $id)));
    }

    function flatten($arr) {
    	$array = new RecursiveIteratorIterator(
    			new RecursiveArrayIterator($arr),
    			RecursiveIteratorIterator::LEAVES_ONLY
    	);
    	return iterator_to_array($arr, false);
    }

    function array_values_recursive ($a = array()) {
    	$r = function ($a) use (&$r) {
    		static $v = array();
    		foreach ($a as $ary) {
    			is_array($ary) ? $r($ary) : $v[] = $ary;
    		}
    		return $v;
    	};
    	return $r($a);
    }
    public function index(){
    	$this->Session->write('beforeURL', Router::url(null,true));
    }


    public function singletrikeytable($id = null,$trikey = null){
    	if($this->request->data['Article']['name'] != null){
    		$options['key'] = $trikey;
    		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
    		$this->Basic->social($this);
    	}
    	if($this->request->data['Tag']['name'] != null and $this->request->data['tagRadd']['add'] != true){
    		$options['key'] = $trikey;
    		$this->Common->triAddbyid($this,$this->request->data['Tag']['user_id'],$id,$this->request->data['Tag']['name'],$options);
    		$this->Basic->social($this,$userID);
    	}
    	$this->loadModel('User');

    	$this->loadModel('Key');
    	$key = $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name')));

    	$options = array('key' => $trikey);
    	$results = $this->Common->trifinderbyid($this,$id,$options);
    	$tableresults = array('ID'=>$key
    			,'name' => $value
    			,'head' =>$results['taghash']
    			,'article' =>$results['articleparentres']
    			,'tag' =>$results['tagparentres']);
    	debug($results);
    	$this->set( 'keylist', $key);
    	$this->set('value',$tableresults);
    	$this->set('model',$this->modelClass);
    	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
    	$this->set( 'currentUserID', $this->Auth->user('id'));
    	$this->Common->tagRadd($this);
    }
    /**
     * srns_member_check method
     *
     * インスタンスを生成できているのか調べる
     * @throws NotFoundException
     * @param array $extended_Object
     *  array ('id' => $id,,'model_name' => $model_name,'creditedUsersID')
     * @param array $instance
     * array ('id' => $id,,'model_name' => $model_name,'creditedUsersID')
     * @return bool
     * 一致していなかったらfalse
     */
    function srns_member_check($extended_Object = NULL,$instance= NULL){
    	$this->loadModel('Tag');
//     	継承があったら、そのパターンと同じタクソノミーを拾ってくる。
    	$options = array('key' => Configure::read('tagID.SRNS_Code'));
    	$extended_Object = $this->Common->trifinderbyid($this,$extended_Object['id'],$options);
    	$extended_Object = array_merge($extended_Object['tagparentres'],
				$extended_Object['articleparentres']);
    	$options = array('key' => Configure::read('tagID.equal'));
    	$instance = $this->Common->trifinderbyid($this,$instance['id'],$options);
    	foreach ($instance as $instance_value){
    		foreach ($instance_value as $child_instance_value){
		    	foreach ($extended_Object as $extended_Object_value){
		    		foreach ($extended_Object_value as $child_extended_Object_value){
				    	if ($this->array_values_recursive($this->array_id_reterner($child_instance_value))
				    			== $this->array_values_recursive($this->array_id_reterner($child_extended_Object_value))){
				    		return ture;
				    	}
		    		}
    			}
    		}
    	}
    	return false;
    }

    /**
     * allKeyList method
     *
     * @throws NotFoundException
     * @param void
     * @return array  keyList
     */
    public function allKeyList(){
    	$this->loadModel('Key');
    	return $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name')));
    }
	public function tagSRAdd(){
		$options['key'] = Configure::read('tagID.search');
		$this->Common->triAddbyid($this,
				$this->request->data['Tag']['user_id'],$this->request->data['Tag']['tag'],$this->request->data['Tag']['LTo'],$options);
		$this->Basic->social($this,$this->Auth->user('id'));
// 		$this->redirect($this->referer());
	}
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = NULL){
    	if (!$this->{$this->modelClass}->exists($id)) {
    		throw new NotFoundException(__('Invalid tag'));
    	}
    	$this->loadModel('User');
    	$this->loadModel('Key');
    	$headresults = $this->headview($id);
		//追加ロジック
    	$this->Common->tagRadd($this);
    	if($this->request->data['Article']['name'] != null){
    		$options['key'] = $this->request->data['Article']['keyid'];
    		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
    		$this->Basic->social($this);
    	}
    	//表示取得
    	$key = $this->allKeyList();
    	$i = 0;
    	$extended_objects = $this->Basic->triupperfiderbyid($this,Configure::read('tagID.extend'),"Tag",$id);

    	foreach ($key as $keyid => $value){
    		if (!($this->name == 'Articles' && $key == Configure::read('tagID.search'))) {
    			$options = array('key' => $keyid);
	    		$temp  = $this->Common->trifinderbyid($this,$id,$options);
	    			$tableresults[$i] = array('ID'=>$keyid,'name' => $value ,'head' =>$temp['taghash'],
	    				'tag' =>$temp['articleparentres'], 'article'=>$temp['tagparentres']);
	    		$i++;
    		}
    	}

    	if (!is_null($extended_objects)) {
    		foreach ($extended_objects as $extended_object){
	    		foreach ($tableresults as $parent_key => $parent_value){
	    			if ($parent_value['ID'] == Configure::read('tagID.definition')) {
	    				foreach ($parent_value['tag'] as $child_key => $child_value){
	    					$tableresults[$parent_key]['tag'][$child_key]['Article']['srns_code_member']
	    					= $this->srns_member_check(
	    							array('id'=> $this->array_id_reterner($extended_object),'model_name'=> 'Tag','creditedUsersID'=>$this->Auth->user('id')),
	    							array('id'=> $this->array_id_reterner($child_value),'model_name'=> 'Tag','creditedUsersID'=>$this->Auth->user('id')));

	    				}
	    			}
    			}
    		}
    	}

    	$this->set('check_srns_inherit',$srns_checked_array);
    	$this->set('idre', $id);
    	$this->set('SecondDems',$this->Basic->tribasicfiderbyid($that,Configure::read('tagID.search'),"Tag",$id,"Tag.ID"));
    	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
    	$this->set( 'keylist', $key);
    	$this->set('idre', $id);
    	$this->pageTitle = $headresults[$this->modelClass]['name'];
    	$this->set('headresults',$headresults);
    	$this->set('tableresults', $tableresults);
    	$this->set('currentUserID', $this->Auth->user('id'));
    	$this->set('model',$this->modelClass);
    	$this->set('upperIdeas', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Tag",$id));
    	$this->set('extends', $extended_objects);
    	$this->Session->write('beforeURL', Router::url(null,true));
    }
    /**
     * array_id_reterner method
     * どのモデルでもIDを返す
     * @param array $array
     * @return array
     */
    public function array_id_reterner($array){
    	if(empty($array['Tag']['ID'])){
			return $array['Article']['ID'];
    	} else {
    		return $array['Tag']['ID'];
    	}
    }
    public function edit($id = null){
    	if (null != ($this->Session->read('beforeURL'))) {
    		$referer = $this->Session->read('beforeURL');
    	}
    	$this->Session->write('beforeURL', $this->beforeURL_pregmuch($referer));
    }

    /**
     * beforeURL_pregmuch method
     * 前のURLが
     * @param string $beforeURL
     * @return string fullpath of before url
     */
    public function beforeURL_pregmuch ($beforeURL){
    	if (!preg_match('[/edit/]', $beforeURLr)
    	or preg_match('[/view/]', $beforeURLr)
    	or preg_match('[s/\z]', $beforeURLr)
    	) {
    		return $beforeURL;
    	}else {
    		return $this->referer();
    	}
    }
}
