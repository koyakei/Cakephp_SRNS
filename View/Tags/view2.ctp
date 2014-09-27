<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
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

<?php echo $this->Form->create('Search'); ?>
	<fieldset>
        <?php
echo $this->AutoComplete->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'c'
    )
);

?>
</fieldset>
AND
<?php echo $this->form->hidden('b' ,array('value' => $value['ID'])); ?>
	<fieldset>
        <?php
echo $this->AutoComplete->input(
    'or1.2',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'c'
    )
);

?>
</fieldset>
<?php echo $this->form->hidden('b' ,array('value' => $value['ID'])); ?>
	<fieldset>
        <?php
echo $this->AutoComplete->input(
    'or2.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'c'
    )
);

?>
</fieldset>

<?php echo $this->form->hidden('b' ,array('value' => $value['ID'])); ?>
AND
	<fieldset>
        <?php
echo $this->AutoComplete->input(
    'or2.2',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'c'
    )
);

?>
</fieldset>
<?php echo $this->form->hidden('b' ,array('value' => $value['ID'])); ?>
NOT
<fieldset>
        <?php
echo $this->AutoComplete->input(
    'not.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
        'houtput' => 'c'
    )
);

?>
</fieldset>
<?php echo $this->form->hidden('b' ,array('value' => $value['ID'])); ?>
<?php echo $this->Form->end(__('Search')); ?>

</body>
</html>