<?php
App::uses('AppController', 'Controller');
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
        'owner_id' => array('type' => 'value'),
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
        public $components = array('Search.Prg','Paginator');
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
		debug($this->Paginator->paginate());
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
        }



public function result($id = null) {
	$this->Tag->recursive = 6;
	$id = $this->request['pass'][0];
	$trikeyID = tagConst()['searchID'];
	$this->loadModel('Article');
	
	$this->Paginator->settings = array(
		'conditions'=> array(
		        	"Link.LTo = Article.ID"
	        	 ),
		'fields' => array('Link.*','taglink.*','Article.*'
			),
		'joins'
		 => array(
		array(
                    'table' => 'Link',
                    'type' => 'INNER',
                    'conditions' => array(
			array("$id = Link.LFrom")
			)
                ),
		array(
                    'table' => 'Link',
                    'alias' => 'taglink',
                    'type' => 'INNER',
                    'conditions' => array(
			array("Link.ID = taglink.LTo"),
			array("$trikeyID = taglink.LFrom")
			)
                ),
		)
	);
	$parentres = $this->Paginator->paginate('Article');

	$k = 0;
	$j = 0;
	$i = 0;
	foreach ($parentres as $result){
		$res = $result['Article']['ID'];
		$this->loadModel('Tag');
		$this->Paginator->settings = array(
			'conditions'=> array(
			        	"Link.LTo = $res"
		        	 ),
			'fields' => array('Tag.*','Link.ID','Link.quant','Link.owner_id'//,'User.username'
			),
			'joins'
			 => array(
				array(
		                    'table' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Tag.ID = Link.LFrom")
					)
		                ),
				array(
		                    'table' => 'Link',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
					array("$trikeyID = taglink.LFrom")
					)
		                ),			)
		);
		$taghashgen = $this->Paginator->paginate('Tag');
		//debug($taghashgen);
		
		
		foreach ($taghashgen as $tag){
			$subtagID = $tag['Tag']['ID'];
			$parentres[$i]['subtag'][$subtagID] = $tag;
			if ($taghash[$subtagID] == null) {
				$taghash[$subtagID] = array( 'ID' => $tag['Tag']['ID'], 'name' =>  $tag['Tag']['name']);
			}
		}
		$i++;
	}
	debug($taghash);
	$this->set('taghashes', $taghash);
	$this->set('results', $parentres);
	}
	public function reply($articleID) {
	if (!$this->Tag->exists($tagID)) {
		throw new NotFoundException(__('関連タグが存在しない'));
	}
	$sql = "SELECT  `article` . *, `LINK`.`ID` AS LinkID FROM  `LINK` INNER JOIN  `LINK` AS tagLink ON  `LINK`.`ID` = `tagLink`.`LTo`, `article`  WHERE  `LINK`.`LFrom` =$tagID AND `tagLink`.`LFrom` =2138  AND `article` . `ID` = `LINK` . `LTo`";
	$sqlres = $this->Tag->query($sql);
	$this->set('results', $sqlres);
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
		$this->set('tag', $this->Tag->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tag->create();
			$this->request->data['Tag']['owner_id'] = $this->Auth->user('ID');
			if ($this->Tag->save($this->request->data)) {//セーブすることに成功したら、
				$this->Session->setFlash(__('success.',$this->request->data));
				return $this->redirect(array('action' => 'index'));
			} else {
				print_r($this->request->data);
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
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
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
