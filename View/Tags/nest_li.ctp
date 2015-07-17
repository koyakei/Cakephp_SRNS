
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
	{{leafs.Trilink.LFrom}}
	{{leafs.Trilink.name}}
	<ol id="{{leafs.Trilink.LFrom}}">
		<li>
			<ol>
				<ng-if="leafs.Article.name">
        			{{leafs.Article.name}}
				</ng-if>
				<ng-if="leafs.Tag.name">
					{{leafs.Tag.name}}
				</ng-if>
			</ol>
		</li>
         <ol>
				<div ng-repeat="(index_key, index) in leafs.leaf.indexHashes" >
					<div ng-repeat="leafs in leafs.leaf" ng-if="index_key == leafs.Trilink.LFrom" id=”leafs.Trilink.LFrom”>
						<li ng-include="'tree.html'">
						</li>
					</div>　
				</div>
			</li>
     	</ol>
		</li>
	</ol>


</script>

<ol class="default vertical" ng-controller="NestCtrl" >
	<div ng-repeat="(index_key, index) in roots.indexHashes" >
		<div ng-repeat="leafs in roots" ng-if="index_key == leafs.Trilink.LFrom" id=”leafs.Trilink.LFrom”>
			<li   ng-include="'tree.html'"></li>
		</div>　
	</div>
</ol>
<ol class="default vertical ng-scope" id="test"ng-controller="NestCtrl">
	<!-- ngRepeat: (index_key, index) in roots.indexHashes --><div ng-repeat="(index_key, index) in roots.indexHashes" class="ng-scope">
		<!-- ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><div ng-repeat="leafs in roots" ng-if="index_key == leafs.Trilink.LFrom" id="”leafs.Trilink.LFrom”" class="ng-scope">
			<!-- ngInclude: 'tree.html' -->
		</div><!-- end ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><div ng-repeat="leafs in roots" ng-if="index_key == leafs.Trilink.LFrom" id="”leafs.Trilink.LFrom”" class="ng-scope">
			<!-- ngInclude: 'tree.html' -->
		</div><!-- end ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots -->　
	</div><!-- end ngRepeat: (index_key, index) in roots.indexHashes --><div ng-repeat="(index_key, index) in roots.indexHashes" class="ng-scope">
		<!-- ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots --><!-- ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in roots -->　
	</div><!-- end ngRepeat: (index_key, index) in roots.indexHashes -->
<li ><span class="ng-scope ng-binding">
	2138
	Reply
	</span><ol id="2138" class="ng-scope">
		<li>
			<ol>
				<ng-if="leafs.article.name" class="ng-binding">
        			なぜ間違っているのか考える。

				<ng-if="leafs.tag.name" class="ng-binding">


			</ng-if="leafs.tag.name"></ng-if="leafs.article.name">
<!-- 			<li class="ng-scope"><span class="ng-scope ng-binding"> -->
			<h2>
	2138
	Reply
	</h2>
	</span><ol id="2138" class="ng-scope">

<!--          <ol> -->


<!--      	</ol> -->

	<li>
			<ol>
				<ng-if="leafs.article.name" class="ng-binding">
        			衰退のみを優先することの利点がない。

				<ng-if="leafs.tag.name" class="ng-binding">


			</ng-if="leafs.tag.name"></ng-if="leafs.article.name"></ol>
		</li></ol>


</li></ol>
<!-- 		</li> -->
		<li class="">
			<ol>
				<ng-if="leafs.article.name" class="ng-binding">
        			命を誕生させ育てることが絶対善でない。

				<ng-if="leafs.tag.name" class="ng-binding">


			</ng-if="leafs.tag.name"></ng-if="leafs.article.name"></ol>
		</li>
         <ol>
				<!-- ngRepeat: (index_key, index) in leafs.leaf.indexHashes --><div ng-repeat="(index_key, index) in leafs.leaf.indexHashes" class="ng-scope">
					<!-- ngRepeat: leafs in leafs.leaf --><!-- ngIf: index_key == leafs.Trilink.LFrom --><div ng-repeat="leafs in leafs.leaf" ng-if="index_key == leafs.Trilink.LFrom" id="”leafs.Trilink.LFrom”" class="ng-scope">
						<!-- ngInclude: 'tree.html' -->
					</div><!-- end ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in leafs.leaf --><!-- ngIf: index_key == leafs.Trilink.LFrom --><!-- end ngRepeat: leafs in leafs.leaf -->　
				</div><!-- end ngRepeat: (index_key, index) in leafs.leaf.indexHashes -->

     	</ol>

	</ol>


</li><li ng-include="'tree.html'" class="ng-scope"><span class="ng-scope ng-binding">
	2138
	Reply
	</span><ol id="2138" class="ng-scope">

         <ol>
				<!-- ngRepeat: (index_key, index) in leafs.leaf.indexHashes -->

     	</ol>

	</ol>


</li></ol>
            <script>
            function GETarray(obj){
            	console.log($('.default').sortable("toArray").get());
            }
            </script>
<!--             headdingのアイディアでも考えよう -->

    <?php
echo $this->Html->script(array('application'));
echo $this->Form->input("Get_array",array("type" => "button" ,"onClick" => "GETarray(this)"));
?>