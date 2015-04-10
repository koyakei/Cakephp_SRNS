<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->script(array("view2","accordion")); ?>
	<style type="css">
	.autoCompleteInputBox {
		width: 50%;
	}
	</style>
</head>
<body>
	<fieldset>
	    <?php
			echo $this->AutoCompleteNoHidden->input(
			    'or1.1',
			    array(
			        'autoCompletesUrl'=>$this->Html->url(
			            array(
			                'controller'=>'tagusers',
			                'action'=>'auto_complete',
			            )
			        ),
			        'autoCompleteRequestItem'=>'autoCompleteText',
			    )
			);
		?>
		<div class="search_tag_id">
		<?php
			echo $this->Form->hidden('or.0.',array('value' => '','class' => 'tag_id','id' => 'or1'));
		?>
		</div>
	</fieldset>
AND
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or.0.',array('value' => '','class' => 'tag_id','id' => 'or2'));
?>
</div>
</fieldset>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or.1.',array('value' => '','class' => 'tag_id','id' => 'or1'));
?>
</div>
</fieldset>
AND

	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or.1.',array('value' => '','class' => 'tag_id','id' => 'or2'));
?>
</div>
</fieldset>


<BUTTON type="button" id="search" onclick="all_reply_find($('.search_tag_id'))">検索</BUTTON>
	</div>

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
				trikey name default <div class="selected_trikey" >aa</div> </div>
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