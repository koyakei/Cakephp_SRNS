<html>
<head>
<?php echo $this->Html->charset("utf-8"); ?>
<?php echo $this->Html->css('cake.generic'); ?> 

<?php
$this->Html->css('http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css', null, array('block' => 'css'));
$this->Html->script(
	array('http://code.jquery.com/ui/1.9.1/jquery-ui.js',
		'http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js'),
	array('block' => 'script')
);
?>
<?php $this->start('script'); ?>
<script>
	$(function() {
		$("#PostFrom").datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			showOtherMonths: true,
			selectOtherMonths: true,
			onClose: function(s) {
				if (s) {
					$("#PostTo").datepicker("option", "minDate", s).focus();
				}
			}
		});
		$("#PostTo").datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			showOtherMonths: true,
			selectOtherMonths: true,
			onClose: function(s) {
				$("#PostFrom").datepicker("option", "maxDate", s);
			}
		});
	});
</script>
<?php $this->end(); ?>

</head>
<body>
	<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<ul>
		<li><?php echo $this->Html->link(__('test'), array('action' => 'test')); ?> </li>
			<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('article index'), array('controller' => 'articles','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('key index'), array('controller' => 'keys','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('social my follow'), array('controller' => 'socials','action' => 'myfollow')); ?> </li>
		<li><?php echo $this->Html->link(__('Article Add'), array('controller' => 'articles','action' => 'add')); ?> </li>
		</ul>
	</div>


<div class="row-fluid">
    <div class="span9">
        <h2><?php echo $this->Html->link('SRNS', array('action' => 'index')); ?></h2>
	<div class="span3">
		<div class="well" style="margin-top:20px;">
			<div class="rightcontainer">
			<?php echo $this->Form->create('Tag', array('action' => 'search')); ?>
			<!--<fieldset>
				<legend>検索</legend>				
					<div class="controls">
						<?php echo $this->Form->input('name'); ?>
					</div>
			</fieldset>-->
			    <div class="control-group">
			        <?php echo $this->Form->label('keyword', 'キーワード', array('class' => 'control-label')); ?>
			        <div class="controls">
			        <?php echo $this->Form->text('keyword', array('class' => 'span12', 'placeholder' => 'タイトル、本文を対象に検索')); ?>
			        <?php
			            $options = array('and' => 'AND', 'or' => 'OR');
			            $attributes = array('default' => 'and', 'class' => 'radio inline');
			            echo $this->Form->radio('andor', $options, $attributes);
			        ?>
			        </div>
			    </div>
			<?php echo $this->Form->end('検索'); ?>
			</div>
		</div>
	</div>
        <table class="table">
            <tr>
 			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
            </tr>
        <?php foreach ($tags as $tag): ?>
            <tr>
		<td><?php echo h($tag['Tag']['ID']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['name']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['created']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tag['Tag']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tag['Tag']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tag['Tag']['ID']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['ID'])); ?>
			<?php echo $this->Html->link(__('Result'), array('action' => 'result', $tag['Tag']['ID'])); ?><!--リザルトへ-->
		</td>
            </tr>
        <?php endforeach; ?>
        </table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
</body>
</html>