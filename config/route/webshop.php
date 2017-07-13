<?php

$app->router->add(
    "webshop/**",
    function () use ($app) {


        if (!$app->session->get('user_name')) {
            $message = "<div class='container'><p>Du måste logga in för att kunna se sidan.</p>";

            header("refresh:5;url=login");
            echo $message;
            echo '<p>You\'ll be redirected in about 5 secs. If not, click <a href="login">here</a>.</p>';
            exit;
        }
    }
);

$app->router->add(
    "webshop",
    function () use ($app) {

        $sql = "SELECT * FROM VProduct;";
        $result = $app->db->executeFetchAll($sql);

        $app->renderWebShopPage("Visa alla varor", "webshop/show-all", $result);
    }
);

$app->router->add(
    "webshop/show-all",
    function () use ($app) {

        $sql = "SELECT * FROM VProduct;";
        $result = $app->db->executeFetchAll($sql);

        $app->renderWebShopPage("Visa alla varor", "webshop/show-all", $result);
    }
);

$app->router->add(
    "webshop/create",
    function () use ($app) {

        $app->renderWebShopPage("Skapa produkt", "webshop/create");
    }
);

$app->router->add(
    "webshop/create_offer",
    function () use ($app) {

        $sql = "SELECT * FROM Product";
        $products = $app->db->executeFetchAll($sql);

        if (hasKeyPost("submit")) {
            $name = getPost("product_name");
            $discount = getPost("discount");
            $recommended = getPost("recommended");

            // Get the product's original price
            $sql = "SELECT id, price FROM Product WHERE name LIKE '$name'";
            $res = $app->db->executeFetch($sql);
            $productId = $res->id;
            $price = $res->price;
            $new_price = $price - ($price * $discount / 100);
            $description = getPost("description");
            $sql = "INSERT INTO Offer (name, product, new_price, discount, description)
            VALUES ('$name', $productId, $new_price, $discount, '$description');";
            $app->db->execute($sql);

            // check product as recommended
            if (isset($recommended) && $recommended != 0) {
                $sql = "UPDATE Product SET recommended = $recommended
                WHERE id = $productId";
                $app->db->execute($sql);
            }
        }

            // Check if offer was deleted
        if (hasKeyGet("remove")) {
            $offerId = getGet("remove");
            $sql = "UPDATE Offer
            SET
            deleted = NOW(),
            new_price = NULL
            WHERE id = $offerId";
            $app->db->execute($sql);
        }


        $sql = "SELECT * FROM Offer";
        $offers = $app->db->executeFetchAll($sql);

        $products[0]->offers = $offers;
        $app->renderWebshopPage("Admin", "webshop/create_offer", $products);
        // $app->renderWebshopPage("Admin", "login/create_offer", $products);
    }
);


$app->router->add(
    "webshop/edit",
    function () use ($app) {
        $title = "Redigera produkt";
        $view = "webshop/edit";
        $contentId = getGet("id");

        $sql = "SELECT * FROM Product WHERE id = ?;";
        $result = $app->db->executeFetch($sql, [$contentId]);

        $app->renderWebShopPage($title, $view, $result);
    }
);

$app->router->add(
    "webshop/delete",
    function () use ($app) {
        $title = "Radera produkt";
        $view = "webshop/delete";
        $productId = getGet("id");
        if (!is_numeric($productId)) {
            die("Not valid for product id.");
        }

        if (hasKeyPost("doDelete")) {
            $productId = getPost("productId");

            // Delete connection in table Prod2Cat
            $sql = "DELETE FROM Prod2Cat WHERE prod_id=$productId";
            $app->db->execute($sql);

            // Delete connection in table Inventory
            $sql = "DELETE FROM Inventory WHERE prod_id=$productId";
            $app->db->execute($sql);

            $sql = "DELETE FROM Product WHERE id=?;";
            $app->db->execute($sql, [$productId]);
            header("Location: ../webshop");
            exit;
        }
        $sql = "SELECT id, description FROM Product WHERE id = ?; ";
        $product = $app->db->executeFetch($sql, [$productId]);

        $app->renderWebShopPage($title, $view, $product);
    }
);

$app->router->add(
    "webshop/categories",
    function () use ($app) {

        $app->renderWebShopPage("Skapa kategori", "webshop/categories");
    }
);
