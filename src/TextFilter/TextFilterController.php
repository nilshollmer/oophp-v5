<?php

namespace Nihl\TextFilter;

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
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var null $filter Textfilter to be initialized
     */
    private $filter = null;


    //
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
        $this->filter = new MyTextFilter();
        $this->app->page->add("textfilter/navbar", [], "main");
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
        $title = "Textfilter";

        // $this->app->page->add("textfilter/navbar", [], "main");
        $this->app->page->add("textfilter/index", [], "main");
        return $this->app->page->render([ "title" => $title ]);
        // return __METHOD__ . ", \$db is {$this->db}";
    }





    /**
     * This sample method action takes one argument:
     * GET mountpoint/bbcode
     *
     * @param mixed $value
     *
     * @return string
     */
    public function bbcodeAction() : object
    {
        $title = "BBcode";
        $text = file_get_contents(__DIR__ . "/textfiles/bbcode.txt");
        // $filter = new MyTextFilter();

        // Deal with the action and return a response.
        $this->app->page->add("textfilter/bbcode", [
            "text" => $text,
            "html" => $this->filter->parse($text, ["bbcode"])
        ], "main");
        return $this->app->page->render([ "title" => $title ]);
    }



    /**
     * This sample method action takes one argument:
     * GET mountpoint/markdown
     *
     * @param mixed $value
     *
     * @return string
     */
    public function markdownAction() : object
    {
        $title = "Markdown";
        $text = file_get_contents(__DIR__ . "/textfiles/sample.md");
        // $filter = new MyTextFilter();

        // Deal with the action and return a response.
        $this->app->page->add("textfilter/markdown", [
            "text" => $text,
            "html" => $this->filter->parse($text, ["markdown"])
        ], "main");
        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This sample method action takes one argument:
     * GET mountpoint/clickable
     *
     * @param mixed $value
     *
     * @return string
     */
    public function linkAction() : object
    {
        $title = "Markdown";
        $text = file_get_contents(__DIR__ . "/textfiles/clickable.txt");
        // $filter = new MyTextFilter();

        // Deal with the action and return a response.
        $this->app->page->add("textfilter/clickable", [
            "text" => $text,
            "html" => $this->filter->parse($text, ["link"])
        ], "main");
        return $this->app->page->render([ "title" => $title ]);
    }


    /**
     * This sample method action takes a variadic list of arguments:
     * GET mountpoint/variadic/
     * GET mountpoint/variadic/<value>
     * GET mountpoint/variadic/<value>/<value>
     * GET mountpoint/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return string
     */
    public function multiAction() : object
    {
        // Deal with the action and return a response.

        $title = "Multi";
        $filters = $this->filter->fetchTextFilters();
        $text = file_get_contents(__DIR__ . "/textfiles/multi.txt");
        $applied = $this->app->request->getGet();
        $html = $applied ? $this->filter->parse($text, $applied) : $text;

        // Deal with the action and return a response.
        $this->app->page->add("textfilter/multi", [
            "text" => $text,
            "html" => $html,
            "filters" => $filters,
            "applied" => $applied,
        ], "main");

        return $this->app->page->render([ "title" => $title ]);
    }
}
