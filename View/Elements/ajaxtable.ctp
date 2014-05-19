
<script>
function genTable(data) {
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

    if (thead == '')
	thead += '<tr>';
	thead += '<th class="mark">ID</th>
				<th class="mark" style="min-width: 100px;">name </th>
				<th>user_id</th>
				<th class="actions"><?php echo __('Actions'); ?></th>
				<th></th>';
    if($head != null){
    	foreach ($JSON['head'] in hash ){
    		thead += '<th>quant</th>';
    		thead += '<th><?php echo $hash['name']; ?><?php echo $this->Html->link(__('View'), array('controller'=> "tags",'action' => 'view', $hash['ID'])); ?></th>';
     	}
    }
    thead += '</tr>';

  }
  var table = document.getElementById('table');
  table.innerHTML = '<table><thead>' + thead + '</thead><tbody>' + tbody + '</tbody></table>';
}
</script>

<div id="table"></div>
<input type="button" value="テーブル生成" onclick='genTable({"Test":[{Id:1,Data:"foo"}, {Id:2,Data:"bar"}, {Id:3,Data:"piyo"}]});' />
