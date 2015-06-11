<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Date', 'Model');
App::uses('Follow', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
class FollowComponent extends Component {

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
			self::Feed(self::GETeffected($changed_id),$options);
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

	 public function followChecker($id,$user_id){
	 	$Follow = new Follow();
	 	$res = $Follow->find("all", array("conditions" =>
	 			array("user_id" => $user_id,"target" => $id)));
	 	return $res;
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
		$data["Social"] = $options;
		foreach ((array)$follower_ids as $follower_id){
			$data["Social"]['user_id'] = $follower_id;
			$Social = new Social();
			$Social->create();
			$bool = $bool + $Social->Save($data);
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