<?php
/**
 * Dice controller
 */
return [
    "mount" => "textfilter",

    "routes" => [
        [
            "info" => "TextFilter Controller.",
            "mount" => null,
            "handler" => "\Nihl\TextFilter\TextFilterController",
        ],
    ]
];
