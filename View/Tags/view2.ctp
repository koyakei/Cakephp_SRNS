<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->script(array('view2')); ?>
    <script type="text/javascript">

$(document).ready(function()
    {
        $(".myTable").tablesorter();
            var newTagNodeSubmit = document.getElementById('trikey_submit');
        	document.getElementById('tag_id').value.onchange = function() {
        	document.getElementById('spesifiedtrikeylink').innerHTML = '/cakephp/tags/singletrikeytable/<?php echo $idre; ?>/' + document.getElementById('tag_id').value;

        };
    }

);


</script>

</head>
<body>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or0.',array('value' => '','class' => 'tag_id','id' => 'or1'));
?>
</div>
</fieldset>
AND

	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or0.',array('value' => '','class' => 'tag_id','id' => 'or2'));
?>
</div>
</fieldset>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or1.',array('value' => '','class' => 'tag_id','id' => 'or1'));
?>
</div>
</fieldset>
AND

	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or1.',array('value' => '','class' => 'tag_id','id' => 'or2'));
?>
</div>
</fieldset>

<BUTTON type="button" id="search">検索</BUTTON>
<div class="body">

</div>
</body>
</html>