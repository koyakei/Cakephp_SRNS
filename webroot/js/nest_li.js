function NestCtrl($scope) {
	$scope.root =
		//ロードした瞬間に取ってくる
		 $.ajax({
				url:"ajaxRDel",
				data:{
					id: 1,
//					trikey: null
				},
				type:"GET",
				dataType:"JSON",
				success: function(data){

				}
		 });


}