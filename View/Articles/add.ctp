zz<div class="articles form">
<?php echo $this->Form->create('Article'); ?>
	<fieldset>
		<legend><?php echo __('Add Article'); ?></legend>
	<?php
		echo $this->Form->input('name',array("na-model" => "name",));
	?>

<?php echo $this->Form->input('user_id', array("na-model" => "user_id",
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	));
echo $this->Form->input('auth',array("na-model" => "auth",
			'type' => 'select',
			'options' => array( 0 => 'public',1 => 'private'),
			'selected' => 1));
?>


	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Articles'),
		 array('action' => 'index',"sort:modified","direction:desc")); ?></li>
	</ul>
</div>
