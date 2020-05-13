<?php
/**
 * Dice controller
 */
return [
    "mount" => "movie",

    "routes" => [
        [
            "info" => "Movie Controller.",
            "mount" => null,
            "handler" => "\Anax\Controller\MovieController",
        ],
    ]
];
