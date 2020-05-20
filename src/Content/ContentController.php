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
     * @var string $errormessage
     */
    private $db = "not active";
    private $errormessage = "";



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
        $this->app->page->add("cms/header", [], "main");
        $this->app->page->add("cms/navbar", [], "sidebar-left");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        $title = "Content";

        // $sql = "SELECT * FROM content;";
        // $res = $this->app->db->executeFetchAll($sql);

        // $obj = new Content();
        // $res = $this->app->db->executeFetchInto($sql, [], $obj);
        // var_dump($res);
        $res = Content::contentFetchAll($this->app->db);

        $this->app->page->add("cms/index", [ "res" => $res ]);

        return $this->app->page->render([ "title" => $title ]);
    }


    /**
     * This is the admin method action, it handles:
     * ANY METHOD mountpoint/admin
     *
     * @return object
     */
    public function adminAction() : object
    {
        // Deal with the action and return a response.
        $title = "Admin";
        //
        // $sql = "SELECT * FROM content;";
        // $res = $this->app->db->executeFetchAll($sql);
        $res = Content::contentFetchAll($this->app->db);
        $this->app->page->add("cms/admin", [ "res" => $res ]);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This is the create method action, it handles:
     * ANY METHOD mountpoint/admin
     *
     * @return object
     */
    public function createAction() : object
    {
        // Deal with the action and return a response.
        $title = "Create";
        // $sql = "SELECT * FROM content;";
        // $res = $this->app->db->executeFetchAll($sql);
        // $res = Content::contentFetchAll($this->app->db);
        $this->app->page->add("cms/create", []);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This is the create method action for Post, it handles:
     * ANY METHOD mountpoint/admin
     *
     * @return object
     */
    public function createActionPost() : object
    {
        // Deal with the action and return a response.

        $title = $this->app->request->getPost("title", null);
        if ($title) {
            $id = Content::contentCreate($this->app->db, $title);
            return $this->app->response->redirect("content/edit/{$id}");
        }
        return $this->app->response->redirect("content");
    }

    /**
     * This is the edit method action, it handles:
     * ANY METHOD mountpoint/edit/<id>
     *
     * @param integer $id of content to edit
     *
     * @return object
     */
    public function editAction($id) : object
    {
        // Deal with the action and return a response.
        $title = "Create";

        if (!is_numeric($id)) {
            die("Not valid for content id.");
        }

        $content = Content::contentFetch($this->app->db, $id);

        $this->app->page->add("cms/edit", [ "content" => $content ]);

        return $this->app->page->render([ "title" => $title ]);
    }


    /**
     * This is the edit method action for Post, it handles:
     * ANY METHOD mountpoint/edit
     *
     * @return object
     */
    public function editActionPost() : object
    {
        // Deal with the action and return a response.

        if (hasKeyPost("doSave")) {
            $params = getPostArray([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);

            try {
                Content::contentUpdate($this->app->db, $params);
            } catch (Exception $e){
                $this->errormessage = $e;
                return $this->app->response->redirect("content/error");
            }

            return $this->app->response->redirect("content/edit/" . $params["contentId"]);
        }


        if (hasKeyPost("doDelete")) {
            return $this->app->response->redirect("content/delete/" . getPostArray("contentId"));
        }

        return $this->app->response->redirect("content");
    }

    /**
     * This is the delete method action, it handles:
     * ANY METHOD mountpoint/delete/<id>
     *
     * @param integer $id of content to delete
     *
     * @return object
     */
    public function deleteAction($id) : object
    {
        // Deal with the action and return a response.
        $title = "Delete";

        if (!is_numeric($id)) {
            die("Not valid for content id.");
        }

        $content = Content::contentFetch($this->app->db, $id);

        $this->app->page->add("cms/delete", [ "content" => $content ]);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This is the delete method action with POST, it handles:
     * ANY METHOD mountpoint/delete
     *
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        // Deal with the action and return a response.
        $id = $this->app->request->getPost("contentId");
        if ($id) {
            Content::contentDelete($this->app->db, $id);
        }

        return $this->app->response->redirect("content/admin");
    }


    /**
     * Handles pages method
     * mountpoint/pages
     * mountpoint/pages/<path>
     *
     * @return object
     */
    public function pagesAction($path = null) : object
    {
        if ($path) {
            $content = Content::contentFetchPage($this->app->db, $path);
            $title = $content->title;
            $this->app->page->add("cms/page", [ "content" => $content ]);
            return $this->app->page->render([ "title" => $title ]);
        }

        $title = "View pages";
        $res = Content::contentFetchAllPages($this->app->db);
        $this->app->page->add("cms/pages", [ "res" => $res ]);
        return $this->app->page->render([ "title" => $title ]);
    }



    /**
     * Handles blog and blogpost method
     * mountpoint/blog
     * mountpoint/blog/<slug>
     *
     * @return object
     */
    public function blogAction($slug = null) : object
    {
        if ($slug) {
            $content = Content::contentFetchBlogPost($this->app->db, $slug);
            $title = $content->title;
            $this->app->page->add("cms/blogpost", [ "content" => $content ]);
            return $this->app->page->render([ "title" => $title ]);
        }

        $title = "View blog";
        $res = Content::contentFetchAllPosts($this->app->db);
        $this->app->page->add("cms/blog", [ "res" => $res ]);
        return $this->app->page->render([ "title" => $title ]);
    }



    /**
     * This is the Error page
     * ANY METHOD mountpoint/error
     *
     *
     * @return object
     */
    public function errorAction() : object
    {
        $title = "Error";

        $this->app->page->add("cms/error", [ "error" => $this->errormessage ]);

        return $this->app->page->render([ "title" => $title ]);
    }
}
