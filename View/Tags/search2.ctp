<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->script("view2"); ?>
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

<div id="body">
<div onClick='toggleShow(this);' >
	add

</div>
<div id='HSfield' style='display: none;'>
	<div id="inputfield">
		<fieldset>
		<?php echo $this->Form->input("Add Article", array('type'=> 'text','placeholder' => '記事　内容')); ?>
		<?php echo $this->Form->input("Add Article", array('type'=> 'button', 'onClick' => 'addArticle(this)')); ?>
		<?php echo $this->Form->input('user_id', array(
		    'type' => 'select',
		    'multiple'=> false,
		    'options' => $ulist,
		  'selected' => $currentUserID//['userselected']
		,'id'=>'user_id')); ?>
		<?php echo $this->Form->input('trikey[]', array('type'=> 'hidden','class' => 'trikey', 'value' =>$trikey)); ?>
		</fieldset>
	<!-- 下に　$user_id $name $target_ids array リンクする対象id配列
	これをどうにかして取り出して投げる-->

		<fieldset>
		        <?php echo $this->AutoCompleteNoHidden->input(
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
			);?>

			<?php
				echo $this->Form->hidden('add_tag_id.',array('value' => '','class' => 'tag_id','id' => 'tag_id'));
			echo $this->Form->hidden('add_trikey_id.',
				array('value' => $trikey_id,'class' => 'tag_id','id' => 'add_trikey_id')); ?>
				<?php echo $this->Form->input('add tag', array('type'=> 'button', 'value' =>'Add Tag','onClick' => 'add_single_tag(this)')); ?>
				<?php echo $this->Form->input('trikey[]', array('type'=> 'hidden','class' => 'trikey', 'value' =>$trikey)); ?>
		</fieldset>

	</div>
</div>
</body>
</html>