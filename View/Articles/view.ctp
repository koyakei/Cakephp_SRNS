<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

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
    <?php echo $this->element('contentssidebar', Array('keylist' => $keylist,'idre'=>$idre,'firstModel' => 'Article','data' => $headresult,'idre'=>$idre,'trikeyID', $trikeyID)); ?>
<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	 <dl><?php echo $this->element('detail',array('detail' =>  $headresult,'firstModel' => 'Article')); ?>
<?php echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$idre,'ToID' => $headresult['Tag']['ID'],'currentUserID' => $currentUserID)); ?>
        <?php if ($headresults =! null) : ?>
        <?php echo $this->element('detailSTag',array('headresults' =>  $headresults,'firstModel' => 'Tag')); ?>
        <?php endif; ?>
        </dl>
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