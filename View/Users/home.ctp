<div class="users form">
	<?php echo $this->Form->create('User',array('action'=>'search'));?>
	<?php
		echo $this->Form->input('username',array('type'=>'text','id'=>'username','label'=>'Search'));
	?>
	<?php echo $this->Form->end(__('Submit', true));?>
</div>
