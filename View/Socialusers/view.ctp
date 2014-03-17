<div class="socialusers view">
<h2><?php echo __('Socialuser'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($socialuser['User']['id'], array('controller' => 'users', 'action' => 'view', $socialuser['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ctrl'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['ctrl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('View'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['view']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Id'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['page_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['plugin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vplugin'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['vplugin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vaction'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['vaction']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vview'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['vview']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vctrl'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['vctrl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($socialuser['Socialuser']['username']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Socialuser'), array('action' => 'edit', $socialuser['Socialuser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Socialuser'), array('action' => 'delete', $socialuser['Socialuser']['id']), null, __('Are you sure you want to delete # %s?', $socialuser['Socialuser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Socialusers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Socialuser'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
