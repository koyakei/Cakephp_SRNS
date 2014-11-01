<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->script(array("view2","accordion")); ?>
</head>
<body>
	<ul class="accordion">
		<?php foreach ($all_results as $allresult): ?>
			<?php echo $this->element('accordion/table_reply'); ?>
		<?php endforeach; ?>
	</ul>
<!-- アコーディオンパネルをここに設置する
taghashみたいに各ネストごとにループして配置
ネストが入れ子になっている時の動作を考える。
アコーディオンでネストさせてテーブルを表示する。
ネストで更にネストしている時の処理
１層目と２総明光でテーブルの中にアコーディオンを作れない店が違う。
階層ごとに処理が違うのはまずそう

-->


</body>
</html>