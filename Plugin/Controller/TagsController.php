<?php

App::uses('AppController', 'Controller');
App::uses('Link', 'Model');
//App::uses('BasicComponent', 'Controller/Component');
/*App::uses('Article', 'Model');
App::uses('Link', 'Model');
App::uses('User', 'Model');*/
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 */
class TagsController extends AppController {

	public $uses = array(//'Tag','Article','Link','User'
			);
/*    // 登録済ユーザーは投稿できる
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
}*/
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
        }
        public $components = array('Search.Prg','Paginator','Common','Basic','Cookie','Session');
        public $helpers = array(
        		'Html',
        		'Session'
        );
//        public $presetVars = true;



/**
 * Components
 *
 * @var array
 */
//        public $components = array(;

/**
 * index method
 *
 * @return void
 */
        public function index() {
                //$this->Tag->recursive = 0;
		$parms = array(
		'joins'=> array(
				array(
		                     'table' => 'Tag',
		                    //'alias' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array("Link.LFrom = Tag.ID")
		                ),
			)
		)
		;
                //$this->set('tags', $this->Paginator->paginate());
		$this->set('tags', $this->Tag->find('all',$parms));
        }
        public function search() {
        $this->Prg->commonProcess();
        $req = $this->passedArgs;
        if (!empty($this->request->data['Tag']['keyword'])) {
            $andor = !empty($this->request->data['Tag']['andor']) ? $this->request->data['Tag']['andor'] : null;
            $word = $this->Tag->multipleKeywords($this->request->data['Tag']['keyword'], $andor);
            $req = array_merge($req, array("word" => $word));
        }
        /*$this->paginate = array(
            'conditions' => $this->Tag->parseCriteria($req),
        );*/

        $this->paginate = array(
                'Tag' =>
            array(
                'conditions' => array(
                    $this->Tag->parseCriteria($req),
                )

            )
        );
        $this->set('tags', $this->Paginator->paginate());
        $this->set('Auth', $this->Auth->user('ID'));
        }

public function quant($id = null) {
	if ($this->request->is('post')) {
		$this->userID = $this->Auth->user('ID');
		if($this->request->data['Link']['user_id'] == $this->userID){
			$this->loadModel('Link');
			if ($this->Link->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		}
	}
//	$this->redirect(array('controller' => 'tags','action'=>'result',$this->request->data['tag']['idre']));
	$this->redirect($this->referer());
}

public function tagdel($id = null) {
	if ($this->request->is('post') and $this->request->data['Link']['user_id'] == $this->Auth->user('ID')) {
		$this->loadModel('Link');
		if ($this->Link->delete($this->request->data('Link.ID'))){
			$this->Session->setFlash(__('削除完了.'));
		} else {
			$this->Session->setFlash(__('削除失敗.'));
		}
	}
//	$this->redirect(array('controller' => 'tags','action'=>'result',$this->request->data['tag']['idre']));
	$this->redirect($this->referer());
}

public function tagRadd($id = null) {
	$searchID = tagConst()['searchID'];
	$this->Tag->unbindModel(array('hasOne'=>array('TO')), false);
	//$this->Link->unbindModel(array('hasOne'=>array('LO')), false);
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
				$this->Basic->trilinkAdd($this,$last_id,$LinkLTo,tagConst()['searchID']);
				$this->Session->setFlash(__('タグがなかった.'));
				}else {
			$this->loadModel('Link');
				$this->Tag->unbindModel(array('hasOne'=>array('TO')), false);
				$this->Link->unbindModel(array('hasOne'=>array('LO')), false);
				$trikeyID = tagConst()['searchID'];
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
	//	}
	}
	//$this->redirect(array('controller' => 'tags','action'=>'result',$this->request->data['tag']['idre']));
	$this->redirect($this->referer());
}

	public function result($id = null) {
		$this->Common->trifinder($this);
		$this->set('idre', $id);
	}


	public function reply($articleID) {
		if (!$this->Tag->exists($tagID)) {
			throw new NotFoundException(__('関連タグが存在しない'));
		}
		$sql = "SELECT  `article` . *, `LINK`.`ID` AS LinkID FROM  `LINK` INNER JOIN  `LINK` AS tagLink ON  `LINK`.`ID` = `tagLink`.`LTo`, `article`  WHERE  `LINK`.`LFrom` =$tagID AND `tagLink`.`LFrom` =2138  AND `article` . `ID` = `LINK` . `LTo`";
		$sqlres = $this->Tag->query($sql);
		$this->set('results', $sqlres);
	}

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

	public function view($id = null) {
		if($this->request->data['Article']['name'] != null){
			$this->keyid = $this->request->data['Article']['keyid'];
			$this->Common->triarticleAdd($this,'Article',1);
		}
		if($this->request->data['Tag']['name'] != null){
			$this->keyid = $this->request->data['Tag']['keyid'];
			$this->Common->tritagAdd($this,"Tag",1);
		}

		$this->set('idre', $id);
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$trikeyID = tagConst()['searchID'];
		$this->Common->SecondDem($this,"Tag","Tag.ID",$trikeyID,$id);
		$this->set('headresults', $this->returntribasic);
		$options = array('conditions' => array('Tag.'.$this->Tag->primaryKey => $id),'order' => array('Tag.ID'));
		$this->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		$this->set('tag', $this->Tag->find('first', $options));
		$this->Common->trifinderbyid($this);
		$this->Session->write('selected',$this->request->data['keyid']['keyid'] );
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tag->create();
			$this->request->data['Tag'] += array(
					'user_id' => $this->Auth->user('ID'),
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
				);
			if ($this->Tag->save($this->request->data)) {//セーブすることに成功したら、
				$this->Session->setFlash(__('success.',$this->request->data));
				//return $this->redirect(array('action' => 'search'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));

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
		$this->Tag->id = $id;
		if (!$this->Tag->exists()) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tag->delete()) {
			$this->Session->setFlash(__('The tag has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function articleview($id) {
	$this->redirect(array('controller' => 'articles','action'=>'view',$id));
	}
}
