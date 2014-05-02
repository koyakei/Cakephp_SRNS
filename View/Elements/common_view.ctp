<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
    $(document).ready(function(){
        //オートコンプリート
        $('#auto').autocomplete(
            '<?php echo $this->html->url('autoSuggest'); ?>',{
                'database':['0'],
                onItemSelect: function(li) {
                }
            }
        );
    });

$(document).ready(function()
    {
        $(".myTable").tablesorter();
    }
);
</script>
</head>
<body>
    <?php echo $this->element('contentssidebar', Array('keylist' => $keylist,'idre'=>$idre,'firstModel' => $firstModel,'data' => $headresults,'idre'=>$idre,'trikeyID', $trikeyID)); ?>
<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	 <dl><?php echo $this->element('detail',array('detail' =>  $headresults,'firstModel' => $firstModel,'SecondDems' =>  $SecondDems)); ?>
        </dl>
    <?php if($firstModel == 'Tag'): ?>
	<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $headresults['Tag']['ID'],'currentUserID' => $currentUserID)); ?>
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
        <?php echo $this->element('inputind', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Article','currentUserID' => $currentUserID,'key' => $value['ID'])); ?>
        <?php echo $this->element('inputind', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Tag','currentUserID' => $currentUserID,'key' => $value['ID'])); ?>
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