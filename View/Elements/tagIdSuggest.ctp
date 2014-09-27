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