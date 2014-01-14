<div class="links view">
<h2><?php echo __('Link'); ?></h2>
	<dl>
		<dt><?php echo __('A To  L To'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['ATo_LTo']['name'], array('controller' => 'articles', 'action' => 'view', $link['ATo_LTo']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LFrom'); ?></dt>
		<dd>
			<?php echo h($link['Link']['LFrom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LTo'); ?></dt>
		<dd>
			<?php echo h($link['Link']['LTo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quant'); ?></dt>
		<dd>
			<?php echo h($link['Link']['quant']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($link['Link']['owner_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($link['Link']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($link['Link']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Link'), array('action' => 'edit', $link['Link']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Link'), array('action' => 'delete', $link['Link']['ID']), null, __('Are you sure you want to delete # %s?', $link['Link']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New A To  L To'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
