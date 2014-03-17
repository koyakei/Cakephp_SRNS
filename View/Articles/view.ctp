<head>
<meta charset="UTF-8">
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

<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	 <dl>
                <dt><?php echo __('ID'); ?></dt>
                <dd>
                        <?php echo h($article['Article']['ID']); ?>
                        &nbsp;
                </dd>
                <dt><?php echo __('Name'); ?></dt>
                <dd>
                        <?php echo h($article['Article']['name']); ?>
                        &nbsp;
                </dd>
                <dt><?php echo __('Owner Id'); ?></dt>
                <dd>
                        <?php echo h($article['Article']['user_id']); ?>
                        &nbsp;
                </dd>
                <dt><?php echo __('Created'); ?></dt>
                <dd>
                        <?php echo h($article['Article']['created']); ?>
                        &nbsp;
                </dd>
                <dt><?php echo __('Modified'); ?></dt>
                <dd>
                        <?php echo h($article['Article']['modified']); ?>
                        &nbsp;
                </dd>
		<?php foreach ($headresults as $headtaghash): ?>
			<dt><?php echo __('Searchtagname'); ?></dt>
		        <dd>
		                <?php echo $this->Html->link(($headtaghash['Tag']['name']), array('controller' => 'tags','action' => 'view', $headtaghash['Tag']['ID'])); ?>
		                &nbsp;
		        </dd>
		<?php endforeach; ?>
        </dl>
</div>
<div class="actions">
<ul>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller'=> 'tags','action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Tag search'), array('controller' => 'tags','action' => 'search')); ?> </li>
	</ul>
</div>
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $article['Article']['ID'])); ?>
	
	<table cellpadding="0" cellspacing="0">
	<table id="myTable" class="tablesorter">
	<?php echo $this->element('tablehead', Array('taghashes'=>$taghashes)); ?>
	<tbody>
	<?php echo $this->element('tablebody', Array('results' => $articleresults,'taghashes'=>$taghashes,'firstModel' => 'Article')); ?>
	<?php echo $this->element('tablebody', Array('results' => $tagresults,'taghashes'=>$taghashes,'firstModel' => 'Tag','currentUserID' => $currentUserID)); ?>
</tbody>
	</table>
	<?php echo $this->element('Input', Array('ulist' => $ulist,'keylist' => $keylist,'model' => 'Article')); ?>
	<?php echo $this->element('Input', Array('ulist' => $ulist,'keylist' => $keylist,'model' => 'Tag')); ?>

