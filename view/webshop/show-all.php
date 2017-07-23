<div class="container show-all">
    <a href="home">
    <img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
<h1>Visa alla varor</h1>

<?php
if (!$data) {
    return;
}



$result = $data;
// var_dump($result);

?>


<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Namn</th>
        <th>Beskrivning</th>
        <th>Bild</th>
        <th>Kategori</th>
        <th>Pris</th>
        <th>På lager</th>
    </tr>
<?php $id = -1; foreach ($result as $row) :
    $id++;
?>
    <tr>
        <td><?= esc($id); ?></td>
        <td><?= esc($row->id); ?></td>
        <td><?= esc($row->name); ?></td>
        <td><div class="scrollable"><?= esc($row->description); ?></div></td>
        <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"</td>
        <td><?= esc($row->category); ?></td>
        <td><?= esc($row->price); ?></td>
        <td><?= esc($row->items); ?></td>
        <td><a href="webshop/edit?id=<?=$row->id?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="webshop/delete?id=<?=$row->id?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
    </tr>

<?php endforeach; ?>
</table>
