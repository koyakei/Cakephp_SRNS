<div class="tags index">
	<h2><?php echo __('Articles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
			<!--<?php foreach ($taghash as $key => $tagValue); ?>
			<th><?php echo $this->Html->link(__('Edit'), array('controller' => 'tags','action' => 'edit', $tagValue[1])); ?></a><br>owner<?php $tagValue[3] ?></th>
			<th></th>
			<?php endforeach; ?>-->
	</tr>
	<?php foreach ($results  as $result): ?>
	<tr>
		<td><?php echo h($result['article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($result['article']['name']); ?>&nbsp;</td>
		<td><?php echo h($result['article']['owner_id']); ?>&nbsp;</td
		<td><?php echo h($result['article']['created']); ?>&nbsp;</td>
		<td><?php echo h($result['article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller' => 'articles','action' => 'view', $result['article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller' => 'articles','action' => 'articleedit', $result['article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'articles','action' => 'articledelete', $result['article']['ID']), null, __('Are you sure you want to delete # %s?', $result['article']['ID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?></li>
	</ul>
</div>
