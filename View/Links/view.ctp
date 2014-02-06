<head>
<?php $this->Html->loadConfig('html5_tags'); ?>
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
<div class="links view">
<h2><?php echo __('Link'); ?></h2>
<?php debug($link); ?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['Link']['ID'], array('controller' => 'articles', 'action' => 'view', $link['Link']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LFrom'); ?></dt>
		<dd>
			<?php echo h($link['Link']['LFrom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LTo'); ?></dt>
		<dd>
			<?php echo h($link['Link']['LTo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quant'); ?></dt>
		<dd>
			<?php echo h($link['Link']['quant']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($link['Link']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($link['Link']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($link['Link']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
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
		<li><?php echo $this->Html->link(__('Edit Link'), array('action' => 'edit', $link['Link']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Link'), array('action' => 'delete', $link['Link']['ID']), null, __('Are you sure you want to delete # %s?', $link['Link']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New A To  L To'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
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