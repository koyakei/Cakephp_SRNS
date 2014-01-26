		<thead>
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>user_id</th>
				<th>created</th>
				<th>modified</th>
				<th class="actions"><?php echo __('Actions'); ?></th>
				<th></th>
				<?php foreach ($taghashes  as $hash): ?>
				<th>quant</th>
				<th><?php echo $hash['name']; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>