<?php
App::uses('ModelBehavior', 'Model');
App::uses('Social', 'Model');
class SrnsBehavior extends ModelBehavior {/*
	public function afterSave($Model,$created){
		debug($Model->plugin);
		debug($Model->action);
		debug($Model->view);
		debug($Model->aname);
		$data['Social']['vaction'] = $Model->action;
		$data['Social']['vplugin'] = $Model->plugin;
		$data['Social']['vctrl'] = $Model->aname;
		$data['Social']['vview'] = $Model->view;
		$Social = new Social();
		$Social->create();
		$Social->Save($data());
	}*/
	/*
	public function afterDelete($model){

	}*/

}
?>