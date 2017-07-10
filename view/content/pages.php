<?php
$resultset = $data;
if (!$resultset) {
    return;
}


?>

<div class="container pages">
<h1>Alla sidor</h1>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++;
?>
    <tr>
        <td><?= esc($row->id); ?></td>
        <td><a href="?route=<?=esc($row->path)?>"><?=esc($row->title)?></a></td>
        <td><?= esc($row->type); ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
