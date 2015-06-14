
<table class="index">
<!-- contents of index
トライキーを複数持つエンティティーが出てきた場合
重複のどちらかを削除するのか、残すのか？
def@A def@b の二つが紐付いていたときにどうするの？
限定された　trikiのみを要求する時も、一度ザンブルを表示させてからでないとだめなのかも
重複している円ティーティーを何度も繰り返して表示しないようにしたら、
-->
	 <?php foreach ($tableresults["indexHashes"] as $trikey_id => $index):?>

	 <tr><td> <a href="#<?php echo $trikey_id; ?>"><?php echo $index; ?></a></td></tr>
	 <?php endforeach;;?>
</table>
<!-- quantize -->
<script type="text/javascript">
    function updateTextInput(val) {
      document.getElementById('qNumber').value=val;
    }
  </script>
<?php //TODO: 量子化切り替えプルダウン
//ここの切り替えによってaddした時のquantize を決定する。
//とりあえず、tagにquantize を設定しない
echo $this->Form->input('quzntize', array(
		'type' => 'range',
		'multiple'=> false,
		'options' => $quantize,
		'selected' => 0//['userselected']
		,'class'=>'quantizeSelector',
		'onchange' =>"updateTextInput(this.value)",
		"value" => "0",
));
echo $this->Form->input('number', array(
		'type' => 'input',
		'onchange' =>"updateTextInput(this.value)",
		'id' => "qNumber",
		"value" => "0",
));
?>
	<div class="DDhandle"> ここを持つとテーブルが動く</div>
	<!--  trikey table itarator
	here is table
	de not duplicate to reply@official or reply@myself
	重複エンティティー
	wikipedhia で調べること。　重複trilinkの対象となるtrilinkを列挙する
	たくさんあって、ancor 重複する意味のアンカーごとに
	たくさんのユーザーが同じエンティティーに対していろいろなtrilinkを
	付与したときに、重複してたくさん表示されると　表示が崩れる。
	俺にとっての定義は是だあれだと主張し合う時や、投票するときにどうやって対応するのか？
	i　opinion range 0-5
	user1 chose 012
	user2 chose 123
	discribe it with trikey link
	上記の意見の組み合わせを一回で絞りたい。　１の意見　２の意見　という比較は必要。
	同じタグに対して、二つの意見パターンを縦に表示するには？
	定義をタグ付け
	トライキーを名前で縛ることによって、　意見の分布を示すとは？
	すでに関連づけらる。
	一つのエンティティーにプルダウンで何のトライキーが結びついているのか表示する？
	チェックボックスでマルチプルチョイス可能なlist にするか？
	名前だけで重複表示させても、同じ意味だとは限らない。
	重複表示させるトライキーも手動で選択できる必要がある。
	どのタグとどのタグが同じ意味なのか個人によって違う。
	==関係で結ばれていれば重複表示にするか。
	-->
	<table class="myTable" cellpadding="0" cellspacing="0" style ="background: white">
        <?php echo $this->element('accordion/tablehead',
         Array('taghashes'=>$tableresults["taghash"])); ?>
	    <tbody>
	    	<?php echo $this->element('accordion/rsorttablebody',
	    	 Array('results' => $tableresults['articleparentres'],
	    	 'taghashes'=>$tableresults["taghash"],
	    	 'firstModel' => 'Article',
	    	 'currentUserID' => $currentUserID,
	    	'srns_code_member'=>$tableresults['srns_code_member']
	    	,$sorting_tags)); ?>
			<?php echo $this->element('accordion/rsorttablebody',
	    	 Array('results' => $tableresults['tagparentres'],
	    	 'taghashes'=>$tableresults["taghash"],
	    	 'firstModel' => 'Tag',
	    	 'currentUserID' => $currentUserID,
	    	'srns_code_member'=>$tableresults['srns_code_member'],
	    	$sorting_tags)); ?>
		</tbody>
	</table>