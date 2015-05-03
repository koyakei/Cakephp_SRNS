<ul>
<?php foreach ($trikey_list as $trikey): ?>
		<li  class="trikey" id="<?php echo $trikey['id'] ?>">
		<?php echo $trikey['name'] ?>
		<?php $this->input($trikey['users'] ,array('type' => 'list' ,'class' => 'trikey'))?>
		</li>
<?php endforeach;?>
</ul>