<div class="whitelists form">
<?php echo $this->Form->create('Whitelist'); ?>
	<fieldset>
		<legend><?php echo __('Edit Whitelist'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entity_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Whitelist.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Whitelist.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Whitelists'), array('action' => 'index')); ?></li>
	</ul>
</div>
