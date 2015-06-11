
<div class="follow">
</div>
<?php if ($data["follow"]):?>
    <br>
  <li><input type="radio" name="follow" value="1" checked onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')">follow</input></li>
	  <li><input type="radio" name="follow" value="0" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')">unfollow</input></li>
	<?php else: ?>
	<br>
  <li><input type="radio" name="follow" value="1" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')">follow</input></li>
	  <li><input type="radio" name="follow" value="0" checked onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')">unfollow</input></li>
    <?php endif;?>