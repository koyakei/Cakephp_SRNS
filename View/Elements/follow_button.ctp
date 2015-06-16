

<?php if ($data["follow"]):?>

	  <input type="button" name="0" value="unfollow" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>')">
	<?php else: ?>

  <input type="button" name="1" value="follow" onClick=
	  "follow(this,'<?php echo $data["id"]; ?>',
	  '<?php echo AuthComponent::user('id');?>' )">
    <?php endif;?>