<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="all users timeline">
<h2><?php echo __d('users', 'User'); ?></h2>
	<h2><?php echo "My activity"; ?></h2>
	<?php echo $this->element('timeline', Array('socials' => $socials)); ?>
</div>
<?php echo $this->element('Users.Users/sidebar'); ?>