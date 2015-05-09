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
	 * @param unknown $that
	 * @param mixed $follower_ids array or int
	 * @param string $name 更新した記事の要約 twitter連携の時はこれをポスト　140文字まで
	 * @param unknown $option  controller  action id
	 * @return boolean
	 */
	public function pushFeed(&$that,$follower_ids,$name,$option){
		return $bool;
	}


	public function GETfollower(&$that,$effected_ids){
		$follower_ids = array();
		$Follow = new Follow();
		$option = array();
		if (is_array($effected_ids)){
			foreach ($effected_ids as $effected_id){
				//
				$follower_ids =+ $Follow->find('all',$option);
			}
		} else {
			return $follower_ids =+ $Follow->find('all',$option);
		}
		return $follower_ids;
	}



}