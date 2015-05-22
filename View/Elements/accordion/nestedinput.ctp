<!-- $model $key $currentUserID $ulist -->
<?php echo $this->Form->create(null); ?>
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
		<legend><?php echo __($model); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('name',array('class'=> 'reply_article_name'));
	?>
<?php
echo $this->Form->end(array(
    'label' => 'submit',
    'div' => FALSE,
    'onclick'=>'addArticle(this)'
)); ?>