<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagRadd')); ?>
							<?php echo $this->Form->input('Tag.name'); ?>
							<?php echo $this->Form->input('userid', array(
							    'type' => 'select',
							    'multiple'=> false,
							    'options' => $ulist
							//  'selected' => $selected  // �E�K�E��E�l�E�́Avalue�E��E�z�E��E�ɂ��E��E��E��E��E��E�
							)); ?>
							<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
							<?php echo $this->Form->hidden('Link.LTo', array('value'=>$ToID)); ?>
						<?php echo $this->Form->end('tag'); ?>