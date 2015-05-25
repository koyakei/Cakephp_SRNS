<?php
App::uses('Social', 'Model');
App::uses('Tag', 'Model');
App::uses('Taguser', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Tagauthcount', 'Model');
Configure::load("static");
App::uses('ConnectionManager', 'Model');
class BasicComponent extends Component {
	public $components = array('Auth');

	public function social(&$that,$userID){
		$data['Social']['vaction'] = $that->action;
		$data['Social']['vplugin'] = $that->plugin;
		$data['Social']['vctrl'] = $that->name;
		$data['Social']['vview'] = $that->view;
		$data['Social']['vpage_id'] = $that->id;
		if ($userID == null) {
			$data['Social']['user_id'] = $that->Auth->user('id');
		}else {
			$data['Social']['user_id'] = $userID;
		}

		$data['Social']['created'] = date("Y-m-d H:i:s");
		$Social = new Social();
		$Social->create();
		return $Social->Save($data,false);

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
	public function tagAuthCountdown(&$that,$FromID,$quant){
		//ignore check special tags
// 		if (in_array($FromID, Configure::read('tagID'))){
// 			return true;
// 		}
		$Tag = new Tag();
		$Tag->id = $FromID;
		$result= $Tag->find();
		$target_user_id = $result["Tag"]["ID"];
		$that->Tagauthcount = new Tagauthcount();
		$options = array('conditions' => array('Tagauthcount.tag_id'=> $FromID
				,'Tagauthcount.user_id'=> $target_user_id
		));
		$result = $that->Tagauthcount->find('first',$options);
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
				if ($that->User == null) {
					$that->User = $that->loadModel('User');
				}
				if($that->User->save($data)){
					$that->Session->setFlash(__('タグ追加成功　残りタグ数'.$that->Auth->user('tlimit')));
					return true;
				}
			}else {
				$that->Session->setFlash(__('タグ追加失敗　'));
				return false;
			}
		}else {
			$that->Session->setFlash(__('タグ追加失敗　発行上限に達しています'));
			return false;
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
		$that->request->data['tag']['user_id'] = $that->request->data['tag']['userid'];
		$that->request->data['Link']['user_id'] = $that->request->data['tag']['userid'];
		$LinkLTo=$that->request->data['Link']['LTo'];
		if (!empty($that->request->data['Tag']['name'])) {
			$that->loadModel('Tag');
			$tagID = $that->Tag->find('first',
				array(
					'conditions' => array('name' => $that->request->data['Tag']['name'],
					'user_id' => $tag_user_id),
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
				if(empty($that->Basic->tribasicfixverifybyid($trikeyID,$LinkLTo))){
					$tagIDd = $tagID['Tag']['ID'];
					if($that->Basic->trilinkAdd($that,$tagIDd,$LinkLTo,$trikeyID)){
						$that->Session->setFlash(__('成功'));
						return true;
					}
				}else{
					$that->Session->setFlash(__('関連付け済み'));
				}
			}
		}else {
				$that->Session->setFlash(__('リクエストが空っぽでこけている　tag.ID'));
			}
			return false;
	}
	/**
	 *
	 * @param array $from_id
	 * @param array $to_ids
	 * @param array $trikey_ids
	 * @param int $user_id
	 * @return boolean
	 */
	public function tagRadd2($from_id,$to_ids,$trikey_ids,$user_id) {
		$searchID = Configure::read('tagID.search');
		$that->request->data['tag']['user_id'] = $that->request->data['tag']['userid'];
		$that->request->data['Link']['user_id'] = $that->request->data['tag']['userid'];
		$LinkLTo=$that->request->data['Link']['LTo'];
		if (!empty($that->request->data['Tag']['name'])) {
			$that->loadModel('Tag');
			$tagID = $that->Tag->find('first',
					array(
							'conditions' => array('name' => $that->request->data['Tag']['name'],
									'user_id' => $tag_user_id),
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
						$that->Session->setFlash(__('成功'));
						return true;
					}
				}else{
					$that->Session->setFlash(__('関連付け済み'));
				}
			}
		}else {
			$that->Session->setFlash(__('リクエストが空っぽでこけている　tag.ID'));
		}
		return false;
	}

	/**
	 * リンクの結合済みチェック
	 * link add の時のチェック
	 * @param string $that
	 * @param unknown $trikeyID
	 * @param unknown $LinkLTo
	 */
	public function tribasicfixverifybyid($trikeyID,$LinkLTo) {
		$Link = new Link();
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
										array("taglink.LFrom" => $trikeyID)
								)
						)
				)
		);
		return  empty($Link->find('first',$option));

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
			);
		return $modelSe->find('all',$option);
	}

	public function allTrilinkFinder($from,$results){
		foreach ($results as $idx => $result){
			$trilink = self::GETTrilink($from, $result['Link']['LTo']);
			if (!empty($trilink)){//TODO: 間違っているかも
				$results[$idx ]['trikey'] = array();
				$results[$idx]['trikey'] = $trilink;
			}
		}
		return $results;
	}
	/**
	 *
	 * @param int $from
	 * @param int $to
	 * @return array trikey key_name
	 */
	private function GETTrilink($from,$to){
		$Link = new Link();
		$option = array(
				'conditions'=> array(//ジョインしなければ、全部のリンクがとれてくるはず。
						"Link.LTo"=> $to,
						"Link.LFrom" =>$from
				),
				'fields' => array("Link.ID",'taglink.name'	),
				'joins'
				=> array(
						array(
								'table' => 'taglinks',
								'alias' => 'taglink',
								'type' => 'INNER',
								'conditions' => array(
										array("Link.ID = taglink.LTo"),
								)
						),
				),
		);
		return $Link->find("list",$option);

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
	public function tribasicRefiderbyid(&$that = null,$trikeyID = null,$modelSe,$LFromtarget,$id) {

		$modelSe = new $modelSe();
		$option = array(
				'conditions'=> array(
						"Link.LFrom" => $LFromtarget
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
								'table' => 'taglinks',
								'alias' => 'taglink',
								'type' => 'INNER',
								'conditions' => array(
										array("Link.ID = taglink.LTo"),
										($trikeyID == null)?null:array($trikeyID." = taglink.LFrom")//$trikeyID
								)
						),
				),
		);
		return $modelSe->find('all',$option);
	}
	/**
	 *
	 * @param unknown $searching_tags
	 * @param unknown $sorting_tags
	 * @param unknown $selectings
	 * @return mixed
	 */
	public function social2(&$that,$searching_tags,$sorting_tags,$selectings){
		// TODO: reply　from 側のfollower の全てに通知を出す
		$data['Social'] = array(
				'user_id' => $that->Auth->user('id'),
				'vaction' => $that->action,
				'vplugin' => $that->plugin,
				'vctrl' => $that->name,
				'vview' => $that->view,
				'page_id' => $that->id,
// 				'ctrl' =>  こっちが実際に更新した物
		);
		$Social = new Social();
		$Social->create();
		return $Social->save($data);
	}

	/**
	 *
	 * @param string $that
	 * @param unknown $link　 link の取得結果
	 * @param unknown $linked_model
	 * @return multitype:＄res $res[$toID] =+ $tr
	 * ,$link_conditions　entity 取得のための条件　or mapper の　in 対応
	 */
	public function linkDistinctor(&$that = null,$link,$linked_model) {
		foreach ($link as $tr){
			if ($link[$rr[$model]['ID']] == null){
				$toID = $tr["Link"]['LTo'];
				if (!array_search($toID,$link)){
					$link_conditions = array_push($link_conditions, $toID);
				}
				$res[$toID] =+ $tr;
				//TODO: ここでリンクとどのタグからリンクしてきているかを入力
				//foearch で回したついでに他の 要素もとってきてしまう
				$res[$toID]['trilink'] =BasicComponent::GetEntity($that, $toID) ;
				$res[$toID]["subtag"] = $this->Basic->tribasicfiderbyid(
					$that,Configure::read('tagID.search'),
					"Tag",$result[$targetModel]['ID'],"Tag.ID");
			}
		}
		return array(＄res,$link_conditions);
	}

	/**
	 *
	 * @param Object $that inherit this
	 * @param array or int $root_ids
	 * @param int $trikey
	 * @param array &$taghash
	 * @return root_id と　trikey を持つ　entity までのLink model
	 * @var res Entity
	 * @var link root_id と　Entitiy の間
	 */
	public function GETLink(&$that,$root_ids,$ToID = null ,$trikey = null){
		$modelSe = new Link();
		$option = array(
			'table' => 'link',
			'alias' => 'Link',
			'conditions'=> array("Link.LFrom" => $root_ids,"Link.LTo" => $ToID),
			'fields' => array('*'		),
			'joins'
			=> array(
					array(
							'table' => 'taglinks',
							'alias' => 'taglink',
							'type' => 'INNER',
							'conditions' => array(
									array("Link.ID = taglink.LTo"),
									($trikeyID == null)?null:array(
											"taglink.LFrom" => $trikey)//$trikeyID
							)
					),
			),
		);
		return  $modelSe->find('listl',$option);//link取得

	}
	//Entity 取得
	public function GetEntity(&$that,$ids,$model=null){
		if (is_null($model)){
			$model = "Tag";
		}
		$modelSe = new $model;
		$option = array(
				'condition' =>
				array($model. "." .$modelSe->primaryKey => $ids)
		);
		return $modelSe->find('all',$option);
	}

	/**
	 * tribasicfiderbyidAndSet method
	 *
	 * @throws NotFoundException
	 * @param mix $that
	 * @param int $trikeyID　
	 * @param string $modelSe
	 * @param string $Ltotarget //target colmunn 探すID
	 * @param array $ids and set array(int , int) 連想配列ではないただの配列
	 * @return $that->returntribasic
	 */
	public function tribasicfiderbyidAndSet(&$that = null,$trikeyID = null,$modelSe,$Ltotarget,$ids= null) {
		if($ids[0] == '"') return ;
		$modelName = $modelSe;
		$modelSe = new $modelSe();
		$andSet = array();
		$or =array();

		foreach ($ids as $idxx =>$id){

			foreach ($id as $idx => $i){
				if ($i == ''){
					unset($id[$idx]);
				}
				$id = array_values($id);
			}

			if ($id !=  array('')){
					array_push($or, array("Link.LFrom" => $id));
			}
		}
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
		                    'conditions' => array("or" => $or
					)
		                ),
				array(
		                    'table' => 'taglinks',
		                    'alias' => 'taglink',
		                    'type' => 'INNER',
		                    'conditions' => array(
					array("Link.ID = taglink.LTo"),
		                    		($trikeyID == null)?null:array("taglink.LFrom" => $trikeyID)//$trikeyID
					)
		                ),
				),
			);
		if (($ids[0][0]!= '' || $ids[0][1]!= '') && ($ids[1][0]!= '' || $ids[1][1]!= '')){
			$option = array_merge($option, array( 'group' => "$Ltotarget HAVING COUNT(*) > 1" ));
		}
		return $modelSe->find('all',$option);
	}


	public function tribasicfiderbyidTF(&$that = null,$trikeyID = null,$modelSe = null,$Ltotarget = null ,$id) {
		// 		$that->loadModel($modelSe);
		$modelSe = new $modelSe();
		$option = array(
				'conditions'=> array(
						"Link.LFrom = $Ltotarget"
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
		$returntribasic = $that->$modelSe->find('all',$option);
		if(!empty($returntribasic)){
			return $returntribasic;
		} else {
			return null;
		}
	}




	/**
	 * 三角関係のリンク追加
	 * @param unknown $that
	 * @param unknown $FromID
	 * @param unknown $ToID
	 * @param unknown $keyID
	 * @param unknown $options if($options['authCheck'] == false){goto authSkip;}
	 * @return boolean
	 */
	public function trilinkAdd(&$that,$FromID,$ToID,$keyID,$options = null) {
		$quant = 1;
		if ($that->request->data['Tag']['user_id'] == null) {
			$that->request->data['Tag']['user_id'] = Configure::read('acountID.admin');
		}
		if($options['authCheck'] == false){goto authSkip;}
		if ($that->Basic->tagAuthCountdown($that,$FromID,$quant)) {
			authSkip:
			$that->Link = new Link();
			$that->request->data['Link'] = array(
					'user_id' => $that->request->data['Tag']['user_id'],
					'LFrom' => $FromID,
					'LTo' => $ToID,//リンク先記事or タグ
					'quant' => $quant,
					'created' => date("Y-m-d H:i:s"),
			);
			$that->Link->create();
			if($that->Link->save($that->request->data)){
				$that->request->data['Link'] = array(
						'user_id' => $that->request->data['Tag']['user_id'],
						'LFrom' => $keyID,
						'LTo' => $that->Link->getLastInsertId(),
						'quant' => $quant,
						'created' => date("Y-m-d H:i:s"),
				);
				$that->Link->create();
				if($that->Link->save($that->request->data)){
					//挿入したIDを返す
					return $that->Link->getLastInsertId();
				}else{
					debug("last step miss");
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