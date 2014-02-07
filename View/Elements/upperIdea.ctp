<dl><dt><?php echo __('上位概念'); ?></dt>
	<?php foreach ($upperIdeas as $upperIdea): ?>
			
		        <dd>
		                <?php echo $this->Html->link(__($upperIdea['Tag']['name']), array('controller'=> 'tags','action' => 'view', $upperIdea['Tag']['ID'])); ?>
		        </dd>
		<?php endforeach; ?>
	</dl>
