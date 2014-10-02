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
            },
        dataType: "html"
        });

    });

});
//構成を変えたディレクトリを渡すと　整形してくれる関数

//data ==
//var test_non_nest_data = JSON[0]{
//	Columuns: string_data
//
//	};
function nester(data){
	var val = null;
	for(val in data){
		val['ID'];
	}
}
function child_nester(data){
	for(val in val['child']){

	}
}
/**
 *
 * @param obj
 * @returns
 */
	function addArticle(obj) {

	 var inputData = obj.parentNode.children;
	 var parent = null;
	 if(parent.parentNode.parentNode.parentNode.$(".tag_id_for_reply").checked){
	    try{
	    	parent = parent.parentNode.parentNode.parentNode.$(".tag_id_for_reply").checked;
	    	$.ajax({
		        type: "POST",
		        url: "cakephp/tags/ajaxInput.php",
		        data:inputData,
		       /** success: function(){
		        	return true;
		        },
		        error:function(){
		        	return false;
		        }**/
		    });
	    	}
	    catch(Exception){                           /* Exception例外クラス */
            return true;                      /* スタックトレースの出力 */
        }
	    for(from_id in obj){

	    }
	 }
	}
/**
 *
 * @param data
 * @returns
 */
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
 *
 * @param obj
 * @returns 追加されたリンクIDを返す
 */
function add_single_tag(obj){
	var target = obj.parentNode.children;
	var data = {
			from:target.$("#from_id"),
			to:target.$("#tag_id"),
			trikey_id: target.$("#trikey_id"),
			};
	triLinker(data,callbaack);
}
/**
 * @param array data= {from:id,to:id,trikey_id;int}
 * @returns bool
 */
function triLinker(data,callback){
    // array('cntroller'=>'tagusers' ,'action' => 'addentity') に送る
    // で渡ってくる　trikey も渡せるようにしたい。label の追加が必要だろう。なければreply にするか。
    //Json post を飛ばす。
    $.getJSON(
    		'/cakephp/Link/addTriLink',
    		data,
    	function(res){// 追加できたら、ture を返してみようか。　権限がなくてできませんもあり得るから、なんとも言えんがね。
            if(res !== null) {
                 data.id = res;
                 callback(data);
            }
    	}
    );

  }

function deleteLink(data,callback) {
    ajaxDelEdge['id'] = data['edges']['0'];
    	$.ajax({
	url: '/cakephp/links/edgedel?id='+ data['edges']['0'],
	dataType: 'json',
	success: function(obj) {

		callback(data);
	}
    	});
}
/**
 * GET_FT method
 *
 * @parm data  array[n] = int ID
 * @return array
 * From To関係
 */

function GET_FT(data){

}