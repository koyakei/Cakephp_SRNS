<?php
App::uses('ModelBehavior', 'Model');
class SrnsBehavior extends ModelBehavior {
	var $pdo;
	var $addedID;
	function open(){
        	$this->pdo = db_open();
    	}
	function delRelationIDExe ($targetDelLinkID) {
		foreach ($targetDelLinkID as $ID) {
		        $this->pdo->beginTransaction();
		        $sql = "DELETE FROM `db0tagplus`.`LINK` WHERE `LINK`.`ID` = $ID;";
			$this->pdo->exec($sql); $this->pdo->commit();
		}
	}
	function delRelationExe ($targetDelLink) {
		foreach ($targetDelLink as $ID) {
		        $this->pdo->beginTransaction();
		        $sql = "DELETE FROM `db0tagplus`.`LINK` WHERE `LINK`.`ID` = $ID[ID] AND `LINK`.`owner` = $ID[owner];";
			$this->pdo->exec($sql); $this->pdo->commit();
		}
	}
	function tagQuantEditExe ($articleEdit) {
		//$pdo = db_open();
	//�����N���ƃ����N����w�肵�č폜����Ń����N�폜�S�ʂ��ł���
		foreach ($articleEdit as $articleEditA) {
		        $this->pdo->beginTransaction();
			$sql = "UPDATE `db0tagplus`.`LINK` SET `quant` = $tagQant[quant] WHERE `LINK`.`ID` = $tagQuant[linkID];";
			$this->pdo->exec($sql); $this->pdo->commit();
		}
	}
	function articleEditExe ($articleEdit) {
		//$pdo = db_open();
	//�����N���ƃ����N����w�肵�č폜����Ń����N�폜�S�ʂ��ł���
		foreach ($articleEdit as $articleEditA) {
		        $this->pdo->beginTransaction();
			$sql = "UPDATE `db0tagplus`.`article` SET `name` = '$articleEditA[name]' WHERE `article`.`ID` = $articleEditA[ID];";
			$this->pdo->exec($sql); $this->pdo->commit();
		}
	}
	function tagEditExe($tagEdit) {
		//$pdo = db_open();
	//�����N���ƃ����N����w�肵�č폜����Ń����N�폜�S�ʂ��ł���
		foreach ($tagEdit as $tagEditA) {
		        $this->pdo->beginTransaction();
			$sql = "UPDATE `db0tagplus`.`Tag` SET `name` = '$tagEditA[name]' WHERE `Tag`.`ID` = $tagEditA[ID];";
			$this->pdo->exec($sql); $this->pdo->commit();
		}
	}
	function articleAddExe($articleAdd) {
		//$pdo = db_open();
	//�����N���ƃ����N����w�肵�č폜����Ń����N�폜�S�ʂ��ł���
	                $this->pdo->beginTransaction();//�Ԏ���ǉ�����
		        $sql = "INSERT INTO  `db0tagplus`.`article` (
		        `ID`,
		        `name`,
		        `owner`,
		        `Created_time`
		        )
		        VALUES (
		        NULL ,  '$articleAdd[name]', '$articleAdd[ownerID]', NOW( )
		        );";
		        $this->pdo->exec($sql);
		        $this->addedID = $this->pdo->lastInsertId('ID');
			$this->pdo->commit();
	}
	function triLinkAddExe ($triAdd) {
		//$pdo = db_open();
	//�����N���ƃ����N����w�肵�č폜����Ń����N�폜�S��
		$this->pdo->beginTransaction();//���L���ƕԐM�L���̃����N���쐬
		$sql = "INSERT INTO  `db0tagplus`.`LINK` (
		`ID`,
		`LFrom`,
		`LTo`,
		`quant`,
		`owner`,
		`Created_time`
		)
		VALUES (
		NULL ,  '$triAdd[fromID]',  '$triAdd[toID]',  '1',  '$triAdd[ownerID]', NOW( )
		);";
		$this->pdo->exec($sql); 
		$lastAIID = $this->pdo->lastInsertId('ID');//�Ō�ɒǉ�����LINK�@�e�[�u����ID����
		$this->pdo->commit();
		$this->pdo->beginTransaction();//���L��-�ԐM�����N�ƕԐM�^�O�����N���쐬
		$sql = "INSERT INTO  `db0tagplus`.`LINK` (
		`ID` ,
		`LFrom` ,
		`LTo` ,
		`quant` ,
		`owner`,
		`Created_time`
		)
		VALUES (
		NULL ,  '$triAdd[keyID]',  '$lastAIID',  '1',  '$triAdd[ownerID]', NOW( )
		);";
		$this->pdo->exec($sql); 
		$this->pdo->commit();
	}
}
class sql extends sqlBace{
function __construct(){
        require_once  dirname(__FILE__)."/../cmn/utils.php";
	require_once  dirname(__FILE__)."/../cmn/specialTagIDList.php";
    	}
	function tagEdit($tagEdit){
		$this->open();
		$this->tagEditExe($tagEdit);
	}
	function articleEdit($articleEdit){
		$this->open();
		$this->articleEditExe($articleEdit);
	}
	function delRelation ($targetDelLinkID){
		$this->open();
		$this->delRelationIDExe($targetDelLinkID);
	}
	function tagquantEdit ($tagquantEdit){
		$this->open();
		$this->tagWeightEditExe($tagquantEdit);
	}
	function triArticleAdd($triArticleAdd){
		$articleAdd[name] = $triArticleAdd[name];
		$articleAdd[ownerID] = $triArticleAdd[ownerID];
		$this->open();
		$this->articleAddExe($articleAdd);
		$triAdd = array (
			'keyID' => $triArticleAdd['keyID'],//
			'fromID' => $triArticleAdd['fromID'],
			'toID' => $this->addedID,
			'ownerID' => $triArticleAdd['ownerID']
		);
		print_r ($replyTagID);
		$this->triLinkAddExe($triAdd);
	}
	function replyAdd($replyAdd){
		$triArticleAdd = $replyAdd;
		$triArticleAdd['keyID'] = $this->replyTagID;
		print_r ($this->replyTagID);
		$this->triArticleAdd($triArticleAdd);
	}
	function SSTagAdd($SSTagAdd){
		$triArticleAdd = $SSTagAdd;
		$triArticleAdd['keyID'] = $this->tagSSugID;
		$this->triArticleAdd($triArticleAdd);
	}

}
?>