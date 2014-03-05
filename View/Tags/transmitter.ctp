<!DOCTYPE html>
<html>
<?php //echo $this->Html->css('lr'); 
//echo $this->Html->css('dd'); 
//echo $this->Html->script('jquery.tablednd');
echo $this->Html->script('header');
echo $this->Html->script('redips-drag-source');
echo $this->Html->script('redips-drag-min');
echo $this->Html->script('ddscript');

?>
<div id="drag">
<div class="left">
	
	<?php echo $this->element('contentssidebar', array('idre'=>$leftID,'firstModel' => 'Tag','data' => $leftheadresult,'lr' => 'left','trikeyID' => $leftKeyID,'rightID' => $rightID ,'rightKeyID' => $rightKeyID,'leftID' => $leftID,'leftKeyID' => $leftKeyID)); ?>
	<div class="main">
		<div class="tags view">
		<?php echo $this->element('detail',array('detail' =>  $leftheadresults,'firstModel' => 'Tag')); ?>
		</div>
		<?php echo $this->Form->create(false,array('url' => array('controller' => 'tags','action' => 'transmitter',$leftID,$leftKeyID,$rightID,$rightKeyID))); ?><?php echo $this->Form->end('transmit'); ?>
		<table class="main_table" id="tbl1" cellpadding="0" cellspacing="0">
			<thead>
			<?php echo $this->element('tablehead', Array('taghashes'=>$lefttaghashes)); ?>
			</thead>
			<tbody>
			
				<?php if($leftarticleresults != null){ echo $this->element('transmittertablebody', Array('results' => $leftarticleresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Article','currentUserID' => $currentUserID,'LR' => "left",'idre'=>$leftID)); } ?>
				<?php if($lefttagresults != null){ echo $this->element('transmittertablebody', Array('results' => $lefttagresults,'taghashes'=>$lefttaghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID,'LR' => "left",'idre'=>$leftID));  } ?>
			<?php echo $this->Form->end('transmit'); ?>

					<tr>
						<td colspan="6" class="mark"><span id="msg">Message line</span></td>
					</tr>
			</tbody>
		</table>
	</div>
	<div class="bottom_box">
	<?php echo $this->Form->create('Tag', array('url'=> array('action' => 'transmitter',0,0,$rightID,$rightKeyID))); ?>
			<?php echo $this->element('searchbox',array('lr' => 'left')); ?>
			<?php echo $this->Form->hidden('lr',array('value' => "left")); ?>
		<?php echo $this->Form->end('検索'); ?>
	</div>
</div>
<div class="right">
	<?php echo $this->element('contentssidebar', array('idre'=>$rightID,'firstModel' => 'Tag','data' => $rightheadresult,'lr' => 'right','rightID' => $rightID ,'rightKeyID' => $rightKeyID,'leftID' => $leftID,'leftKeyID' => $leftKeyID,'trikeyID' => $rightKeyID)); ?>
	
	<div class="main">
		<div class="tags view">
		<?php echo $this->element('detail',array('detail' =>  $rightheadresults,'firstModel' => 'Tag')); ?>
		</div>
		<?php echo $this->Form->create(false, array('url' =>  array('controller' => 'tags','action' => 'transmitter',$rightID,$rightKeyID,$rightID,$rightKeyID))); ?>
		
			<?php echo $this->Form->end('transmit'); ?>
		<table class="main_table" id="tbl2" cellpadding="0" cellspacing="0">
			<thead>
			<?php echo $this->element('tablehead', Array('taghashes'=>$righttaghashes)); ?>
			</thead>
			<tbody>
			
				<?php if($rightarticleresults != null){ echo $this->element('transmittertablebody', Array('results' => $rightarticleresults,'taghashes'=>$righttaghashes,'firstModel' => 'Article','currentUserID' => $currentUserID,'LR' => "right",'idre'=>$rightID)); } ?>
				<?php if($righttagresults != null){ echo $this->element('transmittertablebody', Array('results' => $righttagresults,'taghashes'=>$righttaghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID,'LR' => "right",'idre'=>$rightID));  } ?>
			</tbody>
		</table>
	</div>
	<div class="bottom_box">
		<?php echo $this->Form->create('Tag', array('url' => array('action' => 'transmitter',$leftID,$leftKeyID,false,false))); ?>
			<?php echo $this->element('searchbox',array('lr' => 'right')); ?>
			<?php echo $this->Form->hidden('lr',array('value' => "right")); ?>
		<?php echo $this->Form->end('検索'); ?>
	</div>
</div>
<table>
				<colgroup>
					<col width="100"/>
				</colgroup>
				<tbody>
					<tr>
						<td class="trash">Trash</td>
					</tr>
				</tbody>
			</table>
	
			<div><input type="radio" name="rowDropMode" class="checkbox" onclick="redips.setRowMode(this)" value="after" title="It has effect only when row is dropped to other table"/><span class="messageLine">After - drop row after highlighted row (when row is dropped to other table)</span></div>
			<div><input type="radio" name="rowDropMode" class="checkbox" onclick="redips.setRowMode(this)" value="switch" title="Switch source and current row"/><span class="messageLine">Switch - switch source row and highlighted row</span></div>
			<div><input type="radio" name="rowDropMode" class="checkbox" onclick="redips.setRowMode(this)" value="overwrite" title="Overwrite current row"/><span class="messageLine">Overwrite - highlighted row will be overwritten</span></div>
			<div class="inst">
			DIV elements and table rows can be cloned with SHIFT key</div>
		</div>
</html>