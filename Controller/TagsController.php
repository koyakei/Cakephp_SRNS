<?php
App::import('Vendor', 'DebugKit.FireCake');
App::uses('AppController', 'Controller','ArticlesController');
App::uses('Link', 'Model');
App::uses('User', 'Model');
App::uses('Tagauthcounts', 'Model');
Configure::load("static");
App::uses('Article','Model');
App::uses('Tagauth','Model');
App::uses('Taguser','Model');
App::uses('Key','Model');


/*App::uses('Article', 'Model');
/**
 * Tagusers Controller
 *
 * @property Taguser $Taguser
 * @property PaginatorComponent $Paginator
 */
/*class AppSession {
	public $usermode = 1;
	public $selected = 2138;

}*/

class TagsController extends AppController {
	//public $pagination =  $this->paginator->sort('modified', 'desc');

/**
 * Components
 *
 * @var array
 */
public $components = array('Auth','Search.Prg','Paginator','Common','Basic','Cookie','Session',
			'Security','Authpaginator','Users.RememberMe');
public $presetVars = array(
		'user_id' => array('type' => 'value'),
		'keyword' => array('type' => 'value'),
		'andor' => array('type' => 'value'),
		'from' => array('type' => 'value'),
		'to' => array('type' => 'value'),
);
public function beforeFilter() {
	parent::beforeFilter();

	$this->Security->validateOnce = false;
	$this->Security->validatePost = false;
	$this->Security->csrfCheck = false;
}


	public function isAuthorized($user) {
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = $this->request->params['pass'][0];
			if ($this->Taguser->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}
	public $helpers = array(
	 'Html',
			'Session'
	);
//        public $presetVars = true;
	public function formAdd(){
		 $inserted_id = CommonComponent::singleAdd($this->request->data('name'),
		 		$this->Auth->user("id"));
		 self::nestedAdd($root_ids,$trikey_ids,
		$parent_id,$inserted_id);
// 		$this->redirect($this->referer());
	}
	/**
	 * TODO:nest表示ができたから、それに従って追加する方法を考える。2015/05/19ここ
	 *
	 **/
	/**
	 *
	 * @param unknown $data
	 * @param unknown $root_ids
	 * @param unknown $trikey_ids
	 * @param unknown $parent_ids
	 * @param unknown $before
	 * @param unknown $after
	 */
	public function nestedAdd($root_ids = null,$trikey_ids = null,
		$parent_ids = null,$child_ids =null){
		is_null($root_ids)?$root_ids = $this->request->data("root_ids"): null;
		is_null($parent_ids)?$parent_ids = $this->request->data("parent_ids"): null;
		is_null($trikey_ids)? $trikey_ids = $this->request->data("trikey_ids"): null;
		empty($trikey_ids)? $trikey_ids = Configure::read("tagID.reply"): null;
		is_null($child_ids)?$child_ids = $this->request->data("child_ids"): null;
		//一段階のみのreply 設定
		//trikey 使い放題なの？
		//trikeyと　from トシテの使われ方で権限別にする？
		//別にしないで同じように管理しよう。
		foreach ($parent_ids as $parent_id){
			DemandComponent::eachLinker($parent_id,$child_ids,$trikey_ids,$this->Auth->user("id"));
		}
		return true;
	}
	/**
	 * delbuttoun
	 * @param string $data
	 * 前回移し替えるのを
	 */
	public function  delDemand($data = null){
		DemandComponent::requestDelDemands($del);
		DemandComponent::selfLinkDelete($add);
		$this->redirect($this->referer());
	}
		/**
		 * index method
		 *
		 * @return void
		 */

		public function index() {
			$this->loadModel('Article');
			parent::index();
			//$this->paginate->setting = array('order'=> array('Taguser.modified' => 'DESC'));
			$this->set('tags', $this->paginate('Taguser'));
		}
		//demand は直接コンポーネントを呼ぶのか？呼ばないだろう
		//TODO: save する形式に適応するように　view を書く
		/**
		 * @todo 今いじっている
		 * @param string $insert
		 * @param string $update
		 * @param string $del
		 */
		public function demand($insert = null , $update =null, $del = null){
			$insert = $this->request->data("insert");
			$update = $this->request->data("iupdate");
			$del = $this->request->data("del");
			//TODO:view　で整形不可能ならここで整形する　整形してから下に渡す
			DemandComponent::requestInsertDemands($this,$insert);
			DemandComponent::requestUpdateDemands($this,$update);
			DemandComponent::requestDelDemands($this,$update);

			$this->redirect($this->referer());
		}
		/**
		 *
		 * @param string $data
		 * DemandComponent につなぐ
		 * 要求を出すと同時に、
		 * 自分がパーソナルモードで見ている時にすでに要求が通ったように見えるようにする。
		 *
		 * そのために、関係性追加の要求をしたところには、trilink選択中@自分で関係性を追加。
		 * 切断要求をしたところにはどうやって切断するのか分からない。
		 * 切断する特殊タグを作るか？
		 */
		public function demand2s($data = null){
			if (is_null($data)){
				$data = $this->request->data();
			}
			$del = array_diff_assoc($data["before"],$data["after"]);
			$add = array_diff_assoc($data["after"],$data["before"]);
			//key で比較することによって順番も変化させる。
			DemandComponent::requestInsertDemands($add);
			DemandComponent::selfLinkInsert($del);
			$this->redirect($this->referer());
		}
		/**
		 *
		 * minused_set= $before(big) - $after(smal)
		 * @param unknown $befores
		 * @param unknown $afters
		 * @return multitype:
		 */
		function compare_order($befores,$afters){
			$res = array();
			foreach($befores as $idx => $before){
				$before_each = array('from' => $befores[$idx],'to'=>$befores[$idx++]);

				if ($this->separeted_pair($before_each,$afters)){
					array_push($res,$befores[$idx]["Taguser"]["trikey_id"]);
				}
			}
			return $res;
		}

		/**
		 *
		 * @param unknown $before_each
		 * @param unknown $afters
		 * @return boolean
		 */
		function separeted_pair($before_each,$afters){
			foreach($afters as $idx => $after){
				$after_each = array('from' => $afters[$idx],'to'=>$afters[$idx++]);
				if($before_each　== $after_each){
					return false;
				}
			}
			return true;
		}


        /**
         * view method
         *
         * @throws NotFoundException
         * @param string $id
         * @param string $trikeyID
         * @return void
         */
        public function view($id = null) {
        	parent::view($id);
        	$this->request->data['keyid']['keyid'] =$trikeyID;
        	if ($trikeyID == NULL){
        		$trikeyID = Configure::read('tagID.search');
        	}
        	$this->set('upperIdeas', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Taguser",$id));
        	$this->set('extends', $this->Basic->triupperfiderbyid($this,Configure::read('tagID.extend'),"Taguser",$id));
        	$this->set('trikeyID', $trikeyID);
        }
        /**
         * view2 method
         * 全部GETで情報を渡す
         * POSTだとリンクで同じタグを表示できない。
         * REQUEST array Searching
         * array tags 検索中のタグ
         * 	array("OR"=> (array("AND"=> (int $tag_id ,) ),"NOT" => array()),
         * array users
         * ユーザーのホワイト/ブラックリストの方式を考える必要がある。
         * REQUEST array Sorting
         * array tags 並べ替え中のタグ
         * array users 優先表示するユーザー
         * array colmun modified or created or id
         * タグの当たりをつけるための全文検索　検索に使用したタグを投稿
         *  array(int tag_id)
         * @return void
         * @todo テーブルを2つ作って、ネストしながら　insert demand 実行は後で考える
         *現在の$id からすべてリプライする　replt@who 現在のtrikey 条件を　reply demand $ trikeys (array)に渡す
         *
         */
        public function view2($id,$lower_id = null//テーブル2つ表示の時これ使う？
        		) {
        	if ($id ==null) {
        		$id = $this->request->query["id"];
        	}
        	$base_trikey = $this->request->query('trikey_filter'); //トライキーのフィルター
//         	デフォルトで"リプライ"だけ読む
        	if ($base_trikey == null) {
        		$base_trikey = Configure::read("tagID.reply");
        	}
        	$all_node = null;//全部の情報
        	$this->loadModel("User");

        	$this->loadModel("Trikey_list");
        	$all_trikeis = $this->allKeyList();//すべてのトライキーを取得

//         	$all_node = $this->get_child("Base_trikey_entity",$all_node,$id,$base_id,$base_trikey);
			//base_trikeyのみに関連付けられているエンティティーを取得

			$that = $this;
			$option = array('key' => Configure::read("tagID.reply"));
			$tableresults = $this->Common->trifinderbyid($that,$id,$option);
			$this->set('headresults',$headresults);
			$this->set('tableresults', $tableresults);

			$this->set('base_trikey' ,$base_trikey);
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	//$collected_result[$trikey]["Model"}[ID] こんなかんじで
        	$this->set('default_nodes',$all_node); //デフォルトのノードツリーを返す
        	$this->set('sorting_tags',$sorting_tags);
        	$this->set('taghash',$tableresults["taghash"]);
        	$this->set('id',$id);
        }


        /**
         *idを指定して子供を取得
         * 子供を取得して親の[child_node][model]にくっつける
         * @param unknown $model
         * @param unknown $id
         * @param unknown $base_id
         * @param unknown $base_trikey
         * @return unknown
         */
        public function get_child(&$model,&$entity,&$id,&$base_id,&$base_trikey){
        	$child_node = get_child_each_model($id,$base_id,$base_trikey);
        	if(!is_null($child_node)){
        		$entity["child_node"] = $child_node;
        	}
        	return $entity;
        }
        /**
         *  entity の切り替えのための残してある
         * @param unknown $id
         * @param unknown $base_id
         * @param unknown $base_trikey
         * @return multitype:
         */
        public function get_child_each_model($id,$base_id,$base_trikey){
//         	$res += get_child_node($id,$base_id,$base_trikey,"Base_trikey_tag");
//         	$res += get_child_node($id,$base_id,$base_trikey,"Base_trikey_article");
        	$res += get_child_node($id,$base_trikey,"Base_trikey_entity");
        	return $res;
        }

		/**
		 * tag とarticle ２つ取ってくる必要がある
		 * @param unknown $id
		 * @param unknown $base_id
		 * @param unknown $base_trikey
		 * @param string $model  child model name
		 * @return array("Base_trikey_tag" , "Base_trikey_article")
		 */
		public function get_child_node($id,$base_trikey,$model){
			$trikey = $this->Trikey_list->find('all',array('conditions' => array("Trikey_list.id" =>$id )));
			$db_Base_trikey_entity = $this->{$model}->getDataSource();
			foreach ($trikeys as  $trikey){
				$conditionsSubQuery['AND'] =
				array('"' . $model . '"."link_LFrom" ' => $id ,'"' . $model . '"."trikey_id" ='.$trikey["Trikey_list"]["LFrom"]);
				$subQuery = $db_Base_trikey_tag->buildStatement(
						array(
								'fields'     => array('"Trikey_list"."LFrom"'),
								'table'      => $db->fullTableName($this->{$model}),
								'limit'      => null,
								'offset'     => null,
								'joins'      => array(),
								'conditions' => $conditionsSubQuery,
								'order'      => null,
								'group'      => null
						),
						$this->{$model}				);
				//一番親の　WHERE
				$subQuery = '"' . $model . '"."trikey_id" = '. $base_trikey .'
	        			AND' .$this->and_gen($id) .' AND "' . $model . '".."ID" IN (' . $subQuery_parent . ')';
				$subQueryExpression = $db_Base_trikey_entity->expression($subQuery);
				$conditions[] = $subQueryExpression;
				$results["$trikey"] = $this->{$model}->find('all', compact('conditions'));

				if (is_null($results["$trikey"])) {
					$results["$trikey"]["child_node"] = $this->get_grandSon($results["$trikey"], $model, $base_id, $base_trikey);
				}
			}
			$this->set("res" , $results);
			return $results;
		}

		private function get_grandSon($parent_node,&$model,&$base_id,&$base_trikey){
			foreach ($parent_node as $iterator => $child_result){
				$parent_node[$iterator]["child_node"]
				= $this->get_child_each_model($child_result["$model"]["ID"], $base_id, $base_trikey);
			}
			return $parent_node;
		}

		private function and_gen($id){
			if(!is_array($id)){
				return "`base_trikey_tag`.`link_LFrom` = '. $id .'";

			}else {
				$array_length = count($id);
				foreach ($id as $key => $value){
				$condition_query = $condition_query."`base_trikey_tag`.`link_LFrom` = '. $value .'";
				if($key < ($array_length - 1)){
				$condition_query = $condition_query. "AND";
				}
				}
					return $condition_query;
				}

				}
		public function search2(){
			//         	デフォルトで"リプライ"だけ読む
        	if ($base_trikey == null) {
        		$base_trikey = Configure::read("tagID.reply");
        	}
        	if ($id ==null) {
        		$id = $this->request->query["id"];
        	}
        	$all_node = null;//全部の情報
        	//$this->request->query('trikey_filter'); トライキーのフィルター
//         	$this->loadModel("User");

        	$this->loadModel("Trikey_list");
        	$all_trikeis = $this->allKeyList();//すべてのトライキーを取得

//         	$all_node = $this->get_child("Base_trikey_entity",$all_node,$id,$base_id,$base_trikey);
			//base_trikeyのみに関連付けられているエンティティーを取得

// // 			$all_node["$base_trikey"] = $this->Common->trifinderbyid($that,$id,$option);
// 			$this->set('base_trikey' ,$base_trikey);
//         	$this->set('currentUserID', $this->Auth->user('id'));
//         	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
//         	//$collected_result[$trikey]["Model"}[ID] こんなかんじで
//         	$this->set('default_nodes',$all_node); //デフォルトのノードツリーを返す
//         	$this->set('sorting_tags',$sorting_tags);
//         	$this->set('taghash',$result["taghash"]);
		}
		public function get_parent_id($parent_entities,$model,$primarykey){
			if ($model == "Base_trikey_tag"){

			}else {

			}
			foreach ($parent_entities as $parent_entity){
				if (!is_null($parent_entity["$model"]["ID"])) {
					$this->get_child($model,$parent_entity["$model"]["ID"],$id,$base_id,$base_trikey);
				}else{
					$this->get_child($model,$parent_entity["$2nd_model"]["ID"],$id,$base_id,$base_trikey);
				}

				//$this->get_child("article");
			}
		}

        private function reply_node_cutter($non_bace_node,$bace_node,$base_trikey){
        	if (is_null($base_trikey)){
        		$base_trikey = Configure::read("tagID.reply");
        	}
        	$trikey_list = $this->Trikey_list->find('all',
        			array('condition' => array('id'=> $id ,'NOT'=> array('LFrom' =>$base_trikey)))
        	);
        	//各trikey ごとに結果を取得
        	$collected_result = $non_bace_node;
        	//ベースノードを取得
        	$collected_result[$bace_trikey] = $this->get_specified_reply_by_id_and_trikey($id, $trikey);
        	return $collected_result;
        }


        /**
         * publish exchange method
         *
         * @throws NotFoundException
         * @param string $id
         * @return boolean
         */
        public function exchange($id = NULL){
        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tagauth'));
        	}
			$this->set('headresults',$this->headview($id));
        	$this->set('idre', $id);
        	$this->Tagauthcount = new Tagauthcount();
        	$this->set('myauthresult',$this->Tagauthcount->find('first',array(
        			'conditions' => array('Tagauthcount.tag_id'=> $id,
        					'Tagauthcount.user_id'=> $this->Auth->user('id')
        			))));
        	debug($id);
        	$this->loadModel('Tagauth');
        	$this->Paginator->setting = array(
        			"Tagauth.tag_id" => $id);
        	$tagauth = $this->paginate('Tagauth',$this->Paginator->setting);
        	$this->set('tagauths',$tagauth
        			);

        	//表示部分ここまで
        	//以下権限変更部分


        	if ($this->request->is(array('post', 'put'))) {
        		$targetTagauthcounts=$this->Tagauth->find('first',array('conditions'=>array('Tagauthcount' => array('tag_id'=>$id,
        			'username'=> $this->request->data['username']))))['Tagauth']['id'];
        	//max_quant を超えないようにするチェック　いつも全部の行を合計する処理は重たいのでやらない。一回一回の処理の整合性を取っていく。
	        	if ($this->Basic->tagAuthCountdown($this,$id,$targetTagauthcounts,$this->request->data['Tagauthcount'][`quant`])) {//相手が特定できているか
	           		$that->Session->setFlash(__('The tag has been saved.'));
	        		return true;
	        	} else {
	        			$this->Session->setFlash(__('The tagauth could not be saved. Please, try again.'));
	        	}
	        } else {
	        		$this->request->data = $this->headview($id);
        	}


        }

        /**
		* notice method
		* 通知
		* @param array ids
		* @param string $notice_contents
		*
         */
        public function notice($ids,$notice_contents){
        	foreach($ids as $id){
        		$target_user_ids = $this->get_notice_target($id);
        		foreach($target_user_ids as $target_user_id){
        			$massage = "cake/" + $this->ATSwicher($id) + "/" + $id + ""
        					+ "更新されました" + "<br>" + $notice_contents;
        					$this->mail->send($target_user_id,$massage);
        		}
        	}
        }
/**
 * ATSwicher
 *  Article or Tag discreminate
 *  static.END is upper limit of tag number
 * @param unknown $id
 * @return string "tag" or "article" or error is false
 */
        function ATSwicher($id){
        	if ($id < Configure::read("tagID.END")){
        		return "tag";

        	}elseif($id > Configure::read("tagID.END")) {
        		return "article";
        	}else{
        		return false;
        	}

        }

        /**
         * public anonymous_view method
         *
         * @throws NotFoundException
         * @param string $id
         * @param string $trikeyID
         * @return void
         */
        public function anonymous_view($id = null) {
        	$options = array('conditions' => array('Taguser.'.$this->Taguser->primaryKey => $id),'order' => array('Taguser.ID'));
        	$resultForChange = $this->Taguser->find('first', $options);

        	$this->id =$id;
        	$this->Taguser->cachedName = $this->name;
        	$userID = $this->Auth->user('id');
        	if($this->request->data['tagRadd']['add'] == true){
        		$this->Basic->tagRadd($this);
        		$this->Basic->social($this);
        		$this->redirect($this->referer());
        	}elseif ($this->request->data['Taguser']['max_quant'] != null){
        		if ($this->Auth->user('id')==$resultForChange['Taguser']['user_id']) {
        			$this->Taguser->save($this->request->data());
        		}else {
        			debug("fail no Auth");
        		}
        	}
        	if($this->request->data['Link']['quant'] != null){
        		$this->Basic->quant($this);
        		$this->Basic->social($this);
        	}

        	if($this->request->data['Article']['name'] != null){
        		$options['key'] = $this->request->data['Article']['keyid'];
        		debug($this->request->data);
        		$this->Common->triarticleAdd($this,'Article',$this->request->data['Article']['user_id'],$id,$options);
        		$this->Basic->social($this);
        	}
        	if($this->request->data['Taguser']['name'] != null){
        		debug($this->request->data);
        		$options['key'] = $this->request->data['Taguser']['keyid'];
        		$this->Common->tritagAdd($this,"Taguser",$this->request->data['Taguser']['user_id'],$id,$options);
        		$this->Basic->social($this);
        	}
        	$this->set('idre', $id);
        	if (!$this->Taguser->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	$this->request->data['keyid']['keyid'] =$trikeyID;
        	if ($trikeyID == NULL){//$serchID;//tagConst()['searchID'];
        		$trikeyID = Configure::read('tagID.search');
        	}
        	$this->Common->SecondDem($this,"Taguser","Taguser.ID",Configure::read('tagID.search'),$id);

        	$this->set('headresults', $this->returntribasic);
        	$options = array('conditions' => array('Taguser.'.$this->Taguser->primaryKey => $id));
        	$tag = $this->Taguser->find('first', $options);
        	$this->set('tag', $tag);
        	$this->pageTitle = $tag["Taguser"]['name'];
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->Session->write('userselected',$this->request->data['Taguser']['user_id'] );
        	$this->Basic->triupperfiderbyid($this,Configure::read('tagID.upperIdea'),"Taguser",$id);
        	$this->set('upperIdeas', $this->returntribasic);
        	$this->set('trikeyID', $trikeyID);
        	$this->loadModel('User');
        	$this->loadModel('Key');
        	$key = $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name')));
        	$this->set( 'keylist', $key);
        	$i = 0;
        	foreach ($key as $key => $value){
        		$options = array('key' => $key);
        		$this->Common->trifinderbyid($this,$id,$options);
        		$tableresults[$i] = array('ID'=>$key,'name' => $value ,'head' =>$this->taghash,'tag' =>$this->articleparentres, 'article'=>$this->tagparentres);
        		$i++;
        	}
        	$this->set('tableresults', $tableresults);
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));

        }
        /**
         * transmitter method
         *
         * @return void
         */
        public function transmitter($leftID = null,$leftKeyID = null,$rightID = null,$rightKeyID = null ){
			//view method を読み込む　左
			//左右を同じelemrnt で構成する　その画面を呼び出す方法を考える。
			//ページを固定したまま検索する方法を考える。
			//togetter の左は編集先になっている。
			//debug($this->request->data['to']);
        	//debug($this->request->data['from']);
        	debug($this->request->data);
        	$model_name = array_slice($this->request->data['from'], 0,0);

        		$this->Common->trasmitterDiff($this,$leftID,$leftKeyID,$model_name);


        	if($this->request->data['Taguser']['lr'] == "left"){
        		$leftID = null;
        		$leftKeyID = null;
				$this->psearch($this);

				$this->set('lefttagresults', $this->Paginator->paginate());
				//left $leftID $leftKeyID del
        	}elseif ($this->request->data['Taguser']['lr'] == "right") {
        		debug("isrs");
        		$rghitID = null;
        		$rightKeyID = null;
        		$this->psearch($this);
        		$this->set('righttagresults', $this->Paginator->paginate());
				//left $rightID $rightKeyID del
        	}//else{
        		$this->loadModel('Article');
        		if($rightID == null ){
        			$newart = $this->Article->find('all',array('order'=> array('Article.modified' => 'desc'),'limit' => 30));
        			$this->set('rightarticleresults', //$this->paginate('Article',$options)
        					$newart
        			);
        		} else {
        			if ($rightID != null or $rightID != 0) {
        				$options = array('key' => $rightKeyID);
        				$this->Common->trifinderbyid($this,$rightID,$options);
        				$this->set('righttaghashes', $this->taghash);
        				$this->set('rightarticleresults', $this->articleparentres);
        				$this->set('righttagresults', $this->tagparentres);
        				if ($rightID <= 100000) {
	        				$options = array('conditions' => array('Taguser.'.$this->Taguser->primaryKey => $rightID),'order' => array('Taguser.ID'));
	        				$rightheadresults = $this->Taguser->find('first', $options);
        				} else {
        					$options = array('conditions' => array('Article.'.$this->Article->primaryKey => $rightID),'order' => array('Article.ID'));
        					$rightheadresults = $this->Article->find('first', $options);
        				}
        				$this->set('rightheadresults', $rightheadresults);
        				if(array_key_exists ( 'Taguser' , $rightheadresults )){
        					$this->set('rightheadmodel', 'Taguser');
        				}else {
        					$this->set('rightheadmodel', 'Article');
        				}
        			}

        		}
        	//}
    			if ($leftID != null and $leftID != 0) {
					$options = array('key' => $leftKeyID);
		        	$this->Common->trifinderbyid($this,$leftID,$options);
		        	$this->set('lefttaghashes', $this->taghash);
		        	$this->set('leftarticleresults', $this->articleparentres);
		        	$this->set('lefttagresults', $this->tagparentres);
		        		if ($leftID < 100000) {
	        				$options = array('conditions' => array('Taguser.'.$this->Taguser->primaryKey => $leftID),'order' => array('Taguser.ID'));
	        				$leftheadresults = $this->Taguser->find('first', $options);
        				} else {
        					$options = array('conditions' => array('Article.'.$this->Article->primaryKey => $leftID),'order' => array('Article.ID'));
        					$leftheadresults = $this->Article->find('first', $options);
        				}
					$this->set('leftheadresults', $leftheadresults);
					if(array_key_exists ( 'Taguser' , $leftheadresults )){
						$this->set('leftheadmodel', 'Taguser');
					}else {
						$this->set('leftheadmodel', 'Article');
					}
				}

			/*$options = array('order' => array(
            'Article.modified' => 'desc'
        ));*/

        	//}
			$this->loadModel('Key');
			$this->loadModel('User');
        	$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('leftID', $leftID);
        	$this->set('leftKeyID', $leftKeyID);
        	$this->set('rightID', $rightID);
        	$this->set('rightKeyID', $rightKeyID);
        }

        /**
         * add method
         *　権限について
         *　タグの管理モードはデフォルトでは　オーナーが全て動かせる設定
         *　
         *
         * @return void
         */
        public function add() {
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->loadModel('User');


        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	if ($this->request->is('post')) {
        		if ($this->request->query('max_quant') == null){
        			$max_quant = 1000;
        		} else {
        			$max_quant = $this->request->query('max_quant');
        		}
        		$this->Tag->create();
        		$this->request->data['Tag'] += array(
        				'created' => date("Y-m-d H:i:s"),
        				'modified' => date("Y-m-d H:i:s"),
        				'max_quant' => $this->request->query('max_quant'), // default はテーブルで制御
        		);
        		$this->Basic->taglimitcountup($this);
        		$data['Tagauthcount'] =array('user_id' => $this->request->data['Tag']['user_id'],'tag_id' =>$this->last_id,'quant' => $this->request->query('max_quant'));
        		$this->loadModel('Tagauthcount');
        		$this->Tagauthcount->create();
        		$this->Tagauthcount->save($data);
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
        	$this->set('userinfo', array('ID' => $this->Auth->user('ID')));

        	if (!$this->Tag->exists($id)) {
        		throw new NotFoundException(__('Invalid tag'));
        	}
        	if ($this->request->is(array('post', 'put'))) {
        		$this->Tag->id = $id;
        		if ($this->Tag->save($this->request->data)) {
        			$this->Session->setFlash(__('The tag has been saved.'));
        			return $this->redirect(array('action' => 'view' ,$id));
        		} else {
        			$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
        		}
        	} else {
        		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id),'order'=>'Tag.ID');
        		$this->request->data = $this->Tag->find('first', $options);
        		$this->set('users', $this->request->data['W']);
        	}
        }
        function replysingle(){
        	$options = array('key' => Configure::read('tagID.reply'));
        	debug($this->Common->trifinderbyidAndSet($this,array(1),$options));
        }

        /**
         * @post $this->request->query('sorting_tags') ソートに使っているタグ
         * @post  $this->request->query('trikey') nullの場合配列じゃなくなるんだっけ？
         * @post  $this->request->query('reply_owners') nullの場合配列じゃなくなるんだっけ？
         * @todo 本当は　AutocompleteHelper で　読み込むjsファイルを切り替えたいが、なぜかできない
         */

        public function GET_all_search(){
        	$this->loadModel('User');
        	$tableresults = array();
        	$sorting_tags = array($this->request->query('sorting_tags'));
        	$taghash = array();
        	$id = $this->request->query('id');
        	//リプライか　searchかをidのあるなしで判定　
        	if (is_null($id)|| $id == ''){
				$allresults = $this->GET_search($this->request->query('searching_tag_ids'),Configure::read('tagID.search'),$sorting_tags,$taghash);
        	} else {
        		$allresults  = $this->Common->trifinderbyid($this,$id,array('key'=>$this->request->query('trikey')));
        		$root = array('tagparentres'=>$temp['tagparentres'],
        				'articleparentres'=> $temp['articleparentres'],
        				'taghash' => $temp['taghash']);
        		$taghash = $temp['taghash'];
				$allresults = self::GET_sons_reply($id
						,array($this->request->query('trikey'))
						,$sorting_tags
						,$taghash
						,$root
				);
        	}

			$this->set('currentUserID', $this->Auth->user('id'));
			$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
			$this->set('sorting_tags',$sorting_tags);
			$this->set('taghash',$taghash);
			$this->set("andSet_ids",$andSet_ids);
			$this->set("allresults",$allresults);
        }
		public function result_converter($temp,&$taghash){
			$taghash = $temp['taghash'];
			$sorter_mended_results['article'] = $this->sorting_taghash_gen($temp['articleparentres'],$taghash,$sorting_tags);
			$sorter_mended_results['tag'] = $this->sorting_taghash_gen($temp['tagparentres'],$taghash,$sorting_tags);
			return  array(
					'articleparentres' =>$sorter_mended_results['article']['results']
					,'tagparentres'=>$sorter_mended_results['tag']['results']
			);
		}

        public function GET_search($andSet_ids,$trikey = null,$sorting_tags,&$taghash) {
        	$temp  = $this->Common->trifinderbyidAndSet($this,$andSet_ids,array('key' => $trikey));
        	return  self::result_converter($temp, $taghash);
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
		public function GET_sons_reply(&$that, $trikey = null, $sorting_tags, &$taghash, &$root){
			if (!$this->{$this->modelClass}->exists($id)) {
				throw new NotFoundException(__('Invalid tag'));
			}
			$models = array('article','tag');

			foreach ($models as $model){
				$model_parent = $model + "parentres";
				foreach ($root["$model"] as $idx => $son){ //子供ノードごとに孫を探す
					$temp  = CommonComponent::nestfinderbyid($this,$root,$sorting_tags,$son[ucfirst($model)]['ID'],$taghash,array('key' => $trikey));
					if($temp['tagparentres'] != '' ||$temp['articleparentres'] != '' ){ //孫があったらもう一段入る
						$root["$model"][$idx]['leaf'] = $temp;
					}
				}
			}
		}
		//
		/**
		 * 一回のSQLで全部のネスト構造を一度に取ってくる
		 * 与えられるのは検索タグの集合
		 * まずは　tag_hash 以外を取ってくる
		 * view でネストの塊を定義しておいて,
		 * associationで引っ張ってみるか？
		 * replyのview化
		 *
        	"SELECT * FROM tag where";
		 */
        public function GET_all_reply($id = null){
        	if ($id ==null) {
        		$id = $this->request->query["id"];;
        	}
        	$result = $this->get_specified_reply_by_id_and_trikey($id
        			,Configure::read("tagID.reply"));
        	$this->set('root_ids',$id);
        	$this->set('currentUserID', $this->Auth->user('id'));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('tableresults',$result);
        	$this->set('sorting_tags',$sorting_tags);
        	$this->set('taghash',$result["taghash"]);

        }
        /**
         * replyFinder method
         * @var andSet_ids
         *  array
         * @var sorting_tags
         * @return results
         *
         */
        function replyFinder($id = null ,$sorting_tags = null,&$taghash) {
        	if(is_null($id)){
        		$id = $this->request->data['id'];
        	}
        	if(is_null($sorting_tags)){

        	}
        	$options = array('key' => Configure::read('tagID.reply'));
        	$temp  = $this->Common->trifinderbyid($this,$id,$options);
        	$taghash = $temp['taghash'];
        	$sorter_mended_results['article'] = $this->sorting_taghash_gen($temp['articleparentres'],$taghash,$sorting_tags);
        	$sorter_mended_results['tag'] = $this->sorting_taghash_gen($temp['tagparentres'],$taghash,$sorting_tags);
        	$tableresults = array(
        			'articleparentres' =>$sorter_mended_results['article']['results']
        			,'tagparentres'=>$sorter_mended_results['tag']['results']);

        	$currentUserID = $this->Auth->user('id');
        	return $tableresults;
        }
        /**
         * article もtagも両方返す
         * @param int $id
         * @param int $trikey
         * @return html <results, table>
         *
         */
        public function get_specified_reply_by_id_and_trikey($id,$trikey){
        	$option['key'] = $trikey;
			return $this->Common->trifinderbyid($this,$id,$option);
        }

        /**
         * autoSuggest method
         *
         * @throws NotFoundException
         * @param string $id
         * @return void
         */
        public function autoSuggest() {
        	$this->layout = 'ajax';
        	$data = ''; $json = '';
        	if(!empty($this->params['url']['q'])){
        		$options = array(
        				'field'     =>array('Taguser.ID','Taguser.name'),
        				'conditions' => array('or'=> array(
        						array('Taguser.name LIKE ?' => $this->params['url']['q'].'%')
        				),
        				),
        				'limit'     =>10
        		);
        		$datas = $this->Taguser->find('list', $options);

        		foreach($datas as $key=>$val){
        			$data .= $val.'|'.$key."\n";
        		}
        	}
        	$this->set('json', $data);
        	$this->render('ajax_suggest');
        }

		public function ac(){

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
//         	$options = array('conditions' => array(
//         			'Taguser.'.$this->Taguser->primaryKey => $id),
//         			'order' => array('Taguser.ID'),
//         	);
//         	$Taguser = $this->loadModel("Taguser");
//         	$reslut = $Taguser->find('first', $options);
//         	if ($reslut['Taguser']['user_id'] == $this->Auth->user('id')) {
//         		$this->Tag = $this->loadModel("Tag");
// 	        	$this->Tag->id = $id;
	        	$this->request->onlyAllow('post', 'delete');
	        	if ($this->Tag->delete()){
	        		$this->loadModel('User');
	        		$this->Session->setFlash(__('The tag has been deleted.'));
	        		$data['User']['tlimit'] = $this->Auth->user('tlimit') + 1;
	        		$data['User']['id'] = $this->request->data['Taguser']['user_id'];
	        		if($this->User->save(array('User'=>array('id'=>$this->Auth->user('id'),'tlimit'=>$data['User']['tlimit'])),false)){
	        			$this->Session->setFlash(__('The tag has been deleted.残りタグ数'.$this->Auth->user('tlimit')));
	        		}else {
	        			$this->Session->setFlash(__('deleted but can not count up..残りタグ数'.$this->Auth->user('tlimit')));
	        		}
	        	} else {
	        		$this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
	        	}
//         	}
//         	debug($this->referer());
        	print_r("戻るで戻って");
        	return $this->redirect($this->referer());
        }
        public function articleview($id) {
        	$this->redirect($this->referer());
        }

        /**
         * psearch method
         *
         * @return $tagresult
         */
        private function psearch(&$that){
        	$req = $that->passedArgs;
        	if (!empty($that->request->data['Tag']['keyword'])) {
        		$andor = !empty($that->request->data['Tag']['andor']) ? $that->request->data['Tag']['andor'] : null;
        		$word = $that->Tag->multipleKeywords($that->request->data['Tag']['keyword'], $andor);
        		$req = array_merge($req, array("word" => $word));
        	}
        	$that->paginate = array(
        			'Tag' =>
        			array(
        					'conditions' => array(
        							$that->Tag->parseCriteria($req),
        					)

        			)
        	);
        }

        public function search() {
        	$this->psearch($this);
        	$tags = $this->paginate();
        	$this->set('tags', $tags);

        }

       public function auto_complete() {
        	$terms = $this->Taguser->find('all', array(
        			'conditions' => array(
        					'Taguser.name LIKE BINARY' => '%'.$this->params['url']['autoCompleteText'].'%'
        			),
        			'fields' => array('name','user_id'),
        			'limit' => 3,
        			'recursive'=>1,
        	));
        	debug($terms);
        	$terms = Set::Extract($terms,'{n}.Taguser');
//         	$terms += Set::Extract($terms,'{n}.Taguser.name');
        	$this->set('terms', $terms);
//         	$this->layout = 'ajax';
        }
        /**
         * articletransmitter method
         *
         * @return void
         */
		public function articletransmitter($leftID = null,$leftKeyID = null){
			//view method を読み込む　左
			//左右を同じelemrnt で構成する　その画面を呼び出す方法を考える。
			//ページを固定したまま検索する方法を考える。
			//togetter の左は編集先になっている。
        	if($this->request->data['from'] == null){
        		$this->request->data['from'] = array();
        	}
        	if($this->request->data['to'] == null){
        		$this->request->data['to'] = array();
        	}
        	$diff =array_diff ($this->request->data['to']['Article'],$this->request->data['from']['Article'] );
        	debug($diff);
        	$options['key'] = $leftKeyID;
			foreach ($diff as $var){
				debug($var['ID']);
				 $ToID= $var['ID'];
				$this->Common->triAddbyid($this,$this->Auth->user('id'),$leftID,$ToID,$options);
			}
        	if($this->request->data['Taguser']['lr'] == "left"){
        		$leftID = null;
        		$leftKeyID = null;
				$this->psearch($this);
				$this->set('lefttagresults', $this->Paginator->paginate());
				//left $leftID $leftKeyID del
        	}
    		if ($leftID != null and $leftID != 0) {
				$options = array('key' => $leftKeyID);
	        	$this->Common->trifinderbyid($this,$leftID,$options);
	        	$this->set('lefttaghashes', $this->taghash);
	        	$this->set('leftarticleresults', $this->articleparentres);
	        	$this->set('lefttagresults', $this->tagparentres);
				$options = array('conditions' => array('Taguser.'.$this->Taguser->primaryKey => $leftID),'order' => array('Taguser.ID'));
				$this->set('leftheadresults', $this->Taguser->find('first', $options));
			}
			//$this->Article->recursive = 0;
			//$conditions = array();//array('order' => array('Article.modified' => 'asc'));

			//$this->set('rightarticleresults', $this->paginate('Article',array()));
			$this->loadModel('Article');
			if($rightID == null ){
				$this->set('rightarticleresults', //$this->paginate('Article',$options)
						$this->Article->find('all',array('order'=> array('Article.modified' => 'desc'),'limit' => 30))
				);
			}
        	$this->loadModel('User');
        	$this->loadModel('Key');
        	$this->set( 'keylist', $this->Key->find( 'list', array( 'fields' => array( 'ID', 'name'))));
        	$this->set( 'ulist', $this->User->find( 'list', array( 'fields' => array( 'ID', 'username'))));
        	$this->set('leftID', $leftID);
        	$this->set('leftKeyID', $leftKeyID);
        }



        /**
         * search method
         *
         * @return $tagresult
         */


        public function quant($id = null) {
        	if ($this->request->is('post')) {
        		$this->userID = $this->Auth->user('id');
        		if ($this->userID == null) {
        			$this->userID = Configure::read('acountID.admin');
        		}
        		if($this->request->data['Link']['user_id'] == $this->userID){
        			$this->loadModel('Link');
        			if ($this->Link->save($this->request->data)) {

        				$this->Session->setFlash(__('The article has been saved.'));
        			} else {
        				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
        			}
        		}
        	}
        	$this->redirect($this->referer());
        }



        public function singletrikeytable($id = null,$trikey = null){
        	parent::singletrikeytable($id,$trikey);
        }

        public function tagdel($id = NULL) {
//         	debug($id);
//         	debug($this->request->data());
        	$this->Link = new Link();
        	//$options = array('conditions' => array('.'.$this->Aurh->primaryKey => $this->request->data['Taguser']['']));
//         	$Link->find('all');

        	if ($this->Link->delete($this->request->data('Link.ID'))){
        		if($this->Basic->taglimitcountup($this)){
        			$this->Session->setFlash(__('削除完了.'));
        			debug("sucsess");
        		}else{
        			debug("auth fail");
        		}
        	} else {
        		$this->Session->setFlash(__('削除失敗.'));
        		debug("fail");
        	}
        	//$this->redirect($this->referer());
        }

        public function result($id = null) {
        	$this->Common->trifinder($this);
        	$this->set('idre', $id);
        }
        public function replytagadd($id = null) {

        }

        public function triarticleadd($id = null) {
        	$this->Common->triarticleAdd($this);
        	$this->redirect($this->referer());
        }
        public function logout() {
        	$user = $this->Auth->user();
        	$this->Cookie->destroy();
        	$this->Session->destroy();
        	if (isset($_COOKIE[$this->Cookie->name])) {
        		$this->Cookie->destroy();
        	}
        	$this->RememberMe->destroyCookie();
        	$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged out'), $user[$this->{$this->modelClass}->displayField]));
        	$this->redirect("/tags/search");
        }
}


