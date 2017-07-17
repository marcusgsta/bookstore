<?php

$app->router->add(
    "content/**",
    function () use ($app) {


        if (!$app->session->get('user_name')) {
            $message = "<div class='container'><p>Du måste logga in för att kunna se sidan.</p>";

            header("refresh:5;url=login");
            echo $message;
            echo '<p>You\'ll be redirected in about 5 secs. If not, click <a href="login">here</a>.</p>';
            exit;
        }

        $user_name = $app->session->get('user_name');

        if (!$app->admin->userIsAdmin($user_name)) {
            $admin_message = "<div class='container'><p>Bara administratörer har tillgång till sidan.</p>";

            header("refresh:5;url=../login");
            echo $admin_message;
            echo '<p>You\'ll be redirected in about 5 secs. If not, click <a href="login">here</a>.</p>';
            exit;
        }
    }
);



$app->router->add(
    "content",
    function () use ($app) {
        $sql = "SELECT * FROM Content;";
        $resultset = $app->db->executeFetchAll($sql);

        $app->renderContentPage("Visa allt innehåll", "content/show-all", $resultset);
    }
);

$app->router->add(
    "content/show-all-content",
    function () use ($app) {

        $sql = "SELECT * FROM Content;";
        $resultset = $app->db->executeFetchAll($sql);
        $app->renderContentPage("Visa allt innehåll", "content/show-all", $resultset);
    }
);

$app->router->add(
    "content/edit",
    function () use ($app) {

        $title = "Redigera innehåll";
        $view = "content/edit";
        $contentId = getGet("id");

        $sql = "SELECT * FROM Content WHERE id = ?;";
        $result = $app->db->executeFetch($sql, [$contentId]);

        $app->renderContentPage($title, $view, $result);
    }
);

$app->router->add(
    "content/create",
    function () use ($app) {

        if (hasKeyPost("doCreate")) {
            $title = getPost("contentTitle");

            $sql = "INSERT INTO Content (title) VALUES (?);";
            $app->db->execute($sql, [$title]);
            $id = $app->db->lastInsertId();
            header("Location: edit?id=$id");
        }

        $title = "Skapa innehåll";
        $view = "content/create";
        $contentId = getGet("id");

        $app->renderContentPage($title, $view);
    }
);

$app->router->add(
    "content/delete",
    function () use ($app) {
        $title = "Radera innehåll";
        $view = "content/delete";
        $contentId = getGet("id");
        if (!is_numeric($contentId)) {
            die("Not valid for content id.");
        }

        if (hasKeyPost("doDelete")) {
            $contentId = getPost("contentId");
            $sql = "UPDATE Content SET deleted=NOW() WHERE id=?;";
            $app->db->execute($sql, [$contentId]);
            header("Location: ../content");
            exit;
        }
        $sql = "SELECT id, title FROM Content WHERE id = ?; ";
        $content = $app->db->executeFetch($sql, [$contentId]);

        $app->renderContentPage($title, $view, $content);
    }
);

$app->router->add(
    "content/pages",
    function () use ($app) {
        $title = "Visa sidor";
        $view = "content/pages";
        $route = getGet("route");
        if (isset($route)) {
            header("Location: page?route=$route");
            exit;
        } else {
            $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM Content
WHERE type=?
;
EOD;

            $resultset = $app->db->executeFetchAll($sql, ["page"]);

            $app->renderContentPage($title, $view, $resultset);
        }
    }
);

$app->router->add(
    "content/page",
    function () use ($app) {
        $route = getGet("route");
        // $sql = "SELECT *, DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601, DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified FROM Content WHERE path = ? AND (deleted IS NULL OR deleted > NOW());";
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM Content
WHERE
    path = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;

        $resultset = $app->db->executeFetch($sql, [$route]);
        $title = $resultset->title;
        $view = "content/page";

        $app->renderContentPage($title, $view, $resultset);
        // if (!is_numeric($pageId)) {
        //     die("Not valid for page id.");
        // }
    }
);

$app->router->add(
    "content/blog",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM Content
WHERE
    type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        // $slug = substr($route, 5);
        $content = $app->db->executeFetchAll($sql, ["post"]);
        $title = "Blogg";
        // $title = $content->title;
        $view = "content/blog";

        $app->renderContentPage($title, $view, $content);
    }
);

$app->router->add(
    "content/blogpost",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM Content
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
        $title = "Blogg";
        // $title = $content->title;
        $view = "content/blogpost";

        $app->renderContentPage($title, $view, $content);
    }
);

$app->router->add(
    "content/blocks",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM Content
WHERE
    type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        // $slug = substr($route, 5);
        $content = $app->db->executeFetchAll($sql, ["block"]);
        $title = "Blocks";
        // $title = $content->title;
        $view = "content/blocks";

        $app->renderContentPage($title, $view, $content);
    }
);


$app->router->add(
    "content/block",
    function () use ($app) {
        $route = getGet("route");
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM Content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        $slug = $route;
        $content = $app->db->executeFetch($sql, [$slug, "block"]);
        if (!$content) {
            header("HTTP/1.0 404 Not Found");
            $title = "404";
            $view = "content/404.php";
        }
        $title = "Block";
        $view = "content/block";

        $app->renderContentPage($title, $view, $content);
    }
);
