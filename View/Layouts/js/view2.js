//次にやること　var data を array('cntroller'=>'tagusers' ,'action' => 'addentity') に渡して、そっくりそのまま返す。
jQuery.postJSON = function(url, data, callback) {
    jQuery.post(url, data, callback, "json");
};
$.ajaxSetup({
    timeout: 10000
});


$(function() {

    $(".Search").change(function(){
    	var Search_conditions = null;
    	var i = null;
    	for(i = 0; i < 1; i = i +1){
	    	$.each(document.getElementsByName("data[or" + i +"][]")
	    			, function(k){ Search_conditions["Searching"]["tags"]["or" + i][k] = each_or_id.value;});
    	}
        $.ajax({
            type: "POST",
            url: "cakephp/tags/get_all_reply.php",
            data:
            	Search_conditions

            ,
            success: function(data){
            		//帰ってきたデータでリプライをテーブルに流す
            	//期待する戻り値
            	//
            	$(".body").textContent = nester(data);
            	//ただ入れるだけが一番楽
            }
        });

    });

});
//構成を変えたディレクトリを渡すと　整形してくれる関数

//data ==
var test_non_nest_data = JSON[0]{
	Columuns: string_data

	};
function nester(data){
	var val = null;
	for(val in data){
		val['ID']

	}
}
function child_nester(data){
	for(val in val['child']){

	}
}
//JSON を投げてPHPでHTMLにしてもらう
function table_perser(data){
	$.ajax({
        type: "POST",
        url: "cakephp/tags/table_perser.php",
        data:data,
        success: function(data){
        	return data;
        }
    });
}

/**
 * GET_FT method
 *
 * @parm
 * @return From To
 */

function GET_FT(data){

}