<thead>
	<tr>
		<th class="mark">ID</th>
		<th class="mark" style="min-width: 100px;">name </th>
		<th class="actions">user_id<br><?php echo __('Actions'); ?></th>
		<th></th>
		<?php if($taghashes != null and $this->action != 'transmitter'){ ?>
		<?php foreach ($taghashes  as $hash): ?>
		<th>量</th>
		<th>
		<?php echo $hash['name']; ?>
		<?php
		//TODO:search2になんか入れてジャンプするか？
		echo $this->Html->link(__('Open'),
		array('controller'=> "tags",'action' => 'search2', "?" => array("or1"=>$hash['ID'])));
		?></th>
		<?php endforeach; ?>
		<?php } ?>
	</tr>
</thead>