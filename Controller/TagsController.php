<?php
App::uses('AppController', 'Controller');
App::uses('Article', 'Model');
App::uses('Link', 'Model');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 */
class TagsController extends AppController {
	public $uses = array('Link','Article');
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
                $this->Tag->recursive = 0;
                $this->set('tags', $this->Paginator->paginate());
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
                    $this->Tag->parseCriteria($req),//ここで帰ってきた文字を検索している
                )
                
            )
        );
        $this->set('tags', $this->Paginator->paginate());
        }



	public function result($id = null) {
	$id = $this->request['pass'][0];
	/*if (!$this->Tag->exists($id)) {
		throw new NotFoundException(__('関連タグが存在しない'));
	}*/
	$trikeyID = tagConst()['searchID'];
	$this->Paginator->settings = array(
		'conditions'=> array(
		        	"link.LFrom = $id"
	        	 ),
		'fields' => array('Article.*', 'Link.*'),
		'joins'
		 => array(
		array(
                     'table' => 'Article',
                    //'alias' => 'Link',
                    'type' => 'INNER',
                    'conditions' => array("Link.LTo = Article.ID")
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
	$this->set('results',$this->Paginator->paginate());
	$k = 0;
	$j = 0;
	foreach ($results  as $result){
		$this->Paginator->settings = array(
			'conditions'=> array(
			        	"link.LTo = $result[article][ID]"
		        	 ),
			'fields' => array('Tag.name'),
			'joins'
			 => array(
				array(
		                     'table' => 'Tag',
		                    //'alias' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array("Link.LFrom = Article.ID")
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
		$result["STag"][$j] = $this->Paginator->paginate();
		
$j++;
		if ($taghash[$subTagID] == null) {
			$taghash[$subTagID] = array( $k++, $tagName, $subTagID, $Pname);
		}
	}
	debug($result["STag"]);
	//debug($result);
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
