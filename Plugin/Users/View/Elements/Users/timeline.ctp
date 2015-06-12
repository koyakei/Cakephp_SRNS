
	<h2><?php echo __('Follows'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($socials as $socialuser): ?>
	<tr>
		<td><?php echo $this->Html->link($socialuser['Socialuser']['created'], array('plugin' => null ,'controller' => $socialuser['Socialuser']['vctrl'],
				 'action' => $socialuser['Socialuser']['vaction'], $socialuser['Socialuser']['vpage_id'],
				$socialuser['Socialuser']["page_id"]));
 //pageID で　$(".my_table") の中をネストしていって、その　tr だけ　color="red"にでも塗りつぶすか。クリックしたら色が普通に戻るとかでもいい。

		?>&nbsp;</td>
		<td><?php echo h($socialuser['Socialuser']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'vview', $socialuser['Socialuser']['ID'])); ?>
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
