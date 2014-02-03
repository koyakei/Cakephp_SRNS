<div class="keys form">
<?php echo $this->Form->create('Key'); ?>
	<fieldset>
		<legend><?php echo __('Add Key'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	<?php
		echo $this->Form->input('ID', array ('type'=>'text'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Keys'), array('action' => 'index')); ?></li>
	</ul>
</div>
