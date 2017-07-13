<?php
$app->router->add(
    "",
    function () use ($app) {
        $sql = <<<EOD
SELECT
    *,
    SUBSTR(data, 1, 100) AS extract,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM VBlog
WHERE
    type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
LIMIT 3
;
EOD;
        $content = $app->db->executeFetchAll($sql, ["post"]);
        $view = "take1/home";
        $title = "Hem";

        // Get the last products added to product table
        $orderBy = "id";
        $order = "DESC";
        $limit = 2;
        $lastProducts = $app->admin->showProducts($orderBy, $order, $limit);
        // inject into $content to send to page
        $content[0]->lastProducts = $lastProducts;

        // Get the most sold product
        $mostSold = $app->admin->getMostSoldProduct();
        $content[0]->mostSold = $mostSold;

        // Get this weeks offer (the newest one from the table)
        $sql = "SELECT * FROM Offer
        WHERE (deleted IS NULL OR deleted > NOW())";

        $offer = $app->db->executeFetchAll($sql);
        $content[0]->offer = $offer;

        // Get recommended products
        $sql = "SELECT * FROM VProduct
        WHERE recommended = 1";
        $recommended = $app->db->executeFetchAll($sql);

        $content[0]->recommended = $recommended;

        $app->renderPage($title, $view, $content);
    }
);


$app->router->add(
    "status",
    function () use ($app) {
        $data = [
            "Server" => php_uname(),
            "PHP Version" => phpversion(),
            "Included files" => count(get_included_files()),
            "Memory used" => memory_get_peak_usage(true),
            "Execution time" => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
        ];
        $app->response->sendJson($data);
    }
);

$app->router->add(
    "textfilter",
    function () use ($app) {

        $app->renderPage("Test av textfilter", "take1/textfilter");
    }
);
