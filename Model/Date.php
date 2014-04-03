<?php
App::uses('AppModel', 'Model');
class Date extends AppModel {
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