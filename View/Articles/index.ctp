<div class="articles index">
	<h2><?php echo __('Articles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($articles as $article): ?>
	<tr>
		<td><?php echo h($article['Article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($article['Article']['name']); ?>&nbsp;</td>
		<td><?php echo h($article['Article']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($article['Article']['created']); ?>&nbsp;</td>
		<td><?php echo h($article['Article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $article['Article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $article['Article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $article['Article']['ID']), null, __('Are you sure you want to delete # %s?', $article['Article']['ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New Article'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Tag search'), array('controller' =>'Tags', 'action' => 'search')); ?></li>
	</ul>
</div>
