<?php

namespace Nihl\Dice100;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    // /**
    //  * @var string $db a sample member variable that gets initialised
    //  */
    // private $db = "not active";



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        $title = "Dice100 | Setup";

        $this->app->page->add("dice/setup");
        // $this->app->page->add("dice100/debug");

        return $this->app->page->render([
           "title" => $title,
        ]);
    }


    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint/init
     *
     * @return string
     */
    public function initActionGet() : object
    {
        // Deal with the action and return a response.
        // Initialize game session
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        // Get setup configuration for the game
        $name = $request->getGet("name");
        $numComp = $request->getGet("numComp", 1);
        $dice = $request->getGet("dice", 2);

        // Reset game in session
        $session->delete("game");

        // Create a new game and a new dicehand
        $session->set("game", new Dice100());
        $session->set("diceHand", new DiceHand($dice));
        $session->set("histogram", new Histogram());

        // Create players and initialize gamestate
        $session->get("game")->createPlayers($name, $numComp);
        $session->get("game")->initGamestate();

        return $response->redirect("dice/play");
    }

    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint/play
     *
     * @return string
     */
    public function playAction() : object
    {
        // Deal with the action and return a response.
        // Initialize game session
        $page = $this->app->page;
        $session = $this->app->session;
        $title = "Dice100 | Play";

        $diceHand = $session->get("diceHand");
        $game = $session->get("game");
        $histogram = $session->get("histogram");


        $data = [
            "game" => $game,
            "gamestate" => $game->getGamestate(),
            "diceHand" => $diceHand,
            "histogram" => $histogram
        ];

        $page->add("dice/play", $data);
        $page->add("dice/histogramStatistics", $data, "sidebar-left");
        $page->add("dice/histogram", $data, "sidebar-right");
        // $page->add("dice/debug");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the form method action, it handles:
     * ANY METHOD mountpoint/form
     *
     * @return string
     */
    public function formActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        switch ($request->getPost("action")) {
            case "Roll":
                return $response->redirect("dice/roll");
                break;
            case "Hold":
                return $response->redirect("dice/hold");
                break;
            case "Next Turn":
                return $response->redirect("dice/nextturn");
                break;
            case "Pass":
                return $response->redirect("dice/pass");
                break;
        }

        return $response->redirect("dice/play");
    }

    /**
     * This is the roll method action, it handles:
     * ANY METHOD mountpoint/roll
     *
     * @return string
     */
    public function rollAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $session->get("diceHand")->rollDice();
        $session->get("game")->checkHand($session->get("diceHand"));
        $session->get("histogram")->injectData($session->get("diceHand"));

        return $response->redirect("dice/play");
    }


    /**
     * This is the hold method action, it handles:
     * ANY METHOD mountpoint/hold
     *
     * @return string
     */
    public function holdAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $session->get("game")->holdHand();

        return $response->redirect("dice/play");
    }

    /**
     * This is the nextturn method action, it handles:
     * ANY METHOD mountpoint/nextturn
     *
     * @return string
     */
    public function nextturnAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $session->get("game")->startNextTurn();

        return $response->redirect("dice/play");
    }

    /**
     * This is the pass method action, it handles:
     * ANY METHOD mountpoint/pass
     *
     * @return string
     */
    public function passAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        if ($session->get("game")->computerMove()) {
            $session->get("diceHand")->rollDice();
            $session->get("game")->checkHand($session->get("diceHand"));
            $session->get("histogram")->injectData($session->get("diceHand"));
        } else {
            $session->get("game")->holdHand();
        }
        return $response->redirect("dice/play");
    }

    /**
     * This is the debug method action, it handles:
     * ANY METHOD mountpoint/debug
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debugging";
    }



    /**
     * This sample method dumps the content of $app.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpAppActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->app->getServices());
        return __METHOD__ . "<p>\$app contains: $services";
    }
}
