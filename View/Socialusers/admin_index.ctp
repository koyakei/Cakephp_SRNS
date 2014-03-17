<div class="socialusers index">
	<h2><?php echo __('Socialusers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('ctrl'); ?></th>
			<th><?php echo $this->Paginator->sort('view'); ?></th>
			<th><?php echo $this->Paginator->sort('page_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('plugin'); ?></th>
			<th><?php echo $this->Paginator->sort('vplugin'); ?></th>
			<th><?php echo $this->Paginator->sort('action'); ?></th>
			<th><?php echo $this->Paginator->sort('vaction'); ?></th>
			<th><?php echo $this->Paginator->sort('vview'); ?></th>
			<th><?php echo $this->Paginator->sort('vctrl'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($socialusers as $socialuser): ?>
	<tr>
		<td><?php echo h($socialuser['Socialuser']['ID']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['ctrl']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['view']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['page_id']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['created']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['plugin']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['vplugin']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['action']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['vaction']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['vview']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['vctrl']); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $socialuser['Socialuser']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $socialuser['Socialuser']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $socialuser['Socialuser']['ID']), null, __('Are you sure you want to delete # %s?', $socialuser['Socialuser']['ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New Socialuser'), array('action' => 'add')); ?></li>
	</ul>
</div>
