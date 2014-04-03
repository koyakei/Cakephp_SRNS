<div class="whiteusers view">
<h2><?php echo __('Whiteuser'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($whiteuser['Whiteuser']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entity Id'); ?></dt>
		<dd>
			<?php echo h($whiteuser['Whiteuser']['entity_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($whiteuser['Whiteuser']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($whiteuser['Whiteuser']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($whiteuser['Whiteuser']['username']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Whiteuser'), array('action' => 'edit', $whiteuser['Whiteuser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Whiteuser'), array('action' => 'delete', $whiteuser['Whiteuser']['id']), null, __('Are you sure you want to delete # %s?', $whiteuser['Whiteuser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Whiteusers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Whiteuser'), array('action' => 'add')); ?> </li>
	</ul>
</div>
