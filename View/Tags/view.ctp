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
$(function () {
    $('input#search').quicksearch('table#myTable tbody tr', {
    'delay':300,
    'selector':'th',
    'stripeRows':['odd','even'],
    'loader':'span.loading',
    'bind':'keyup click',
    'show':function () {
        this.style.color = '';
    },
    'hide': function () {
        this.style.color = '#ccc';
    },
    'prepareQuery': function (val) {
        return new RegExp(val, "i");
    },
    'testQuery': function (query, txt, _row) {
        return query.test(txt);
    }
    });
    });
</script>
</head>
<body>
<?php echo $this->element('upperIdea', Array('ulist' => $upperIdeas,'idre'=>$idre)); ?>
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
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $tag['Tag']['ID'])); ?>
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

<div class="actions">
<?php echo $this->Form->create('keyid'); ?>
			<?php echo $this->Form->input('keyid', array(
			'type' => 'select',
			'multiple'=> false,
			'options' => $keylist,
			'selected' => $_SESSION['selected']//$this->Session->read('selected')  // ・ｽK・ｽ・ｽl・ｽﾍ、value・ｽ・ｽz・ｽ・ｽﾉゑｿｽ・ｽ・ｽ・ｽ・ｽ・ｽ・ｽ
			)); ?>
			<?php echo $this->Form->end(__('keyselect')); ?>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['ID']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
		<li><?php //echo $this->Html->link(__('test'), array('action' => 'test')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('action' => 'search')); ?> </li>
		<li><?php echo $this->Html->link(__('test'), array('action' => 'test')); ?> </li>
	</ul>
</div>
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