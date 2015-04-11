//次にやること　var data を array('cntroller'=>'tagusers' ,'action' => 'addentity') に渡して、そっくりそのまま返す。
jQuery.postJSON = function(url, data, callback) {
    jQuery.post(url, data, callback, "json");
};
$.ajaxSetup({
    timeout: 10000
});


$(document).ready(function(){
	var selected_trikey ="";
	    $(".myTable").tablesorter();
	    if(document.getElementById('tag_id') != null){
	        var newTagNodeSubmit = document.getElementById('trikey_submit');
	    	document.getElementById('tag_id').value.onchange = function() {
	    	document.getElementById('spesifiedtrikeylink').innerHTML = '/cakephp/tags/singletrikeytable/<?php echo $idre; ?>/' + document.getElementById('tag_id').value;
	    	};
	    };
	    if(selected_trikey == null ||selected_trikey == "" ){
	    	selected_trikey = "official reply";
	    }
	    $(".selected_trikey").html(selected_trikey);

});
function get_type(thing){
    if(thing===null)return "[object Null]"; // special case
    return Object.prototype.toString.call(thing);
}


/**
 * acordionNester method
 * 構成を変えたディレクトリを渡すと　整形してくれる関数
 * 一度GET_all_replyで出した<table>の各行のIDを再走査してネストして出力するか、
 * これを廃止してSQLで一度にやるのか考える。
 *var test_non_nest_data = JSON[0]{
 *	Columuns: string_data
 * @param array ids 全部のreply id
 *@returns nested html <table></table>
 *ネスト構造を複数のトライキーを持っていないentityについても含めた、
 *そのまま　innerHtml = しても良い状態で返す。
 *
 */
function acordionNester(ids){
	//現在ページに読み込まれているidのリストが渡ってくる
	var val = null;
	var val = null;
	//リストをばらして一つづつネストする対象があるかどうか確かめる
	for(val in ids){
		val['ID'];
		nested = nestExist(val['ID']);
	}
	//複数のネスト対象があった時の処理
	return nested;
}

/**
 * ネストの先が他のトライキーで親から紐付いていることを確認
 * もし存在したら、
 * sfrom_id,  検索キー　search trikey の場合
from_id　trikey で指定されたfrom
, trikey ,
 id , name , mod ,created, auth 以下普通の内容
 のセットで返す。
 * id name tri
 * @param id
 * @returns {bool}
 */
function nestExist(id){
	return bool;
}

var rootWindowId = null; //ルートのターゲットを一意に決める

/**
 * 根本のIDを取ってくる
 * 葉っぱと根本を結ぶとどのReplyIdをエンティティーとともに追加するか
 * わかる
 * @param obj
 */
function getRootId(obj){
	rootWindowId = obj.$("table").id;

}
/*
 * アコーディオンでtrikey の数だけ項目を作る
 * 一つのエンティティに対してどれだけのtrikey の種類がある亜k
 * distinct で絞るview を作る　キーはfrom側のIDにしてリスト形式で出力
 * reply 以外になければreply に返す
 * 重複していれば2つのアコーディオンの中に返す
 * 各retult{"subTrikeyTag"]に持つ
 */
/**
 * 閉じるボタン　onclick で呼ばれる
 * その時に選択されている基底テーブルのIDを同様んでくるのか？
 * それの確保 = storageBaceTableId
 * @param newBaceId
 * @returns {Boolean}
 */
function windowCloser(newBaceId){
//消すときに新しい基底状態のウィンドウがあるか？チェック
	if(is_null(newBaceId)){return false;}
	//結果を返すところは呼ぶところに書いておいた方がいい
	$('#body').innerHtml = all_reply_finder(newBaceId);
}


function all_reply_finder(newBaceId){
	$.ajax({
		type: 'POST',
    	url: '/cakephp/tags/ET_reply/' ,
    	dataType: 'html',
    	data: newBaceId,
    	success: function(obj) {
			callback(data);
		}
	});
}
function child_nester(data){
	for(val in val['child']){

	}
}

/**
 * ネストを開く
 * @param trikey 開くときのトライキー　
 */
function open_nest(trikey){

}
/**
 * 今現在開いているトライキー
 */
function trikey_printer(){

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