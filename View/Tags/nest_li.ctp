<?php
echo $this->Html->script(array('jquery-sortable'.'nest_li'));
?>
 <link href="http://johnny.github.io/jquery-sortable/css/vendor.css" rel="stylesheet">
  <link href="http://johnny.github.io/jquery-sortable/css/application.css" rel="stylesheet">
  <div id="data_store">
  	<input type="hidden" id= "root_ids" value="<?php echo $this->params['pass'][0]; ?>">
  	<input type="hidden" id= "root_ids" value="<?php echo Configure::read("tagID.reply"); ?>">
</div>
<ol ng-app class="default vertical">
 <div ng-repeat=" nest in roots">
              <li >
                Second

                <ol></ol>
              </li>
              </div>
</ol>
            <script>
            function GETarray(obj){
            	console.log($('.default').sortable("toArray").get());
            }
            </script>
    <?php
echo $this->Html->script(array('application'));
echo $this->Form->input("Get_array",array("type" => "button" ,"onClick" => "GETarray(this)"));
?>