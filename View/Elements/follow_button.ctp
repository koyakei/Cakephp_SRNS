<?php if ($data["follow"]):?>
	<?php $title = "unfollow";
	else:
	$title = "follow";
	?>
    <?php endif;?>
    <?php echo $this->Form->button($title,array("value"=>  $title,"onClick" => "follow(this,'".$data["id"]."',
	  '".AuthComponent::user('id')."')"))?>