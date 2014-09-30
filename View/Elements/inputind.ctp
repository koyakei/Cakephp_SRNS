<?php echo $this->Form->create($model); ?>
<fieldset>
    		<?php echo $this->element('tablebody',
    	 array('ulist' => $ulist,
    	 'currentUserID'=>$currentUserID,
    	 'model'=>$model,

    	 )); ?>


	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>