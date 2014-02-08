<!DOCTYPE html>
<html>
<head>
<?php //$this->Html->loadConfig('html5_tags'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.13.3/jquery.tablesorter.min.js"></script>
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
		<?php foreach ($headresults as $headtaghash): ?>
			<dt><?php echo __('Searchtagname'); ?></dt>
		        <dd>
		                <?php 
		                 echo $this->Html->link(__($headtaghash['Tag']['name']), array('controller'=> 'tags','action' => 'view', $headtaghash['Tag']['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
	</dl>
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $tag['Tag']['ID'])); ?>
<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links', 'action' => 'singlelink'))); ?>
	<?php
		echo $this->Form->input('LTo');
	?>
	<?php
		echo $this->Form->hidden('LFrom',array('value' => $this->request['pass'][0]));
	?>

<?php echo $this->Form->end(__('Single link')); ?>
</div>

<div class="actions">
<?php echo $this->Form->create('keyid'); ?>
			<?php echo $this->Form->input('keyid', array(
			'type' => 'select',
			'multiple'=> false,
			'options' => $keylist,
			'selected' => $_SESSION['selected']//$this->Session->read('selected')  // �K��l�́Avalue��z��ɂ�������
			)); ?>
			<?php echo $this->Form->end(__('keyselect')); ?>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['ID']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('action' => 'search')); ?> </li>
	</ul>
</div>
<table id="myTable" cellpadding="0" cellspacing="0">
		<?php echo $this->element('tablehead', Array('taghashes'=>$taghashes)); ?>
		<tbody>
		<?php echo $this->element('tablebody', Array('results' => $articleresults,'taghashes'=>$taghashes,'firstModel' => 'Article')); ?>
		<?php echo $this->element('tablebody', Array('results' => $tagresults,'taghashes'=>$taghashes,'firstModel' => 'Tag')); ?>
		</tbody>
	</table>



		<?php echo $this->element('Input', Array('keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Article')); ?>
		<?php echo $this->element('Input', Array('keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Tag')); ?>
</body>
</html>