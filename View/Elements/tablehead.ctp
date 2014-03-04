		<thead>
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>user_id</th>
				<th>created</th>
				<th>modified</th>
				<th class="actions"><?php echo __('Actions'); ?></th>
				<th></th>
				<?php if($taghashes =! null){ ?>
				<?php foreach ($taghashes  as $hash): ?>
				<th>quant</th>
				<th><?php echo $hash['name']; ?><?php echo $this->Html->link(__('View'), array('controller'=> "tags",'action' => 'view', $hash['ID'])); ?></th>
				<?php endforeach; ?>
				<?php } ?>
			</tr>
		</thead>