  <h2><?php echo __d('users', 'Users'); ?></h2>


	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('username'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
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

		</tr>
	<?php endforeach; ?>
	</table>
	<?php //echo $this->element('Users.pagination'); ?>
	</div>