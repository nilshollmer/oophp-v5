<?php
/**
 * Create routes using $app programming style.
 */
// var_dump(array_keys(get_defined_vars()));


/**
 * Initalize guessing game and redirect
 */
$app->router->get("guess/init", function () use ($app) {
    // Initialize game session

    // $gutil = new Nihl\Guess\GuessUtil();
    // $gutil::unsetGuess();
    // use function Nihl\Guess\{unsetGuess};
    // unsetGuess();
    unset($_SESSION["game"], $_SESSION["message"], $_SESSION["cheat"]);
    $_SESSION["game"] = new Nihl\Guess\Guess();
    return $app->response->redirect("guess/play");
});


/**
 * Play the guessing game
 */
$app->router->get("guess/play", function () use ($app) {
    // Play the game
    $title = "Guessing game";

    $game = $_SESSION["game"];
    $msg = $_SESSION["message"] ?? null;
    $tries = $game->tries() ?? null;
    $answer = (isset($_SESSION["cheat"]) ||  !$tries) ? $game->number() : null;

    $data = [
        "tries" => $tries,
        "msg" => $msg,
        "answer" => $answer
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
       "title" => $title,
    ]);
});

/**
 * Take care of post requests
 */
$app->router->post("guess/handle_post", function () use ($app) {
    if (isset($_POST["doGuess"]) && isset($_POST["guess"])) {
        $message = $_SESSION["game"]->makeGuess(intval($_POST["guess"]));
        $_SESSION["message"] = $message;
        if ($message === "Correct!") {
            $_SESSION["game"]->setTries(0);
        }
    }

    if (isset($_POST["doInit"])) {
        return $app->response->redirect("guess/init");
    }

    if (isset($_POST["doCheat"])) {
        $_SESSION["cheat"] = $_SESSION["game"]->number();
    }

    return $app->response->redirect("guess/play");
});
