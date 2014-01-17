<div class="tags index">
	<h2><?php echo __('Articles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th>$this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
			<?php foreach ($taghashes  as $hash): ?>
			<th><?php echo $hash['name']; ?></th>
			<?php endforeach; ?>
	</tr>
	<?php foreach ($results  as $result): ?>
	<tr>
		<td><?php echo h($result['Article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['name']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['owner_id']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['created']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller' => 'articles','action' => 'view', $result['Article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller' => 'articles','action' => 'articleedit', $result['Article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'articles','action' => 'articledelete', $result['Article']['ID']), null, __('Are you sure you want to delete # %s?', $result['Article']['ID'])); ?>
		</td>
		<?php foreach ($taghashes  as $key => $hash): ?>
			<?php $b = 0; ?>
		<?php foreach ($result['subtag']  as $subtag): ?>
		<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?>
					<td><?php echo $subtag['Tag']['name']; ?><?php echo $subtag['Link']['quant']; ?></td>
				<?php $b = 1; ?>
				<?php } ?>
			<?php endforeach; ?>
				<?php if ($b == 0){ ?>
					<td></td>
				<?php } ?>
		<?php endforeach; ?>
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
