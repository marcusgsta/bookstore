<div class="container show-all">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<img src="image/books_logo.png?w=200" alt="Böcker" class="left">

<h1>Produkter</h1>
<?php
$search = isset($_GET['search']) ? htmlentities($_GET['search']) : "";

if ($search != "") {
    $search_results = $app->admin->searchProducts($search);
}

?>
<form class="" action="" method="get">
    <input type="text" name="search" value="">
    <input type="submit" name="submit" value="Sök produkt">
</form>

    <?php $defaultRoute = "?route=show-all-sort&" ?>
    <?php if (isset($search_results) and $search_results != "") :?>
    <table>
        <tr>
        <th>Namn <?= $app->admin->orderby("name", $defaultRoute) ?></th>
        <th>Beskrivning</th>
        <th>Bild</th>
        <th>Kategori</th>
        <th>Pris <?= $app->admin->orderby("price", $defaultRoute) ?></th>
        <th>I lager</th>
        <th></th>
    </tr>
    <?php foreach ($search_results as $search_result) : ?>

    <tr>
        <td class="name"><?= esc($search_result->name); ?></td>
        <td><div class="scrollable"><?= esc($search_result->description); ?></div></td>
        <td><img src="image/webshop/<?=esc($search_result->image)?>?w=150" class="productImage" title="Image of <?=esc($search_result->name)?>"></td>
        <td><?= esc($search_result->category); ?></td>
        <td><?php
        $price = isset($search_result->new_price) ? $search_result->new_price . " (<span class='line'>$search_result->price</span>)" : $search_result->price;
        echo $price; ?></td>
        <td><?= esc($search_result->items); ?></td>
        <td><a href="?add=<?= esc($search_result->id);?>">Lägg till i varukorg</a></td>
    </tr>

    <?php endforeach;?>

    </table>
    <?php endif; ?>


<?php
if (!$data) {
    return;
}
$result = $data;
?>
<h2>Alla produkter</h2>
<table>
    <tr>
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
        <td class="name"><?= esc($row->name); ?></td>
        <td><div class="scrollable"><?= esc($row->description); ?></div></td>
        <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"></td>
        <td><?= esc($row->category); ?></td>
        <td><?php
        $price = isset($row->new_price) ? $row->new_price . " (<span class='line'>$row->price</span>)" : $row->price;
        echo $price; ?></td>
        <td><?= esc($row->items); ?></td>
        <td><a href="?add=<?= esc($row->id);?>">Lägg till i varukorg</a></td>
    </tr>

<?php endforeach; ?>
</table>
