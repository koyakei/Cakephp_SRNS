
			<?php echo $this->Form->input('keyid', array(
			'type' => 'select',
			'multiple'=> false,
			'options' => $keylist,
			'selected' => $_SESSION['selected']//$this->Session->read('selected')  // �E�K�E��E�l�E�́Avalue�E��E�z�E��E�ɂ��E��E��E��E��E��E�
			)); ?>
			