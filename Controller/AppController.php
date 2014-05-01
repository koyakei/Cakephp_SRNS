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
        $this->Auth->allow('login','anonymous_view','logout');
//         if (empty($this->params['registerd'])) {
//         	// adminルーティングではない場合、認証を通さない（allow）
//         	$this->Auth->allow($this->params['action']);
//         }
    }
    function beforeRender() {
    	$this->set('title_for_layout', $this->pageTitle);
    }
    public function headview($id = NULL){
    			return $this->{$this->modelClass}->find('first',
    					 array('conditions' => array(
    					 		$this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $id)));
    }

    function view($id = NULL){
    	$this->set('headresults',$this->headview($id));
    	if (!$this->{$this->modelClass}->exists($id)) {
    		throw new NotFoundException(__('Invalid tag'));
    	}
    	if($this->request->data['tagRadd']['add'] == true){
    		if($this->Basic->tagRadd($this)){
    			if($this->Basic->social($this)){
						debug("tag relation added.");
    			}
    		}
    	}elseif ($this->request->data['Tag']['max_quant'] != null){
    		if ($this->Auth->user('id')==$resultForChange['Tag']['user_id']) {
    			if($this->Tag->save($this->request->data())){
    				$that->Session->setFlash(__('Max quant changed.'));
    			}
    		}else {
    			debug("fail no Auth");
    		}
    	} elseif($this->request->data['Link']['quant'] != null){
    		if($this->Basic->quant($this) && $this->Basic->social($this)){
    			$that->Session->setFlash(__('Quant changed.'));
    		}
    	}
    	if($this->request->data['Article']['name'] != null){
    		$options['key'] = $this->request->data['Article']['keyid'];
    		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
    		$this->Basic->social($this);
    	}
    	if($this->request->data['Tag']['name'] != null and $this->request->data['tagRadd']['add'] != true){
    		debug($this->request->data);
    		$options['key'] = $this->request->data['Tag']['keyid'];
    		$this->Common->tritagAdd($this,"Tag",$this->request->data['Tag']['user_id'],$id,$options);
    		$this->Basic->social($this,$userID);
    	}
    	$this->set('idre', $id);
    	$this->loadModel('User');
    	$this->loadModel('Key');
    	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
    	$key = $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name')));
    	$this->set( 'keylist', $key);
    	$i = 0;
    	foreach ($key as $key => $value){
    		if (!($this->name == 'Articles' && $key == Configure::read('tagID.search'))) {
    			$options = array('key' => $key);
	    		$this->Common->trifinderbyid($this,$id,$options);
	    		$tableresults[$i] = array('ID'=>$key,'name' => $value ,'head' =>$this->taghash,'tag' =>$this->articleparentres, 'article'=>$this->tagparentres);
	    		$i++;
    		}

    	}
    	$this->set('tableresults', $tableresults);

    	$this->pageTitle = $headresults[$this->modelClass]['name'];
    	$this->Common->SecondDem($this,"Tag","Tag.ID",Configure::read('tagID.search'),$id);
    	$this->set('SecondDems', $this->returntribasic);
    	$this->set('currentUserID', $this->Auth->user('id'));
    }
}
