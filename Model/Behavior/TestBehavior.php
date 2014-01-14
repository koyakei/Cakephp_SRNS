<?php
class TestBehavior extends ModelBehavior {
	function __construct($id = null){
		parent::__construct();

		}
	
	function main($id = null){
		
		debug($id);
	}

}