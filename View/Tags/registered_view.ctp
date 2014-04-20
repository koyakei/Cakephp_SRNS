<head>
<script type="text/javascript">
$(document).ready(function()
    {
        $(".myTable").tablesorter();
    }
);
</script>
</head>
<body>
<?php echo $this->element('contentsidebar', Array('keylist' => $upperIdeas,'idre'=>$idre,'firstModel' => 'Tag','data' => $tag,'key' => $trikeyID)); ?>
<div class="tags view">
<h2><?php echo __('Tag');  ?></h2>

<dl>
		<?php echo $this->element('detail',array('detail' =>  $tag,'firstModel' => 'Tag')); ?>
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $tag['Tag']['ID'],'currentUserID' => $currentUserID)); ?>
<?php if ($headresults =! null) { ?>
		<?php echo $this->element('detalSTag',array('headresults' =>  $headresults,'firstModel' => 'Tag')); ?>
		<?php } ?>
</dl>
<?php if($idre == 2184):?>
<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links', 'action' => 'singlelink'))); ?>
	<?php
		echo $this->Form->input('LTo');
	?>
	<?php
		echo $this->Form->hidden('LFrom',array('value' => $this->request['pass'][0]));
	?>
<?php echo $this->Form->end(__('Single link')); ?>
<?php endif ?>

</div>

<?php echo $this->element('contentssidebar', Array('keylist' => $keylist,'idre'=>$idre,'firstModel' => 'Tag','data' => $tag,'idre'=>$idre,'trikeyID', $trikeyID)); ?>
<?php foreach($tableresults as $value): ?>
<a name="<?php echo $value['ID'] ?>">
	<h2><?php echo $value['name'] ?></h2>
	<table class="myTable" cellpadding="0" cellspacing="0">
		<?php echo $this->element('tablehead', Array('taghashes'=>$value['head'])); ?>
		<tbody>
		<?php echo $this->element('tablebody', Array('results' => $value['tag'],'taghashes'=>$value['head'],'firstModel' => 'Article','currentUserID' => $currentUserID)); ?>
		<?php echo $this->element('tablebody', Array('results' => $value['article'],'taghashes'=>$value['head'],'firstModel' => 'Tag','currentUserID' => $currentUserID)); ?>
		</tbody>
	</table>
	</a>
<?php endforeach; ?>
		<script>
	window.onload=function(){


		var f=document.getElementById("keyid");
		checkSelect(f.elements["keyid"],"<?php echo $trikeyID; ?>");
	}
	function checkSelect(obj,val){
		for(var i=0;i<obj.length;i++){
			var objval =obj[i].id;
			var objval2 =val;
			if(obj[i].id==val){
			obj[i].selected=true;
			break;
			}
		}
	}
	</script>
</body>
</html>