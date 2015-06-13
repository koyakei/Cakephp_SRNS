function follow(obj,target_id,user_id){
	$obj = $(obj);
	$.ajax({
		url:location.origin +"/cakephp/tags/follow_unfollow",
		data:{
			follow: $obj.val(),
			target_id: target_id,
			user_id: user_id,
		},
		type:"GET",
		dataType:"JSON",
	});
}