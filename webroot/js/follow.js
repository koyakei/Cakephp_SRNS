/**
 * element follow button
 * @param obj this
 * @param target_id string
 * @param user_id  string
 * @var follow bool
 */
function follow(obj,target_id,user_id){
	$obj = $(obj);
	var follow = ($obj.val() == "follow");
	$.ajax({
		url:location.origin +"/cakephp/tags/follow_unfollow",
		data:{
			follow: follow,
			target_id: target_id,
			user_id: user_id,
		},
		type:"GET",
		dataType:"JSON",
		success:function(data){
			if(data){
				$obj.val("unfollow");
				$obj.html("unfollow");
			}else{
				$obj.val("follow");
				$obj.html("follow");
			}
		}
	});

}