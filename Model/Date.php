<?php
App::uses('AppModel', 'Model');
class Date extends AppModel {
	public $components = array('Auth');
	public $findMethods = array(
			'auth' => true,
	);
	public function _findAuth($state, $query, $results = array()){
		debug(AuthComponent::user('id'));
		if ($state === 'before') {

			return $query;
		}
		foreach ($results as $idx => $value){
			if (AuthComponent::user('id') == $value[$this->alias]['user_id']) {

			}elseif ($value[$this->alias]['auth'] == 1) {
				foreach ($value['W'] as $whiteuser){
					$list[] =$whiteuser['user_id'];
				}
				if (false === in_array(AuthComponent::user('id'),$list)) {
					unset($results[$idx]);
				}
			}elseif ($value[$this->alias]['auth'] == 0){
				// 				if (false == array_search(AuthComponent::user('id'),$value['B'])) {
				// 					;
				// 				}
			}

		}

		$results = array_values($results);
		return $results;

	}
	public function beforeSave(){
			$this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
			return true;
		}

		public function afterSave($created){
			if ($created) {
				$this->data[$this->alias]['created'] = date("Y-m-d H:i:s");
				$created_save = new $this->alias;
				$created_save->save($this->data);
				return true;
			}

	}
	public function afterFind($results){
		//auth の数値で判定分岐
		//debug($results);
// 		if ($results[$this->alias]['auth'] == 0) {//0何も処理をせずに通す

// 		}elseif ($results[$this->alias]['auth'] == 1){//1 特定ユーザーだけに許可
// 			//sauthテーブルをjoin して

// 		}
	}
	public function isOwnedBy($post, $user) {
		return $this->field('user_id', array('ID' => $post, 'user_id' => $user)) === $post;
	}
}