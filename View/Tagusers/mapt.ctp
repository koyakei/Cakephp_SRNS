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
$(document).ready(function(){

	$('input:button').click(function(){
		//alert('test1');
		$.getJSON('/cakephp/tagusers/map?id=<?php echo $id; ?>',
			null,//{ id: <?php echo $id; ?> },
			function(obj) {
				if(obj !== null) {
					nodes[idx] = [];
					edges[idx] = [];
					//alert(obj);
					list = obj["Article"];
					for (var i = 0; i < list.length; i++) {
						var item = list[i];
						var aId = item["Article"]["ID"];
						var aName = item["Article"]["name"];
						var lId = item["Link"]["ID"];
						var lLFrom = item["Link"]["LFrom"];
						var lLTo = item["Link"]["LTo"];
						var tName = item["taglink"]["name"];
						//nodes[idx].push({ id: <?php echo $id; ?>, label: "管理者" });
						nodes[idx].push({ id: aId, label: aName });

						var isFrom = true;
						for (var j = 0; j < nodes[idx].length; j++) {
							if (nodes[idx][j]["id"] == lLFrom) isFrom = false;
						}
						if (isFrom) nodes[idx].push({ id: lLFrom, label:tName });

						var isTo = true;
						for (var j = 0; j < nodes[idx].length; j++) {
							if (nodes[idx][j]["id"] == lLTo) isTo = false;
						}
 						if (isTo) nodes[idx].push({ id: lLTo, label:tName });
						edges[idx].push({ id: lId, from: lLFrom, to: lLTo, label: tName, style: 'line', length: Math.random()*200+40 });
						//edges[idx].push({ from: lLFrom, to: lLTo });
					}

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
					graph.on('select', function(properties) {
    				document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties) + '<br>';
    				getInfo(JSON.stringify(properties)['nodes'])
  });

				}
			}
		);
	});
}
		);

</script>
</body>