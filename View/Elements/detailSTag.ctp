<?php foreach ($SecondDems as $SecondDem): ?>
	<dt><?php echo __('Searchtagname'); ?></dt>
        <dd>
                <?php
                 echo $this->Html->link(__($SecondDem[$firstModel]['name']),
                 		array('controller'=> 'tags','action' => 'view2', $SecondDem[$firstModel]['ID'])); ?>

                 <?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagdel')); ?>
                 <?php echo $this->Form->hidden('Link.ID', array('value'=>$SecondDem['Link']['ID'])); ?>
				<?php echo $this->Form->hidden('Link.user_id', array('value'=>$SecondDem['Link']['user_id'])); ?>
				<?php echo $this->Form->hidden('idre', array('value'=>$this->params["pass"][0])); ?>
				<?php echo $this->Form->end('del'); ?>
        </dd>
<?php endforeach; ?>
