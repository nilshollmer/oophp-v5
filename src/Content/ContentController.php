<?php

namespace Nihl\Content;

use Anax\Commons\AppInjectableTrait;
use Anax\Commons\AppInjectableInterface;
use Nihl\TextFilter\MyTextFilter;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */

class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;


    /**
     * @var string $db
     * @var string $errormessage
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
        $title = "Content";

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
        $title = "Admin";

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

        $title = "Create";

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
        $title = "Create";

        if (!is_numeric($id)) {
            $this->app->session->set("error", "{$id} is not valid for content id.");
            return $this->app->response->redirect("content/error");
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
            } catch (\Exception $e) {
                $this->app->session->set("error", "Duplicate slug or path not allowed");
                return $this->app->response->redirect("content/error");
            }
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
        $title = "Delete";

        if (!is_numeric($id)) {
            $this->app->session->set("error", "{$id} is not valid for content id.");
            return $this->app->response->redirect("content/error");
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
            $textFilter = new MyTextFilter();
            $content = Content::contentFetchPage($this->app->db, $path);
            $title = $content->title;
            $content->data = $textFilter->parse($content->data, explode(",", $content->filter));
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
            $textFilter = new MyTextFilter();
            $content = Content::contentFetchBlogPost($this->app->db, $slug);
            $title = $content->title;
            $content->data = $textFilter->parse($content->data, explode(",", $content->filter));
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
        $error = $this->app->session->get("error");
        $this->app->page->add("cms/error", [ "error" => $error]);

        return $this->app->page->render([ "title" => $title ]);
    }
}
