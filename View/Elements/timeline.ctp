<table>
		<thead>
			<th><?php echo $this->Paginator->sort('created'); ?>
			</th>
			<th>link
			</th>
		</thead>
		<tbody>
			<?php foreach ($socials as $social): ?>
			<tr>
				<td><?php echo h($social['Social']['created']); ?>&nbsp
				</td>
				<td><?php echo $this->Html->link(($social['User']['username']), array('plugin' =>$social['Social']['vplugin'],'controller' => $social['Social']['vctrl'], 'action' => $social['Social']['vaction'], $social['Social']['page_id'])); ?></td>
				
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>