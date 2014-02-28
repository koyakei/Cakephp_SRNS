
			<?php echo $this->Form->input('keyid', array(
			'type' => 'select',
			'multiple'=> false,
			'options' => $keylist,
			'selected' => $_SESSION['selected']//$this->Session->read('selected')  // ・ｽK・ｽ・ｽl・ｽﾍ、value・ｽ・ｽz・ｽ・ｽﾉゑｿｽ・ｽ・ｽ・ｽ・ｽ・ｽ・ｽ
			)); ?>
			