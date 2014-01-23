<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($article['Article']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($article['Article']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($article['Article']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($article['Article']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($article['Article']['modified']); ?>
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
	<?php debug($results);foreach ($results  as $result): ?>
	<tr>
		<td><?php echo h($result['Article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['name']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['user_id']); ?>&nbsp;</td
		<td><?php echo h($result['Article']['created']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $result['Article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $result['Article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $result['Article']['ID']), null, __('Are you sure you want to delete # %s?', $result['Article']['ID'])); ?>
		</td>
		<td>
			<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagRadd')); ?>
				<?php echo $this->Form->input('Tag.name'); ?>
				<?php echo $this->Form->input('userid', array( 
    'type' => 'select', 
    'multiple'=> false,
    'options' => $ulist
//  'selected' => $selected  // ‹K’è’l‚ÍAvalue‚ð”z—ñ‚É‚µ‚½‚à‚Ì
)); ?>
				<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
				<?php echo $this->Form->hidden('Link.LTo', array('value'=>$result['Article']['ID'])); ?>
			<?php echo $this->Form->end('tag'); ?>

		<?php foreach ($taghashes as $key => $hash): ?>
			<?php $b = 0; ?>
		
			<?php if($result['subtag'] != null) { ?>
				<?php foreach ($result['subtag'] as $subtag): ?>
					<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?>
						<td><?php echo $subtag['Link']['quant']; ?></td>
						<td>
						<!--<?php echo $subtag['Tag']['name']; ?>-->
						<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'quant')); ?>
							<?php echo $this->Form->input('Link.quant',array('default'=>$subtag['Link']['quant'])); ?>
							<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
						<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
						<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
						<?php echo $this->Form->end('tag'); ?>
						<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagdel')); ?>
							<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
							<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
							<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
						<?php echo $this->Form->end('tag'); ?>
						</td>
						</td>
						<?php $b = 1; ?>
					<?php } ?>
				<?php endforeach; ?>
			<?php } ?>
			<?php if ($b == 0){ ?>
				<td></td><td></td>
			<?php } ?>
		<?php endforeach; ?>
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
		echo $this->Form->input('name');
		//echo $this->Form->hidden('id', array('value'=>'$this->params['pass'][0]'));
		debug($this->params['pass'][0]);
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>


	</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Article'), array('action' => 'edit', $article['Article']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Article'), array('action' => 'delete', $article['Article']['ID']), null, __('Are you sure you want to delete # %s?', $article['Article']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('action' => 'add')); ?> </li>
	</ul>
</div>
