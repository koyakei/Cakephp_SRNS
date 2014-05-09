<?php $controller_name = lcfirst ($firstModel) ?>
<?php if ($upperIdeas) {
echo $this->element('upperIdea', Array('ulist' => $upperIdeas,'idre'=>$idre)); 
} ?>
		<dt><?php echo __('ID');  ?></dt>
		<dd>
			<?php echo $this->Html->link($detail[$firstModel]['ID'], array('controller' => $firstModel."s", 'action' => 'view', $detail[$firstModel]['ID'])); ?>		<?php echo $this->Html->link('anonymous', array('prefix'=>'anonymous','anonymous' => true,'controller' => $firstModel."s", 'action' => 'view', $detail[$firstModel]['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($detail[$firstModel]['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($detail['O']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($detail[$firstModel]['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($detail[$firstModel]['modified']); ?>
			&nbsp;
		</dd>
		<?php if ($firstModel == 'Tag'): ?>
		<div onClick='toggleShow(this);' >
		<dt><?php echo __('Max quant'); ?></dt>
						</div>
		<div id='HSfield' style='display: none;'>
		<dd>
<?php echo $this->Form->create($firstModel//,array('controller' => 'tags','action'=>'quant')
); ?>
			<?php echo $this->Form->input($firstModel.'.max_quant',array('default'=>$detail[$firstModel]['max_quant'])); ?>
<?php echo $this->Form->hidden($firstModel.'.ID', array('value'=>$detail[$firstModel]['ID'])); ?>
<?php echo $this->Form->end('change max quant'); ?>
			&nbsp;
		</dd>
	</div>
		<?php endif; ?>

	<?php if (!empty($SecondDems)): ?>
		<?php echo $this->element('detailSTag',array('SecondDems' =>  $SecondDems,'firstModel' => 'Tag')); ?>
	<?php endif; ?>
	<?php echo $this->element('map', array('id' => $id)); ?>