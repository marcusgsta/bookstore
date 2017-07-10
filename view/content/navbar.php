<?php

require_once 'navbar-array.php';

// print_r($navbar['config']);
// print_r($navbar['items']);
if (basename($_SERVER['REQUEST_URI']) == 'content') {
    $page = basename($_SERVER['REQUEST_URI']);
} else {
    $page = "content/" . basename($_SERVER['REQUEST_URI']);
}


$values = $navbar['items'];
$navbarClass = $navbar['config']['navbar-class'];

$html = "<navbar class='$navbarClass'><ul>";
foreach ($values as $key => $value) {
    // echo $key . " is " . $value['text'] . $value['route'];
    $route = $value['route'];
    $text = $value['text'];
    $url = $app->url->create($route);

    $html .= "<li class=\"";

    if ($value['route'] == "") {
        $value['route'] = "htdocs";
    }

    // echo "page: " . $page . "<br>";
    // echo "route: " . $value['route'] . "<br>";;

    if ($page == $value['route']) {
        $html .= "selected";
    } else {
        $html .= "";
    }
    // ($page == $url) ? "selected" : "";
    $html .= "\"><a href='" . $url . "'>" . $text . "</a></li>";
}
$html .= "</ul></navbar>";




echo $html;
