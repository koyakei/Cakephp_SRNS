<dl><dt><?php echo __('extends 継承'); ?></dt>
	<?php foreach ($extends as $extend): ?>

		        <dd>
		                <?php echo $this->Html->link(__($extend['Tag']['name']), array('controller'=> 'tags','action' => 'view', $extends['Tag']['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
	</dl>
