<head>
<meta charset="UTF-8">

z
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
<div class="tags index">

	<h2><?php echo __('Articles'); ?></h2>
	<table id="myTable" class="tablesorter">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo __('Actions'); ?></th>
			<th></th>
			<?php foreach ($taghashes  as $hash): ?>
			<th>quant</th>
			<th><?php echo $hash['name']; ?></th>
			<?php endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($results  as $result): ?>
	<tr>
		<td><?php echo h($result['Article']['ID']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['name']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['created']); ?>&nbsp;</td>
		<td><?php echo h($result['Article']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller' => 'articles','action' => 'view', $result['Article']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller' => 'articles','action' => 'articleedit', $result['Article']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'articles','action' => 'articledelete', $result['Article']['ID']), null, __('Are you sure you want to delete # %s?', $result['Article']['ID'])); ?>
		</td>
		<td>
			<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagRadd')); ?>
				<?php echo $this->Form->input('Tag.name'); ?>
				<?php echo $this->Form->input('userid', array( 
    'type' => 'select', 
    'multiple'=> false,
    'options' => $ulist
//  'selected' => $selected  // 規定値は、valueを配列にしたもの
)); ?>
				<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
				<?php echo $this->Form->hidden('Link.LTo', array('value'=>$result['Article']['ID'])); ?>
			<?php echo $this->Form->end('tag'); ?>

		<?php foreach ($taghashes as $key => $hash): ?>
			<?php $b = 0; ?>
		
			<?php if($result['subtag'] != null) { ?>
				<?php foreach ($result['subtag'] as $subtag): ?>
					<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?></td>
						<td><?php echo $subtag['Link']['quant']; ?></td>
						<td>
						<!--<?php echo $subtag['Tag']['name']; ?>-->
						<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'quant')); ?>
							<?php echo $this->Form->input('Link.quant',array('default'=>$subtag['Link']['quant'])); ?>
							<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
						<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
						<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
						<?php echo $this->Form->end('tag'); ?>
						<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagdel')); ?>
							<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
							<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
							<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
						<?php echo $this->Form->end('tag'); ?>
						</td>
						</td>
						<?php $b = 1; ?>
					<?php } ?>
				<?php endforeach; ?>
			<?php } ?>
			<?php if ($b == 0){ ?>
				<td></td><td></td>
			<?php } ?>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</tbody>
	</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?></li>
	</ul>
</div>
