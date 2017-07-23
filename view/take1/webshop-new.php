<div class="container show-all">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<a href="home">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
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
        <td><img src="image/webshop/<?=esc($search_result->image)?>?w=150" class="tableImage" title="Image of <?=esc($search_result->name)?>"></td>
        <td><?= esc($search_result->category); ?></td>
        <td><?php
        $price = isset($search_result->new_price) ? $search_result->new_price . " (<span class='line'>$search_result->price</span>)" : $search_result->price;
        echo $price; ?></td>
        <td><?= esc($search_result->items); ?></td>
        <td><div class="add_to_cart">
            <a href="webshop-new?add=<?= esc($search_result->id);?>">
            <img src="image/webshop/add_to_cart.png?w=40" title="Lägg i varukorg" alt="Lägg i varukorg">
        </a>
    </div></td>
    </tr>

    <?php endforeach;?>

    </table>
    <?php endif; ?>


<?php
if (!$data) {
    return;
}
$result = $data;
$all_categories = $result[0]->all_categories;

$hits = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$min = 0;
?>
<h3>Kategorier</h3>
<form class="" action="" method="get">
    <select name="catId">
        <option value="">Alla kategorier</option>
        <?php foreach ($all_categories as $category) : ?>
        <option value="<?= esc($category->cat_id) ?>"><?= esc($category->category) ?></option>
    <?php endforeach; ?>
    </select>
    <input type="submit" name="" value="Välj">

</form>
<?php
    echo $app->admin->getHitsPerPage(array(2, 4, 8));

?>

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
        <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="tableImage" title="Image of <?=esc($row->name)?>"></td>
        <td><?= esc($row->category); ?></td>
        <td><?php
        $price = isset($row->new_price) ? $row->new_price . " (<span class='line'>$row->price</span>)" : $row->price;
        echo $price; ?></td>
        <td><?= esc($row->items); ?></td>
        <td><div class="add_to_cart">
            <a href="webshop-new?add=<?= esc($row->id);?>">
            <img src="image/webshop/add_to_cart.png?w=40" title="Lägg i varukorg" alt="Lägg i varukorg">
        </a>
    </div></td>
    </tr>

<?php endforeach; ?>
</table>
<?php
$rows = $result[0]->rows;


$max = ceil($rows / $hits);

 echo $app->admin->getPageNavigation($page, $max); ?>
