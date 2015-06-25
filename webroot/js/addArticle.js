function ArticleCtrl($scope) {
    	  $scope.primes = [
    	    {text:'AngularJSの学習', done:true},
    	    {text:'AngularJSのアプリケーション構築', done:false}
    	    ];

    	  $scope.separeteds =[
    	                     ];
    	  $scope.addArticle = function(obj) {
    		  var data =[];
    		  $.ajax({
    				url:"ajaxAdd",
    				data:{
    					Article:{
	    					name:$scope.name,
	    					user_id: $scope.user_id,
	    					auth: $scope.auth,
    				},
    					rTag_ids:$scope.rTag_ids
    				},
    				type:"GET",
    				dataType:"JSON",
    				success: function(data){
    					var id =data["id"];
    					if(id){
$scope.primes.push({id:id,text:$scope.name, done:false,
    	    	    	RTags:data["rTags"]
    	    	    		});
    					}else{
    						alert("add failed");
    					}
    					$scope.name = '';
    				}

    			}
    		  );

    	  };
    	  $scope.addRTag = function(){
    		  var articles = $scope.prime;
//    		  こっちで分解するのは面倒なので　phpで分解
//    		  articles.forEach(element,index,array
//    				){
//    			  sortingTags["rTag"]
//    			  unset
//    		  }
    		  angular.forEach(articles,function(article){
    			  $.ajax({
      				url:"ajaxRTagAdd",
      				data:{
      					articles:prime,//entity ids
  	   					user_id: $scope.user_id, //current user id
  	   					rTagIds: $scope.rTagId, // array or int rTagId
      				},
      				type:"GET",
      				dataType:"JSON",
      				success: function(data){
      					var id =data["id"];
      					if(id){
  $scope.primes.push({id:id,text:$scope.name, done:false,
      	    	    	sortingTags:data["rTags"]
      	    	    		});
      					}else{
      						alert("add failed");
      					}
      					$scope.name = '';
      				}

      			}
      		  );
    		  })
    	  };
    	  $scope.remaining = function() {
    	    var count = 0;
    	    angular.forEach($scope.primes, function(prime) {
    	      count += prime.done ? 0 : 1;
    	    });
    	    return count;
    	  };
    	  $scope.archive = function() {
    	    var oldprimes = $scope.primes;
    	    $scope.primes = [];
    	    angular.forEach(oldprimes, function(prime) {
    	      if (!prime.done) $scope.primes.push(prime);
    	    });
    	  };
    	  $scope.separate =function(){
    		  	$scope.separeteds.push({htmls:$scope.primes});
    		  	$scope.primes = [];
    	  }
    	  $scope.addRecStag = function(){
    		  angular.forEach($scope.primes, function(prime) {
        	      count += prime.done ? 0 : 1;
        	    });
    	  }

 }