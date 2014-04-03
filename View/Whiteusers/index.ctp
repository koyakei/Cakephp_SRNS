<div class="whiteusers index">
	<h2><?php echo __('Whiteusers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entity_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($whiteusers as $whiteuser): ?>
	<tr>
		<td><?php echo h($whiteuser['Whiteuser']['id']); ?>&nbsp;</td>
		<td><?php echo h($whiteuser['Whiteuser']['entity_id']); ?>&nbsp;</td>
		<td><?php echo h($whiteuser['Whiteuser']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($whiteuser['Whiteuser']['created']); ?>&nbsp;</td>
		<td><?php echo h($whiteuser['Whiteuser']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $whiteuser['Whiteuser']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $whiteuser['Whiteuser']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $whiteuser['Whiteuser']['id']), null, __('Are you sure you want to delete # %s?', $whiteuser['Whiteuser']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Whiteuser'), array('action' => 'add')); ?></li>
	</ul>
</div>
