<!-- $model $key $currentUserID $ulist -->
<form>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	,'id'=>'user_id')); ?>

	<?php
	if (!empty($parentID)){
		echo $this->form->hidden("parentID" ,array('value' => $parentID));
	}
	?>
		<legend><?php echo __($model); ?></legend>
	<?php
		$targetid = $this->params['pass'][0];
		echo $this->Form->input('Article',array('class'=> 'reply_article_name'));
	?>
<input type="button" value="addArticle" onClick="addArticle(this)">
</form>