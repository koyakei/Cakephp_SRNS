function ArticleCtrl($scope) {
    	  $scope.todos = [
    	    {text:'AngularJSの学習', done:true},
    	    {text:'AngularJSのアプリケーション構築', done:false}
    	    ];

    	  $scope.separeteds =[
    	                     ];
    	  $scope.addArticle = function(obj) {
    		  $.ajax({
    				url:"add",
    				//cilant でテーブル全体を比較して、選択中のtrike root を指定して
    				//比較するのか？それとも、phpでやるのか？
    				data:{Article:{
    					name:$scope.name,
    					user_id: $scope.user_id,
    					auth: $scope.auth,
    					rTag_ids:$scope.rTag_ids
    				}
    				},
    				type:"GET",
    				dataType:"JSON",
    				success: function(data){
    					if(data["id"]){
    						$scope.todos.push({id:data["id"],text:$scope.articleText, done:false,
        		    	    	sortingTags:[{id:$scope.tagId,
        		    	    		name:$scope.tagName}]});
        		    	    $scope.name = '';
    					}else{
    						alert("add failed");
    					}
    				}
    			});

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
    	  $scope.addRecStag = function(){
    		  angular.forEach($scope.todos, function(todo) {
        	      count += todo.done ? 0 : 1;
        	    });
    	  }

 }