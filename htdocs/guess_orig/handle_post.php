<?php
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
include(__DIR__ . "/src/util.php");

if (isset($_POST["doGuess"]) && isset($_POST["guess"])) {
    $message = $_SESSION["game"]->makeGuess(intval($_POST["guess"]));
    $_SESSION["message"] = $message;
}

if (isset($_POST["doInit"])) {
    sessionDestroy();
}

if (isset($_POST["doCheat"])) {
    $_SESSION["cheat"] = $_SESSION["game"]->number();
}

header("Location: index.php");
