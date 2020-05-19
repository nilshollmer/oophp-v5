<?php
/**
 * Dice controller
 */
return [
    "mount" => "content",

    "routes" => [
        [
            "info" => "Content Controller.",
            "mount" => null,
            "handler" => "\Nihl\Content\ContentController",
        ],
    ]
];
