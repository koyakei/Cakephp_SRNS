
<div class="follow">
</div>
<?php if ($data["follow"]):?>
    <br>
	  <li><input type="button" name="0" value="unfollow" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')"></li>
	<?php else: ?>
	<br>
  <li><input type="button" name="1" value="follow" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>' )"></li>
    <?php endif;?>