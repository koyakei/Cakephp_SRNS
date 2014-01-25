<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tag'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('name');
		echo $this->Form->input('owner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
<?php echo $this->element('userinfo',$userinfo); ?>
<?php //echo $userinfo['ID']; ?>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Tag.ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Tag.ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?></li>
	</ul>
</div>
