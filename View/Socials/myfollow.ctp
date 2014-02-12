<div class="follows index"><?php //debug($socials); ?>
	<h2><?php echo __('Follows'); ?></h2>
	<table>
		<thead>
			<th><?php echo $this->Paginator->sort('created'); ?>
			</th>
			<th>link
			</th>
		</thead>
		<tbody>
			<?php foreach ($socials as $social): ?>
			<tr>
				<td><?php echo h($social['Social']['created']); ?>&nbsp
				</td>
				<td><?php echo $this->Html->link(($social['User']['username']), array('plugin' =>$social['Social']['vplugin'],'controller' => $social['Social']['vctrl'], 'action' => $social['Social']['vaction'], $social['Social']['page_id'])); ?></td>
				
			</tr>
			<?php endforeach; ?>
		
		</tbody>
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
		
		<li><?php echo $this->Html->link(__('New Follow'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Social'), array('controller' => 'socials', 'action' => 'index')); ?> </li>
	</ul>
</div>
