<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<?php echo $this->Html->script(array("addArticle")); ?>


<div ng-app="article">
 <div ng-controller="ArticleController as article">
 <form ng-submit="add()">
		<legend><?php echo __('Add Article'); ?></legend>
	<?php
		echo $this->Form->input('name',array("ng-model" => "name","value" =>""));
	?>
<?php echo $this->Form->input('user_id', array(
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID//['userselected']
	)); ?>

<?php
// echo $this->Form->button(null,
// 		array("class" => "btn-primary" ,"type" => "submit" ,"value" =>""));
//  echo $this->Form->end(__('Submit'),array("class" => "btn-primary" ,"value" =>"")); ?>
  <button class="btn" ng-click="article.add()">add
  </button>
 <p>{{name}}</p>
</form>

<ul class="unstyled">
        <li ng-repeat="todo in todos">
          <input type="checkbox" ng-model="todo.done">
          <span class="done-{{todo.done}}">{{todo.text}}</span>
        </li>
      </ul>
</div>
</div>
    <div ng-init="qty=1;cost=2">
      <b>Invoice:</b>
      <div>
        Quantity: <input type="number" ng-model="qty" required >
      </div>
      <div>
        Costs: <input type="number" ng-model="cost" required >
      </div>
      <div>
        <b>Total:</b> {{qty * cost | currency}}
      </div>
    </div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Articles'),
		 array('action' => 'index',"sort:modified","direction:desc")); ?></li>
	</ul>
</div>
