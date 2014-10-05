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

	public $helpers = array('Js','AutoComplete');
public $components = array(
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
     * replyFinder method
     * @var andSet_ids
     *  array
     * @var sorting_tags
     * @return results
     *
     */
    function replyFinder($andSet_ids = null ,$sorting_tags = null) {
    	if(is_null($andSet_ids)){
			$andSet_ids = $this->request->data['andSet_ids'];
    	}
    	if(is_null($sorting_tags)){

    	}
    	$taghash = array();
    	$options = array('key' => Configure::read('tagID.reply'));
    	$temp  = $this->Common->trifinderbyidAndSet($this,$andSet_ids,$options);

//     	$sorter_mended_results = $this->sorting_taghash_gen($temp['articleparentres'],$temp['taghash'],$sorting_tags);
    	$tableresults = array('taghash' =>$temp['taghash'],
    			'articleparentres' =>$temp['articleparentres'], 'tagparentres'=>$temp['tagparentres']);
		//$non_sorter_tagid

    	//sorting_tagに含まれているtagだけハッシュとして渡す
		$currentUserID = $this->Auth->user('id');
    	return $tableresults;
    }


    /**
     *
     * @param array $taghashes
     * @param array $sorting_tags
     * $sorting_tags= array ('ID');
     * @return array
     */
    function taghashes_cutter($taghashes,$sorting_tags){
    	if (!is_null($sorting_tags)) {
	    	foreach ($sorting_tags as $sorting_tag){
				unset($taghashes[$sorting_tag]);
	    	}
    	}
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
     * @param results 結果
     * @param taghashes
     * この二つに分けると思ったが上だけでいい
     * $targetParent[$i]['no_sort_subtag'][$that->subtagID]['Tag']['ID']
     * //$targetParent[$i]['sort_subtag'][$that->subtagID]['Tag']['ID']
     * @return array('results','taghashes')
     *
     */
    function sorting_taghash_gen($results,$taghashes,$sorting_tags){
    	$i =0;
    	foreach  ($results as $result){
    		if(!$result['no_sort_subtag'] == null){
	    		foreach ($result['no_sort_subtag'] as $sub_tag_key => $sub_tag_value){
	    			foreach ($sorting_tags as $hashval){
	    				if ($results[$i]['subtag'][$sub_tag_key]['Tag']['ID']
	    					!== $hashval) {
	    					$results[$i]['no_sort_subtag'][$sub_tag_key]['Tag']
	    					 = $results[$i]['subtag'][$sub_tag_key]['Tag'];
	    				}
	    			}
	    		}
    		}
    		$i++;
    	}



    		$taghashes = $this->taghashes_cutter($taghashes,$sorting_tags);;

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

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */


    function view($id = NULL){
    	if (!$this->{$this->modelClass}->exists($id)) {
    		throw new NotFoundException(__('Invalid tag'));
    	}
    	$this->loadModel('User');
    	$this->loadModel('Key');
    	$headresults = $this->headview($id);

    	$this->Common->tagRadd($this);
    	if($this->request->data['Article']['name'] != null){
    		$options['key'] = $this->request->data['Article']['keyid'];
    		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
    		$this->Basic->social($this);
    	} elseif($this->request->data['Tag']['name'] != null and $this->request->data['tagRadd']['add'] != true){
    		$options['key'] = $this->request->data['Tag']['keyid'];
    		$this->Common->triAddbyid($this,$this->request->data['Tag']['user_id'],$id,$this->request->data['Tag']['name'],$options);
    		$this->Basic->social($this,$this->Auth->user('id'));
    	}
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
