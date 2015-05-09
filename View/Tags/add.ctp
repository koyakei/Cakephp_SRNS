<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
		<legend><?php echo __('Add Tag'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	));
	echo $this->Form->input('auth',array(
    'type' => 'select',
    'options' => array( 0 => 'public',1 => 'private'),
  'selected' => 0));
	echo $this->Form->input('max_quant',array(
			'type' => 'number',
			'value' => 1000,
	));
	// 三番目の選択肢として、タグの選択が可能にしたい
	//jquery で
	echo $this->Form->input('auth_move',array(
			'type' => 'select',
			'options' => array( 0 => 'public',1 => 'private'),
			'selected' => 1));
	echo $this->Form->input('auth_delegate',array(
			'type' => 'select',
			'options' => array( 0 => 'public',1 => 'private'),
			'selected' => 1));
	?>
	<!--
	<datalist id="auth">
<option value="公開">
<option value="自分だけ">
</datalist>
このデータリストを　append してタグの候補を表示したい　js.autocomplete でやろうかな
-->
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?></li>
	<li><?php echo $this->Html->link(__('Tag search'), array('action' => 'search')); ?> </li>
	</ul>
</div>
