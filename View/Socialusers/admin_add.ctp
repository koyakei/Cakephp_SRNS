<div class="socialusers form">
<?php echo $this->Form->create('Socialuser'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Socialuser'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('ctrl');
		echo $this->Form->input('view');
		echo $this->Form->input('page_id');
		echo $this->Form->input('plugin');
		echo $this->Form->input('vplugin');
		echo $this->Form->input('action');
		echo $this->Form->input('vaction');
		echo $this->Form->input('vview');
		echo $this->Form->input('vctrl');
		echo $this->Form->input('username');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Socialusers'), array('action' => 'index')); ?></li>
	</ul>
</div>
