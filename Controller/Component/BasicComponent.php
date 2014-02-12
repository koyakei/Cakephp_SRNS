<?php
App::uses('Social', 'Model');
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
Configure::load("static");
class BasicComponent extends Component {
	public function social(&$that){
		/*debug($that->plugin);
		debug($that->action);
		debug($that->view);
		debug($that->name);
		debug($that->id);*/
		$data['Social']['vaction'] = $that->action;
		$data['Social']['vplugin'] = $that->plugin;
		$data['Social']['vctrl'] = $that->name;
		$data['Social']['vview'] = $that->view;
		$data['Social']['page_id'] = $that->id;
		$data['Social']['user_id'] = Configure::read('acountID.admin');
		$data['Social']['created'] = date("Y-m-d H:i:s");
		$Social = new Social();
		$Social->create();
		$Social->Save($data);
	}

	public function quant(&$that) {
		if ($that->request->is('post')) {
			$that->userID = $that->Auth->user('id');
			if ($that->userID == null) {
				$that->userID = Configure::read('acountID.admin');
			}
			if($that->request->data['Link']['user_id'] == $that->userID){
				$that->loadModel('Link');
				if ($that->Link->save($that->request->data)) {
					$that->Session->setFlash(__('The article has been saved.'));
				} else {
					$that->Session->setFlash(__('The article could not be saved. Please, try again.'));
				}
			}
		}
	}

	public function tagRadd(&$that) {
		$searchID = Configure::read('tagID.search');//tagConst()['searchID'];
		$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
		//$that->Link->unbindModel(array('hasOne'=>array('LO')), false);
		$that->request->data['Tag']['user_id'] = $that->request->data['tag']['userid'];
		$that->request->data['Link']['user_id'] = $that->request->data['tag']['userid'];
		$LinkLTo=$that->request->data['Link']['LTo'];
		if (!empty($that->request->data['Tag']['name'])) {
			$that->loadModel('Tag');
			$tagID = $that->Tag->find('first',
				array(
					'conditions' => array('name' => $that->request->data['Tag']['name'],
					'user_id' => $that->request->data['Tag']['user_id']),
					'fields' => array('Tag.ID'),
					'order' => 'Tag.ID'
				)
			);
			if($tagID == null){
				$that->Tag->create();
				$that->Tag->save($that->request->data);
				$last_id = $that->Tag->getLastInsertID();
				$that->Basic->trilinkAdd($that,$last_id,$LinkLTo,Configure::read('tagID.search'));
				$that->Session->setFlash(__('タグがなかった.'));
			}else {
				$that->loadModel('Link');
				$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
				$that->Link->unbindModel(array('hasOne'=>array('LO')), false);
				$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
				$that->Basic->tribasicfixverifybyid($that,$trikeyID,$LinkLTo);
				$LE = $that->returntribasic;
				if(null == $LE){
					$tagIDd = $tagID['Tag']['ID'];
					$that->Basic->trilinkAdd($that,$tagIDd,$LinkLTo,$trikeyID);
					$that->Session->setFlash(__('タグ既存リンク追加'));

				}else{
					$that->Session->setFlash(__('関連付け済み'));
				}
			}
		}
		debug($that->referer());
		//$that->redirect($that->referer());
	}
	public function test(&$that){
		$that->redirect($that->referer());
	}
	public function tribasic(&$that = null,$trykeyname,$modelSe,$Ltotarget,$id) {
		$that->loadModel($modelSe);
		$trikeyID = Configure::read('tagID.'.$trykeyname);//tagConst()[$trykeyname];
		$that->Paginator->settings = array(
			'conditions'=> array(
			        	"Link.LTo = $Ltotarget"
		        	 ),
			'fields' => array('Link.*',$modelSe .'.*'
				),
			'joins'
			 => array(
			array(
	                    'table' => 'link',
	                    'alias' => 'Link',
	                    'type' => 'INNER',
	                    'conditions' => array(
				array("$id = Link.LFrom")
				)
	                ),
			array(
	                    'table' => 'link',
	                    'alias' => 'taglink',
	                    'type' => 'INNER',
	                    'conditions' => array(
				array("Link.ID = taglink.LTo"),
				array($trikeyID . " = taglink.LFrom")
				)
	                ),
			)
		);
		$that->returntrybasic = $that->Paginator->paginate($modelSe);
		return $that->returntrybasic;
	}

	public function tribasicfind(&$that = null,$trykeyname,$modelSe,$Ltotarget,$id) {
		$that->loadModel($modelSe);
		$trikeyID = Configure::read('tagID.'.$trykeyname);//tagConst()[$trykeyname];
		$option = array(
				'conditions'=> array(
				        	"Link.LTo = $Ltotarget"
			        	 ),
				'fields' => array('Link.*',$modelSe .'.*'
					),
				'joins'
				 => array(
				array(
		                    'table' => 'link',
		                    'alias' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("$id = Link.LFrom")
					)
		                ),
				array(
		                    'table' => 'link',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
					array($trikeyID . " = taglink.LFrom")
					)
		                ),
				),
				'order' => ''
			);
		$that->returntrybasic = $that->Tag->find('all',$option);
		return $that->returntrybasic;
	}

	public function tribasicfiderbyid(&$that = null,$trikeyID,$modelSe,$Ltotarget,$id) {
		$that->loadModel($modelSe);
		$option = array(
				'conditions'=> array(
				        	"Link.LTo = $Ltotarget"
			        	 ),
				'fields' => array('Link.*',$modelSe .'.*'
					),
				'joins'
				 => array(
				array(
		                    'table' => 'link',
		                    'alias' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("$id = Link.LFrom")
					)
		                ),
				array(
		                    'table' => 'link',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
					array($trikeyID." = taglink.LFrom")//$trikeyID
					)
		                ),
				),
				'order' => ''
			);
		$that->returntribasic = $that->$modelSe->find('all',$option);
		return $that->returntribasic;
	}
	public function triupperfiderbyid(&$that = null,$trikeyID,$modelSe,$id) {
		$that->loadModel($modelSe);
		/*if($trikeyID == null) {
			$trikeyID = Configure::read('tagID.reply');//tagConst()['replyID'];
		}*/
		$option = array(
				'conditions'=> array(
				        	"Link.LFrom =".$modelSe.".ID"
			        	 ),
				'fields' => array('Link.*',$modelSe .'.*'
					),
				'joins'
				 => array(
				array(
		                    'table' => 'link',
		                    'alias' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("$id = Link.LTo")
					)
		                ),
				array(
		                    'table' => 'link',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
					array($trikeyID . " = taglink.LFrom")
					)
		                ),
				),
				'order' => ''
			);
		$that->returntribasic = $that->$modelSe->find('all',$option);
		return $that->returntribasic;
	}
	public function tribasicfixverifybyid(&$that = null,$trikeyID,$LinkLTo) {
		$that->loadModel('Link');
		//$trikeyID = tagConst()[$trykeyname];
		if($trikeyID == null) {
			$trikeyID = Configure::read('tagID.reply');//tagConst()['replyID'];
		}
		$option = array(
			'order' => '',
	        'conditions' => array('Link.LTo' => $LinkLTo,'Link.LFrom' => $LinkLTo),
	        'fields' => array('Link.ID'),
			'order' => 'Link.ID',
			'joins' => array(
				array(
                    'table' => 'Link',
                    'alias' => 'taglink',
                    'type' => 'INNER',
                    'conditions' => array(
						array("Link.ID = taglink.LTo"),
						array("$trikeyID = taglink.LFrom")
			        )
				)
			)
		);

		$that->returntribasic = $that->Link->find('first',$option);
		return $that->returntribasic;
	}
	public function trilinkAdd(&$that,$FromID,$ToID,$keyID) {
		debug($that->request->data['Tag']['user_id']);
		debug($keyID);
		$that->loadModel('Link');
		$that->request->data['Link'] = array(
			'user_id' => $that->request->data['Tag']['user_id'],
			'LFrom' => $FromID,
			'LTo' => $ToID,//リンク先記事or タグ
			'quant' => 1,
			'created' => date("Y-m-d H:i:s"),
			'modified' => date("Y-m-d H:i:s"),
		);
		$that->loadModel('Link');
		$that->Link->create();
		if($that->Link->save($that->request->data)){
			$that->last_id = $that->Link->getLastInsertID();
			$that->request->data['Link'] = array(
					'user_id' => $that->request->data['Tag']['user_id'],
					'LFrom' => $keyID,//
					'LTo' => $that->last_id,
					'quant' => 1,
					'created' => date("Y-m-d H:i:s"),
					'modified' => date("Y-m-d H:i:s"),
			);
			$that->Link->create();
			if($that->Link->save($that->request->data)==false){
				debug("2nd step miss");
			}
		}else{
			debug("1st step miss");
		}

	}

	public function trisinglefind(&$that = null,$trikeyID,$modelSe,$Ltotarget) {
		$that->loadModel($modelSe);
		if($trikeyID == null) {
			$trikeyID = Configure::read('tagID.reply');
		}
		$option = array(
				'conditions'=> array(
						"Link.LTo = $Ltotarget"
				),
				'fields' => array('Link.*',$modelSe .'.*'
				),
				'joins'
				=> array(
						array(
							'table' => 'Link',
							'type' => 'INNER',
							'conditions'=> array(
								"Link.LTo = $modelSe.ID"
							)
						),
						array(
								'table' => 'Link',
								'alias' => 'taglink',
								'type' => 'INNER',
								'conditions' => array(
										array("Link.ID = taglink.LTo"),
										array($trikeyID . " = taglink.LFrom")
								)
						),
				),
				'order' => ''
		);
		$that->returntrybasic = $that->$modelSe->find('all',$option);
		return $that->returntrybasic;
	}
/*
	public function tribasicfiderbyida(&$that = null) {
		$modelSe=$this->modelSe;
		$that->loadModel($modelSe);
		//$trikeyID = tagConst()[$trykeyname];
		if($trikeyID == null) {
			$trikeyID = tagConst()['replyID'];
		}
		$option = array(
				'conditions'=> array(
						"Link.LTo = $Ltotarget"
				),
				'fields' => array('Link.*',$modelSe .'.*'
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
										array($trikeyID . " = taglink.LFrom")
								)
						),
				),
				'order' => ''
		);
		$that->returntrybasic = $that->$modelSe->find('all',$option);
		return $that->returntrybasic;
	}*/
}