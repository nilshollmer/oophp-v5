<?php
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}
$game = $_SESSION["game"];
$tries = $game->tries();

require __DIR__ . "/view/guess_my_number.php";
