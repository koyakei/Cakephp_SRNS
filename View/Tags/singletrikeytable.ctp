<a name="<?php echo $value['ID'] ?>">
    <h2><?php echo $value['name'] ?></h2>
    <table class="myTable" cellpadding="0" cellspacing="0">
        <?php echo $this->element('tablehead', Array('taghashes'=>$value['head'])); ?>
        <tbody>
        <?php echo $this->element('tablebody', Array('results' => $value['tag'],'taghashes'=>$value['head'],'firstModel' => 'Article','currentUserID' => $currentUserID)); ?>
        <?php echo $this->element('tablebody', Array('results' => $value['article'],'taghashes'=>$value['head'],'firstModel' => 'Tag','currentUserID' => $currentUserID)); ?>
        </tbody>
    </table>
        <?php echo $this->element('inputind', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Article','currentUserID' => $currentUserID,'key' => $value['ID'])); ?>
        <?php echo $this->element('inputind', Array('ulist' => $ulist,'keylist' => $keylist,'selected' => $_SESSION['selected'],'model' => 'Tag','currentUserID' => $currentUserID,'key' => $value['ID'])); ?>
    </a>