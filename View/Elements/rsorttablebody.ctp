
<?php foreach ($results  as $result): ?>
<?php if($firstModel == 'Tag'){$userCallAssosiation = 'O';} else {$userCallAssosiation = 'O';} // アソシエーションの名前を一緒にしたが後で別にするかも?>
<div id="draggble">
				<tr>
					<td <?php if($result[$firstModel]['srns_code_member']): ?>  bgcolor=green <?php endif; ?> > <?php echo h($result[$firstModel]['ID']); ?>&nbsp;</td>
					<td>
					<?php if(!is_null($leaf)){ echo "<b>"; } ?>
					<?php echo $this->element('URL', Array('result' => $result,'firstModel' =>$firstModel)); ?>
					<?php if(!is_null($leaf)){ echo "</b>"; } ?>
						<?php echo $this->Form->hidden($firstModel.'.ID', array('value'=>$result[$firstModel]['ID'])); ?>
						<div onClick='toggleShow(this);' >
						tagged
						</div>
						<div id='HSfield' style='display: none;'>
							<?php foreach ($result['no_sort_subtag'] as $taghash): ?>
								<?php if($taghash !== $sorting_tag): ?>
									<?php echo $this->Html->link($taghash['name'],
										 array('controller'=> "tags",'action' => 'view', $taghash['ID'])); ?>
									<?php echo $taghash['Link']['quant'] + ":" + $taghash['Tag']['namename']; ?>
									<br>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						</td>

					<td class="actions">
					<?php echo h($result[$userCallAssosiation]['username']); ?>&nbsp;
						<div onClick='toggleShow(this);' >
						Action
						</div>
						<div id='HSfield' style='display: none;'>
						<?php echo $this->Html->link(__('View'), array('controller'=> $firstModel."s",'action' => 'view', $result[$firstModel]['ID'])); ?><br>
						<?php echo $this->Html->link(__('Edit'), array('controller'=> $firstModel."s",'action' => 'edit', $result[$firstModel]['ID'])); ?><br>

						 <?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'Links','action' => 'delete', $result['Link']['ID']), null, __('Are you sure you want to delete # %s?', $result[$firstModel]['ID']));
						  ?></div>
					</td>
					<td><div onClick='toggleShow(this);' >
						Tag add
						</div>
						<div id='HSfield' style='display: none;'>
						<?php if ($idre != null) {
							$ToID =$result[$firstModel]['ID'];
							echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $ToID,'currentUserID' => $currentUserID));
						}

						 ?></div></td>

						<?php if ($taghashes != null) {
							foreach ($taghashes as $key => $hash): ?>
						<?php $b = 0; ?>
							<?php if($result['subtag'] != null) { ?>
								<?php foreach ($result['subtag'] as $subtag): ?>
									<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?>
										<td><?php echo $subtag['Link']['quant']; ?></td>
										<td>
										<div onClick='toggleShow(this);' >
						Quant
						</div>
						<div id='HSfield' style='display: none;'>
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
									</div>
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