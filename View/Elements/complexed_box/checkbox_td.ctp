<?php foreach ($nodes as $node): ?>
	<td>
		<p>
			<input type="checkbox">trikey
		</p>
		<?php debug($node);?>
		<?php echo $node["$model"]["name"]; ?>
	</td>
<?php endforeach; ?>