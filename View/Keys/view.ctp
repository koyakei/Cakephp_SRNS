<div class="keys view">
<h2><?php echo __('Key'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($key['Key']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($key['Key']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Key'), array('action' => 'edit', $key['Key']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Key'), array('action' => 'delete', $key['Key']['ID']), null, __('Are you sure you want to delete # %s?', $key['Key']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Keys'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Key'), array('action' => 'add')); ?> </li>
	</ul>
</div>
