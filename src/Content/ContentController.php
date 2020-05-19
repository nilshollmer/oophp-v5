<?php

namespace Nihl\Content;

use Anax\Commons\AppInjectableTrait;
use Anax\Commons\AppInjectableInterface;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
        $this->app->db->connect();
        // $this->app->page->add("movie/movie-header", [], "main");
        // $this->app->page->add("movie/movie-nav", [], "main");
    }



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
        $title = "Content";

        $sql = "SELECT * FROM content WHERE id = 1;";
        $obj = new Content();
        $res = $this->app->db->executeFetchInto($sql, [], $obj);
        // $res = $this->app->db->executeFetchAll($sql);
        // var_dump($res);
        $this->app->page->add("cms/index", [ "res" => $res ]);

        return $this->app->page->render([ "title" => $title ]);
    }

}
