<?php
/**
 * Create routes using $app programming style.
 */
// var_dump(array_keys(get_defined_vars()));


/**
 * Initalize guessing game and redirect
 */
$app->router->get("dice100/setup", function () use ($app) {
    // Setup game session

    $title = "Dice100 | Setup";

    $app->page->add("dice100/setup");
    // $app->page->add("dice100/debug");

    return $app->page->render([
       "title" => $title,
    ]);
});

$app->router->get("dice100/init", function () use ($app) {
    // Initialize game session
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $numComp = isset($_GET["numComp"]) ? $_GET["numComp"] : 1;
    $dice = isset($_GET["dice"]) ? $_GET["dice"] : 2;

    unset($_SESSION["game"]);
    $_SESSION["game"] = new Nihl\Dice100\Dice100();
    $_SESSION["diceHand"] = new Nihl\Dice100\DiceHand($dice);
    $_SESSION["game"]->createPlayers($name, $numComp);
    $_SESSION["game"]->initGamestate();

    return $app->response->redirect("dice100/play");
});

/**
 * Play dice100
 */
$app->router->get("dice100/play", function () use ($app) {
    // Play the game
    $title = "Dice100 | Play";
    $game = $_SESSION["game"];

    $data = [
        "game" => $game,
        "gamestate" => $game->getGamestate(),
        "diceHand" => $_SESSION["diceHand"]
    ];

    $app->page->add("dice100/play", $data);
    // $app->page->add("dice100/debug");

    return $app->page->render([
       "title" => $title,
    ]);
});

/**
 * Take care of post requests
 */
$app->router->post("dice100/action", function () use ($app) {
    switch ($_POST["action"]) {
        case "Roll":
            $_SESSION["diceHand"]->rollDice();
            $_SESSION["game"]->checkHand($_SESSION["diceHand"]);
            break;
        case "Hold":
            $_SESSION["game"]->holdHand();
            break;
        case "Next Turn":
            $_SESSION["game"]->startNextTurn();
            break;
        case "Pass":
            if ($_SESSION["game"]->computerMove()) {
                $_SESSION["diceHand"]->rollDice();
                $_SESSION["game"]->checkHand($_SESSION["diceHand"]);
                break;
            }
            $_SESSION["game"]->holdHand();
            break;
    }
    // $_SESSION["game"]->runGame($_POST["action"]);

    return $app->response->redirect("dice100/play");
});

/**
 * Take care of post requests
 */
$app->router->post("dice100/restart", function () use ($app) {
    foreach ($_SESSION["game"]->getPlayers() as $player) {
        $player->setTotalPoints(0);
    }

    $_SESSION["game"]->initGamestate();

    return $app->response->redirect("dice100/play");
});
