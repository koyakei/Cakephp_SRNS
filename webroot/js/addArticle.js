function ArticleCtrl($scope) {
    	  $scope.primes = [
      	    {ID:101421,text:"55555",
      	        		"rTags":[{"Tag":{"ID":"1","name":"\u5c0f\u67f3\u572d\u8f14","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"0000-00-00 00:00:00","modified":"2014-05-24 12:00:12","max_quant":"1000","auth":"0","auth_move":"0","auth_delegate":"0"},
      	    	 		"O":{"id":"52f5e533-0280-4b40-878a-0194e0e4e673","username":"koyakei","slug":"koyakei","password":"ab5ff72f7079c49d5846455d13311add05d905e7","password_token":null,"email":"koyakeiaaaaa@hotmail.com","email_verified":true,"email_token":"cv9dmzxlah","email_token_expires":"2014-02-09 17:05:07","tos":true,"active":true,"last_login":"2014-02-09 21:31:26","last_action":null,"is_admin":true,"role":"admin","created":"2014-02-08 17:05:07","modified":"2015-06-23 16:07:51","tlimit":"750","tag_id":"0"},
      	    	 		"Link":{"ID":"2004477","LFrom":"1","LTo":"101445","quant":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"2015-06-26 23:21:45","modified":"2015-06-26 23:21:45","auth":"0","quantize_id":"0"},"taglink":{"name":"Search","tag_user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","tag_modified":"0000-00-00 00:00:00","tag_created":"2013-12-31 14:41:50","quantize_id":"0","ID":"2004478","LFrom":"2146","LTo":"2004477","quant":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"2015-06-26 23:21:45","modified":"2015-06-26 23:21:45","auth":"0"},
      	   			"W":[{"id":"1","entity_id":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"0000-00-00 00:00:00","username":"koyakei"},{"id":"2","entity_id":"1","user_id":"52fdeaea-4364-494d-9005-4796e0e4e673","created":"0000-00-00 00:00:00","username":"bluecrow"}],

      	    	 		},
      	    	 		{"Tag":{"ID":"1","name":"\u5c0f\u67f3\u572d\u8f14","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"0000-00-00 00:00:00","modified":"2014-05-24 12:00:12","max_quant":"1000","auth":"0","auth_move":"0","auth_delegate":"0"},
          	    	 		"O":{"id":"52f5e533-0280-4b40-878a-0194e0e4e673","username":"koyakei","slug":"koyakei","password":"ab5ff72f7079c49d5846455d13311add05d905e7","password_token":null,"email":"koyakeiaaaaa@hotmail.com","email_verified":true,"email_token":"cv9dmzxlah","email_token_expires":"2014-02-09 17:05:07","tos":true,"active":true,"last_login":"2014-02-09 21:31:26","last_action":null,"is_admin":true,"role":"admin","created":"2014-02-08 17:05:07","modified":"2015-06-23 16:07:51","tlimit":"750","tag_id":"0"},
          	    	 		"Link":{"ID":"2004477","LFrom":"1","LTo":"101445","quant":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"2015-06-26 23:21:45","modified":"2015-06-26 23:21:45","auth":"0","quantize_id":"0"},"taglink":{"name":"Search","tag_user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","tag_modified":"0000-00-00 00:00:00","tag_created":"2013-12-31 14:41:50","quantize_id":"0","ID":"2004478","LFrom":"2146","LTo":"2004477","quant":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"2015-06-26 23:21:45","modified":"2015-06-26 23:21:45","auth":"0"},
          	   			"W":[{"id":"1","entity_id":"1","user_id":"52f5e533-0280-4b40-878a-0194e0e4e673","created":"0000-00-00 00:00:00","username":"koyakei"},{"id":"2","entity_id":"1","user_id":"52fdeaea-4364-494d-9005-4796e0e4e673","created":"0000-00-00 00:00:00","username":"bluecrow"}],

          	    	 		}
      	    	 		],

      	 		},
    	    ];

    	  $scope.separeteds =[
    	                     ];
    	  $scope.rDel = function(obj,primeKey,key){
    		  obj.rTag.Link.ID;
    		  $scope.primes[obj.$parent.$index].rTags.splice([obj.$index],1)
//    		  $.ajax({
//  				url:"ajaxRDel",
//  				data:{
//  					linkId: linkId,
//  					userId: $scope.user_id,
//  				},
//  				type:"GET",
//  				dataType:"JSON",
//  				success: function(data){
//  					$scope.primes.indexOf(obj);
//  				}
//  			}
//  		  );
    	  }

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
    					rTag_ids:$("#rTagId").val(),
    				},
    				type:"GET",
    				dataType:"JSON",
    				success: function(data){
    					var id =data["ID"];
    					if(id){
    							$scope.primes.push.apply({ID:id,text:$scope.name, done:false,
    	    	    	rTags:data["rTags"]
    	    	    		});
    					}else{
    						alert("add failed");
    					}
    					$scope.name = '';
    				}
    			}
    		  );
    	  };
    	  $scope.addRTag = function(obj){
    		  var articles = $scope.primes;
    			  $.ajax({
      				url:"ajaxRTagAdd",
      				data:{
      					articles:articles,//entity ids
  	   					user_id: $scope.user_id, //current user id
  	   					rTagIds: [$("#rTagId").val()], // array or int rTagId
      				},
      				type:"GET",
      				dataType:"JSON",
      				success: function(data){
      					$scope.primes =data;
      				}

      			}
      		  );

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