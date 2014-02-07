<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
Configure::load("static");
class BasicComponent extends Component {
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
		$that->returntrybasic = $that->Tag->find('all',$option);
		return $that->returntrybasic;
	}

	public function tribasicfiderbyid(&$that = null,$trikeyID,$modelSe,$Ltotarget,$id) {
		$that->loadModel($modelSe);
		if($trikeyID == null) {
			$trikeyID = Configure::read('tagID.reply');//tagConst()['replyID'];
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
		$that->returntribasic = $that->$modelSe->find('all',$option);
		return $that->returntribasic;
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
		                    'table' => 'Link',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("$id = Link.LTo")
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
		$that->loadModel('Link');
		$that->request->data['Link'] = array(
			'user_id' => $that->request->data['tag']['userid'],
			'LFrom' => $FromID,
			'LTo' => $ToID,//リンク先記事or タグ
			'quant' => 1,
			'created' => date("Y-m-d H:i:s"),
			'modified' => date("Y-m-d H:i:s"),
		);
		$that->loadModel('Link');
		$that->Link->create();
		$that->Link->save($that->request->data);
		$that->last_id = $that->Link->getLastInsertID();
		$that->request->data['Link'] = array(
			'user_id' => $that->request->data['tag']['userid'],
			'LFrom' => $keyID,//
			'LTo' => $that->last_id,
			'quant' => 1,
			'created' => date("Y-m-d H:i:s"),
			'modified' => date("Y-m-d H:i:s"),
		);
		$that->Link->create();
		$that->Link->save($that->request->data);
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