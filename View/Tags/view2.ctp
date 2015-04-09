<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->script(array("view2","accordion")); ?>
</head>
<body>

<!-- アコーディオンパネルをここに設置する
taghashみたいに各ネストごとにループして配置
ネストが入れ子になっている時の動作を考える。
アコーディオンでネストさせてテーブルを表示する。
ネストで更にネストしている時の処理
１層目と２層目でテーブルの中にアコーディオンを作れない店が違う。
階層ごとに処理が違うのはまずそう

-->
<div class="root">
	<!-- プルダウンメニューを開くようにはしない。スクロールのみで対応
	プルダウンで閉じるメリットが少ない。クッキー制御で繊維をまたいで開閉-->
	<?php //debug($default_nodes[$base_trikey]["tagparentres"]); ?>
	<?php //$this->element('complexed_box/checkbox_td',array('model' => 'Tag'));?>
	<?php $tag_nodes = $default_nodes[$base_trikey]["tagparentres"];
		$model = "Tag"; ?>
	<?php foreach ($tag_nodes as $node): ?>
	<td>
		<p>
			<input type="checkbox">
		</p>
		<?php echo $node["$model"]["name"]; ?>
	</td>
<?php endforeach; ?>

</div>

</body>
</html>