
<?php echo $this->Form->input('name', Array('name'=>'auto')); ?>
<?php 
  if(isset($terms)) { 
    echo $this->Js->object($terms); 
  } 
?> 