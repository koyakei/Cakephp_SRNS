//$(document).ready(
//function all_search_finder(){
//		var i = null;
//		var Search_conditions = [];
//		var sorting_tags = $(".sorting_tags .search_tag_id .tag_id").val();
//		var trikeys = [];
//		for(i=0;i<=1;i++){
//    		Search_conditions[i] = $(".search_tag_id").children("input[name*='data[or]["+ i +"]']").map(function() { return $(this).val();});
//    	}
//    	$.ajax({
//            type: "GET",
//            url: location.origin +"/cakephp/tags/GET_all_search",
//            data: {searching_tag_ids:[[Search_conditions[0][0],Search_conditions[0][1]],[Search_conditions[1][0],Search_conditions[1][1]]],trikeys : trikeys,sorting_tags : sorting_tags},
//            dataType:'html',
//            success: function(data){
//            	$(".root").html(data);
//            },
//        });
//	}
//)