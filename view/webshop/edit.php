<?php
$product = $data;

$productId = getGet("id");
// $productId = getPost("productId") ?: getGet("id");
if (!is_numeric($productId)) {
    die("Not valid for product id.");
}

// Get categories

$sql = "SELECT * FROM ProdCategory ORDER BY category";
$categories = $app->db->executeFetchAll($sql);

// Build array of category ids


$sql = "SELECT cat_id FROM Prod2Cat WHERE prod_id=$productId";

$cat_ids = $app->db->executeFetchAll($sql);
$cat_array = [];
foreach ($cat_ids as $cat_id) {
    array_push($cat_array, $cat_id->cat_id);
}

// Get inventory, to check how many items there are

   $sql = "SELECT * FROM Inventory WHERE prod_id=$productId";
   $inventory = $app->db->executeFetch($sql);

// Insert into inventory

if (hasKeyPost("productAmount")) {
    $params = getPost([
        "productAmount",
        "productId"
    ]);

    // check to see that amount is a number
    $amount = $params["productAmount"];
    if (!is_numeric($amount)) {
        die("Not valid for product amount.");
    }

    $sql = "UPDATE Inventory SET items=? WHERE prod_id=?";
    // $sql = "INSERT INTO Inventory (prod_id, items) VALUES (?, ?)";
    $app->db->execute($sql, array_values($params));
}


if (hasKeyPost("doSave")) {
    //$params gets all values from getPost()
    $params = getPost([
    "productName",
    "productDescription",
    "productImage",
    "productPrice",
    "productId"
    ]);

    // check to see that amount is a number
    $price = $params["productPrice"];
    if (!is_numeric($price)) {
        die("Not valid for product price.");
    }

    $productId = $params['productId'];

    $sql = "UPDATE Product SET name=?, description=?, image=?, price=? WHERE id = ?;";

    $app->db->execute($sql, array_values($params));


    // Insert a new connection in table Prod2Cat
    if (hasKeyPost("catId")) {
        // Delete old connections in table Prod2Cat
        $sql = "DELETE FROM Prod2Cat WHERE prod_id=$productId";
        $app->db->execute($sql);

        foreach (getPost('catId') as $catId) {
            $sql = "INSERT INTO Prod2Cat (prod_id, cat_id) VALUES ($productId, $catId)";
            $app->db->execute($sql);
        }
    }

    header("Location: edit?id=$product->id");
    exit;
}
?>

<div class="container edit-content">
    <a href="../home">
    <img src="../image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
<h1>Redigera produkt</h1>

<form method="post">
    <fieldset>
    <legend>Redigera</legend>
    <input type="hidden" name="productId" value="<?= esc($product->id) ?>"/>

    <p>
        <label>Namn:<br>
        <input type="text" name="productName" value="<?= isset($product->name) ? esc($product->name) : '' ?>"/>
        </label>
    </p>
    <p>
        <label>Beskrivning:<br>
        <textarea name="productDescription" rows="8" cols="80"><?= isset($product->description) ? esc($product->description) : '' ?></textarea>
        </label>
    </p>

    <p>
        <label>Bild:<br>
        <input type="text" name="productImage" value="<?= isset($product->image) ? esc($product->image) : null ?>"/>
    </p>

    <div class="checkbox">
        <label>Kategori:<br>
            <?php foreach ($categories as $category) :?>
                <div class="left">
            <input type="checkbox" name="catId[]" value="<?=$category->id;?>" <?=in_array($category->id, $cat_array) ? 'checked' : ''?>>
<?=$category->category; ?>
</div>
<?php endforeach;?>

    </div>


    <p>
        <label>Pris:<br>
        <input type="text" name="productPrice" value="<?= isset($product->price) ? esc($product->price) : '' ?>"/>
     </p>
     <p>
         <label>På lager:<br>
         <input type="text" name="productAmount" value="<?= isset($inventory->items) ? esc($inventory->items) : '' ?>"/>
      </p>
    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Spara</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Rensa</button>
        <!-- <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Ta bort</button> -->
    </p>
    </fieldset>
</form>
