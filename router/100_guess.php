<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Initalize guessing game and redirect
 */
$app->router->get("guess/init", function () use ($app) {
    // Initialize game session
    return $app->response->redirect("guess/play");
});



/**
 * Play the guessing game
 */
$app->router->get("guess/play", function () use ($app) {
    // Play the game
    $title = "Guessing game";
    $data = [
       "content" => "Guess game in " . __FILE__,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
       "title" => $title,
   ]);
});

//
//
// /**
// * Showing message Hello World, rendered within the standard page layout.
//  */
// $app->router->get("lek/hello-world-page", function () use ($app) {
//     $title = "Hello World as a page";
//     $data = [
//         "class" => "hello-world",
//         "content" => "Hello World in " . __FILE__,
//     ];
//
//     $app->page->add("anax/v2/article/default", $data);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
