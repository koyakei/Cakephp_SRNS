
	<?php
	echo $this->element('accordion/table_reply',
		array('tableresults' => $allresults,
			'taghashes'=>$taghash,
		   	'currentUserID' => $currentUserID,
		   	'srns_code_member'=>$tableresults['srns_code_member']
		   	,$sorting_tags
		)
	);
	?>



</div>
