<?php

/**
 * Routes.
 */
 // Create the router
$app->router = new \Anax\Route\RouterInjectable();

// An 'always' route to check if user is logged in
$app->router->always(function () use ($app) {

    if ($app->session->has("user_name")) {
        $user = $app->session->get("user_name");
        $app->user_logged_in = "<span class='active_user right'>Inloggad: " . $user . "</span>";
    };
});


require __DIR__ . "/route/internal.php";
require __DIR__ . "/route/base.php";
require __DIR__ . "/route/calendar.php";
require __DIR__ . "/route/access.php";
require __DIR__ . "/route/admin.php";
require __DIR__ . "/route/content.php";
require __DIR__ . "/route/webshop.php";
require __DIR__ . "/route/webshop-new.php";
