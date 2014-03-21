<?php if ($leftID == null) {
	$leftID = 0;
}
if ($leftKeyID == null) {
	$leftKeyID = 0;
} ?>
<div id="draggble">
 <?php foreach ($results  as $result): ?>
<?php if($firstModel == 'Tag'){$userCallAssosiation = 'TO';} else {$userCallAssosiation = 'AO';}?>

				<tr>
						
					<td class="rowhandler"><div class="drag row">
						<?php echo h($result[$firstModel]['ID']); ?></div><br>
					<?php echo $this->Form->hidden('to.'.$firstModel.'.'.'.ID', array('value'=>$result[$firstModel]['ID'])); ?></td>
					<td ><?php if($LR == "left"){ echo $this->Html->link($result[$firstModel]['name'], array('controller' => "tags", 'action' => 'transmitter', $result[$firstModel]['ID'],$leftKeyID,$rightID,$rightKeyID)); } else {
						echo $this->Html->link($result[$firstModel]['name'], array('controller' => "tags", 'action' => 'transmitter', $leftID,$leftKeyID,$result[$firstModel]['ID'],$rightKeyID));
						
					}

					 	?></td>
					<td><?php echo h($result[$userCallAssosiation]['username']); ?>&nbsp;</td>
					<td><?php echo h($result[$firstModel]['created']); ?>&nbsp;</td>
					<td><?php echo h($result[$firstModel]['modified']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller'=> $firstModel."s",'action' => 'view', $result["$firstModel"]['ID'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'links','action' => 'delete', $result['Link']['ID']), null, __('Are you sure you want to delete # %s?', $result['Link']['ID'])); ?>
					</td>
					
				</tr>
			
			<?php endforeach; ?>
			</div>