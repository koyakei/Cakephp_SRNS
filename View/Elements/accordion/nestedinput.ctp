<!-- $model $key $currentUserID $ulist -->

<?php
$quantize = $this->params['pass'][1];
if (is_null($quantize)){
	$quantize = 0;
}
echo $this->Form->create(null);

		echo $this->Form->input('user_id', array(
			    'type' => 'select',
			    'multiple'=> false,
			    'options' => $ulist,
			  'selected' => AuthComponent::user("id")//['userselected']
			,'id'=>'user_id'));


		echo $this->Form->hidden("target",array("value" =>$result["follow"]));
		echo $this->Form->input('Article',array("type" =>"text",'class'=> 'reply_article_name'));
	?>

<?php echo $this->Form->button('add article', array('onClick' =>
						"addArticle(this,'".$this->params['controller']."','".$this->params['action']."','".$this->params['pass'][0]."','".$quantize."')")); ?>
<?php echo $this->Form->end();?>

<!-- tag追加 -->
<fieldset id="add_tag">

		        <?php echo $this->AutoCompleteNoHidden->input(
			    'tag',
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
echo $this->Form->hidden('tag',array('value' => '','class' => 'tag_id','id' => 'tag'));
?>
				<?php echo $this->Form->input('add tag', array('type'=> 'button', 'value' =>'Add Tag','onClick' =>
						"add_reply_tag(this,'".$this->params['controller']."','".$this->params['action']."','".$this->params['pass'][0]."','".$quantize."')")); ?>
				<?php echo $this->Form->input('trikey[]', array('type'=> 'hidden','class' => 'trikey', 'value' =>$trikey)); ?>
		</fieldset>