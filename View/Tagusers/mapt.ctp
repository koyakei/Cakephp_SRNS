<input type="button" value="Test" />

<script>
$(document).ready(function(){

$('input:button').click(function(){
 $.getJSON('map/' + '<?php echo $id; ?>',
  null,
  function(obj) {
   if(obj !== null) {
    alert(obj["Article"]);
   }
  }
 );
});
nodes = [];
edges = [];
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
alert(nodes);
alert(edges);
</script>