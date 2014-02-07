<div class="follows view">
<h2><?php echo __('Follow'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($follow['User']['ID'], array('controller' => 'users', 'action' => 'view', $follow['User']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Target'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['target']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Follow'), array('action' => 'edit', $follow['Follow']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Follow'), array('action' => 'delete', $follow['Follow']['ID']), null, __('Are you sure you want to delete # %s?', $follow['Follow']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Follows'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Follow'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
