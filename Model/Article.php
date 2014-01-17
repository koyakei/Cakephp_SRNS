<?php
App::uses('AppModel', 'Model');
/**
 * Article Model
 *
 */
class Article extends AppModel {
	function __construct(){
		parent::__construct();
		$this->replyID = tagConst()['replyID'];
	}
	
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
	public $useTable = 'article';
	var $uses = array("article", "link");

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
        }*/
/*
	
	public $hasMany = array(
		'AI_LF' => array(//ここの名前がこのモデルのAS　なんとかになる
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
		'AI_LT' => array(//ここの名前がこのモデルのAS　なんとかになる
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

}
