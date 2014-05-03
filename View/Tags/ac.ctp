
<?php  
echo $this->AutoComplete->input( 
    'Tag.name', 
    array( 
        'autoCompleteUrl'=>$this->Html->url(  
            array( 
                'controller'=>'terms', 
                'action'=>'auto_complete', 
            ) 
        ), 
        'autoCompleteRequestItem'=>'autoCompleteText', 
    ) 
); 
?> 