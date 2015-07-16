function NestCtrl($scope) {
	//ロードした瞬間に取ってくる
	 $.ajax({
			url:location.origin +"/cakephp/tags/ajaxList",
			data:{
				root_ids: $("#data_store #root_ids").val(),
				trikey: $("#data_store #trikey").val(),
			},
			type:"GET",
			dataType:"JSON",
			success: function(data){
				$scope.$apply(function(){$scope.roots = data;});
			}
	 });

//	 $scope.$apply(function(){
//		 for(node in $scompe.roots){
//			 if(Array_search(node.Trilink.LFrom,index)
//		 }
//	 });
}