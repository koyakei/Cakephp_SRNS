<?php
App::uses('AppModel', 'Model');
/**
 * Key Model
 *
 */
class Key extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'test';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'key';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
