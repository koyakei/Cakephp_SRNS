<div class="socials view">
<h2><?php echo __('Social'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($social['Social']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($social['User']['ID'], array('controller' => 'users', 'action' => 'view', $social['User']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ctrl'); ?></dt>
		<dd>
			<?php echo h($social['Social']['ctrl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('View'); ?></dt>
		<dd>
			<?php echo h($social['Social']['view']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Id'); ?></dt>
		<dd>
			<?php echo h($social['Social']['page_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Social'), array('action' => 'edit', $social['Social']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Social'), array('action' => 'delete', $social['Social']['ID']), null, __('Are you sure you want to delete # %s?', $social['Social']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Socials'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Social'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
