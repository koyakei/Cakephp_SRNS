function NestCtrl($scope) {

//	$scope.$apply(function(){
		$scope.roots =
			//ロードした瞬間に取ってくる
			 $.ajax({
					url:"ajax_list",
					data:{
						root_ids: $(".data_store #root_ids").val(),
						trikey: $(".data_store #trikey").val(),
					},
					type:"GET",
					dataType:"JSON",
//					success: function(data){
	//
//					}
			 });
//	});

}