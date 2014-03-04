<html>
<?php echo $this->Html->css('lr'); 
echo $this->Html->script('jquery.tablednd');
?>
<script type="text/javascript">
$(document).ready(function() {
    $(".main_table").tableDnD();
    $("#myTable").tablesorter();
});
</script>

<div class="left">
	<div class="main">
		<?php echo $this->element('detail',array('detail' =>  $lefttagresults,'firstModel' => 'Tag')); ?>
		<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $tag['Tag']['ID'],'currentUserID' => $currentUserID,'headresults' => $leftheadresults)); ?>
		<table id="myTable" class="main_table" cellpadding="0" cellspacing="0">
			<thead>
			<?php echo $this->element('tablehead', Array('taghashes'=>$lefttaghashes)); ?>
			</thead>
			<tbody>
			<?php echo $this->Form->create(false, array('controller' => 'tags','action' => 'transmitter',$leftID,$leftKeyID,$rightID,$rightKeyID)); ?>
				<?php if($leftarticleresults != null){ echo $this->element('transmittertablebody', Array('results' => $leftarticleresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Article','currentUserID' => $currentUserID)); } ?>
				<?php if($lefttagresults != null){ echo $this->element('transmittertablebody', Array('results' => $lefttagresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID));  } ?>
			<?php echo $this->Form->end('transmit'); ?>
			</tbody>
		</table>
	</div>
	<div class="bottom_box">
		<?php echo $this->Form->create('Tag', array('action' => 'transmitter',false,false,$rightID,$rightKeyID)); ?>
			<?php echo $this->element('searchbox'); ?>
		<?php echo $this->Form->end('検索'); ?>
	</div>
</div>
<div class="right">
</div>
</html>