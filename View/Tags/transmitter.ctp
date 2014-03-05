<!DOCTYPE html>
<html>
<?php //echo $this->Html->css('lr'); 
echo $this->Html->script('jquery.tablednd');
?>
<script type="text/javascript">
$(document).ready(function() {
    $(".main_table").tableDnD();
    $("#myTable").tablesorter();
});
</script>
<div class="left">
	
	<?php echo $this->element('contentssidebar', array('idre'=>$leftID,'firstModel' => 'Tag','data' => $leftheadresult,'LR' => 'left')); ?>
	
	<div class="main">
		<div class="tags view">
		<?php echo $this->element('detail',array('detail' =>  $leftheadresults,'firstModel' => 'Tag')); ?>
		</div>
		<php? debug($lefttaghashes); ?>
		<table class="main_table" id="myTable" cellpadding="0" cellspacing="0">
			<thead>
			<?php echo $this->element('tablehead', Array('taghashes'=>$lefttaghashes)); ?>
			</thead>
			<tbody>
			<?php echo $this->Form->create(false, array('controller' => 'tags','action' => 'transmitter',$leftID,$leftKeyID,$rightID,$rightKeyID)); ?>
				<?php if($leftarticleresults != null){ echo $this->element('transmittertablebody', Array('results' => $leftarticleresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Article','currentUserID' => $currentUserID,'LR' => "left",'idre'=>$leftID)); } ?>
				<?php if($lefttagresults != null){ echo $this->element('transmittertablebody', Array('results' => $lefttagresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID,'LR' => "left",'idre'=>$leftID));  } ?>
			<?php echo $this->Form->end('transmit'); ?>
			</tbody>
		</table>
	</div>
	<div class="bottom_box">
		<?php echo $this->Form->create('Tag', array('action' => 'transmitter',false,false,$rightID,$rightKeyID)); ?>
			<?php echo $this->element('searchbox',array('lr' => 'left')); ?>
		<?php echo $this->Form->end('検索'); ?>
	</div>
</div>
<div class="right">
	<?php echo $this->element('contentssidebar', array('idre'=>$rightID,'firstModel' => 'Tag','data' => $rightheadresult,'LR' => 'right')); ?>
	
	<div class="main">
		<div class="tags view">
		<?php echo $this->element('detail',array('detail' =>  $rightheadresults,'firstModel' => 'Tag')); ?>
		</div>
		<php? debug($righttaghashes); ?>
		<table class="main_table" id="myTable" cellpadding="0" cellspacing="0">
			<thead>
			<?php echo $this->element('tablehead', Array('taghashes'=>$righttaghashes)); ?>
			</thead>
			<tbody>
			<?php echo $this->Form->create(false, array('controller' => 'tags','action' => 'transmitter',$rightID,$rightKeyID,$rightID,$rightKeyID)); ?>
				<?php if($rightarticleresults != null){ echo $this->element('transmittertablebody', Array('results' => $rightarticleresults,'taghashes'=>$righttaghashes,'firstModel' => 'Article','currentUserID' => $currentUserID,'LR' => "right",'idre'=>$rightID)); } ?>
				<?php if($righttagresults != null){ echo $this->element('transmittertablebody', Array('results' => $righttagresults,'taghashes'=>$righttaghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID,'LR' => "right",'idre'=>$rightID));  } ?>
			<?php echo $this->Form->end('transmit'); ?>
			</tbody>
		</table>
	</div>
	<div class="bottom_box">
		<?php echo $this->Form->create('Tag', array('action' => 'transmitter',$leftID,$leftKeyID,false,false)); ?>
			<?php echo $this->element('searchbox',array('lr' => 'right')); ?>
		<?php echo $this->Form->end('検索'); ?>
	</div>
</div>
</html>