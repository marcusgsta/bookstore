<div class="container show-all">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<img src="image/books_logo.png?w=200" alt="Böcker" class="left">

<h1>Alla produkter</h1>
<?php
$search = isset($_GET['search']) ? htmlentities($_GET['search']) : "";

if ($search != "") {
    $search_results = $app->admin->searchProducts($search);
}

?>
<form class="" action="" method="get">

    <!-- <label for="search">Sök produkt (% = wildcard): -->
    <input type="text" name="search" value="">
    <!-- </label> -->
    <input type="submit" name="submit" value="Sök produkt">

    <?php $defaultRoute = "?route=show-all-sort&" ?>
    <?php if (isset($search_results) and $search_results != "") :?>
    <table class="admin">
        <th>Namn</th>
        <th>Beskrivning</th>
        <th>Bild</th>
        <th>Kategori</th>
        <th>Pris </th>
        <th>I lager</th>
        <th></th>
    <?php foreach ($search_results as $search_result) : ?>

    <tr>
        <td><?= esc($search_result->name); ?></td>
        <td><?= esc($search_result->description); ?></td>
        <td><img src="image/webshop/<?=esc($search_result->image)?>?w=150" class="productImage" title="Image of <?=esc($search_result->description)?>"></td>
        <td><?= esc($search_result->category); ?></td>
        <td><?= esc($search_result->price); ?></td>
        <td><?= esc($search_result->items); ?></td>
        <td><a href="?add=<?= esc($search_result->id);?>">Lägg till i varukorg</a></td>
    </tr>

    <?php endforeach;?>

    </table>
    <?php endif; ?>


</form>


<?php
if (!$data) {
    return;
}

$result = $data;
// var_dump($result);

?>

<table>
    <tr class="first">
        <th>Namn <?= $app->admin->orderby("name", $defaultRoute) ?></th>
        <th>Beskrivning</th>
        <th>Bild</th>
        <th>Kategori</th>
        <th>Pris <?= $app->admin->orderby("price", $defaultRoute) ?></th>
        <th>På lager</th>
        <th></th>
    </tr>
<?php $id = -1; foreach ($result as $row) :
    $id++;
?>
    <tr>
        <td><?= esc($row->name); ?></td>
        <td><?= esc($row->description); ?></td>
        <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->description)?>"></td>
        <td><?= esc($row->category); ?></td>
        <td><?= esc($row->price); ?></td>
        <td><?= esc($row->items); ?></td>
        <td><a href="?add=<?= esc($row->id);?>">Lägg till i varukorg</a></td>
    </tr>

<?php endforeach; ?>
</table>
