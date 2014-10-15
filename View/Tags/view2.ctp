<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->script("view2"); ?>
</head>
<body>
<table class="myTable" cellpadding="0" cellspacing="0">
<colgroup span="4"></colgroup>
<colgroup class="taghash" span="15"></colgroup>
        <?php echo $this->element('tablehead',
         Array('taghashes'=>$taghash)); ?>
    <tbody>
    	<?php echo $this->element('rsorttablebody',
    	 Array('results' => $tableresults['articleparentres'],
    	 'taghashes'=>$taghash,
    	 'firstModel' => 'Article',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member']
    	,$sorting_tags)); ?>
		<?php echo $this->element('rsorttablebody',
    	 Array('results' => $tableresults['tagparentres'],
    	 'taghashes'=>$taghash,
    	 'firstModel' => 'Tag',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member'],
    	$sorting_tags)); ?>

	</tbody>
</table>
<div id="acordion">
<!-- アコーディオンパネルをここに設置する
taghashみたいに各ネストごとにループして配置
ネストが入れ子になっている時の動作を考える。
アコーディオンでネストさせてテーブルを表示する。
ネストで更にネストしている時の処理
１層目と２総明光でテーブルの中にアコーディオンを作れない店が違う。
階層ごとに処理が違うのはまずそう

-->

</div>
</body>
</html>