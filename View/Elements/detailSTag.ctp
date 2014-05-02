<?php foreach ($SecondDems as $SecondDem): ?>
			<dt><?php echo __('Searchtagname'); ?></dt>
		        <dd>
		                <?php 
		                 echo $this->Html->link(__($SecondDem[$firstModel]['name']), array('controller'=> 'tags','action' => 'view', $SecondDem[$firstModel]['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
		