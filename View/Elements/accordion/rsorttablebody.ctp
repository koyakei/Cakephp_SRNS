<?php echo $this->Html->script("view2.js")?>
<?php foreach ($results  as $result): ?>
<?php if($firstModel == 'Tag'){$userCallAssosiation = 'O';} else {$userCallAssosiation = 'O';} // アソシエーションの名前を一緒にしたが後で別にするかも?>
<div id="draggble">
				<tr>
					<!--  ここらへんに　trilink での関連性表示 -->
					<!--
				同じ階層同士の関連性がある時は　mindmap ボタンがハイライトされればOKとする
				SHAで色生成　同色でもいいかも　グレースケールで黒方向の制限　文字とのコントラストを確保
				関連性にフラグ　$result["child_rel"] = bool で建てる
					--><div class="DDhandle" id="<?php echo h($result[$firstModel]['ID']); ?>">
					<td class="id"<?php if($result[$firstModel]['srns_code_member']): ?>

					 bgcolor=green <?php endif; ?> id ="<?php echo h($result[$firstModel]['ID']); ?>">
					 <?php echo h($result[$firstModel]['ID']); ?>&nbsp;

					</td></div>
					<td>
					<!-- $leaf -->
					<div class="droppable">
					<?php $leaf = $result["leaf"]; //leaf こうして　配列の何処かに隠しておくほかあるまい。　common component trifinder でそう渡すようにする　base trikey の仕様を考える。
					if(!is_null($leaf)){ echo "<b>"; } ?>
					<?php echo $this->element('accordion/URL', Array('result' => $result,'firstModel' =>$firstModel)); ?>
					<?php if(!is_null($leaf)){ echo "</b>"; } ?>
					</div>
					<?php if(!is_null($leaf)): ?>
						<div onClick='toggleShow(this)' >
								Reply
							</div>
							<div id='HSfield' style='display: none;'>
							<!-- このエレメントを再帰的に呼び出す-->
							<?php
    	echo $this->element('accordion/table_reply',
    			array('tableresults' => $leaf["nodes"],
    					'taghashes'=>$taghash,
    					'currentUserID' => $currentUserID,
    					'srns_code_member'=>$leaf["nodes"]['srns_code_member'],
    					"index" => $leaf["index"]
    					,$sorting_tags
    			)
    	);
    	?>
							</div>
					<?php endif; ?>
						<?php echo $this->Form->hidden($firstModel.'.ID', array('value'=>$result[$firstModel]['ID'])); ?>
						<?php  if($result['no_sort_subtag'] != null): ?>
							<div onClick='toggleShow(this);' >
								tagged
							</div>
							<div id='HSfield' style='display: none;'>
								<?php foreach ($result['no_sort_subtag'] as $taghash): ?>
									<?php if(!in_array($taghash,$sorting_tags)): ?>
										<?php echo $this->Html->link($taghash['Tag']['name'],
											 array('controller'=> "tags",'action' => 'view2', $taghash['Tag']['ID'])); ?>
										<?php echo $taghash['Link']['quant'] + ":" + $taghash['Tag']['name']; ?>
										<br>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						</td>
					<td class="actions">
					<?php echo h($result[$userCallAssosiation]['username']); ?>&nbsp;
						<div onClick='toggleShow(this);' >
						Action
						</div>
						<div id='HSfield' style='display: none;'>
						<?php echo $this->Html->link(__('View'), array('controller'=> $firstModel."s",'action' => 'view', $result[$firstModel]['ID'])); ?><br>
						<?php echo $this->Html->link(__('Edit'), array('controller'=> $firstModel."s",'action' => 'edit', $result[$firstModel]['ID'])); ?><br>

						 <?php
						 echo $this->Form->button('タグ付け要求',array("onClick" =>"demand(this)"));

						 // こっちのボタンでは現在選択しているtirikeyでのリンクをすべて削除。
						 echo $this->Form->create("Link"
						 		,array('controller'=> 'Links','action' => 'delete'));
						 //replay@mine も選択し
						 $ORflag = false;
						 $MRflag = false;
						 foreach ($result['trikey'] as $each){
						 	foreach ($each as $val){
							 	if ($val == Configure::read("tagID.reply")){
							 		$ORflag =true;
							 	}
// 							 	 elseif ($val == $myReply){
// 									$MRflag = true;
// 							 	}
							 }
						 }
						 if ($ORflag){
						 	$defaultId = Configure::read("tagID.reply");
						 }
// 						 elseif ($MRflag){
// 						 	$defaultId = $myReply;
// 						 }

						 echo $this->Form->input('trikey_id', array(
						 		'type' => 'select',
						 		'multiple'=> false,
						 		'options' => $result['trikey'],
						 		'selected' => $defaultId,
						 		'id'=>'trikey_id'));
						 echo $this->Form->end(__('削除'));

						 echo $this->Form->postLink(__('削除'.$result["taglink"]["name"]),
						 		 array('controller'=> 'Links','action' => 'delete', $result['Link']['ID']), null, __('Are you sure you want to delete # %s?', $result[$firstModel]['ID']));
						 echo $this->Form->postLink(__('削除要求'),
						 		array('controller'=> 'Links','action' => 'delDemand', $result['Link']['ID']), null, __('deldemand # %s?', $result[$firstModel]['ID']));
// 						 <!-- pull down trikey delete demand submitter
// 						 $result['Link']['ID']　で現在のtrikey でのID　が取得できるが、
// 						 複数のidを持って同時に消したい　どうやって複数持たせるのか？-->
						 							//@todo 複数のtrikey link id を$result[$trike_id]['Link']['ID']みたいな形で表示　trikeyAndSet をいじる
						 							?>
						 							<?php echo $this->Form->button('del')?>
						  <?php
						  echo $this->element('accordion/nestedinput', array("model" => "Article",
						  		 "currentUserID" => $currentUserID ,"ulist" =>$ulist,"parentID" => $result[$firstModel]['ID']))
						  ?>

						  </div>
					</td>
					<td><div onClick='toggleShow(this);' >
						Tag add
						</div>
						<div id='HSfield' style='display: none;'>
						<?php
							echo $this->element('tagrelationadd', Array('ulist' => $ulist,'idre'=>$id,'ToID' => $result[$firstModel]['ID'],'currentUserID' => $currentUserID));
						 ?></div></td>

						<?php if ($taghashes != null) {
							foreach ($taghashes as $key => $hash): ?>
						<?php $b = 0; ?>
							<?php if($result['subtag'] != null) { ?>
								<?php foreach ($result['subtag'] as $subtag): ?>
									<?php if ($hash['ID'] == $subtag['Tag']['ID']){ ?>
										<td><?php echo $subtag['Link']['quant']; ?></td>
										<td>
										<div onClick='toggleShow(this);' >
						Quant
						</div>
						<div id='HSfield' style='display: none;'>
										<?php echo $this->Form->create('tag'); ?>
										<?php echo $this->Form->input('Link.quant',array('default'=>$subtag['Link']['quant'])); ?>
										<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
										<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
										<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
										<?php echo $this->Form->end('change quant'); ?>
										<?php echo $this->Form->create('tag',array('controller' => 'tags','action'=>'tagdel')); ?>
										<?php echo $this->Form->hidden('Link.ID', array('value'=>$subtag['Link']['ID'])); ?>
										<?php echo $this->Form->hidden('Link.user_id', array('value'=>$subtag['Link']['user_id'])); ?>
										<?php echo $this->Form->hidden('idre', array('value'=>$idre)); ?>
										<?php echo $this->Form->end('del'); ?>
									</div>
										</td>
										<?php $b = 1; ?>
									<?php } ?>
								<?php endforeach; ?>
							<?php } ?>
							<?php if ($b == 0){ ?>
							<td></td><td></td>
						<?php } ?>
					<?php endforeach; }?>
				</tr>
			</div>
			<?php endforeach; ?>