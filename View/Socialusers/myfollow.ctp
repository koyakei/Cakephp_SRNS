<div class="follows index"><?php //debug($socials); ?>
	<h2><?php echo __('Follows'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($socialusers as $socialuser): ?>
	<tr>
		<td><?php echo $this->Html->link($socialuser['Socialuser']['created'], array('controller' => $socialuser['Socialuser']['vctrl'], 'action' => $socialuser['Socialuser']['vaction'], $socialuser['Socialuser']['page_id'])); ?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'vview', $socialuser['Socialuser']['ID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->element('timeline', Array('socials' => $socials)); ?>
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
		
		<li><?php echo $this->Html->link(__('New Follow'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Social'), array('controller' => 'socialusers', 'action' => 'index')); ?> </li>
	</ul>
</div>
