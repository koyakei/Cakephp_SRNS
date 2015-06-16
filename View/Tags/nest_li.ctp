<?php
echo $this->Html->script(array('jquery-sortable'));
?>
 <link href="http://johnny.github.io/jquery-sortable/css/vendor.css" rel="stylesheet">
    <link href="http://johnny.github.io/jquery-sortable/css/application.css" rel="stylesheet">

<ol class="default vertical">

              <li>
                Second
                <ol></ol>
              </li>
              <li>
                Third
                <ol>
                  <li class="">Second</li><li class="">
                First
                <ol></ol>
              </li><li class="">Second</li><li>First</li>

                  <li>
                    Third
                    <ol>
                      <li>First</li>

                    </ol>
                    <ol>
                      <li>First</li>
                      <li>Second</li>
                    </ol>
                  </li>
                </ol>
              </li>
              <li>Fourth</li>
              <li>Fifth</li>
              <li>Sixth</li>
            </ol>

    <?php
echo $this->Html->script(array('application'));
?>
