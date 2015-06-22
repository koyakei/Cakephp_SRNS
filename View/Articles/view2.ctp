<!DOCTYPE html>
<html>
<head>

	<?php echo $this->Html->script(array("view2","accordion")); ?>
	<style type="css">
	.autoCompleteInputBox {
		width: 50%;
	}
	table {
  background: #E4F2F6;
  }
	</style>

</head>
<body>
<div class="actions"  style ="width: 50%;">
<?php echo $this->element('detail',array('detail' =>  $headresults,'firstModel' => $firstModel,'SecondDems' =>  $SecondDems)); ?>
<div class="switch">
    <input type="radio" name="s2" id="on" value="1" checked="">
    <label for="on" class="switch-on"><i class="fa fa-user fa-lg"></i></label>
    <input type="radio" name="s2" id="off" value="0">
    <label for="off" class="switch-off"><i class="fa fa-globe fa-lg"></i></label>
</div>
<?php echo $this->element('accordion/data_strage',array('root_ids' => $id)); ?>
<?php /**
TODO:入れ子もそうだが、　動的表現も　考えよう
この2つの内どちらが優先なのか？ということが重要だ　
動的表現で使い方の説明をするとどうなるのか考えてみてからやるのを決めよう。
動的サンプル　の場面設定はタグ追加のみにしようか？
こよりに聞かれたのは場面追加設定について説明可能か考える
テーブル同士の結びつきが描かれていない。しかしそれを描こうとしているのにこの体たらくである。
テーブル同士の結びつきで正確に描写する欲求がそこまで無いのでは？

**/ ?>
<br>
<!-- quantize -->
<script type="text/javascript">
    function updateTextInput(val) {
      document.getElementById('qNumber').value=val;
    }
  </script>
<?php
	//TODO: 量子化切り替えプルダウン
	//ここの切り替えによってaddした時のquantize を決定する。
	//とりあえず、tagにquantize を設定しない
	echo $this->Form->input('quzntize', array(
			'type' => 'range',
			'multiple'=> false,
			'options' => $quantize,
			'selected' => 0,//['userselected']
			'max' => 5,
			'class'=>'quantizeSelector',
			'onchange' =>"updateTextInput(this.value)",
			"value" => "0",
	));
	echo $this->Form->input('number', array(
			'type' => 'input',
			'onchange' =>"updateTextInput(this.value)",
			'id' => "qNumber",
			"value" => "0",
	));
	$root_data["id"] = $this->params["pass"][0];
	echo $this->element('follow_button',
			array('data' => $root_data
			)
	);
?>
</div>
<div id="search_box"  style ="width: 200px; float:right;">
<ul>
  <li>
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
	</li>

<li>
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
    		'click_function' => 'test()',
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
</fieldset></li>
</ul>

</div>
<div class="trikeys" style ="width: 200px; float:right;">
<p>trikeys</p>
<ul>
<li>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'trikeys.0',
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
<div class="search_tag_id" >
<?php
echo $this->Form->hidden('trikeys..',array('value' => '','class' => 'tag_id'));
?>
</div>
</fieldset></li>
</ul>
</div>
<div class="sorting_tags" style ="width: 200px; float:right;">
<p>sorting tags</p>
<ul>
<li>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'sorting_tags.0',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )

        ),
    	'click_function' => 'all_reply_finder()',
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('sorting_tags..',array('value' => '','class' => 'tag_id'));
?>
</div>
</fieldset></li>
</ul>
</div>
<div class="root">
    	<?php
    	echo $this->element('accordion/table_reply',
    			array('tableresults' => $tableresults,
    					'taghashes'=>$tableresults["taghash"],
    					"index" => $tableresults["indexHashes"],
    					'currentUserID' => $currentUserID,
    					'srns_code_member'=>$tableresults['srns_code_member']
    					,$sorting_tags
    			)
    	);

    	?>
</div>
<div onClick='toggleShow(this);' >
	add
</div>
<div id='HSfield' style='display: none;'>
	<div id="inputfield">
		 <?php
		  echo $this->element('accordion/nestedinput', array("model" => "Article",
		  		 "currentUserID" => $currentUserID ,"ulist" =>$ulist,"parentID" => $result[$firstModel]['ID']))
		  ?>
	</div>
	</div>

</body>
</html>