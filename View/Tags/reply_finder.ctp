<table class="myTable" cellpadding="0" cellspacing="0">
        <?php echo $this->element('tablehead',
         Array('taghashes'=>$taghash)); ?>
    <tbody>
    	<?php echo $this->element('rsorttablebody',
    	 Array('results' => $tableresults'articleparentres',
    	 'taghashes'=>$tableresults['taghash],
    	 'firstModel' => 'Article',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member']
    	,$sorting_tags)); ?>
    		<?php echo $this->element('tablebody',
    	 Array('results' => $tableresults['tagparentres'],
    	 'taghashes'=>$tableresults['taghash],
    	 'firstModel' => 'Tag',
    	 'currentUserID' => $currentUserID,
    	'srns_code_member'=>$tableresults['srns_code_member'])); ?>
	</tbody>
</table>

<!-- ボタンを押したら ajaxInput(this)
-->
<div onClick='toggleShow(this);' >
	add
	</div>
	<div id='HSfield' style='display: none;'>

	<div id="inputfield">
	<input type="buttun" value="Add Article" onClick="inputArticle(this)">
		<?php echo $this->element('Input',
    	 array('ulist' => $ulist,
    	 'currentUserID'=>$currentUserID,
    	 'model'=>'Article',
    	 )); ?>
	</div>

	</div>