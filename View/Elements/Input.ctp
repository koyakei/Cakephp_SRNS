
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	,'id'=>'user_id')); ?>
	<?php echo $this->form->hidden($model.'.keyid' ,array('value' => $key)); ?>
		<legend><?php echo __($model); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('name' array('class'=> 'reply_article_name'));
	?>