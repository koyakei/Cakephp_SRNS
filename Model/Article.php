<?php
App::uses('Date', 'Model');
Configure::load("static");
/**
 * Article Model
 *
 */
class Article extends Date {
	//public $replyID = Configure::read('tagID.reply');//tagConst()['replyID']

	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
	        'word' => array(
//'name' => 'name',
 'type' => 'value'
, 'field' => array('tag.name')
, 'connectorAnd' => '+', 'connectorOr' => ','
),
	);

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'article';
	//var $uses = array("article", "link");

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

        //public $useTable = false;





	function beforeValidate(){
		if($this->data['Article']['user_id'] == null){
			$this->data['Article']['user_id'] = AuthComponent::user("id");
		}
		return true; //this is required, otherwise validation will always fail
	}
public $base_sql = null;


        /*public function paginate($conditions,$fields,$order,$limit,$page=1,$recursive=null,$extra=array()){
	$this->replyID = tagConst()['replyID'];
            if($page==0){$page = 1;}
            $recursive = -1;
            $offset = $page * $limit - $limit;
	 $this->base_sql = "SELECT  `article` . *, `LINK`.`ID` AS LinkID FROM  `LINK` INNER JOIN  `LINK` AS tagLink ON  `LINK`.`ID` = `tagLink`.`LTo`, `article`  WHERE  `LINK`.`LFrom` = $this->id AND `tagLink`.`LFrom` =$this->replyID  AND `article` . `ID` = `LINK` . `LTo`";
            $sql = $this->base_sql . ' limit ' . $limit . ' offset ' . $offset;
            return $this->query($sql);
        }

        public function paginateCount($conditions=null,$recursive=0,$extra=array()){
            $this->recursive = $recursive;
            $results = $this->query($this->base_sql);
            return count($results);
        }*//*
    public $hasOne= array(
        'AO' => array(
		'className' => 'User',
		'foreignKey' => 'ID',
		'dependent' => false,
		'conditions' => 'AO.ID = Article.user_id',
		//'type' => 'inner'
        )
    );*/
/*

	public $hasMany = array(
		'AI_LF' => array(//�����̖��O�����̃��f����AS�@�Ȃ�Ƃ��ɂȂ�
			'className' => 'Link',
			'foreignKey' => 'LFrom',
			'dependent' => false,
			'conditions' => 'article.ID = link.LFrom',
			'fields' => 'LTo',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
	/*
	);
	public $belongsTo = array(
		'AI_LT' => array(//�����̖��O�����̃��f����AS�@�Ȃ�Ƃ��ɂȂ�
			'className' => 'Link',
			'foreignKey' => 'ID',
			'dependent' => false,
			//'conditions' => 'Article.ID = AI_LT.LTo',
			'fields' => 'LFrom',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '10',
			'finderQuery' => '',
			'counterQuery' => '',
			'type' => 'INNER'
		),
	);*/
/**
 * Validation rules
 *
 * @var array
 */
public $validate = array(
		'user_id' => array(
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

   public $hasOne= array(
        'O' => array(
	        'fields' => 'username',
			'className' => 'User',
			'foreignKey' => FALSE,
			'dependent' => false,
			'conditions' => array('`O.id = Article.user_id`')
			,
		//'type' => 'inner'
        ),
//    		'URL' => array(
//    				'fields' => 'name',
//    				'className' => 'Link',
//    				'foreignKey' => FALSE,
//    				'dependent' => false,
//    				'conditions' => array('`URL.FromID = Article.ID`',)
//    				,
//    				'type' => 'inner',
//    				'joins' => array()
//    		)
    );
}
