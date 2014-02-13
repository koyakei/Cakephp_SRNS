<?php echo $this->Form->create($model); ?>
<fieldset>
	<?php echo $this->Form->input('keyid', array(
	'type' => 'select',
	'multiple'=> false,
	'options' => $keylist,
	'selected' => $selected  
	)); ?>
<?php echo $this->Form->input('userid', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']  
	)); ?>
	
		<legend><?php echo __($model); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('name');
		//echo $this->Form->hidden('id', array('value'=> $targetid));
		//echo $this->Form->hidden('replyarticleadd', array('value'=> true));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>