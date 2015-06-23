<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<div class="articles form">
<?php echo $this->Form->create('Article'); ?>
	<fieldset>
		<legend><?php echo __('Add Article'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	)); ?>
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
