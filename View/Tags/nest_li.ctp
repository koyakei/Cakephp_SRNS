
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular.min.js"></script>
<!--     <script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.10.0/angular-material.min.js"></script> -->
 <link href="http://johnny.github.io/jquery-sortable/css/vendor.css" rel="stylesheet">
  <link href="http://johnny.github.io/jquery-sortable/css/application.css" rel="stylesheet">
  <?php
echo $this->Html->script(array('jquery-sortable','nest_li'));
?>
  <div id="data_store">
  	<input type="hidden" id= "root_ids" value="<?php echo $this->params['pass'][0]; ?>">
  	<input type="hidden" id= "trikey" value="<?php echo Configure::read("tagID.reply"); ?>">
</div>
<div ng-app >
<script type="text/ng-template" id="tree.html">

	<ol>
		<ng-if="leafs.Article.name">
        {{leafs.Article.name}}
		</ng-if>
		<ng-if="leafs.Tag.name">
		{{leafs.Tag.name}}
		</ng-if>
         <ol>
			<li ng-if="leafs" ng-repeat="leafs in leafs.leaf" ng-include="'tree.html'">
			</li>
     	</ol>
	</ol>
</script>

<ol class="default vertical" ng-controller="NestCtrl" >
<li ng-repeat="leafs in roots" ng-include="'tree.html'">

</li>
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