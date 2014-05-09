<head>
  <style type="text/css">
    #mygraph {
      width: 400px;
      height: 400px;
      border: 1px solid lightgray;
    }
  </style>
</head>

<body>

<div id="mygraph"></div>
<div id="info"></div>
<input type="button" value="Test" />

<script>
$(document).ready(function(){

var nodes = [];
var edges = [];
$('input:button').click(function(){
 $.getJSON('map/' + '<?php echo $id; ?>',
  null,
  function(obj) {
   if(obj !== null) {
     list = obj["Article"];
     for (var i = 0; i < list.length; i++) {
         var item = list[i];
         var aId = item["Article"]["ID"];
         var aName = item["Article"]["name"];
         var lId = item["Link"]["ID"];
         var lLFrom = item["Link"]["LFrom"];
         var lLTo = item["Link"]["LTo"];
         var tName = item["taglink"]["name"];
         nodes[i] = { ID: aId, label: aName };
         edges[i] = { ID: lId, from: lLFrom, to: lLTo, label: tName, style: 'line' };
     }
     //alert(nodes);
     //alert(edges);
  // create a graph
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
   }
  }
 );
});

</script>
</body>