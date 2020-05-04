<?php

namespace Nihl\Dice100;

use Anax\DI\DIMagic;
use Anax\Page\Page;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    private $app;

    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;

        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->app = $di;
        $di->set("app", $this->app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($this->app);
        // $this->controller->initialize();
    }


    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller index action.
     */
    public function testInitActionGetWithArguments()
    {

        $this->app->request->setGlobals([
            "get" => [
                "name" => "Nils",
                "numComp" => 6,
                "dice" => 6
            ]
        ]);

        $res = $this->controller->initActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $game = $this->app->session->get("game");
        $diceHand = $this->app->session->get("diceHand");

        $exp = 7;
        $this->assertEquals($exp, count($game->getPlayers()));

        $exp = "Nils";
        $this->assertEquals($exp, $game->getPlayer(0)->getName());

        $exp = 6;
        $this->assertEquals($exp, count($diceHand->getDiceInHand()));
    }

    /**
     * Call the controller index action with no arguments sent with get.
     */
    public function testInitActionGetWithNoArguments()
    {

        $res = $this->controller->initActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $game = $this->app->session->get("game");
        $diceHand = $this->app->session->get("diceHand");

        $exp = 2;
        $this->assertEquals($exp, count($game->getPlayers()));

        $exp = 2;
        $this->assertEquals($exp, count($diceHand->getDiceInHand()));
    }

    /**
     * Call the controller index action.
     */
    public function testPlayAction()
    {
        $res = $this->controller->playAction();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Call the controller index action.
     */
    public function formActionPost()
    {
        $this->app->request->setGlobals([
            "post" => [
                "action" => "Roll"
            ]
        ]);

        $res = $this->controller->formActionPost();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
