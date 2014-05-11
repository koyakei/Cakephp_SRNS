var idx = 0;
var nodes = [];
var edges = [];
dataManipulation: true,
        onAdd: function(data,callback) {
          var span = document.getElementById('operation');
          var idInput = document.getElementById('node-id');
          var labelInput = document.getElementById('node-label');
          var saveButton = document.getElementById('saveButton');
          var cancelButton = document.getElementById('cancelButton');
          var div = document.getElementById('graph-popUp');
          span.innerHTML = "Add Node";
          idInput.value = data.id;
          labelInput.value = data.label;
          saveButton.onclick = saveData.bind(this,data,callback);
          cancelButton.onclick = clearPopUp.bind();
          div.style.display = 'block';
        }
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
			onConnect: function(data,callback) {
				callback(data);
			}
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
				var container = document.getElementById('mygraph');
			    var data = {
			        nodes: nodes,
			        edges: edges
			      };
			      var options = {
			        edges: {
			          length: 50
			        },
			        stabilize: false,
			        dataManipulation: true,
			        onAdd: function(data,callback) {
			          saveData.bind(this,data,callback);
			          div.style.display = 'block';
			        },
			        onEdit: function(data,callback) {
			          var span = document.getElementById('operation');
			          var idInput = document.getElementById('node-id');
			          var labelInput = document.getElementById('node-label');
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
			          if (data.from == data.to) {
			            var r=confirm("Do you want to connect the node to itself?");
			            if (r==true) {
			              callback(data);
			            }
			          }
			          else {
			            callback(data);
			          }
			        }
			      };

				graph = new vis.Graph(container, data, options);
				//select eventlistner from sample code 07 selection
				//cklick で　jsonを取得
				//graph.on('select',function(){checkGet(properties)}
				graph.on('select', function(properties) {
    			document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties['nodes'][0]) + '<br>';
    			getInfo(JSON.stringify(properties['nodes'][0]))

				});
				idx++;
			}
		}
	);
}
graph.on("resize", function(params) {console.log(params.width,params.height)});

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
function checkGet(properties) {
    				document.getElementById('info').innerHTML += 'selection: ' + JSON.stringify(properties) + '<br>';
    				getInfo(JSON.stringify(properties)['nodes'])
  		}

$(document).ready(function(){
getInfo(<?php echo $id; ?>);
	$('input:button').click(getInfo(<?php echo $id; ?>)
			);
}

		);