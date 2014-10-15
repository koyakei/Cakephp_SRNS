<table class="myTable" cellpadding="0" cellspacing="0">
<colgroup span="4"></colgroup>
<colgroup class="taghash" span="15"><!-- 15にしとけば端まで行くだろう defalt で　collapse--></colgroup>
        <?php echo $this->element('tablehead',
         Array('taghashes'=>$taghash)); ?>
    <tbody>
    	<?php echo $this->element('rsorttablebody',
    	 Array('results' => $tableresults['articleparentres'],
    	 'taghashes'=>$taghash,
    	 'firstModel' => 'Article',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member']
    	,$sorting_tags)); ?>
		<?php echo $this->element('rsorttablebody',
    	 Array('results' => $tableresults['tagparentres'],
    	 'taghashes'=>$taghash,
    	 'firstModel' => 'Tag',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member'],
    	$sorting_tags)); ?>

	</tbody>
</table>