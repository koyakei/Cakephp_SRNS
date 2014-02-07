<div class="follows index">
	<h2><?php echo __('Follows'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('target'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($follows as $follow): ?>
	<tr>
		<td><?php echo h($follow['Follow']['ID']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($follow['User']['username'], array('controller' => 'users', 'action' => 'view', $follow['User']['ID'])); ?>
		</td>
		<td>
		<?php echo $this->Html->link($follow['target']['username'], array('controller' => 'users', 'action' => 'view', $follow['Follow']['target'])); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $follow['Follow']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $follow['Follow']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $follow['Follow']['ID']), null, __('Are you sure you want to delete # %s?', $follow['Follow']['ID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('My Follow'), array('action' => 'myfollow')); ?></li>
		<li><?php echo $this->Html->link(__('New Follow'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Social'), array('controller' => 'socials', 'action' => 'index')); ?> </li>
	</ul>
</div>
