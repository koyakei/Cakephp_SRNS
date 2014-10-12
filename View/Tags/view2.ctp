<?php Configure::load("static"); ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->script("view2"); ?>
</head>
<body>
<table class="myTable" cellpadding="0" cellspacing="0">
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
<div id="body">

</div>
</body>
</html>