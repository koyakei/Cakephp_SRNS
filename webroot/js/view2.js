//次にやること　var data を array('cntroller'=>'tagusers' ,'action' => 'addentity') に渡して、そっくりそのまま返す。
jQuery.postJSON = function(url, data, callback) {
    jQuery.post(url, data, callback, "json");
};
$.ajaxSetup({
    timeout: 10000
});
/**
 *
 */
var search_tag_id_fields = $(".search_tag_id").children(".tag_id");
var tag = 'autoCompleteDiv';
function all_reply_finder(){
	var Search_conditions = null;
	var i = null;
	for(i = 0; i < 1; i = i +1){
    	$.each(search_tag_id_fields("data[or" + i +"][]")
    			, function(k){ Search_conditions["Searching"]["tags"]["or" + i][k] = each_or_id.value;});
	}
    $.ajax({
        type: "POST",
        url: "cakephp/tags/GET_all_reply.php",
        data:
        	Search_conditions,
        success: function(data){
        		//帰ってきたデータでリプライをテーブルに流す
        	//期待する戻り値
        	//
        	$(".body").textContent = nester(data);
        	//ただ入れるだけが一番楽
        },
    dataType: "html",
    });
};
$(document).ready(function(){
	    $(".myTable").tablesorter();
	    if(document.getElementById('tag_id') != null){
	        var newTagNodeSubmit = document.getElementById('trikey_submit');
	    	document.getElementById('tag_id').value.onchange = function() {
	    	document.getElementById('spesifiedtrikeylink').innerHTML = '/cakephp/tags/singletrikeytable/<?php echo $idre; ?>/' + document.getElementById('tag_id').value;
	    	}
	    };


	}



);




/**
 * 構成を変えたディレクトリを渡すと　整形してくれる関数
 *var test_non_nest_data = JSON[0]{
 *	Columuns: string_data
 */
function nester(data){
	var val = null;
	for(val in data){
		val['ID'];
	}
	return nested;
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
	 var name = obj.parantNode.$(".reply_article_name")[0].value;
	 var reply_ids = null;
	 //代入
	 obj = obj.$closet.$("tr");
	 array_make_reply_ids(obj,reply_ids);
	 //traverse して代入

	    $.ajax({
	        type: "POST",
	        url: "cakephp/articles/addArticles.php",
	        data:inputData,
	       /** success: function(){
	        	return true;
	        },
	        error:function(){
	        	return false;
	        }**/
	    });
	}

	function array_make_reply_ids(obj,reply_ids){
		try{
			if($(".tag_id_for_reply")[0].checked == false){
				throw "Exception";
			}
	    	//その起点から　id を取得
	    	reply_ids = reply_ids.push(obj.$(".tag_id_for_reply")[0].value);

	    	//一番近い祖先の<tr>を起点に定める
	    	obj = obj.$closet("tr");
	    	array_makey_reply_ids(obj,reply_ids);
	    	}
	    catch(Exception){
	    	return reply_ids;
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