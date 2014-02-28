<!DOCTYPE html>
<html>
<head>
<?php //$this->Html->loadConfig('html5_tags'); ?>
<script type="text/javascript">
$(document).ready(function()
    {
        $("#myTable").tablesorter();
    }
);
</script>
</head>
<body>
<?php echo $this->element('contentsidebar', Array('keylist' => $upperIdeas,'idre'=>$idre,'firstModel' => 'Tag','data' => $tag)); ?>
<div class="tags view">
<h2><?php echo __('Tag'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Max quant'); ?></dt>
		<dd>
<?php echo $this->Form->create('Tag'//,array('controller' => 'tags','action'=>'quant')
); ?>
			<?php echo $this->Form->input('Tag.max_quant',array('default'=>$tag['Tag']['max_quant'])); ?>
<?php echo $this->Form->hidden('Tag.ID', array('value'=>$tag['Tag']['ID'])); ?>
<?php echo $this->Form->end('change max quant'); ?>
			&nbsp;
		</dd>
		<?php foreach ($headresults as $headtaghash): ?>
			<dt><?php echo __('Searchtagname'); ?></dt>
		        <dd>
		                <?php 
		                 echo $this->Html->link(__($headtaghash['Tag']['name']), array('controller'=> 'tags','action' => 'view', $headtaghash['Tag']['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
	</dl>
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $tag['Tag']['ID'],'currentUserID' => $currentUserID)); ?>
<?php if($idre == 2184){ ?>
<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links', 'action' => 'singlelink'))); ?>
	<?php
		echo $this->Form->input('LTo');
	?>
	<?php
		echo $this->Form->hidden('LFrom',array('value' => $this->request['pass'][0]));
	?>
<?php echo $this->Form->end(__('Single link')); ?>
<?php } ?>
</div>

<?php echo $this->element('contentssidebar', Array('keylist' => $keylist,'idre'=>$idre,'firstModel' => 'Tag','data' => $tag,'idre'=>$idre,'trikeyID', $trikeyID)); ?>
	<table id="myTable" cellpadding="0" cellspacing="0">
		<?php echo $this->element('tablehead', Array('taghashes'=>$taghashes)); ?>
		<tbody>
		<?php echo $this->element('tablebody', Array('results' => $articleresults,'taghashes'=>$taghashes,'firstModel' => 'Article','currentUserID' => $currentUserID)); ?>
		<?php echo $this->element('tablebody', Array('results' => $tagresults,'taghashes'=>$taghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID)); ?>
		</tbody>
	</table>
		<?php echo $this->element('Input', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Article','currentUserID' => $currentUserID)); ?>
		<?php echo $this->element('Input', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Tag','currentUserID' => $currentUserID)); ?>
</body>
</html>