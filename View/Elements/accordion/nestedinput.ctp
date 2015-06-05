<!-- $model $key $currentUserID $ulist -->
<form>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	,'id'=>'user_id')); ?>

	<?php
	if (!empty($parentID)){
		echo $this->form->hidden("parentID" ,array('value' => $parentID));
	}
	?>
		<?php echo __($model); ?>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('Article',array('class'=> 'reply_article_name'));
		echo $this->Form->hidden("target",array("value" =>$result["follow"]));
	?>
<input type="button" value="addArticle" onClick="addArticle(this)">
</form>

<!-- tag追加 -->
<fieldset id="add_tag">
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	,'id'=>'user_id')); ?>
		        <?php echo $this->AutoCompleteNoHidden->input(
			    'tag',
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
echo $this->Form->hidden('tag',array('value' => '','class' => 'tag_id','id' => 'tag'));
?>

				<?php echo $this->Form->input('add tag', array('type'=> 'button', 'value' =>'Add Tag','onClick' => 'add_reply_tag(this)')); ?>
				<?php echo $this->Form->input('trikey[]', array('type'=> 'hidden','class' => 'trikey', 'value' =>$trikey)); ?>
		</fieldset>