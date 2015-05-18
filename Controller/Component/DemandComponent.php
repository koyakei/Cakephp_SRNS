<?php
App::uses('Tag', 'Model');
App::uses('User', 'Model');
App::uses('Link', 'Model');
App::uses('Article', 'Model');
App::uses('Date', 'Model');
App::uses('BasicComponent', 'Controller/Component');
Configure::load("static");
class DemandComponent extends Component {
	//削除と追加の要請が入り交じったものがが流れてくる
	//分解してそれぞれの関数に渡す

	//複数のエンティティーの追加要請
	/**
	 *
	 * @param array $request
	 *  format  array(array(
	 *  	'to' =>
	 *    'from' =>
	 *    'trikey' => ),...
	 *    )
	 *
	 *    from -(trikey) > to
	 *     是を表すとして、是の連続で表現するかな
	 *     trikey を固定したまま　from と　to だけ　どんどん変える場合が多い
	 *     　3っつの様相のうち２つが固定されている場合も多いだろう。
	 *     前の値が継承されるようにした方が良い。
	 *
	 */

	// update と insert をどうやって区別をつけるのか？
	//主にupdate が多いはずだが、

	public function requestUpdateDemands($requests){
		foreach ($requests as $request){

		}
	}
	public function requestUpdateDemand($requests){
		foreach ($requests as $request){

		}
	}


	//複数のエンティティーの削除要請
	/**
	 * delete に関しては　単体作事余のみで行けるかも？
	 * でも、trikey@official と　trikey@personal 両方一回のクリックで削除となると大変かも
	 *
	 *
	 * trの戦闘にdelボタンを設置
	 *
	 * @param unknown $request
	 * @param unknown $trikeys
	 */
	public function requestDelDemands($request,$trikeys){

	}

	//複数のエンティティーの削除要請
	public function requestDelDemand($request,$trikeys){

	}

	public function acceptDemand(){

	}

	//追加リクエスト
	public function requestInsertDemands(&$that,$requests){
		foreach ($requests as $request){
			BasicComponent::trilinkAdd(&$that,$FromID,$ToID,$keyID);

		}
	}
	//単体の追加リクエスト
	//まとめて削除とかするときにはどうするの　demand　table をどうまとめるか？
	public function requestInsertDemand($request,$trikeys){

	}

	public function accepter($demand_id){
// 		$demand = new Demand();
// 		$demand->id = $demand_id;
// 		$demand = $demand->find("first");
// 		foreach ($demand as $each){
			if ($each["Demand"]["c_d"] == 0){
				if(LinksController::add2($demand)){
					$DDemand->delete();
				}
			} else {
				$DDemand = new Ddemand();
				$DDemand->id = $demand_id;
				$DDemand = $DDemand->find("first");
				if(LinksController::delete2($demand)){
					$DDemand->delete();
				}
			}
// 		}



	}
	//要求を実行 $demand の形式は？
	/**
	 *
	 * @param unknown $demand　array("Link"=>array("LFrom","LTo"...））
	 * テーブルと同じ形式ならとてもありがたい、
	 * でも　$userID,$FromID,$ToID, trikey を絶対に含む
	 * 要求の種類
	 * 　両方接続　新しく作るのでひとつの権限を消費するだけ
	 * 変更という変種手段をなくして、全部create とdelete に置き換えて考えよう。　　
	 * 片方接続taglink は関係ないが、権限を切り離した状態とくっつける状態の異界動かす比喩等がある。
	 * 　　　切り離す
	 * article
	 * @var $i_or_d  insert or demand
	 * @return bool  accepted true fail false
	 */
	public function delDemandExe($demand){

	}
	/**
	 * 自分にだけ見えるリンクを作る
	 * @param unknown $demand
	 */
	public function selfLinkInsert($demand){

	}

	public function selfLinkDelete($demand){

	}
}