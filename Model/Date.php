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
}