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

    $app->session->delete("game");

    $app->session->set("game", new Nihl\Dice100\Dice100());

    $app->session->set("diceHand", new Nihl\Dice100\DiceHand($dice));

    $app->session->get("game")->createPlayers($name, $numComp);

    $app->session->get("game")->initGamestate();

    return $app->response->redirect("dice100/play");
});

/**
 * Play dice100
 */
$app->router->get("dice100/play", function () use ($app) {
    // Play the game
    $title = "Dice100 | Play";
    $game = $app->session->get("game");


    $data = [
        "game" => $game,
        "gamestate" => $game->getGamestate(),
        "diceHand" => $app->session->get("diceHand")
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
            return $app->response->redirect("dice100/roll");
            break;
        case "Hold":
            return $app->response->redirect("dice100/hold");
            break;
        case "Next Turn":
            return $app->response->redirect("dice100/nextturn");
            break;
        case "Pass":
            return $app->response->redirect("dice100/pass");
            break;
    }

    return $app->response->redirect("dice100/play");
});

/**
 * Handle Roll action
 */
$app->router->get("dice100/roll", function () use ($app) {
    $app->session->get("diceHand")->rollDice();
    $app->session->get("game")->checkHand($app->session->get("diceHand"));

    return $app->response->redirect("dice100/play");
});

/**
 * Handle Hold action
 */
$app->router->get("dice100/hold", function () use ($app) {
    $app->session->get("game")->holdHand();

    return $app->response->redirect("dice100/play");
});

/**
 * Handle Next Turn action
 */
$app->router->get("dice100/nextturn", function () use ($app) {
    $app->session->get("game")->startNextTurn();

    return $app->response->redirect("dice100/play");
});

/**
 * Handle Pass action
 */
$app->router->get("dice100/pass", function () use ($app) {
    if ($app->session->get("game")->computerMove()) {
        $app->session->get("diceHand")->rollDice();
        $app->session->get("game")->checkHand($app->session->get("diceHand"));
    } else {
        $app->session->get("game")->holdHand();
    }
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
