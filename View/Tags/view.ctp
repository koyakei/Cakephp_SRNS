<div class="tags view">
<h2><?php echo __('Tag'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($results  as $result): ?>
	<tr>
		<td><?php echo h($result['Article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['name']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['user_id']); ?>&nbsp;</td
		<td><?php echo h($result['Article']['created']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller'=> 'articles','action' => 'view', $result['Article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller'=> 'articles','action' => 'edit', $result['Article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'articles','action' => 'delete', $result['Article']['ID']), null, __('Are you sure you want to delete # %s?', $result['Article']['ID'])); ?>
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
	<?php echo $this->Form->create('Article'); ?>
	<fieldset>
		<legend><?php echo __('Reply'); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('name');
		//echo $this->Form->hidden('id', array('value'=> $targetid));
		//echo $this->Form->hidden('replyarticleadd', array('value'=> true));
		debug($this->params['pass'][0]);
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['ID']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
	</ul>
</div>
