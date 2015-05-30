<!DOCTYPE html>
<html>
<head>

	<?php echo $this->Html->script(array("view2","accordion")); ?>
	<style type="css">
	.autoCompleteInputBox {
		width: 50%;
	}
	table {
  background: #E4F2F6;
  }
	</style>

</head>
<body>
<div id="search_box">
<ul>
  <li>
	<fieldset>
	    <?php
			echo $this->AutoCompleteNoHidden->input(
			    'or1.1',
			    array(
			        'autoCompletesUrl'=>$this->Html->url(
			            array(
			                'controller'=>'tagusers',
			                'action'=>'auto_complete',
			            )
			        ),
			        'autoCompleteRequestItem'=>'autoCompleteText',
			    )
			);
		?>
		<div class="search_tag_id">
		<?php
			echo $this->Form->hidden('or.0.',array('value' => '','class' => 'tag_id','id' => 'or1'));
		?>
		</div>
	</fieldset>
	</li>

<li>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
    		'click_function' => 'test()',
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or.0.',array('value' => '','class' => 'tag_id','id' => 'or2'));
?>
</div>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'or1.1',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('or.1.',array('value' => '','class' => 'tag_id','id' => 'or1'));
?>
</div>
</fieldset></li>
</ul>

</div>
<div class="trikeys">
<p>trikeys</p>
<ul>
<li>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'trikeys.0',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )
        ),
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('trikeys..',array('value' => '','class' => 'tag_id'));
?>
</div>
</fieldset></li>
</ul>
</div>
<div class="sorting_tags">
<p>sorting tags</p>
<ul>
<li>
	<fieldset>
        <?php
echo $this->AutoCompleteNoHidden->input(
    'sorting_tags.0',
    array(
        'autoCompletesUrl'=>$this->Html->url(
            array(
                'controller'=>'tagusers',
                'action'=>'auto_complete',
            )

        ),
    	'click_function' => 'all_reply_finder()',
        'autoCompleteRequestItem'=>'autoCompleteText',
    )
);
?>
<div class="search_tag_id">
<?php
echo $this->Form->hidden('sorting_tags..',array('value' => '','class' => 'tag_id'));
?>
</div>
</fieldset></li>
</ul>
</div>



<div class="switch">
    <input type="radio" name="s2" id="on" value="1" checked="">
    <label for="on" class="switch-on"><i class="fa fa-user fa-lg"></i></label>
    <input type="radio" name="s2" id="off" value="0">
    <label for="off" class="switch-off"><i class="fa fa-globe fa-lg"></i></label>
</div>
<?php echo $this->element('accordion/data_strage',array('root_ids' => $id)); ?>

<div class="root">

    	<?php
    	echo $this->element('accordion/table_reply',
    			array('tableresults' => $tableresults,
    					'taghashes'=>$taghash,
    					'currentUserID' => $currentUserID,
    					'srns_code_member'=>$tableresults['srns_code_member']
    					,$sorting_tags
    			)
    	);
    	?>



</div>
<div onClick='toggleShow(this);' >
	add
</div>
<div id='HSfield' style='display: none;'>
	<div id="inputfield">
		 <?php
						  echo $this->element('accordion/nestedinput', array("model" => "Article",
						  		 "currentUserID" => $currentUserID ,"ulist" =>$ulist,"parentID" => $result[$firstModel]['ID']))
						  ?>


	</div>
	</div>
</body>
</html>