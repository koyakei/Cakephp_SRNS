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
// 	public $helpers = array( 'Javascript', 'Ajax');
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

    /**
     * srns_member_check method
     *
     * インスタンスを生成できているのか調べる
     * @throws NotFoundException
     * @param array $extended_Object
     *  array ('id' => $id,,'model_name' => $model_name,'creditedUsersID')
     * @param array $creditedUsers
     * @param array $instance
     * array ('id' => $id,,'model_name' => $model_name,'creditedUsersID')
     * @return bool
     * 一致していなかったらfalse
     */
    function srns_member_check($extended_Object = NULL,$instance= NULL){
//     	$this->loadModel('Tag');
    	//継承があったら、そのパターンと同じタクソノミーを拾ってくる。
//     	$options = array($extended_Object['model_name'], $extended_Object['id']);
//     	$extended_Object = $this->{$this->modelClass}->find('all',array('conditions' => array($options)));

//     	$options = array($instance['model_name'], $instance['id']);
//     	$incetance = $this->{$this->modelClass}->find('all',array('conditions' => array($options)));
//     	if ($extended_Object == $incetance){
//     		return ture;
//     	}
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
    	$this->loadModel('User');
    	$this->loadModel('Key');
//     	$this->id = $id; // 消したい
    	if (!$this->{$this->modelClass}->exists($id)) {
    		throw new NotFoundException(__('Invalid tag'));
    	}
    	$headresults = $this->headview($id);


    	$this->Common->tagRadd($this);
    	if($this->request->data['Article']['name'] != null){
    		$options['key'] = $this->request->data['Article']['keyid'];
    		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
    		$this->Basic->social($this);
    	} elseif($this->request->data['Tag']['name'] != null and $this->request->data['tagRadd']['add'] != true){
    		$options['key'] = $this->request->data['Tag']['keyid'];
    		$this->Common->triAddbyid($this,$this->request->data['Tag']['user_id'],$id,$this->request->data['Tag']['name'],$options);
    		$this->Basic->social($this,$userID);
    	}
    	$key = $this->allKeyList();
    	$i = 0;
    	$extended_objects = $this->Basic->triupperfiderbyid($this,Configure::read('tagID.extend'),"Tag",$id);
    	foreach ($key as $keyid => $value){
    		if (!($this->name == 'Articles' && $key == Configure::read('tagID.search'))) {
    			$options = array('key' => $keyid);
	    		$this->Common->trifinderbyid($this,$id,$options);

	    			$tableresults[$i] = array('ID'=>$keyid,'name' => $value ,'head' =>$this->taghash,
	    					'tag' =>$this->articleparentres, 'article'=>$this->tagparentres);

	    		$i++;
    		}
    	}
    	foreach ($tableresults as $parent_key => $parent_value){
    		if ($parent_value['ID'] == Configure::read('tagID.definition')) {
    				foreach ($parent_value['tag'] as $child_key => $child_value){
    					$tableresults[$parent_key]['tag'][$child_key]['Article']['srns_code_member'] = $this->srns_member_check(array('id'=>$extended_objects,'model_name'=> 'Tag','creditedUsersID'=>$this->Auth->user('id')),array('id'=>$id,'model_name'=> 'Tag','creditedUsersID'=>$this->Auth->user('id')));;

    				}
    		}
    	}

//     	$srns_checked_array[$checked_id] = $this->checkSrnsInstance(array('id' => $extends['Tag']['ID'],'model_name' => 'Tag'));
    	$this->set('check_srns_inherit',$srns_checked_array);
    	$this->set('idre', $id);
    	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
    	$this->set( 'keylist', $key);
    	$this->set('idre', $id);
    	$this->pageTitle = $headresults[$this->modelClass]['name'];
    	$this->Common->SecondDem($this,"Tag","Tag.ID",Configure::read('tagID.search'),$id);
    	$this->set('headresults',$headresults);
    	$this->set('tableresults', $tableresults);
    	$this->set('SecondDems', $this->returntribasic);
    	$this->set('currentUserID', $this->Auth->user('id'));
    	$this->set('model',$this->modelClass);
    	$this->set('upperIdeas', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Tag",$id));
    	$this->set('extends', $extended_objects);
    }
    public function edit($id = null){
    	if (null != ($this->Session->read('beforeURL'))) {
    		$referer = $this->Session->read('beforeURL');
    	}else {
    		debug($this->referer());
    		if (!preg_match('/edit/', $referer)) {
    			$this->Session->write('beforeURL', $referer);

    		} else {
    			$this->redirect($this->referer());
    		}

    	}
    }
}
