<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="users view">
<h2><?php echo __d('users', 'User'); ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class; ?>><?php echo __d('users', 'Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class; ?>>
			<?php echo $user[$model]['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class; ?>><?php echo __d('users', 'Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class; ?>>
			<?php echo $user[$model]['created']; ?>
			&nbsp;
		</dd>
		<?php
		if (!empty($user['UserDetail'])) {
			foreach ($user['UserDetail'] as $section => $details) {
				foreach ($details as $field => $value) {
					echo '<dt>' . $section . ' - ' . $field . '</dt>';
					echo '<dd>' . $value . '</dd>';
				}
			}
		}
		?>
	</dl>
</div>

<table>
	<thead>
		<th><?php echo $this->Paginator->sort('created'); ?>
		</th>
		<th>link
		</th>
	</thead>
		<?php foreach ($socials as $social): ?>
		<tr>
			<td><?php echo $this->Html->link($social['User']['username'], array('plugin' => 'users','controller' => 'users', 'action' => 'view', $follow['User']['id'])); ?>&nbsp
			</td>
			<td><?php echo $this->Html->link($social['Social']['created'], array('plugin' =>$social['Social']['plugin'], 'action' => $social['Social']['action'] 'view'=>$social['Social']['view'], $social['Social']['ID'])); ?></td>
			
		</tr>
		<?php endforeach; ?>
	<tbody>
	</tbody>
</table>
<?php echo $this->element('Users.Users/sidebar'); ?>