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
		<dt><?php echo __d('users', 'Following'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__d('users', 'Following'),
					array('action' => 'following',$this->params["pass"][0]
			)); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('users', 'Follower'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__d('users', 'Follower'),
					array('action' => 'follower',$this->params["pass"][0]
			)); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('users', 'My activity'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__d('users', 'My activity'),
					array('action' => 'my_activity',$this->params["pass"][0]
			)); ?>
			&nbsp;
		</dd>
	</dl>
	<?php
	if (AuthComponent::user("id") != $this->params["pass"][0]){
		$root_data["id"] = $this->params["pass"][0];
		echo $this->element('follow_button',
				array('data' => $root_data
				)
		);
	}
	?>
	<h2><?php echo __('Time line'); ?></h2>
	<?php echo $this->element('Users.Users/timeline', Array('socials' => $timeLine)); ?>
</div>
<?php echo $this->element('Users.Users/sidebar'); ?>