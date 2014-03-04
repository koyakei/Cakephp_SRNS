<?php foreach ($headresults as $headtaghash): ?>
			<dt><?php echo __('Searchtagname'); ?></dt>
		        <dd>
		                <?php 
		                 echo $this->Html->link(__($headtaghash[$firstModel]['name']), array('controller'=> $controller_name,'action' => 'view', $headtaghash[$firstModel]['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
		