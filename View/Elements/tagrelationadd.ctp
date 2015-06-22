<?php echo $this->Form->create("Tag",array('action' =>'tagSRAdd')); ?>
	<?php echo $this->Form->input('userid', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => AuthComponent::user("id")//['userselected']
	));

	echo $this->AutoCompleteNoHidden->input(
			'tag',
			array(
					'autoCompletesUrl'=>$this->Html->url(
							array(
									'controller'=>'tagusers',
									'action'=>'auto_complete',
							)
					),
					'autoCompleteRequestItem'=>'autoCompleteText',
			)
	);
	echo $this->Form->hidden('tag',array('value' => '','class' => 'tag_id','id' => 'tag'));
	?>
	<?php echo $this->Form->hidden('LTo', array('value'=>$ToID)); ?>
<?php echo $this->Form->end('tag'); ?>