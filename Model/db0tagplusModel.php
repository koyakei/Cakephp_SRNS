<?php
App::uses('AppModel', 'Model');
 
class SrnsModel extends AppModel {
	public function Srns() {
		$st = $this->query("SELECT * FROM `Tag` WHERE `ID` =1");
	}
}