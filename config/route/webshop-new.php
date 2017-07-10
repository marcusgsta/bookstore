<?php
$app->router->add(
    "webshop-new",
    function () use ($app) {
        // Only these values are valid
        $columns = ["name", "price"];
        $orders = ["asc", "desc"];

        $orderBy = getGet("orderby") ?: "name";
        $order = getGet("order") ?: "asc";

        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            die("Not valid input for sorting.");
        }

        $result = $app->admin->showProducts($orderBy, $order);

        // Check to see if a product has been added to cart
        $productId = getGet("add") ?: "";

        if ($productId != "") {
        // if (isset($_GET['add'])) {
            if (!$app->session->has("user_name")) {
                echo "<p>Logga in för att köpa varor.</p>";
            } else {
                $user = $app->session->get("user_name");
                $userId = $app->admin->getUserId($user);

                $cartId = $app->webshop->getCartId($userId);

                // add product to user's cart
                $app->webshop->addToCart($cartId, $productId, 1);
                // unset($app->db);
                // echo "<p>Produkt lades till i varukorg.</p>";
            }
        }

        $app->renderPage("Visa alla varor", "take1/webshop-new", $result);
    }
);

$app->router->add(
    "about",
    function () use ($app) {
        $sql = "SELECT * FROM Content WHERE id = 2";
        $result = $app->db->executeFetch($sql);

        $app->renderPage("Om", "take1/about", $result);
    }
);

$app->router->add(
    "orderhistory",
    function () use ($app) {
        // fixa detta med dir/** istället :

        $userName = $app->session->get('user_name');
        if (!isset($userName)) {
            header('Location: login');
        } else {
            $userId = $app->admin->getUserId($userName);
            // get orderId from userId
            $orderId = $app->webshop->getOrderId($userId);
            // get all orderIds from a userId
            $result = $app->webshop->getOrders($userId);

            $app->renderPage("Orderhistorik", "login/orderhistory", $result);
        }
    }
);

$app->router->add(
    "order",
    function () use ($app) {
        if (!$app->session->has("user_name")) {
            header('Location: login');
        }
        $user = $app->session->get("user_name");
        // get userID from user_name
        $res = $app->admin->search($user);
        $userId = $res[0]->id;

        if (getGet("order_id")) {
            $orderId = getGet("order_id");
        } else {
            // get orderId from userId
            $orderId = $app->webshop->getOrderId($userId);
        }

        // check that orderId is associated to the user

        // $orderId = $orderId;
        $sql = "CALL showUsersOrder($orderId)";

        $result = $app->db->executeFetchAll($sql);

        $app->renderPage("Order", "take1/order", $result);
    }
);

$app->router->add(
    "cart",
    function () use ($app) {
        if (!$app->session->has("user_name")) {
            header('Location: login');
        }
        $user = $app->session->get("user_name");
        // get userID from user_name
        $userId = $app->admin->getUserId($user);

        // Check if order-button is clicked
        if (hasKeyPost("order")) {

            // get cartId from userId
            $cartId = $app->webshop->getCartId($userId);
            $sql = "CALL makeOrder($cartId)";
            $result = $app->db->executeFetch($sql);
            if ($result == true) {
                foreach($result as $res) {
                    echo $res;
                    die;
                }
            } else {
                header('Location: order');
            }
        }

        // check if remove is set, and remove product
        if (isset($_GET['remove'])) {
            // get cartId from userId
            $cartId = $app->webshop->getCartId($userId);

            $app->webshop->removeFromCart($cartId, $_GET['remove']);
        }



        $sql = "CALL showUsersCart($userId);";
        $result = $app->db->executeFetchAll($sql);
        $app->renderPage("Varukorg", "take1/cart", $result);
    }
);


$app->router->add(
    "news",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM VBlog
WHERE
    type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        // $slug = substr($route, 5);
        $title = "Nyheter";
        $content = $app->db->executeFetchAll($sql, ["post"]);
        // $title = "Blogg";
        // $title = $content->title;
        $view = "take1/news";

        $app->renderPage($title, $view, $content);
    }
);

$app->router->add(
    "newspost",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

    // slug = ?
        // $slug = substr($route, 5);
        $slug = $route;
        $content = $app->db->executeFetch($sql, [$slug, "post"]);
        if (!$content) {
            header("HTTP/1.0 404 Not Found");
            $title = "404";
            $view = "content/404.php";
        }
        $title = "Nyheter";
        // $title = $content->title;
        $view = "take1/newspost";

        $app->renderPage($title, $view, $content);
    }
);
