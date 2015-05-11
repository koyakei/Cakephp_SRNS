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
	public function requestupdateDemands($requests){
		foreach ($requests as $request){

		}
	}


	//複数のエンティティーの削除要請
	public function requestDelDemand($request,$trikeys){

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
	public function requestInsertDemand($request,$trikeys){

	}

}