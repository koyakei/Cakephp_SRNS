<div class="tagusers form">
<?php echo $this->Form->create('Taguser'); ?>
	<fieldset>
		<legend><?php echo __('Add Taguser'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('name');
		echo $this->Form->input('user_id');
		echo $this->Form->input('max_quant');
		echo $this->Form->input('username');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tagusers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
