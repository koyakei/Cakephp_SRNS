<head>
<style type="text/css">
#mygraph {
	width: 800px;
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
var nodes = [];
var edges = [];
$(document).ready(function(){

	$('input:button').click(function(){
		//alert('test1');
		$.getJSON('map?id=<?php echo $id; ?>',
			null,
			function(obj) {
				if(obj !== null) {
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
						nodes.push({ id: <?php echo $id; ?>, label: "管理者" });
						nodes.push({ id: aId, label: aName });

						var isFrom = true;
						for (var j = 0; j < nodes.length; j++) {
							if (nodes[j]["id"] == lLFrom) isFrom = false;
						}
						if (isFrom) nodes.push({ id: lLFrom, label:tName });

						var isTo = true;
						for (var j = 0; j < nodes.length; j++) {
							if (nodes[j]["id"] == lLTo) isTo = false;
						}
 						if (isTo) nodes.push({ id: lLTo, label:tName });
						edges.push({ id: lId, from: lLFrom, to: lLTo, label: tName, style: 'line' });
						edges.push({ from: lLFrom, to: lLTo });
					}

					var container = document.getElementById('mygraph');
					var data = {
							nodes: nodes,
							edges: edges
					};
					var options = {
						nodes: {
							shape: 'box'
						}
					};
					graph = new vis.Graph(container, data, options);
					//select eventlistner from sample code 07 selection
					graph.on('select', function(properties) {
    				document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties) + '<br>';
  });

				}
			}
		);
	});
}
		);

</script>
</body>