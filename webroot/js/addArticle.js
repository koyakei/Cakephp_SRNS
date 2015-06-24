function ArticleCtrl($scope) {
    	  $scope.todos = [
    	    {text:'AngularJSの学習', done:true},
    	    {text:'AngularJSのアプリケーション構築', done:false}
    	    ];

    	  $scope.separeteds =[
    	                     ];
    	  $scope.addArticle = function() {
    	    $scope.todos.push({text:$scope.articleText, done:false,
    	    	sortingTags:[{id:$scope.tagId,
    	    		name:$scope.tagName}]});
    	    $scope.articleText = '';
    	  };
    	  $scope.remaining = function() {
    	    var count = 0;
    	    angular.forEach($scope.todos, function(todo) {
    	      count += todo.done ? 0 : 1;
    	    });
    	    return count;
    	  };
    	  $scope.archive = function() {
    	    var oldTodos = $scope.todos;
    	    $scope.todos = [];
    	    angular.forEach(oldTodos, function(todo) {
    	      if (!todo.done) $scope.todos.push(todo);
    	    });
    	  };
    	  $scope.separate =function(){
    		  	$scope.separeteds.push({htmls:$scope.todos});
    		  	$scope.todos = [];
    	  }
 }