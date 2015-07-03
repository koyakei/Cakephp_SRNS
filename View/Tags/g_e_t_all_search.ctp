<?php
	echo $this->element('accordion/data_strage',array('root_ids' => $id));
// 	echo $this->element('accordion/table_reply',
// 		array('tableresults' => $allresults,
// 			'taghashes'=>$taghash,
// 		   	'currentUserID' => $currentUserID,
// 		   	'srns_code_member'=>$tableresults['srns_code_member']
// 		   	,$sorting_tags
// 		)
// 	);
?>
<table>
<?php foreach ($results  as $result): ?>
<tr>
					<td>
								<?php echo $result["Trilink"]["Link_LTo"]; ?>
					 </td>
					 <?php if ($result["Tag"]["ID"] == null){
					 	$model = "Article";
					 }else{
					 	$model = "Tag";
					 }?>
					<td>
						<?php echo $this->Html->link($result[$model]["name"], array('controller' => $model."s", 'action' => 'view2', $result[$model]['ID'])); ?>
					</td>
			</tr>
<?php endforeach; ?>
</table>