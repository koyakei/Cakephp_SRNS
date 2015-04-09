<?php debug($default_nodes);?>
<?php foreach ($default_nodes as $default_node): ?>
	<td>
		<p>
			<input type="checkbox">
		</p>
		<?php debug($default_node);?>
	</td>
<?php endforeach; ?>