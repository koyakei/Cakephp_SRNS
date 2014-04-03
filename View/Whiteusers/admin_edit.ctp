<div class="whiteusers form">
<?php echo $this->Form->create('Whiteuser'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Whiteuser'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entity_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('username');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Whiteuser.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Whiteuser.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Whiteusers'), array('action' => 'index')); ?></li>
	</ul>
</div>
