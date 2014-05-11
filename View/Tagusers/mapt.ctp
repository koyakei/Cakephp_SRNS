<head>
<style type="text/css">
#mygraph {
width: 100%;
height: 600px;
border: 1px solid lightgray;
}
</style>
</head>

<body>

<div id="mygraph"></div>
<div id="info"></div>
<input type="button" value="Test" />

<script>
var idx = 0;
var nodes = [];
var edges = [];

/* function
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
		//nodes[idx].push({ id: <?php echo $id; ?>, label: "管理者" });

		var isExists = false;
		for (var j = 0; j < nodes[idx].length; j++) {
			if (nodes[idx][j]["id"] == aId) isExists = true;
		}
		if (!isExists) {
			//alert('aId=' + aId + ' lId=' + lId + ' aName=' + aName + ' lLFrom=' + lLFrom + ' lLTo=' + lLTo);
			nodes[idx].push({ id: aId, label: aName, color:option });
		}

		var isFrom = false;
		for (var j = 0; j < nodes[idx].length; j++) {
			if (nodes[idx][j]["id"] == lLFrom) isFrom = true;
		}
		if (!isFrom) {
			nodes[idx].push({ id: lLFrom, label:tName, color:option });
		}

		var isTo = false;
		for (var j = 0; j < nodes[idx].length; j++) {
			if (nodes[idx][j]["id"] == lLTo) isTo = true;
		}
		if (!isTo) {
			nodes[idx].push({ id: lLTo, label:tName, color:option });
		}

		var isEdge = false;
		for (var j = 0; j < edges[idx].length; j++) {
			if (edges[idx][j]["id"] == lId) isEdge = true;
		}
		if (!isEdge) {
			edges[idx].push({ id: lId, from: lLFrom, to: lLTo, label: tName, style: 'line', length: Math.random()*200+40 });
		}
		//edges[idx].push({ from: lLFrom, to: lLTo });
	}
}
function getInfo(id){
	$.getJSON('/cakephp/tagusers/map?id='+ id,
		null,//{ id: <?php echo $id; ?> },
		function(obj) {
			if(obj !== null) {
				nodes[idx] = [];
				edges[idx] = [];
				addNodes(obj, "Article");
				addNodes(obj, "Tag", "#FF6666");

				var container = document.getElementById('mygraph');
				var data = {
					nodes: nodes[idx],
					edges: edges[idx]
				};
				var options = {
					nodes: {
						shape: 'box'
					}
				};
				graph = new vis.Graph(container, data, options);
				//select eventlistner from sample code 07 selection
				//cklick で　jsonを取得
				//graph.on('select',function(){checkGet(properties)}
				graph.on('select', function(properties) {
    			document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties['nodes']) + '<br>';
    			getInfo(JSON.stringify(properties['nodes'][0]))

				});
				idx++;
			}
		}
	);
}
function checkGet(properties) {
    				document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties) + '<br>';
    				getInfo(JSON.stringify(properties)['nodes'])
  		}

$(document).ready(function(){

	$('input:button').click(getInfo(<?php echo $id; ?>)
			);
}
		);

</script>
</body>