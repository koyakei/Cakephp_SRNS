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
	 //TODO：置き換えロジック
	 //優先trikey が存在しない場合、　indexHasheses を　DECで使用
	 $scope.$apply(function(){
		 for(node in $scompe.roots){
			 if(Array_search(node.Trilink.LFrom,index)){}//同列のノードだったら
			 	node
		 }
	 });
	 // このサンプルの形に完全にノード構造を置き換えるviewでやるのは諦め
	 var node_sample = [
            {"trikey":{"name":"reply","id":1111},
            	"nodes":{"foo":name},

            }
	 ];
}