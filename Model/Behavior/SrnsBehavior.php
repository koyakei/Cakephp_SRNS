<?php
App::uses('ModelBehavior', 'Model');
App::uses('Social', 'Model');
class SrnsBehavior extends ModelBehavior {
	public function afterSave(){
		debug($this->plugin);
		debug($this->action);
		debug($this->view);
		debug($this->name);
		$this->request->data['Social']['vaction'] = $this->action;
		$this->request->data['Social']['vplugin'] = $this->plugin;
		$this->request->data['Social']['vctrl'] = $this->name;
		$this->request->data['Social']['vview'] = $this->view;
		$this->Social->create();
		$this->Social->Save($this->request->data());
	}
	/*
	public function afterDelete($model){

	}*/

}
?>