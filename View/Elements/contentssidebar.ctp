<div class="actions">
<?php if ($firstModel == 'Tag'){ ?>
<script>
window.onload=function(){


	var f=document.getElementById("keyid");
	checkSelect(f.elements["keyid1"],"<?php echo $trikeyID; ?>");
}
function checkSelect(obj,val){
	for(var i=0;i<obj.length;i++){
		var objval =obj[i].id;
		var objval2 =val;
		if(obj[i].id==val){
		obj[i].selected=true;
		break;
		}
	}
}
</script>

<form id="keyid">
<select name ="keyid1" onChange="location.href=value">

<?php foreach($keylist as $key => $value){ ?>
<?php if ($this->action == 'transmitter') { ?>
<?php if ($lr == "left") { ?>
<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/transmitter/".$leftID."/".$key."/".$rightID."/".$rightKeyID; ?>"
>	
<?php } else { ?>
<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/transmitter/".$leftID."/".$leftKeyID."/".$rightID."/".$key; ?>"
>
<?php } ?>
<?php } else { ?>
<option id="<?php echo $key ?>" value="<?php echo "/cakephp/tags/view/".$idre."/".$key; ?>"
>
<?php } ?>
<?php echo $value; ?></option>
<?php } ?>
</select>
</form>

<?php } ?>
	<ul>
	<?php if($idre != null){ ?>
		<li><?php echo $this->Html->link(__('Edit' .$firstModel), array('controller' => 'tags','action' => 'edit', $data[$firstModel]['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'. $firstModel), array('controller' => 'tags','action' => 'delete',$data[$firstModel]['ID']), null, __('Are you sure you want to delete # %s?', $data[$firstModel]['ID'])); ?> </li>
	<?php } ?>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('controller' => 'tags','action' => 'search')); ?> </li>
		<li><?php echo $this->Html->link(__('List Article'), array('controller' => 'articles','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Transmitter'), array('controller' => 'tags','action' => 'transmitter')); ?> </li>
		
	</ul>
</div>
