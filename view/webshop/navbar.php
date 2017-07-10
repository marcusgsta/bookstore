<?php

require_once 'navbar-array.php';

if (basename($_SERVER['REQUEST_URI']) == 'webshop') {
    $page = basename($_SERVER['REQUEST_URI']);
} else {
    $page = "webshop/" . basename($_SERVER['REQUEST_URI']);
}


$values = $navbar['items'];
$navbarClass = $navbar['config']['navbar-class'];

$html = "<navbar class='$navbarClass'><ul>";
foreach ($values as $key => $value) {
    $route = $value['route'];
    $text = $value['text'];
    $url = $app->url->create($route);

    $html .= "<li class=\"";

    if ($value['route'] == "") {
        $value['route'] = "htdocs";
    }
    if ($page == $value['route']) {
        $html .= "selected";
    } else {
        $html .= "";
    }

    $html .= "\"><a href='" . $url . "'>" . $text . "</a></li>";
}
$html .= "</ul></navbar>";


echo $html;
