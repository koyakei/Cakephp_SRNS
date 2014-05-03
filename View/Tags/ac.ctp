
<?php  
echo $this->AutoComplete->input( 
    'Tag.name', 
    array( 
        'autoCompleteUrl'=>$this->Html->url(  
            array( 
                'controller'=>'tags', 
                'action'=>'auto_complete', 
            ) 
        ), 
        'autoCompleteRequestItem'=>'autoCompleteText', 
    ) 
); 
?> 