<div class="links form">
<?php echo $this->Form->create('Link'); ?>
	<fieldset>
		<legend><?php echo __('Edit Link'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('LFrom');
		echo $this->Form->input('LTo');
		echo $this->Form->input('quant');
		echo $this->Form->input('owner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Link.ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Link.ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List Links'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New A To  L To'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
