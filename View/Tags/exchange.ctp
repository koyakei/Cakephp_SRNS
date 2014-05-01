<html>
<head>
</head>
<body>
<?php echo $this->element('contentsidebar', Array('idre'=>$idre,'firstModel' => 'Tag','data' => $headresults,'key' => $trikeyID)); ?>
<div class="tags view">
<h2><?php echo __('Tag');  ?></h2>
<dl>
		<?php echo $this->element('detail',array('detail' =>  $headresults,'firstModel' => 'Tag')); ?>
		<dt>My auth</dt>
		<dd><?php echo $myauthresult['Tagauthcount']['quant'];?></dd>
</dl>
<?php echo $this->Form->create('Tagauth'); ?>
	<fieldset>
		<legend><?php echo __('exchange Tagauth'); ?></legend>
	<?php
		echo $this->Form->input('quant');
		echo $this->Form->input('username');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
<table class="table">
            <h2><?php echo __('Tagauths'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('quant'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tagauths as $tagauth): ?>
	<tr>
		<td><?php echo h($tagauth['Tagauth']['id']); ?>&nbsp;</td>
		<td><?php echo h($tagauth['Tagauth']['quant']); ?>&nbsp;</td>
		<td><?php echo h($tagauth['Tagauth']['modified']); ?>&nbsp;</td>
		<td><?php echo h($tagauth['Tagauth']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tagauth['Tagauth']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tagauth['Tagauth']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tagauth['Tagauth']['id']), null, __('Are you sure you want to delete # %s?', $tagauth['Tagauth']['id'])); ?>
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
</div>
</body>
</html>