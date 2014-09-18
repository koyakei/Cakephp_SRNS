<div class="actions"  style ="width: 115px;">

	<h2><?php foreach($keylist as $key => $value): ?></h2>
	<br>
<a href="#<?php echo $key ?>"><?php echo $value ?></a>
	<?php endforeach; ?>
	<form id="keyid<?php if ($this->action == 'transmitter'): ?><?php if($lr == true ){echo 1; } else { echo 0; } ?><?php endif; ?>">
	<select name ="keyid<?php if ($this->action == 'transmitter'): ?><?php if($lr == true ){echo 1; } else { echo 0; } ?><?php endif; ?>" onChange="location.href=value">
	<?php foreach($keylist as $key => $value): ?>
		<?php if ($this->action == 'transmitter'): ?>
			<?php if ($lr == ture): ?>
				<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/transmitter/".$leftID."/".$key."/".$rightID."/".$rightKeyID; ?>"
				>
			<?php  else:  ?>
				<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/transmitter/".$leftID."/".$leftKeyID."/".$rightID."/".$key; ?>"
				>

			<?php endif; ?>
		<?php else: ?>
			<!--<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/view/".$idre."/".$key; ?>"
			>-->
		<?php endif; ?>
		<?php echo $value; ?></option>
	<?php endforeach; ?>
	</select>
	</form>


	<ul>
	<?php if($idre != null): ?>
		<li><?php echo $this->Html->link(__('New user'), array('anonymous'=> false,'plugin' =>  'users','controller' => 'users','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Mind Map'), array('controller' => 'tagusers','action' => 'mapt', $idre)); ?> </li>
		<li><?php echo $this->Html->link(__('Edit ' .$firstModel), array('action' => 'edit', $idre)); ?> </li>
		<li><?php echo $this->Html->link(__('Venn diagram'), array('controller' => 'tagusers','action' => 'vennt', $idre)); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'. $firstModel), array('action' => 'delete',$idre), null, __('Are you sure you want to delete # %s?', $idre)); ?> </li>
	<?php if($firstModel == "Tag"): ?>
		<li><?php echo $this->Html->link(__('Exchange'), array('controller' => 'tags','action' => 'exchange',$idre)); ?> </li>
		<?php endif; ?>
	<?php endif; ?>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Articles'), array('controller' => 'tags','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tags'), array('controller' => 'tags','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('controller' => 'tags','action' => 'search',"sort:modified","direction:desc")); ?> </li>

		<li><?php echo $this->Html->link(__('List Article'), array('controller' => 'articles','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Transmitter'), array('controller' => 'tags','action' => 'transmitter')); ?> </li>


	</ul>
</div>
