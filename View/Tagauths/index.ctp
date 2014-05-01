<div class="tagauths index">
	<h2><?php echo __('Tagauths'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('tag_id'); ?></th>
			<th><?php echo $this->Paginator->sort('quant'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tagauths as $tagauth): ?>
	<tr>
		<td><?php echo h($tagauth['Tagauth']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tagauth['User']['id'], array('controller' => 'users', 'action' => 'view', $tagauth['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($tagauth['Tag']['name'], array('controller' => 'tags', 'action' => 'view', $tagauth['Tag']['ID'])); ?>
		</td>
		<td><?php echo h($tagauth['Tagauth']['quant']); ?>&nbsp;</td>
		<td><?php echo h($tagauth['Tagauth']['modified']); ?>&nbsp;</td>
		<td><?php echo h($tagauth['Tagauth']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tagauth['Tagauth']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tagauth['Tagauth']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tagauth['Tagauth']['id']), null, __('Are you sure you want to delete # %s?', $tagauth['Tagauth']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Tagauth'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
