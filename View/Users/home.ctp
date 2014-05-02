//file:app/views/users/home.ctp
<div class="users form">
	<?php echo $this->Form->create('User',array('action'=>'search'));?>
	<?php
		echo $this->Form->input('username',array('type'=>'text','id'=>'username','label'=>'Search'));
	?>
	<?php echo $this->Form->end(__('Submit', true));?>
</div>
<p><a href="http://blogfreakz.com/">Read & Download on Blogfreakz</a></p>