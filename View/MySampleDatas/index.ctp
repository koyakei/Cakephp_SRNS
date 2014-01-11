<h1>Index Page</h1>
<p>MySampleData Index View.</p>
<table>
<?php
print_r ($datas);
?>
<?php foreach ($datas as $data): ?>
  <tr>
    <td><?php echo $data['MySampleData']['name']; ?></td>
    <td><?php echo $data['MySampleData']['mail']; ?></td>
    <td><?php echo $data['MySampleData']['tel']; ?></td>
  </tr>
<?php endforeach; ?>
</table>