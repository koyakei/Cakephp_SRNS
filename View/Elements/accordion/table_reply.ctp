
<table class="index">
<!-- contents of index
トライキーを複数持つエンティティーが出てきた場合
重複のどちらかを削除するのか、残すのか？
-->

	 <?php foreach ($indexs as $index):?>
	 <tr><td> <?php echo $index["trikey"]["name"];?></td></tr>
	 <?php endforeach;;?>
</table>
	<div class="DDhandle"> ここを持つとテーブルが動く</div>
	<table class="myTable" cellpadding="0" cellspacing="0" style ="background: white">
        <?php echo $this->element('tablehead',
         Array('taghashes'=>$taghash)); ?>
	    <tbody>
	    	<?php echo $this->element('accordion/rsorttablebody',
	    	 Array('results' => $tableresults['articleparentres'],
	    	 'taghashes'=>$taghash,
	    	 'firstModel' => 'Article',
	    	 'currentUserID' => $currentUserID,
	    	'srns_code_member'=>$tableresults['srns_code_member']
	    	,$sorting_tags)); ?>
			<?php echo $this->element('accordion/rsorttablebody',
	    	 Array('results' => $tableresults['tagparentres'],
	    	 'taghashes'=>$taghash,
	    	 'firstModel' => 'Tag',
	    	 'currentUserID' => $currentUserID,
	    	'srns_code_member'=>$tableresults['srns_code_member'],
	    	$sorting_tags)); ?>
		</tbody>
	</table>