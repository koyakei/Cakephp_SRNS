
<?php  
echo $this->AutoComplete->input( 
    'Tag.name', 
    array( 
        'autoCompleteUrl'=>$this->Html->url(  
            array( 
                'controller'=>'tagusers', 
                'action'=>'auto_complete', 
            ) 
        ), 
        'autoCompleteRequestItem'=>'autoCompleteText', 
    ) 
); 
?> 