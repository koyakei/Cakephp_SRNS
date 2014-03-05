<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>$this->action)); ?>
	<?php echo $this->Form->input('Tag.name'); ?>
	<?php echo $this->Form->input('userid', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']  
	)); ?>
	<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
	<?php echo $this->Form->hidden('Link.LTo', array('value'=>$ToID)); ?>
	<?php echo $this->Form->hidden('tagRadd.add', array('value'=>true)); ?>
<?php echo $this->Form->end('tag'); ?>