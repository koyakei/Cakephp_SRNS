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
	    $(function() {

	    	$(".myTable").draggable(
	    			{helper: "clone",}
	    			);

	    	$( ".droppable" ).droppable({
	    		accept : ".myTable" , // 受け入れる要素を指定
	    		drop : function(event , ui){
	    			$(this).append(ui.draggable);
	    			demand(ui.draggable)
	    		}

	    	});
	    });
});
/**
 *
 * @param that  <tr = parent<td = parent><input>that </input></td>
 */
function demand(that){
	var root_ids = $(".data_strage #root_ids").val();
	var trikey_ids = $(".data_strage #trikey_ids").val();
	$.ajax({
		url:"tags/nestedAdd",
		//cilant でテーブル全体を比較して、選択中のtrike root を指定して
		//比較するのか？それとも、phpでやるのか？
		data:{
			child_ids:that,
			root_ids: root_ids,
			trikey_ids: trikey_ids,
			parent_ids :parentIdFinder( root_ids ,that),
		},
		type:"GET",
		dataType:"JSON",
	});
	location.reload();
}

/**
 * root までたどって全部の親となるキーを取得
 * @param root
 * @param that
 */
function parentIdFinder(root,that){
	var parent_ids =[];
	var $that = $(that);
	//一番上まで行ったら？　body まで行ったら＿か
	if($that.closest("tr").find(".id").attr("id") == null){
		return parent_ids;
	}

	do{
		parent_ids.push($that.closest("tr").find(".id").attr("id"));
		if($that.closest("tbody")[0] != null){//tr があれば
			$that = $that.closest("table"); //一つ上のtrまで上がる
		}else{
			return parent_ids;
		}

	}while($that.closest("tr").find(".id").attr("id") != root
			&& $that.closest("tr").find(".id").attr("id") == true)
		//root id と　親id がおなじになるまで。
		return parent_ids;
}


 /**
  *
  * @param data
  *  grab handle for d&d
  */
function GET_table_diff(data){

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
    	url: '/cakephp/tags/GET_reply/' ,
    	dataType: 'html',
    	data: newBaceId,
    	success: function(obj) {
    		//$('#body').innerHtml = all_reply_finder(obj);
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
 * @returns
 */
function addArticle(obj,ctrl,action,id,quantize_id) {
	 var obj = $(obj).parent();
	 var root_ids = obj.parents("#content").find(".data_strage #root_ids").val();
	 var parent_ids = parentIdFinder(root_ids,obj);
	 parent_ids.push(root_ids);
	 var trikeys = ["2138"];
	 if($(".trikeys #trikeys").val()){
		 trikeys.push($(".trikeys #trikeys").val());
	 }
	 var $this = $(this);
	 //代入
	 //traverse して代入
	    $.ajax({
	        type: "GET",
	        url: location.origin +"/cakephp/tags/formAdd",
	        data:{
	        	name: obj.parent().find(".text").find("input").val(),
				root_ids: root_ids,
				trikey_ids: trikeys,
				parent_ids :parent_ids,
				ctrl :ctrl,
				action : action,
				id : id,
				quantize_id:quantize_id
			},
	      success: function(obj){
//	        	$this.find("td .id").append(obj);
//	    	  location.reload();

	        },
	        error:function(){
	        }
	    });
	}



/**
 *タグ追加
 * @param obj
 * @returns 追加されたリンクIDを返す
 */
function add_reply_tag(obj,ctrl,action,id,quantize_id){
	var target = $(obj);
	var root_ids = $(".data_strage #root_ids").val();
	var parent_ids = parentIdFinder(root_ids ,obj);
	var trikeys = ["2138"];
	 if($(".trikeys #trikeys").val()){
		 trikeys.push($(".trikeys #trikeys").val());
	 }
	parent_ids.push(root_ids);
	 $.ajax({
	        type: "GET",
	        url: location.origin +"/cakephp/Links/triLinkAdd",
	        data: {root_ids:root_ids
	        	,to:target.closest("#add_tag").find(".tag_id").val(),
	        	parent_ids:parent_ids,
	        	trikeys:trikeys,
				ctrl :ctrl,
				action : action,
				page_id : id,
				quantize_id:quantize_id,
				},
	    });
//	 location.reload();

}
/**
 * @param array data= {from:id,to:id,trikey_id;int}
 * @returns bool
 */
function triLinker(data){
    // array('cntroller'=>'tagusers' ,'action' => 'addentity') に送る
    // で渡ってくる　trikey も渡せるようにしたい。label の追加が必要だろう。なければreply にするか。
    //Json post を飛ばす。
	 $.ajax({
	        type: "GET",
	        url: location.origin +"/cakephp/Links/triLinkAdd",
	        data:data,
//	      success: function(obj){
////	    	  	callback;
//	        },
//	        error:function(){
//	        	return false;
//	        }
	    });

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