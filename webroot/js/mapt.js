
//次にやること　var data を array('cntroller'=>'tagusers' ,'action' => 'addentity') に渡して、そっくりそのまま返す。
jQuery.postJSON = function(url, data, callback) {
    jQuery.post(url, data, callback, "json");
};
$.ajaxSetup({
    timeout: 10000
});
var nodes = [];
var edges = [];
var duringManip = false;
var previousNodeId = null;
var options = {
        edges: {
          length: 50,
          style: 'arrow'
        },
        stabilize: false,
        dataManipulation: true,
        onAdd: function(data,callback) {
          var span = document.getElementById('operation');
          var labelInput = document.getElementById('label');
          var saveButton = document.getElementById('saveButton');
          var cancelButton = document.getElementById('cancelButton');
          var div = document.getElementById('graph-popUp');
          span.innerHTML = "Add Node";
          idInput.value = data.id;
          labelInput.value = data.label;
          saveButton.onclick = saveData.bind(this,data,callback);
          cancelButton.onclick = clearPopUp.bind();
          div.style.display = 'block';
        },
        onEdit: function(data,callback) {
          var span = document.getElementById('operation');
          var labelInput = document.getElementById('label');
          var saveButton = document.getElementById('saveButton');
          var cancelButton = document.getElementById('cancelButton');
          var div = document.getElementById('graph-popUp');
          span.innerHTML = "Edit Node";
          idInput.value = data.id;
          labelInput.value = data.label;
          saveButton.onclick = saveData.bind(this,data,callback);
          cancelButton.onclick = clearPopUp.bind();
          div.style.display = 'block';
        },
        onConnect: function(data,callback) {
        duringManip = true;
        var span = document.getElementById('operation');
        var labelInput = document.getElementById('label');
        var saveButton = document.getElementById('saveButton');
        var cancelButton = document.getElementById('cancelButton');
        var div = document.getElementById('graph-popUp');
        span.innerHTML = "Add Edge";
        saveButton.onclick = saveEdgeData.bind(this,data,callback);
        cancelButton.onclick = clearEdgePopUp.bind();
        div.style.display = 'block';
        duringManip = false;
        //idも作ったやつを返したい
        },
        onDelete: function(data,callback) {
        	$.getJSON('/cakephp/tagusers/addentity',data,
        		function(res){// 追加できたら、ture を返してみようか。　権限がなくてできませんもあり得るから、なんとも言えんがね。
                	if(res !== null) {
                    	var result = res["result"];

                    if (result) {

                   	 } else {

                    	}
                	}
        		}
        	)
        }

      };
      //2つの違うツリーを読み込む方法 getJson を別にするselect 以外のタイミングでgetInfoがはりるように
      //いつ走らせたら良いのか？　あのタグに対してリンクを貼りたいな。button-"mapload" をauto suggest付きのinput boxに表示して、
      //それを 送ることでそのタグからのツリーを実行しよう。
      /* function addLinkSQL
 * @object data
 * @string option['color']
 * return added Link info @string //追加に成功したら追加した情報が帰ってくるようにしたい。
 */
      function addLinkSQL(data){

        // array('cntroller'=>'tagusers' ,'action' => 'addentity') に送る
        //data= {from:id,to:id,trikeyname:string} で渡ってくる　trikey も渡せるようにしたい。label の追加が必要だろう。なければreply にするか。
        //Json post を飛ばす。
        $.getJSON('/cakephp/tagusers/addentity',data,
        	function(res){// 追加できたら、ture を返してみようか。　権限がなくてできませんもあり得るから、なんとも言えんがね。
                if(res !== null) {
                    return res;
                }
        	}
        )
        return false;

      }
/* function addNodes
 * @object obj
 * @string entity
 * @string option['color']
 */
function addNodes(obj, entity, option) {
	list = obj[entity];
	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var aId = item[entity]["ID"];
		var aName = item[entity]["name"];
		var lId = item["Link"]["ID"];
		var lLFrom = item["Link"]["LFrom"];
		var lLTo = item["Link"]["LTo"];
		var tName = item["taglink"]["name"];
		//nodes.push({ id: <?php echo $id; ?>, label: "管理者" });

		var isExists = false;
		for (var j = 0; j < nodes.length; j++) {
			if (nodes[j]["id"] == aId) isExists = true;
		}
		if (!isExists) {
			//alert('aId=' + aId + ' lId=' + lId + ' aName=' + aName + ' lLFrom=' + lLFrom + ' lLTo=' + lLTo);
			nodes.push({ id: aId, label: aName, color:option });
		}

		var isFrom = false;
		for (var j = 0; j < nodes.length; j++) {
			if (nodes[j]["id"] == lLFrom) isFrom = true;
		}
		if (!isFrom) {
			nodes.push({ id: lLFrom, label:tName, color:option });
		}

		var isTo = false;
		for (var j = 0; j < nodes.length; j++) {
			if (nodes[j]["id"] == lLTo) isTo = true;
		}
		if (!isTo) {
			nodes.push({ id: lLTo, label:tName, color:option });
		}

		var isEdge = false;
		for (var j = 0; j < edges.length; j++) {
			if (edges[j]["id"] == lId) isEdge = true;
		}
		if (!isEdge) {
			edges.push({ id: lId, from: lLFrom, to: lLTo, label: tName, length: Math.random()*200+40, color: (new jsSHA(tName,'ASCII')).getHash('SHA-384','HEX').substr(1,6) });

		}
		//edges.push({ from: lLFrom, to: lLTo });
	}
}
function getInfo(id){
	$.ajax({
    	url: '/cakephp/tagusers/map?id='+ id,
    	dataType: 'json',
    	success: function(obj) {
			if(obj !== null) {
				addNodes(obj, "Article");
				addNodes(obj, "Tag", "#FF6666");
				var container = document.getElementById('mygraph');
				var data = {
					nodes: nodes,
					edges: edges
				};
				var newTagNodeSubmit = document.getElementById('tag_id_submit')
				var submttingTagID = document.getElementById('tag_id');
				newTagNodeSubmit.onclick = function(){getInfo(submttingTagID.value)};


				graph = new vis.Graph(container, data, options);
				//select eventlistner from sample code 07 selection
				//cklick で　jsonを取得
				//graph.on('select',function(){checkGet(properties)}

				graph.on('select', function(properties) {
					var nodeId = JSON.stringify(properties['nodes'][0]);
	    			if (properties['nodes'][0] != undefined) {
	    				document.getElementById('info').innerHTML += 'selection: ' + nodeId + ' ' + '<a href="/cakephp/' + (properties['nodes'][0] >= 100000 ? 'articles' : 'tags') + '/view/' + properties['nodes'][0] + '" target="_blank">' + properties['nodes'][0] + 'を開く</a>' + '<br>';
	    			}
					if(previousNodeId == properties['nodes'][0]){

	    				if(properties['nodes'][0] != null){
	    					getInfo(nodeId);
	    				}

	    			}
	    			previousNodeId = properties['nodes'][0];
				}
			);
		}

	}
	});
	$.getJSON('/cakephp/tagusers/map?id='+ id,
		null,
		function(obj) {
		}
	)
}
//graph.on("resize", function(params) {console.log(params.width,params.height)});

      function clearPopUp() {
        var saveButton = document.getElementById('saveButton');
        var cancelButton = document.getElementById('cancelButton');
        saveButton.onclick = null;
        cancelButton.onclick = null;
        var div = document.getElementById('graph-popUp');
        div.style.display = 'none';
      }

      function saveData(data,callback) {
        var idInput = document.getElementById('node-id');
        var labelInput = document.getElementById('node-label');
        var div = document.getElementById('graph-popUp');
        data.id = idInput.value;
        data.label = labelInput.value;
        callback(data);
      }
      function clearEdgePopUp() {
        var saveButton = document.getElementById('saveButton');
        var cancelButton = document.getElementById('cancelButton');
        saveButton.onclick = null;
        cancelButton.onclick = null;
        var div = document.getElementById('graph-popUp');
        div.style.display = 'none';
      }

      function saveEdgeData(data,callback) {
        var div = document.getElementById('graph-popUp');
        var labelInput = document.getElementById('label');
        data.label = labelInput.value;
        data.color = (new jsSHA(data.label,'ASCII')).getHash('SHA-384','HEX').substr(1,6);
        data.id = addLinkSQL(data);
		callback(data);
      }

$(document).ready(function(){
getInfo(<?php echo $id; ?>);
	$('input:button').click(getInfo(<?php echo $id; ?>)
			);
}

		);
</script>
</body>