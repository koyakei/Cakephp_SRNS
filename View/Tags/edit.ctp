<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tag'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('name');
		echo $this->Form->input('owner_id');
		echo $this->Form->input('auth');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php echo $this->element('singletable', Array('users' => $users)); ?>
	<?php echo $this->Form->create('Whitelist',array('controller' => 'Whitelist','action' => 'addbyname')); ?>
	<fieldset>
		<legend><?php echo __('Edit List'); ?></legend>
		<?php echo $this->form->hidden('Whitelist.entity_id' ,array('value' => $this->Form->value('Tag.ID'))); ?>
	<?php
		echo $this->Form->input('username');
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
