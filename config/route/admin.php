<?php


$app->router->add(
    "admin/**",
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

            header("refresh:5;url=login");
            echo $admin_message;
            echo '<p>You\'ll be redirected in about 5 secs. If not, click <a href="login">here</a>.</p>';
            exit;
        }
    }
);

$app->router->add(
    "admin",
    function () use ($app) {

        $app->renderAdminPage("Admin", "admin/admin");
    }
);


$app->router->add(
    "edit",
    function () use ($app) {

        $app->renderAdminPage("Admin", "admin/edit");
    }
);
