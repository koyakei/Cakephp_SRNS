<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Article $Article
 * @property Follow $Follow
 * @property Link $Link
 * @property Social $Social
 * @property Tag $Tag
 * @property UserDetail $UserDetail
 */
class User extends AppModel {
	function &getInstance($user=null) {
		static $instance = array();

		if ($user) {
			$instance[0] =& $user;
		}

		if (!$instance) {
			trigger_error(__("User not set.", true), E_USER_WARNING);
			return false;
		}

		return $instance[0];
	}

	function store($user) {
		if (empty($user)) {
			return false;
		}

		User::getInstance($user);
	}

	function get($path) {
		$_user =& User::getInstance();

		$path = str_replace('.', '/', $path);
		if (strpos($path, 'User') !== 0) {
			$path = sprintf('User/%s', $path);
		}

		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}

		$value = Set::extract($path, $_user);

		if (!$value) {
			return false;
		}

		return $value[0];
	}
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'slug' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Follow' => array(
			'className' => 'Follow',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Link' => array(
			'className' => 'Link',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Social' => array(
			'className' => 'Social',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserDetail' => array(
			'className' => 'UserDetail',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
