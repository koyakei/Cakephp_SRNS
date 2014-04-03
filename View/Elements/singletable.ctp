  <h2><?php echo __d('users', 'Users'); ?></h2>


	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('username'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th class="actions"><?php echo __d('whitelists', 'Actions'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		?>
		<tr<?php echo $class; ?>>
			<td><?php echo $this->Html->link($user['username'], array('plugin' => 'users','controller' => 'users','action' => 'view', $user['user_id'])); ?></td>
			<td><?php echo $user['created']; ?></td>
			<td class="actions">
				 <?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'Whitelists','action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id']));
						  ?>
			</td>

		</tr>
	<?php endforeach; ?>
	</table>
	
