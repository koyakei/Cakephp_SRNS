<?php Configure::load("static"); ?>
<html>
<head>
    <script type="text/javascript">
$(document).ready(function()
    {
            var newTagNodeSubmit = document.getElementById('trikey_submit');
        	document.getElementById('tag_id').value.onchange = function() {
        	document.getElementById('spesifiedtrikeylink').innerHTML = '/cakephp/tags/singletrikeytable/<?php echo $idre; ?>/' + document.getElementById('tag_id').value;
        };
    }
);

function jumpStrikey(){
	document.getElementById('spesifiedtrikeylink').href = '/cakephp/<?php echo $model; ?>s/singletrikeytable/<?php echo $idre; ?>/' + document.getElementById('or1_1').value;
}
function ajaxtable(keyid){
	$.ajax({
    	url: '/cakephp/tagusers/mapft?id=<? echo $idre; ?>&keyid=' + keyid,
    	dataType: 'json',
    	success: function(obj) {
			genTable(obj);
		}
		,
		error: function(obj) {
			genTable(obj.responseJSON);
		}
	});
}
</script>
</head>
<body>
    <?php echo $this->element('contentssidebar', Array('keylist' => $keylist,'idre'=>$idre,'firstModel' => $firstModel,'data' => $headresults,'idre'=>$idre,'trikeyID', $trikeyID)); ?>
<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	<?php echo $this->element('detail',array('detail' =>  $headresults,'firstModel' => $firstModel,'SecondDems' =>  $SecondDems)); ?>


    <?php if($firstModel == 'Tag'): ?>

	<?php if($idre == 2184): ?>
	<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links', 'action' => 'singlelink'))); ?>
		<?php
			echo $this->Form->input('LTo');
		?>
		<?php
			echo $this->Form->hidden('LFrom',array('value' => $this->request['pass'][0]));
		?>
	<?php echo $this->Form->end(__('Single link')); ?>
	<?php endif; ?>
<?php endif; ?>
</div>
	<?php foreach($tableresults as $value):
	 ?>
<a name="<?php echo $value['ID']; ?>">
    <h2><?php echo $value['name'] ?></h2>
    <table class="myTable" cellpadding="0" cellspacing="0">
        <?php echo $this->element('tablehead', Array('taghashes'=>$value['head'])); ?>
        <tbody>
        <?php echo $this->element('tablebody', Array('results' => $value['tag'],'taghashes'=>$value['head'],'firstModel' => 'Article','currentUserID' => $currentUserID,'srns_code_member'=>$value['srns_code_member'])); ?>
        <?php echo $this->element('tablebody', Array('results' => $value['article'],'taghashes'=>$value['head'],'firstModel' => 'Tag','currentUserID' => $currentUserID,'srns_code_member'=>$value['srns_code_member'])); ?>
        </tbody>
    </table>
        <?php echo $this->element('inputind', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Article','currentUserID' => $currentUserID,'key' => $value['ID'])); ?>
        <?php echo $this->Form->create('Tag'); ?>
<fieldset>
        <?php
echo $this->AutoComplete->input(
    'Tag.name',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'tag_id'
    )
);

?>
</fieldset>
<?php echo $this->form->hidden($model.'.keyid' ,array('value' => $value['ID'])); ?>
		<legend><?php echo __($model); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
	?>
<?php echo $this->Form->end(__('Submit')); ?>
    </a>
<?php endforeach; ?>
<!-- 現存するタグだけ表示して、　
基本タグをプルダウンでサジェストして、
-->
        <?php
echo $this->AutoComplete->input(
    'Tag.name',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'tag_id'
    )
);

?>
<a id="spesifiedtrikeylink" onclick ="jumpStrikey()" >個別trikey</a>



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