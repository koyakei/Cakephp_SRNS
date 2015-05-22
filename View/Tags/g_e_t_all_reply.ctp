<table class="myTable" cellpadding="0" cellspacing="0">
        <?php echo $this->element('tablehead',
         Array('taghashes'=>$taghash)); ?>

    <tbody>

    	<?php
    	echo $this->element('accordion/table_reply',
    			array('tableresults' => $tableresults,
    					'taghashes'=>$taghash,
    					'currentUserID' => $currentUserID,
    					'srns_code_member'=>$tableresults['srns_code_member']
    					,$sorting_tags
    			)
    	); ?>

	</tbody>
</table>

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
