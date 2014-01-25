<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('BasicComponent', 'Controller/Component'); 
class CommonComponent extends Component {
        public $components = array('Basic');
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
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
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
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
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
	public function triarticleAdd(&$that = null) {
		if ($that->keyid == null){
			$this->Session->setFlash(__('no that->keyid'));
			}else{
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
						'created' => date("Y-m-d H:i:s"),
						'modified' => date("Y-m-d H:i:s"),
					);
					$Link = new Link();
					$Link->create();
					if ($Link->save($that->request->data)) {
					$that->last_id = $Link->getLastInsertID();
					$that->request->data = null;
					$that->request->data['Link'] = array(
						'user_id' => 1,
						'LFrom' => $that->keyid,//
						'LTo' => $that->last_id,
						'quant' => 1,
						'created' => date("Y-m-d H:i:s"),
						'modified' => date("Y-m-d H:i:s"),
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
	}
	
	public function trifinder(&$that = null) {
		$id = $that->request['pass'][0];
		$this->Basic->tribasic($that,"searchID","Article","Article.ID",$id);
		$that->parentres = $that->returntrybasic;
		$that->k = 0;
		$that->j = 0;
		$that->i = 0;
		$that->taghash = array();
		$trikeyID = tagConst()['searchID'];
		$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		foreach ($that->parentres as $result){
			$res = $result['Article']['ID'];				
			$this->Basic->tribasic($that,"searchID","Tag",$res,"Tag.ID");
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
		$this->Basic->tribasic($that,"replyID","Article","Article.ID",$id);
		$that->parentres = $that->returntrybasic;
		$that->k = 0;
		$that->j = 0;
		$that->i = 0;
		$that->taghash = array();
		$trikeyID = tagConst()['searchID'];
		//$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		foreach ($that->parentres as $result){
			$res = $result['Article']['ID'];				
			$this->Basic->tribasicfind($that,"searchID","Tag",$res,"Tag.ID");
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
}