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
</script>
<?php echo $this->form->create('User', array('url' => '/ajax/view')); ?>
	<?php echo $this->ajax->autoComplete('Post.subject', '/ajax/autoComplete')?>
<?php echo $this->form->end('View Post')?>

<?php echo $this->Form->input('name', Array('name'=>'auto')); ?>
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