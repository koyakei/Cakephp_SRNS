<?php if($result['URL'] == null): ?>
		<?php echo $this->Html->link($result[$firstModel]['name'], array('controller' => lcfirst($firstModel)."s", 'action' => 'view', $result[$firstModel]['ID'])); ?>
		<?php else: ?>
		<a href="
		<?php echo $result['URL']; ?>
		">
		<?php echo $result[$firstModel]['name']; ?>
		</a>
		<?php endif; ?>