<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
class FollowComponent extends Component {
	/**
	 * 　add method
	 * @param array or int $changed_ids
	 *  どっちで渡してもOK
	 */
	public function add(&$that,$changed_ids){
		$changed_ids = (array)$changed_ids;
		if (is_array($changed_ids)){
			foreach ($changed_ids as $changed_id){
				self::Feed(&$that,self::GETeffected(&$that,$changed_id));
			}
		} else {
			 self::Feed(&$that,self::GETeffected(&$that,$changed_ids));
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
	 */
	public function Feed(&$that,$effected_ids){
		foreach ($effected_ids as $effected_id){
			self::pushFeed($that, self::GETfollower($that, $effected_ids), $name, $option);
		}
		return $bool;
	}

	/**
	 *
	 * @param Object $that
	 * @param mixed $follower_ids array or int
	 * @param string $name 更新した記事の要約 twitter連携の時はこれをポスト　140文字まで
	 * @param array $option  ctrl action id
	 * @return boolean
	 * 　どのページを帆湯辞させた方がいいのかわからない。
	 * 更新した人間が操作している現在のアドレスと　捜査した対象を記録する
	 * 　表示させるときは、更新した人間のいるページを表示して　更新対象をハイライトする
	 * 　履歴を表示するときに　元のページのroot entity と更新した対象が関連性を持たない場合、どのように処理するのか？
	 * 　関連性がない倍委、ページの下に無関係として　append する。
	 */
	public function pushFeed(&$that,$follower_ids,$name,$option){
		$bool = false;
		$data["Social"] = array(
				'name' => $name,
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
 * @param unknown $that
 * @param unknown $effected_ids
 * @return Ambigous <multitype:, NULL>|Ambigous <multitype:, number>
 *
 * follower target <(follow)=  User
 *
 */
	public function GETfollower(&$that,$effected_ids){
		$follower_ids = array();

		if (is_array($effected_ids)){
			foreach ($effected_ids as $effected_id){
				$follower_ids = array_merge($follower_ids,BasicComponent::tribasicRefiderbyid(
						$that,Configure::read("tagID.follow"),
						"User","User.id",$effected_id)) ;
			}
		} else {
			return BasicComponent::tribasicRefiderbyid(
						$that,Configure::read("tagID.follow"),
						"User","User.id",$effected_ids);;
		}
		return $follower_ids;
	}



}