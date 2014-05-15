<?php
App::uses('Social', 'Model');
App::uses('Tag', 'Model');
App::uses('Taguser', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Tagauthcount', 'Model');
Configure::load("static");
class BasicComponent extends Component {
	public $components = array('Auth');
	public function social(&$that,$userID){
		$data['Social']['vaction'] = $that->action;
		$data['Social']['vplugin'] = $that->plugin;
		$data['Social']['vctrl'] = $that->name;
		$data['Social']['vview'] = $that->view;
		$data['Social']['page_id'] = $that->id;
		if ($userID == null) {
			$data['Social']['user_id'] = $that->Auth->user('id');;
		}else {
			$data['Social']['user_id'] = $userID;
		}

		$data['Social']['created'] = date("Y-m-d H:i:s");
		debug($data);
		$Social = new Social();
		$Social->create();
		if($Social->Save($data,false)){
			debug("social ok");
			return true;
		} else{
			debug("social miss");
			return FALSE;
		}
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
	/**
	 * publish tagAuthCountdown method
	 *
	 * @param mixed $that
	 * @param string $FromID
	 * @param string $target_user_id //give or recive する対象
	 * @param string $quant //give する量+　recive -
	 * @return boolean
	 */
	public function tagAuthCountdown(&$that,$FromID,$target_user_id,$quant){
		$that->Tagauthcount = new Tagauthcount();
		$options = array('conditions' => array('Tagauthcount.tag_id'=> $FromID
				,'Tagauthcount.user_id'=> $target_user_id
		));
		$result = $that->Tagauthcount->find('first',$options);
		debug($result);
		//$data['Auth'] = array('id'=>$result['Auth']['id'],'quant'=> $that->request->data['Auth']['quant']);
		$result['Tagauthcount']['quant'] = $result['Tagauthcount']['quant'] - $quant;//動かし分だけquantを消費　==
		if ($result['Tagauthcount']['quant'] >= 0) {//払っても借金でないことを確認。借金を実装するときはここを変える。
			if(null != $result['Tagauthcount']['user_id']){
				if($that->Tagauthcount->save($result)){
					debug("auth count down ok");
					return true;
				}else {
					debug("auth count down miss");
					return false;
				}
			}else{
				debug("auth count down miss");
				return false;
			}
		}
		return false;
	}

	public function taglimitcountup(&$that){
		if ($that->Auth->user('tlimit') > 0) {
			if($that->Tag->save($that->request->data)){
				$that->last_id = $that->Tag->getLastInsertID();
				$data['User']['id'] = $that->request->data['Tag']['user_id'];
				$data['User']['tlimit'] = $that->Auth->user('tlimit')- 1;
				if($that->User->save($data)){
					$that->Session->setFlash(__('タグ追加成功　残りタグ数'.$that->Auth->user('tlimit')));
				}
			}else {
				$that->Session->setFlash(__('タグ追加失敗　'));
			}
		}else {
			$that->Session->setFlash(__('タグ追加失敗　発行上限に達しています'));
		}
	}
	public function tagLimitCountDel(&$that){
		$that->loadModel('User');
		if($that->Tag->save($that->request->data)){
			if ($that->Tag->delete()) {
				$data['User']['tlimit'] = $that->Auth->user('tlimit') + 1;
				$data['User']['id'] = $that->request->data['Tag']['user_id'];
				if($that->User->save($data)){
					$that->Session->setFlash(__('The tag has been deleted.残りタグ数'.$that->Auth->user('tlimit')));
				}else {
					$that->Session->setFlash(__('deleted but can not count up..残りタグ数'.$that->Auth->user('tlimit')));
				}
        	} else {
        		$that->Session->setFlash(__('The tag could not be deleted. Please, try again.残りタグ数'.$that->Auth->user('tlimit')));
        	}
		}else {
			$that->Session->setFlash(__('タグ追加失敗　発行上限に達しています'));
		}
	}
	public function tagRadd(&$that) {
		$searchID = Configure::read('tagID.search');
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
				$that->Basic->taglimitcountup($that);
				$that->Basic->trilinkAdd($that,$that->last_id,$LinkLTo,Configure::read('tagID.search'));
			}else {
				$that->loadModel('Link');
				$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
				$that->Link->unbindModel(array('hasOne'=>array('LO')), false);
				$trikeyID = Configure::read('tagID.search');//tagConst()['searchID'];
				$that->Basic->tribasicfixverifybyid($that,$trikeyID,$LinkLTo);
				$LE = $that->returntribasic;
				if(null == $LE){
					$tagIDd = $tagID['Tag']['ID'];
					if($that->Basic->trilinkAdd($that,$tagIDd,$LinkLTo,$trikeyID)){
						debug(debug("sucsess"));
						return true;
					}
				}else{
					$that->Session->setFlash(__('関連付け済み'));
					debug("already exist");
				}
			}
		}else {
				$that->Session->setFlash(__('リクエストが空っぽでこけている　tag.ID'));
			}
			return false;
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
	/**
	 * tribasicfiderbyid method
	 *
	 * @throws NotFoundException
	 * @param mix $that
	 * @param int $trikeyID
	 * @param string $modelSe
	 * @param string $Ltotarget //target colmunn 探すID
	 * @param ind $id
	 * @return $that->returntribasic
	 */
	public function tribasicfiderbyid(&$that = null,$trikeyID = null,$modelSe,$Ltotarget,$id) {
// 		$that->loadModel($modelSe);
		$modelSe = new $modelSe();
		$option = array(
				'conditions'=> array(
				        	"Link.LTo = $Ltotarget"
			        	 ),
				'fields' => array('*'		),
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
		                    'table' => 'taglinks',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
		                    		($trikeyID == null)?null:array($trikeyID." = taglink.LFrom")//$trikeyID
					)
		                ),
				),
				'order' => ''
			);
		$that->returntribasic = $modelSe->find('all',$option);
		return $that->returntribasic;
	}
	public function tribasicfiderbyidTF(&$that = null,$trikeyID = null,$modelSe = null,$Lfromtarget = null ,$id) {
		// 		$that->loadModel($modelSe);
		$modelSe = new $modelSe();
		$option = array(
				'conditions'=> array(
						"Link.LFrom = $Lfromtarget"
				),
				'fields' => array('*'		),
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
										($trikeyID == null)?null:array($trikeyID." = taglink.LFrom")//$trikeyID
								)
						),
				),
				'order' => ''
		);
// 		debug($modelSe->find('all',$option));
	    return $modelSe->find('all',$option);

	}
	public function triupperfiderbyid(&$that = null,$trikeyID,$modelSe,$id) {
		$that->loadModel($modelSe);
		if($trikeyID == null) {
			$trikeyID = Configure::read('tagID.reply');//tagConst()['replyID'];
		}
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
                    'table' => 'link',
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
	public function trilinkAdd(&$that,$FromID,$ToID,$keyID,$options) {
		$quant = 1;
		if ($that->request->data['Tag']['user_id'] == null) {
			$that->request->data['Tag']['user_id'] = Configure::read('acountID.admin');
		}
		if($options['authCheck'] == false){goto authSkip;}
		if ($that->Basic->tagAuthCountdown($that,$FromID,$that->request->data['tag']['userid'],$quant)) {
			authSkip:
			$that->loadModel('Link');
			$that->request->data['Link'] = array(
					'user_id' => $that->request->data['Tag']['user_id'],
					'LFrom' => $FromID,
					'LTo' => $ToID,//リンク先記事or タグ
					'quant' => $quant,
					'created' => date("Y-m-d H:i:s"),
			);
			$that->Link->create();
			if($that->Link->save($that->request->data)){
				$that->last_id = $that->Link->getLastInsertID();
				$that->request->data['Link'] = array(
						'user_id' => $that->request->data['Tag']['user_id'],
						'LFrom' => $keyID,//
						'LTo' => $that->last_id,
						'quant' => $quant,
						'created' => date("Y-m-d H:i:s"),
				);
				$that->Link->create();
				if($that->Link->save($that->request->data)){
					//挿入したIDを返す
					debug($that->last_id);
					return $that->last_id;
				}
			}else{
				debug("1st step miss");
				return false;
			}
			return false;
		}
		return false;
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