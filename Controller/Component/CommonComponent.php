<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Date', 'Model');
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

	public function trifinderbyid(&$that = null,$id,&$option) {
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}
		$articleparentres = $this->Basic->tribasicfiderbyid($that,$option['key'],"Article","Article.ID",$id);
		$articleparentres = $this->Basic->allTrilinkFinder($id,$articleparentres);//どんな記事がぶら下がっているか探す
		list($articleparentres,$taghash) =
		$this->getSearchRelation($that,$articleparentres, $taghash, "Article");
		$tagparentres = $this->Basic->allTrilinkFinder($id,$this->Basic->tribasicfiderbyid($that,$option['key'],"Tag","Tag.ID",$id));
		list($tagparentres,$taghash) =
		$this->getSearchRelation($that, $tagparentres, $taghash, "Tag");
		return array('tagparentres'=>$tagparentres,
				'articleparentres'=> $articleparentres,
				 'taghash' => $taghash);
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
	 *
	 * @param unknown $that
	 * @param unknown $root　親ノード
	 * @param unknown $sorting_tags
	 * @param unknown $id
	 * @param unknown $taghash
	 * @param string $option
	 * @return multitype:unknown
	 * @var $temp 子供
	 */
	public function nestfinderbyid(&$that,&$roots,$sorting_tags,$id,&$taghash,&$parents,&$option = null){
		if ($option['key'] == null) {
			$option['key'] = Configure::read('tagID.reply');
		}

		$children = array();
		$models = array( 'article' ,'tag');
		foreach ($models as  $r_model){
			$r_model_parent = $r_model. "parentres";
			foreach ($roots[$r_model_parent] as $root){
				foreach ($models as $p_model){
					$p_model_parent = $p_model."parentres";
						foreach ($parents[$p_model_parent] as $parent_idx =>$parent){
							if ($parent[ucfirst($p_model)]["ID"] != null){
								$is_child = false;
								$this_nodes  = self::trifinderbyid($that,$parent[ucfirst($p_model)]["ID"],$options);
								if($this_nodes  != array(
										'tagparentres' => array(),
										'articleparentres' => array(),
										'taghash' => null
								)){//子ノードが空だったら、もうこれ以上深くはいらない
									foreach ($models as $model){
										$model_parent = $model."parentres";
										foreach ($this_nodes[$model_parent] as $this_node){
											foreach ($models as $ip_model){
												$ip_model_parent = $ip_model."parentres";
												foreach ($parents[$ip_model_parent] as $iparent_idx =>$iparent){

													if (($root[ucfirst($r_model)]['ID'] == $this_node[ucfirst($model)]['ID'] && //ルートノードに存在し、かつ
																$iparent[ucfirst($p_model)]['ID'] == $this_node[ucfirst($model)]['ID'])){ // 親に含まれているなら

														unset($parents[$p_model_parent][$iparent_idx]);
														//親を切って　子ノードとして追加
														$parents[$p_model_parent][$parent_idx]['leaf'] = array();
														$parents[$p_model_parent][$parent_idx]['leaf'][$model_parent] = array();
														array_push($parents[$p_model_parent][$parent_idx]['leaf'][$model_parent]
																,$root);
													}
												}
											}

										}

									}
								}
							}
						}
					}
				}
			}
		//親テーブルに存在するものを検索
				return $parents;//何もなかったと教える

	}

	public function ATswitcher($res, Callback $func){
		$models = array( 'article' ,'tag');
		foreach ($models as  $model){
			$model_parent = $model. "parentres";
			foreach ($res[$model_parent] as $root){
				$func();
			}
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
	 *
	 * @param unknown $that
	 * @param unknown $targetParent
	 * @param unknown $taghash
	 * @param unknown $targetModel
	 * @param array $option = array("ToID","trikeys")
	 * @return multitype:array($tagparent,$taghash)
	 */

	public function getSearchRelation(&$that,$targetParent,&$taghash,$targetModel,$option){
		if (!is_array($targetParent)|| empty($targetParent)) return null;
		foreach ($targetParent as $i => $result){
			//個別のtrに対して関連付けられているタグを呼ぶ
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

		return array($targetParent,$taghash );
	}


}