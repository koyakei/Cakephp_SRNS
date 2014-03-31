<div class="actions"  style ="width: 115px;">
<?php if ($firstModel == 'Tag'): ?>
	<?php foreach($keylist as $key => $value): ?>
<a href="#<?php echo $value ?>"><?php echo $value ?></a>
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

<?php endif; ?>
	<ul>
	<?php if($idre != null): ?>
		<li><?php echo $this->Html->link(__('Edit' .$firstModel), array('controller' => 'tags','action' => 'edit', $data[$firstModel]['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'. $firstModel), array('controller' => 'tags','action' => 'delete',$data[$firstModel]['ID']), null, __('Are you sure you want to delete # %s?', $data[$firstModel]['ID'])); ?> </li>
	<?php endif; ?>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('controller' => 'tags','action' => 'search')); ?> </li>
		<li><?php echo $this->Html->link(__('List Article'), array('controller' => 'articles','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Transmitter'), array('controller' => 'tags','action' => 'transmitter')); ?> </li>
		
	</ul>
</div>
