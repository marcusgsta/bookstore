<?php

$navbar = [
    "config" => [
        "navbar-class" => "navbar1"
    ],
    "items" => [
        "hem" => [
            "text" => "Hem",
            "route" => "",
        ],

        "admin" => [
            "text" => "Administrera",
            "route" => "admin",
        ],

        "content" => [
            "text" => "Innehåll",
            "route" => "content",
        ],

        "create" => [
            "text" => "Skapa",
            "route" => "content/create",
        ],

        "pages" => [
            "text" => "Visa sidor",
            "route" => "content/pages",
        ],

        "blog" => [
            "text" => "Blogg",
            "route" => "content/blog",
        ],

        "blocks" => [
            "text" => "Blocks",
            "route" => "content/blocks",
        ],
    ]
];

$navbar_sub = [
    "config" => [
        "navbar-class" => "navbar_sub"
    ],
    "items" => [
        "Innehåll" => [
            "text" => "",
            "route" => "",
        ],
    ]
];
