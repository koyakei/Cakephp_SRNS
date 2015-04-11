<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
class CommonComponent extends Component {
    public $components = array('Basic');
    public function getURL(&$that = null,$id = null){
		$this->Basic->tribasicfiderbyid($that,Configure::read('tagID.URL'),'Article',"Article.ID",$id);
		return $that->returntribasic[0]['Article']['name'];
    }
	public function replyarticleAdd(&$that = null) {
		if ($that->request->params['pass'][0] != null) {
			$Article = new Article();
			$Article->create();
			$that->userID = $that->Auth->user('ID');
			if ($Article->save($that->request->data)) {
				$that->last_id = $Article->getLastInsertID();
				//debug($Article->getLastInsertID());
				$that->request->data = null;
				$that->request->data['Link'] = array(
					'user_id' => 1,
					'LFrom' => $that->request->params['pass'][0],//2138
					'LTo' => $that->last_id,
					'quant' => 1,
				);
				$Link = new Link();
				$Link->create();
				if ($Link->save($that->request->data)) {
				$that->last_id = $Link->getLastInsertID();
				$that->request->data = null;
				$that->request->data['Link'] = array(
					'user_id' => 1,
					'LFrom' => 2138,//
					'LTo' => $that->last_id,
					'quant' => 1,
				);
				$Link->create();
					if ($Link->save($that->request->data)) {
						$that->Session->setFlash(__('The article has been saved.'));

					} else {
						$that->Session->setFlash(__('The article could not be saved. Please, try again.'));
					}
				}
			}
		}
	}
	public function trasmitterDiff(&$that,$fromID,$fromKeyID,$model){
		if($that->request->data['from'][$model] == null){
			$that->request->data['from'][$model] = array();
		}
		if($that->request->data['to'][$model] == null){
			$that->request->data['to'][$model] = array();
		}
		$diff =array_diff ($that->request->data['to']['Article'],$that->request->data['from']['Article'] );
		debug($diff);
		$options['key'] = $fromKeyID;
		foreach ($diff as $var){
			//debug($var['ID']);
			$ToID= $var['ID'];
			$that->Common->triAddbyid($that,$that->Auth->user('id'),$fromID,$ToID,$options);
			//}
		}
	}
	public function triarticleAdd(&$that = null,$model,$userID,$FromID,$options) {
		if ($userID == null) {
			$userID = Configure::read('acountID.admin');
		}
		if ($options['key'] == null or $options['key'] == 0){
			$options['key'] = Configure::read('tagID.reply');
		}
		if ($FromID != null) {
			$Article = new $model();
			$Article->create();
			if ($Article->save($that->request->data)) {
				$that->Session->setFlash(__($Article->getLastInsertID()));
				$that->last_id = $Article->getLastInsertID();
				$that->request->data = null;
				$that->request->data['Link'] = array(
					'user_id' => $userID,
					'LFrom' => $FromID,
					'LTo' => $that->last_id,
					'quant' => 1,
				);
				$Link = new Link();
				$Link->create();
				if ($Link->save($that->request->data,false)) {
					$that->last_id = $Link->getLastInsertID();
					$that->request->data = null;
					$that->request->data['Link'] = array(
						'user_id' => $userID,
						'LFrom' => $options['key'],//
						'LTo' => $that->last_id,
						'quant' => 1,
					);
					$Link->create();
					if ($Link->save($that->request->data,false)) {
						$that->Session->setFlash(__('The article has been saved.'));

					} else {
						$that->Session->setFlash(__('The article could not be saved. Please, try again.'));
					}
				}else {
					debug("misslink1");
				}
			}

		}

	}
	public function tagRadd(&$that){
		if($that->request->data['tagRadd']['add'] == true){
			if($that->Basic->tagRadd($that)){
				if($that->Basic->social($that)){
					debug("tag relation added.");
				}
			}
		}elseif ($that->request->data['Tag']['max_quant'] != null){
			if ($that->Auth->user('id')==$resultForChange['Tag']['user_id']) {
				if($that->Tag->save($that->request->data())){
					$that->Session->setFlash(__('Max quant changed.'));
				}
			}else {
				debug("fail no Auth");
			}
		} elseif($that->request->data['Link']['quant'] != null){
			if($that->Basic->quant($that) && $that->Basic->social($that)){
				$that->Session->setFlash(__('Quant changed.'));
			}
		}
	}
	/**
	 *
	 * @param string $that
	 * @param int $userID
	 * @param int $FromID
	 * @param int $ToID
	 * @param array $options $options['key']
	 */
	public function triAddbyid(&$that = null,$userID,$FromID,$ToID,$options) {
		if ($userID == null) {
			$userID = Configure::read('acountID.admin');
		}
		if ($options['key'] == null){
			$options['key'] = Configure::read('tagID.reply');
		}

		if ($FromID != null) {
			$that->request->data = null;
			$that->request->data['Link'] = array(
					'user_id' => $userID,
					'LFrom' => $FromID,
					'LTo' => $ToID,
					'quant' => 1,
			);
			$Link = new Link();
			$Link->create();
			if ($Link->save($that->request->data)) {

				$that->last_id = $Link->getLastInsertID();
				$that->request->data = null;
				$that->request->data['Link'] = array(
						'user_id' => $userID,
						'LFrom' => $options['key'],//
						'LTo' => $that->last_id,
						'quant' => 1,
				);
				$Link->create();
				if ($Link->save($that->request->data)) {
					$that->Session->setFlash(__('The article has been saved.'));

				} else {
					$that->Session->setFlash(__('The article could not be saved. Please, try again.'));
				}
			}else {
				debug("misslink1");
			}
		}
	}

	public function tritagAdd(&$that = null,$model,$userID,$targetFromID,$options) {
		if ($userID == null) {
			$userID = Configure::read('acountID.admin');
		}
		if ($options['key'] == null) {
			$options['key'] = Configure::read('tagID.reply');
		}

		$Tag = new Tag();
		$tagID = $Tag->find('first',
			array(
				'conditions' => array('name' => $that->request->data['Tag']['name']),
				'user_id' => $userID,
				'fields' => array('Tag.ID')//,
				//'order' => 'Tag.ID'
			)
		);
		if($tagID['Tag']['ID'] == null){
			$Article = new $model();
			$Article->create();
			$Article->save($that->request->data);
			$that->last_id = $Article->getLastInsertID();
		}else{
			$that->last_id = $tagID['Tag']['ID'];
			if ($that->request->params['pass'][0] != null) {
				$that->request->data = null;
				$that->request->data['Link'] = array(
						'user_id' => $userID,
						'LFrom' => $targetFromID,//$that->request->params['pass'][0],
						'LTo' => $that->last_id,
						'quant' => 1,
				);
				debug($that->request->data['Link']);
				$Link = new Link();
				$Link->create();
				if ($Link->save($that->request->data)) {
					$that->last_id = $Link->getLastInsertID();
					$that->request->data = null;
					$that->request->data['Link'] = array(
							'user_id' => $userID,
							'LFrom' => $options['key'],//
							'LTo' => $that->last_id,
							'quant' => 1,
					);
					$Link->create();
					if ($Link->save($that->request->data)) {
						$that->Session->setFlash(__('The tag has been saved.'));

					} else {
						$that->Session->setFlash(__('The tag could not be saved. Please, try again.'));
					}
				}else {
					debug("miss");
				}
			}
		}
	}

	public function trifinder(&$that = null) {
		$id = $that->request['pass'][0];
		$this->Basic->tribasic($that,"search","Article","Article.ID",$id);
		$that->parentres = $that->returntrybasic;
		$that->k = 0;
		$that->j = 0;
		$that->i = 0;
		$that->taghash = array();
		$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
		$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		foreach ($that->parentres as $result){
			$res = $result['Article']['ID'];
			$this->Basic->tribasic($that,"search","Tag",$res,"Tag.ID");
			$that->taghashgen = $that->returntrybasic;
			foreach ($that->taghashgen as $tag){
				$that->subtagID = $tag['Tag']['ID'];
				$that->parentres[$that->i]['subtag'][$that->subtagID] = $tag;
				if ($that->taghash[$that->subtagID] == null) {
					$that->taghash[$that->subtagID] = array( 'ID' => $tag['Tag']['ID'], 'name' =>  $tag['Tag']['name']);
				}
			}
			$that->i++;
		}
		$that->loadModel('User');
		$that->loadModel('Key');
		$that->userlist = $that->User->find( 'list', array( 'fields' => array( 'ID', 'username')));
		$that->set( 'ulist', $that->userlist);
		$that->set('taghashes', $that->taghash);
		$that->set('results', $that->parentres);
	}
	public function trireplyfinder(&$that = null) {
		$id = $that->request['pass'][0];
		$this->Basic->tribasic($that,"reply","Article","Article.ID",$id);
		$that->parentres = $that->returntrybasic;
		$that->k = 0;
		$that->j = 0;
		$that->i = 0;
		$that->taghash = array();
		$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
		//$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		foreach ($that->parentres as $result){
			$res = $result['Article']['ID'];
			$this->Basic->tribasicfind($that,"search","Tag",$res,"Tag.ID");
			$that->taghashgen = $that->returntrybasic;
			foreach ($that->taghashgen as $tag){
				$that->subtagID = $tag['Tag']['ID'];
				$that->parentres[$that->i]['subtag'][$that->subtagID] = $tag;
				if ($that->taghash[$that->subtagID] == null) {
					$that->taghash[$that->subtagID] = array( 'ID' => $tag['Tag']['ID'], 'name' =>  $tag['Tag']['name']);
				}
			}
			$that->i++;
		}
		$that->loadModel('User');
		$that->loadModel('Key');
		$that->set( 'keylist', $that->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
		$that->set( 'ulist', $that->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
		$that->set('taghashes', $that->taghash);
		$that->set('results', $that->parentres);
	}

	/**
	 * trifinderbyid method
	 * id と　trikey を指定すると　結果が帰ってくる
	 * @var this
	 * @var id
	 * @var option ['key']
	 * @return array('tagparentres'
				'articleparentres',
				 'taghash' );
	 *
	 */

	public function trifinderbyid(&$that = null,$id,&$option) {

		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$articleparentres = $this->Basic->tribasicfiderbyid($that,$option['key'],"Article","Article.ID",$id);//どんな記事がぶら下がっているか探す

		list($articleparentres,$taghash) = $this->getSearchRelation($that, $articleparentres, $taghash, "Article");
		$tagparentres = $this->Basic->tribasicfiderbyid($that,$option['key'],"Tag","Tag.ID",$id);
		list($tagparentres,$taghash) =
		$this->getSearchRelation($that, $tagparentres, $taghash, "Tag");
		return array('tagparentres'=>$tagparentres,
				'articleparentres'=> $articleparentres,
				 'taghash' => $taghash);
	}
	/**
	 *
	 * @param string $that
	 * @param unknown $andSet_ids
	 * @param unknown $option
	 * @return multitype:unknown multitype:multitype:NULL  unknown
	 */
	public function trifinderbyidAndSet(&$that,$andSet_ids,&$option = null) {
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$articleparentres = $this->Basic->tribasicfiderbyidAndSet($that,$option['key'],"Article","Article.ID",$andSet_ids);//どんな記事がぶら下がっているか探す
				list($articleparentres,$taghash) = $this->getSearchRelation($that, $articleparentres, $taghash, "Article");
		$tagparentres = $this->Basic->tribasicfiderbyidAndSet($that,$option['key'],"Tag","Tag.ID",$andSet_ids);
		list($tagparentres,$taghash) =
		$this->getSearchRelation($that, $tagparentres, $taghash, "Tag");
		return array('tagparentres'=>$tagparentres,
				'articleparentres'=> $articleparentres,
				'taghash' => $taghash);
	}

	/**
	 *
	 * @param unknown $that
	 * @param unknown $targetParent
	 * @param unknown $taghash
	 * @param unknown $targetModel
	 * @return multitype:multitype:NULL  unknown
	 */

	public function getSearchRelation(&$that,$targetParent,&$taghash,$targetModel){
		$i = 0;
		if (!is_array($targetParent)) return null;
		foreach ($targetParent as $result){
			$taghashgen = $this->Basic->tribasicfiderbyid($that,Configure::read('tagID.search'),"Tag",$result[$targetModel]['ID'],"Tag.ID");//

			foreach ($taghashgen as $tag){
				$that->subtagID = $tag['Tag']['ID'];
				$targetParent[$i]['subtag'][$that->subtagID] = $tag;
				if ($taghash[$that->subtagID] == null) {
					$taghash[$that->subtagID] = array( 'ID' => $tag['Tag']['ID'], 'name' =>  $tag['Tag']['name']);
				}
			}
			$i++;
		}

		return array($targetParent,$taghash );
	}


}