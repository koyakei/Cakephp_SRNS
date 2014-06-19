<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
		<legend><?php echo __('Add Tag'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	));
	echo $this->Form->input('auth',array(
    'type' => 'select',
    'options' => array( 0 => 'public',1 => 'private'),
  'selected' => 0));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?></li>
	<li><?php echo $this->Html->link(__('Tag search'), array('action' => 'search')); ?> </li>
	</ul>
</div>
