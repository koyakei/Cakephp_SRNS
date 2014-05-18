
<script>
function genTable(json) {
  var data = json['Test'];
  var thead = '';
  var th = '';
  var tbody = '';
  var td = '';
  for (var i = 0; i < data.length; i++) {
    var data2 = data[i];
    var key;
    td = '';
    for (key in data2) {
      //alert(key + "=" + data2[key]);
      td += '<td>' + data2[key] + '</td>';
      th += '<th>' + key + '</th>';
    }
    if (thead == '') thead += '<tr>' + th + '</tr>';
    tbody += '<tr>' + td + '</tr>';
  }
  var table = document.getElementById('table');
  table.innerHTML = '<table><thead>' + thead + '</thead><tbody>' + tbody + '</tbody></table>';
}
</script>

<div id="table"></div>
<input type="button" value="テーブル生成" onclick='genTable({"Test":[{Id:1,Data:"foo"}, {Id:2,Data:"bar"}, {Id:3,Data:"piyo"}]});' />
