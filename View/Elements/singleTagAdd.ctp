<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagRadd')); ?>
							<?php echo $this->Form->input('Tag.name'); ?>
							<?php echo $this->Form->input('userid', array(
							    'type' => 'select',
							    'multiple'=> false,
							    'options' => $ulist
							//  'selected' => $selected  //
							)); ?>
							<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
							<?php echo $this->Form->hidden('Link.LTo', array('value'=>$targetID)); ?>
						<?php echo $this->Form->end('tag'); ?>