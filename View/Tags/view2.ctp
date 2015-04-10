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

	<table>
		<?php $nodes = $default_nodes[$base_trikey]["tagparentres"];
		$model = "Tag"; ?>
		<?php foreach ($nodes as $node): ?>
		<tr>
			<td>
				<p>
				<div onClick='toggleShow(this);' >
				trikey name default 2138 reply</div>
				<div id='HSfield' style='display: none;'>
				<input type="text"></div>

				</p>
				<?php echo $node["$model"]["name"]; ?>
				<div onClick='toggleShow(this);' >
				son</div>
				<div id='HSfield' style='display: none;'>
				<table><tr><td>
				son
				</td></tr></table></div>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php $nodes = $default_nodes[$base_trikey]["articleparentres"];
		$model = "Article"; ?>
		<?php foreach ($nodes as $node): ?>
		<tr>
			<td>
				<p>
					<input type="checkbox">
				</p>
				<?php echo $node["$model"]["name"]; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>>
	 reply with <div class="selected_trikey">aa</div> trikey
	<?php echo $this->Form->create($model); ?>

		<?php echo $this->form->hidden($model.'.keyid' ,array('value' => $key)); ?>
			<legend><?php echo __($model); ?></legend>
		<?php
			$targetid = $this->params['pass'][0];
			echo $this->Form->input('name',array('class'=> 'reply_article_name'));
		?>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>

</body>
</html>