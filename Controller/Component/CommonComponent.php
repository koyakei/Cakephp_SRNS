<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Taglink', 'Model');
App::uses('Trilink', 'Model');
App::uses('Article', 'Model');
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
App::uses('FollowComponent', 'Controller/Component');
// App::uses('AuthComponent', 'Controller/Component');
Configure::load("static");
class CommonComponent extends Component {
    public $components = array('Basic',"Demand",

//     "Follow"

    );
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
			$ToID= $var['ID'];
			$that->Common->triAddbyid($that,$that->Auth->user('id'),$fromID,$ToID,$options);
			//}
		}
	}
	public function singleAdd($name,$user_id,$auth = null){
		$this->Article = new Article();
		$this->Article->create();
		$data = array("Article"=>
				array(
						"name" =>$name,
						"user_id" => $user_id,
				)
		);
		$this->Article->save($data);
		return $this->Article->getLastInsertID();
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
	 * @param unknown $data
	 * @param unknown $root_ids
	 * @param unknown $trikey_ids
	 * @param unknown $parent_ids
	 * @param unknown $before
	 * @param unknown $after
	 */
	public function nestedAdd(&$that,$root_ids,$trikey_ids,
			$parent_ids,$child_ids,$quantize = 0){
		is_null($that)?$that = $this:null;

		is_null($parent_ids)?$parent_ids = $that->request->data("parent_ids"): null;
		is_null($trikey_ids)? $trikey_ids = $that->request->data("trikey_ids"): null;
		empty($trikey_ids)? $trikey_ids = Configure::read("tagID.reply"): null;
		is_null($child_ids)?$child_ids = $that->request->data("child_ids"): null;
		//一段階のみのreply 設定
		//trikey 使い放題なの？
		//trikeyと　from トシテの使われ方で権限別にする？
		//別にしないで同じように管理しよう。
		foreach ($parent_ids as $parent_id){
			self::requestInsertDemands($that,$parent_id,$child_ids,$trikey_ids,$that->Auth->user("id"),$quantize);
		}
		return true;
	}
	public function requestInsertDemands(&$that,$from_ids,$to_ids,$trikey_ids,$user_ids,$quantize){
		$from_ids = (array)$from_ids;
		$to_ids = (array)$to_ids;
		$trikey_ids = (array)$trikey_ids;
		$user_ids = (array)$user_ids;
		foreach ($from_ids as $from_id){
			foreach ($to_ids as $to_id){
					foreach ($user_ids as $user_id){
						self::trilinkAdd($that,$from_id,$to_id,$trikey_ids,$user_id,$quantize);
					}

			}
		}
		return true;
	}
	public function trilinkAdd($that,$from_id,$to_id,$trikey_id,$user_id,$quantize){
		if (empty($trikey_id)){
			$trikey_id = Configure::read('tagID.search');
		};
		if($to_id == null){
			return false;
		}else {
			$that->Tag = new Tag();
			$that->Link = new Link();
			$that->Tag->unbindModel(array('hasOne'=>array('TO')), false);
			$that->Link->unbindModel(array('hasOne'=>array('LO')), false);
			$options['authCheck'] = false;
			if($that->Basic->tribasicfixverifybyid($trikey_id,$to_id,$options)){
				if($that->Basic->trilinkAdd($that,$from_id,$to_id,$trikey_id,$quantize)){
					$that->Session->setFlash(__('成功'));
					return true;
				}
			}else{
				$that->Session->setFlash(__('関連付け済み'));
			}
			$that->Session->setFlash(__('失敗'));
		}


		return false;

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
		$data['Link'] = array(
				'user_id' => $userID,
				'LFrom' => $FromID,
				'LTo' => $ToID,
				'quant' => 1,
		);
		$Link = new Link();
		$Link->create();
		if ($Link->save($data)) {
			$that->last_id = $Link->getLastInsertID();
			$data = null;
			$data['Link'] = array(
					'user_id' => $userID,
					'LFrom' => $options['key'],//
					'LTo' => $that->last_id,
					'quant' => 1,
			);
			$Link->create();
			if ($Link->save($data)) {

				$that->Session->setFlash(__('The entity has been saved.'));

			} else {
				$that->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		}else {
			$that->Session->setFlash(__("misslink1"));
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

	public function GETrootTrikey($results){
		foreach ($results as $idx => $articleparentre){
// 			$results[$idx]["follow"] = array();
// 			array_push($results[$idx]["follow"],  $articleparentre["Link"]["LFrom"]);
			$results[$idx]["trikeys"] = array();
			$results[$idx]["trikeys"] = self::allTrikeyFinder($articleparentre["Link"]["ID"]);
		}
		return $results;
	}
	/**
	 * trifinderbyid method
	 * id と　trikey を指定すると　結果が帰ってくる
	 * @param Object that
	 * @param int id
	 * @param array option
	 * @var this
	 * @var id
	 * @var option ['key']
	 * @return array('tagparentres'
	 'articleparentres',
	 'taghash' );
	 *
	 */
	public function trifinderbyid(&$that = null,$id,$quantize = 0,&$option) {
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$articleparentres = self::GETrootTrikey($this->Basic->tribasicfiderbyid($that,$option['key'],"Article","Article.ID",$id,$quantize));
		list($articleparentres,$taghash) =
		$this->getSearchRelation($that,$articleparentres, $taghash, "Article");
		$tagparentres =  self::GETrootTrikey($this->Basic->allTrilinkFinder($id,$this->Basic->tribasicfiderbyid($that,$option['key'],"Tag","Tag.ID",$id,$quantize)));
		list($tagparentres,$taghash) =
		$this->getSearchRelation($that, $tagparentres, $taghash, "Tag");
		return array('tagparentres'=>$tagparentres,
				'articleparentres'=> $articleparentres,
				 'taghash' => $taghash);
	}
	public function searchFinder($id, $trikey){
		$result = array();
		return self::searchEntity($id, $trikey);
	}
	private function searchBoth($id,$trikey){
		foreach (self::models as $model){
			yield  self::searchEntity($id, $trikey, $model);
		}
	}
	/**
	 *
	 * @param int $id
	 * @param int $trikey
	 * @param string $model
	 * @return multitype:
	 */
	private function searchEntity($id, $trikey){
		$result = array();
		$Trilink = new Trilink();
		$options = array("conditions" =>
				array(
						"AND" => array(array("Trilink.Link_LFrom" => $id[0]),
								$id[1] != array('','') ? array("Trilink.Link_LFrom" => $id[1]):false
						),
						"Trilink.LFrom" => $trikey,
				),
				'contain' => array("Tag","Article",
						"Search" =>array("fields" => array("Link_LTo"),"Stag"),
						'Parallel',
				),
		);
		return $Trilink->find("all",$options);
		//リプライでどうやって　なかに
		//Rtag niyotte　headding を並び替えるにや？
		$params = array(
				'fields' => array(
						'username'
				),
				'contain' => array(
						'Profile',
						'Account' => array(
								'AccountSummary'
						),
						'Post' => array(
								'PostAttachment' => array(
										'fields' => array(
												'id',
												'name'
										),
										'PostAttachmentHistory' => array(
												'HistoryNote' => array(
														'fields' => array(
																'id',
																'note'
														)
												)
										)
								),
								'Tag' => array(
										'conditions' => array(
												'Tag.name LIKE' => '%1%'
										)
								)
						)
				)
		);
	}
	/**
	 * view2用のテーブル取得関数
	 * これをget_all_reply から実行する。
	 * @param Object $that
	 * @param unknown $root_ids
	 * @param unknown $trikey_ids
	 * @param unknown $sorter_ids
	 * @param unknown $searchMode
	 * @param unknown $taghash
	 * @return unknown
	 */
	public function GetTable(&$that,$root_ids,$trikey_ids,$sorter_ids
			,$searchMode,&$taghash){
// 		$res = BasicComponent::GETlink($that,$root_ids,$trikey_ids);
		//link まで全部重ねて取るのはまずそう。リンクを取得してから、Entityに
		$option["key"] = $trikey_ids;
		$main = self::trifinderbyidAndSet($that,$andSet_ids,$option);
		list($link,$link_conditions) = BasicComponent::linkDistinctor($link,"Link");
		// $link[$linkTo_id] = array(LinkModel_res ,EntityModel_res);
		$entity = BasicComponent::GetEntity($that, $link_conditions);
		foreach ($entity as $index => $each){
			$each[$model][$primaryKey];
		}
		list($result,$taghash) = CommonComponent::getSearchRelation(
				$that,$entity,$taghash,$targetModel,array("ToID"=> $root_ids,"trikeys" =>$trikey_ids));
		return $result;
	}
	/**
	 *
	 * @param string $that
	 * @param unknown $andSet_ids
	 * @param unknown $option
	 * @return multitype:unknown multitype:multitype:NULL  unknown
	 */
	public function trifinderbyidAndSet(&$that,$andSet_ids,$option = null) {
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$articleparentres = $this->Basic->tribasicfiderbyidAndSet($that,$option['key'],"Article","Article.ID",$andSet_ids);//どんな記事がぶら下がっているか探す
		list($articleparentres,$taghash) = $this->getSearchRelation($that, $articleparentres, $taghash, "Article");
		$tagparentres = $this->Basic->tribasicfiderbyidAndSet($that,$option['key'],"Tag","Tag.ID",$andSet_ids);
		list($tagparentres,$taghash) =$this->getSearchRelation($that,$tagparentres,$taghash,"Tag");

		return array('tagparentres'=>$tagparentres,
				'articleparentres'=> $articleparentres,
				'taghash' => $taghash);
	}

	/**
	 * @param unknown $that
	 * @param unknown $roots
	 * @param unknown $sorting_tags
	 * @param unknown $id
	 * @param unknown $taghash
	 * @param unknown $parents
	 * @param string $option
	 * @param string $index インデックステーブルを　最初のsんしょうだんかいからのみ返す。
	 * @return multitype:
	 *
	 * trikey で整形するのはview 側では相当面倒なのでここでやりたい
	 * r array( article , tag) と分かれているが、それごとにもう一度　foreach を回して　trikey ごとに紐付けていくか？
	 */
    const   models = array( 'article' ,'tag');
	public function nestfinderbyid(&$that,&$roots,$sorting_tags,$id,&$parents,$quantize = 0,
			$option = null){
		$indexHashes = array();
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$children = array();
		foreach (self::models as $p_model){
			$p_model_parent = $p_model."parentres";
			foreach ($parents[$p_model_parent] as $parent_idx =>$parent){
				$parents[$p_model_parent][$parent_idx]['trikeys']
				= self::allTrikeyFinderWithLinkId($parent["Link"]["ID"]);
			}
		}
		foreach (self::models as $p_model){
			$from_id = $to_id = array();
			$p_model_parent = $p_model."parentres";
			foreach ($parents[$p_model_parent] as $parent_idx =>$parent){

				foreach (self::models as  $r_model){
					$r_model_parent = $r_model. "parentres";
					foreach ($roots[$r_model_parent] as $root_idx =>$root){
							if ($parent[ucfirst($p_model)]["ID"] != null){
								$is_child = false;
								$this_nodes  = self::trifinderbyid($that,$parent[ucfirst($p_model)]["ID"],$quantize,$options);
// 								$this_nodes = self::nestfinderbyid($that, $roots, $sorting_tags, $id, $parents);
								//indexHash generator
								foreach (self::allTrikeyFinder($parent["Link"]["ID"]) as $key =>$index){
									if ($indexHashes[$key]== null){
										$indexHashes[$key] = $index;
									}
								}

								foreach (self::models as $model){
									$model_parent = $model."parentres";
									foreach ($this_nodes[$model_parent] as $this_node){
										foreach (self::models as $ip_model){
											$ip_model_parent = $ip_model."parentres";
											foreach ($parents[$ip_model_parent] as $iparent_idx =>$iparent){

												if (($root[ucfirst($r_model)]['ID'] == $this_node[ucfirst($model)]['ID'] && //ルートノードに存在し、かつ
														$iparent[ucfirst($ip_model)]['ID'] == $this_node[ucfirst($model)]['ID'])){ // 親に含まれているなら
													//削除フェーズ
													unset($parents[$ip_model_parent][$iparent_idx]);

													array_merge($parents[$p_model_parent]);
													//TODO:配列を詰めるところを削除したせいで　結果に空欄ができていることに気づかなかった
													//follow キーを追加すると空と認識されないから詰まない　ステップ実行とかで　早くそれを認識する方法を考える
													//モジュール化して整理しないとまた同じ間違いをするのではないか？考えよう
													//追加フェーズ
													// 														//follow
													// 														$roots[$p_model_parent][$parent_idx]["follow"] = array();
													// 														$root["follow"] =$roots[$p_model_parent][$parent_idx]["follow"];
													array_push($root["follow"],$this_node["Link"]["LFrom"]);
													array_push($roots[$p_model_parent][$parent_idx]["follow"],$parent["Link"]["LFrom"]);
													//leaf 追加
													if (is_null($parents[$p_model_parent][$parent_idx]['leaf'])){
														$parents[$p_model_parent][$parent_idx]['leaf']["nodes"] = array();
														$parents[$p_model_parent][$parent_idx]['leaf']["index"] = array();
														$parents[$p_model_parent][$parent_idx]['leaf']['trikeys']= array();
														$parents[$p_model_parent][$parent_idx]['leaf']["taghash"] = array();
														if (is_null($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$model_parent])){
															$parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$model_parent] = array();
														}
													}
													array_push($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$model_parent]
															,$root);

												}
											}
										}

									}
								}
						}
					}
				}
				if(!empty($parents[$p_model_parent][$parent_idx]['leaf'])){
					$from_id = $to_id = array();
					foreach (self::models as $taghash_model){
						$taghash_model_parent = $taghash_model."parentres";
						list($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent],$parents[$p_model_parent][$parent_idx]['leaf']["taghash"]) =
						self::getSearchRelation($that,$parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent] ,
								$parents[$p_model_parent][$parent_idx]['leaf']["taghash"], (string)ucfirst($taghash_model));
						if (is_array($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent])){
							array_merge($from_id,
									Hash::extract($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent],
											"{n}.Link.LFrom"));
							array_merge($to_id,
									Hash::extract($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent],
											"{n}.Link.LTo"));
						}
						$from_id = $to_id = array();
					}
					$parents[$p_model_parent][$parent_idx]['leaf']["parallel"] = array(); // 並列関係の判定
					$parents[$p_model_parent][$parent_idx]['leaf']["parallel"] = !empty($this->Basic->parallelChecker($from_id,$to_id));
				}
				if (is_array($parents[$p_model_parent][$parent_idx]['leaf']["nodes"][$taghash_model_parent])){
				array_merge($from_id,
						Hash::extract($parents[$p_model_parent],
								"{n}.Link.LFrom"));
				array_merge($to_id,
						Hash::extract($parents[$p_model_parent],
								"{n}.Link.LTo"));
				}
			}
			$parents["parallel"] = array(); // 並列関係の判定
			$parents["parallel"] = !empty($this->Basic->parallelChecker($from_id,$to_id));

			list($parents[$p_model_parent],$taghash) =
			self::getSearchRelation($that,$parents[$p_model_parent] , $taghash, (string)ucfirst($p_model));
		}
		$parents["taghash"] =$taghash;
		$parents["indexHashes"] =$indexHashes;
		return $parents;
	}
	/**
	 * 再起するんだけれども各段階の　$model $model_parent $re は各海藻から識別可能であること
	 * @param unknown $res
	 * @return Generator
	 */
	public function ATswitcher($res,callable $func){
		foreach (self::models as  $model){
			$model_parent = $model. "parentres";
			foreach ($res[$model_parent] as $re){
				$func;
			}

		}
	}
	private  function GETContentsIndex($res){
// 		[$p_model_parent][$parent_idx]['trikeys']
		$all_array = Hash::get($res, "text=/articleparenters|tagparenters/");

		return Hash::apply($all_array, "trikeys",self::dispatchMethod($method));
	}
	private function distinct($hash){
// 		$contents_of_index =
//TODO:group_by を使って　distinct 　taglink.LFrom で
		return $contents_of_index;
	}
	/**
	 *
	 * @param unknown $to
	 * @return array
	 */
public function allTrikeyFinder($link_id){
		$Taglink = new Taglink();
		return $Taglink->find("list", array("fields"=> array("Taglink.LFrom","Taglink.name"),"conditions" =>
				array("Taglink.LTo" =>  $link_id,"Taglink.LFrom <".Configure::read("tagID.End"))));
	}

	/**
	 *
	 * @param unknown $to
	 * @return array
	 */
	public function allTrikeyFinderWithLinkId($link_id){
		$Taglink = new Taglink();
		return $Taglink->find("list", array("conditions" =>
				array("Taglink.LTo" =>  $link_id,"Taglink.LFrom <".Configure::read("tagID.End"))));
	}

	/**
	 *
	 * @param unknown $all array( array("res" => $res, "callback" => $func), .... )
	 */
	public function nestTest($all){
		self::ATswitcher($res);
		foreach ($all as $each){
		}
	}

	/**
	 * GET_sons_reply method
	 *
	 * @param int $id
	 * @param array $trikey
	 * @throws NotFoundException　
	 * @return array
	 'articleparentres' =>$sorter_mended_results['article']['results']
	 ,'tagparentres'=>$sorter_mended_results['tag']['results']

	 *　トライキーを複数指定したり、ノードごとに違ったり、
	 *　arrayで渡す必要が出てくる可能性があるのか？
	 *　今のところさしあたりはそう感じない
	 *　定義トラキーかつリプライの時にどうするかが問題だ。array
	 *　それだけを抽出する必要が出てくるが、今の仕様ではそこだけ抽出不可能だ。array
	 *すべてのリプライを並べるだけではなく、トライキーで検索して順番を付けられる必要がある。
	 *
	 */
	public function GET_sons_reply(&$that, $trikey = null, $sorting_tags, &$taghash, &$root,&$parent){
		foreach (Configure::read("models") as $model){
			$model_parent = $model + "parentres";
			foreach ($parent["$model"] as $idx => $son){ //子供ノードごとに孫を探す
				$temp  = CommonComponent::nestfinderbyid($that
						,$root,$sorting_tags,$son[ucfirst($model)]['ID'],$taghash,array('key' => $trikey));
				if($temp['tagparentres'] != '' ||$temp['articleparentres'] != '' ){ //孫があったらもう一段入る
					$parent["$model"][$idx]['leaf'] = $temp;
				}
			}
		}
	}

	public function nestedtrifiderbyid(&$that,$id,$trikeyID = null,$model,$Ltotarget){
		$leaf = self::nestfinderbyid($that, $id, array('key' => $trikeyID));
		if ($leaf['articleparentres']  != ''){
			foreach ($leaf['articleparentres'] as $node){

			}
		}
		if ($leaf['tagparentres'] !=''){
			foreach ($leaf['tagparentres'] as $node){

			}
		}
		return $result; //leaf も含めて返す
	}
	/**
	 * taghash generator taghash 生成
	 * @param unknown $that
	 * @param unknown $targetParent
	 * @param unknown $taghash
	 * @param unknown $targetModel
	 * @param array $option = array("ToID","trikeys")
	 * @return multitype:array($tagparent,$taghash)
	 * follow check も入れておくか
	 */

	public function getSearchRelation(&$that,$targetParent,&$taghash,$targetModel,$option){
		if (!is_array($targetParent)|| empty($targetParent)) {
			return array($targetParent,$taghash);
		}
		foreach ($targetParent as $i => $result){
			//TODO: parent を超えてfrom_id と　to_id を配列として取得するには？
			$targetParent[$i]["follow"] = $that->Follow->followChecker($result[$targetModel]["ID"],$that->Auth->user("id"));
			//個別のtrに対して関連付けられているタグを呼ぶ
			if(!is_null($result[$targetModel]['ID'])){
			$taghashgen = $this->Basic->tribasicfiderbyid(
					$that,Configure::read('tagID.search'),
					"Tag",$result[$targetModel]['ID'],"Tag.ID");//

			foreach ($taghashgen as $tag){
				$that->subtagID = $tag['Tag']['ID'];
				$targetParent[$i]['subtag'][$that->subtagID] = $tag;
				if ($taghash[$that->subtagID] == null) {
					$taghash[$that->subtagID] = array( 'ID' => $tag['Tag']['ID'], 'name' =>  $tag['Tag']['name']);
				}
			}
			//link 持ってきたい
			if (!is_null($option)){
				$targetParent[$i]['trilink'] =BasicComponent::GetLink($that,
						$retult[$model][$primaryKey],$option["ToID"],$option["trikeys"]) ;
			}
			}
		}

		return array($targetParent,$taghash );
	}

	/**
	 * 　add method
	 * @param array or int $changed_ids
	 *  どっちで渡してもOK
	 *  link もfollow 対象にするのか？
	 *  対象にしたいが対象にしなかったときにどれだけ不具合になるのか
	 *  @param options
	 *'name' => $option["name"],
	 'vaction' =>$option['action'],
	 'vctrl'  => $option['ctrl'],
	 'id' => $option['id'],
	 *
	 */
	public function tickSStream($changed_ids,$options){
		foreach ((array)$changed_ids as $changed_id){
			$this->Feed($this->GETeffected($changed_id),$options);
		}
	}
	/**
	 *　リプライ関係を逆にたどる
	 * @param array $changed_id
	 * @return array $follow_ids
	 */
	public function GETeffected(&$that,$changed_id){
		$follow_ids = BasicComponent::tribasicRefiderbyid(
				$that,Configure::read("tagID.reply"),
				"Article","Article.ID",$changed_id);
		return $effected_ids;
	}

	/**
	 *　Social テーブルに対してプッシュ　
	 * @param array $follow_ids
	 * @return bool
	 * @var name twitter size 　
	 */
	public function Feed($effected_ids,$options = null){
		foreach ($effected_ids as $effected_id){
			self::pushFeed(self::GETfollower($effected_ids),$options);
		}
		return $bool;
	}

	/**
	 *
	 * @param Object $that
	 * @param mixed $follower_ids array or int
	 * @param array $option  name 更新した記事の要約 twitter連携の時はこれをポスト　140文字まで
	 * ctrl action idとか　更新対象情報を与える
	 * @return boolean
	 * 　どのページを帆湯辞させた方がいいのかわからない。
	 * 更新した人間が操作している現在のアドレスと　捜査した対象を記録する
	 * 　表示させるときは、更新した人間のいるページを表示して　更新対象をハイライトする
	 * 　履歴を表示するときに　元のページのroot entity と更新した対象が関連性を持たない場合、どのように処理するのか？
	 * 　関連性がない倍委、ページの下に無関係として　append する。
	 */
	public function pushFeed($follower_ids,$options){
		$bool = false;
		$data["Social"] = array(
				'name' => $option["name"],
				'vaction' =>$option['action'],
				'vctrl'  => $option['ctrl'],
				'id' => $option['id'],
		);
		if (is_array($changed_ids)){
			foreach ($follower_ids as $follower_id){
				$data["Social"]['user_id'] = $follower_id;
				$Social = new Social();
				$Social->create();
				$bool = $bool + $Social->Save($data);
			}
		} else {
			$data["Social"]['user_id'] = $follower_ids;
			$Social = new Social();
			$Social->create();
			return $Social->Save($data);
		}
		return $bool;
	}

	/**
	 *
	 * @param array or int $effected_ids
	 * @return array follower's user_id
	 *
	 */
	public function GETfollower($effected_ids){
		$options = array("fields" => "Follow.user_id","conditions" => array(
				"Follow.target" => $effectedid
		));
		$Follow = new Follow();
		return $Follow->find("all",$options);
	}


}