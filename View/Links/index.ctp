<div class="links index">
	<h2><?php echo __('Links'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('LFrom'); ?></th>
			<th><?php echo $this->Paginator->sort('LTo'); ?></th>
			<th><?php echo $this->Paginator->sort('quant'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($links as $link): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($link['ATo_LTo']['name'], array('controller' => 'articles', 'action' => 'view', $link['ATo_LTo']['ID'])); ?>
		</td>
		<td><?php echo h($link['Link']['LFrom']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['LTo']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['quant']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['owner_id']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['created']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $link['Link']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $link['Link']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $link['Link']['ID']), null, __('Are you sure you want to delete # %s?', $link['Link']['ID'])); ?>
			
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
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New A To  L To'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
