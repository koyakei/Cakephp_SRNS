<?php if ($leftID == null) {
	$leftID = 0;
}
if ($leftKeyID == null) {
	$leftKeyID = 0;
} ?>
<?php foreach ($results  as $result): ?>
<?php if($firstModel == 'Tag'){$userCallAssosiation = 'TO';} else {$userCallAssosiation = 'AO';}?>
<div id="draggble">
				<tr>
					<td class="rowhandler"><div class="drag row">
						<?php echo h($result[$firstModel]['ID']); ?></div></td>
					<td><?php if($LR == "left"){ echo $this->Html->link($result[$firstModel]['name'], array('controller' => $firstModel."s", 'action' => 'transmitter', $result[$firstModel]['ID'],$leftKeyID,$rightID,$rightKeyID)); } else {
						echo $this->Html->link($result[$firstModel]['name'], array('controller' => $firstModel."s", 'action' => 'transmitter', $leftID,$leftKeyID,$result[$firstModel]['ID'],$rightKeyID));
						
					}

					 	?>
						<?php echo $this->Form->hidden($firstModel.'.ID', array('value'=>$result[$firstModel]['ID'])); ?></td>
					<td><?php echo h($result[$userCallAssosiation]['username']); ?>&nbsp;</td>
					<td><?php echo h($result[$firstModel]['created']); ?>&nbsp;</td>
					<td><?php echo h($result[$firstModel]['modified']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('controller'=> $firstModel."s",'action' => 'edit', $result[$firstModel]['ID'])); ?>
						<?php 
						if ($result['Link']['ID'] =! null) {
						 echo $this->Form->postLink(__('Delete'), array('controller'=> 'Links','action' => 'delete', $result['Link']['ID']), null, __('Are you sure you want to delete # %s?', $result[$firstModel]['ID'])); 

						
						} ?>
					</td>
					<td>
						<?php if ($idre != null) {$ToID =$result[$firstModel]['ID']; echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $ToID,'currentUserID' => $currentUserID));
						}
						 ?></td>

						<?php if ($taghashes != null) {
							foreach ($taghashes as $key => $hash): ?>
						<?php $b = 0; ?>
							<?php if($result['subtag'] != null) { ?>
								<?php foreach ($result['subtag'] as $subtag): ?>
									<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?>
										<td><?php echo $subtag['Link']['quant']; ?></td>
										<td>
										
										<?php echo $this->Form->create('tag'); ?>
										<?php echo $this->Form->input('Link.quant',array('default'=>$subtag['Link']['quant'])); ?>
										<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
										<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
										<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
										<?php echo $this->Form->end('change quant'); ?>
										<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagdel')); ?>
										<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
										<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
											<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
										<?php echo $this->Form->end('del'); ?>
										</td>
										<?php $b = 1; ?>
									<?php } ?>
								<?php endforeach; ?>
							<?php } ?>
							<?php if ($b == 0){ ?>
							<td></td><td></td>
						<?php } ?>
					<?php endforeach; }?>
				</tr>
			</div>
			<?php endforeach; ?>