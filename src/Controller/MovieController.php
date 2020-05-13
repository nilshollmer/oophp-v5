<?php

namespace Anax\Controller;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
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
        $this->app->page->add("movie/movie-header", [], "main");
        $this->app->page->add("movie/movie-nav", [], "main");
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
        $title = "Visa alla filmer";

        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);
        $this->app->page->add("movie/show-all", [ "resultset" => $res ]);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This is the search-title method action, it handles:
     * ANY METHOD mountpoint/search-title
     *
     * @return string
     */
    public function searchTitleActionGet($value = "") : object
    {
        // Deal with the action and return a response.
        $title = "Sök titel";

        $searchTitle = $this->app->request->getGet("searchTitle", $value);

        $this->app->page->add("movie/search-title", [ "searchTitle" => $searchTitle ]);

        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
            $this->app->page->add("movie/show-all", [ "resultset" => $res ]);
        }

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This is the search-year method action, it handles:
     * ANY METHOD mountpoint/search-year
     *
     * @return string
     */
    public function searchYearActionGet() : object
    {
        // Deal with the action and return a response.
        $title = "Sök år";

        $year1 = $this->app->request->getGet("year1", 1900);
        $year2 = $this->app->request->getGet("year2", 2100);

        $this->app->page->add("movie/search-year", [
            "year1" => $year1,
            "year2" => $year2
        ]);

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year2]);
        }

        $this->app->page->add("movie/show-all", ["resultset" => $res ?: []]);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     *
     *
     * @return object
     */
    public function movieSelectAction() : object
    {
        // Deal with the action and return a response.
        $title = "Välj film";

        $movieId = $this->app->request->getPost("movieId");
        $doAction = $this->app->request->getPost("doAction");

        if ($doAction == "Delete") {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->execute($sql, [$movieId]);
            return $this->app->response->redirect("movie");
        } elseif ($doAction == "Add") {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, ["A title", 2017, "image/noimage.png"]);
            $movieId = $this->app->db->lastInsertId();
            return $this->app->response->redirect("movie/movie-edit/{$movieId}");
        } elseif ($doAction == "Edit" && is_numeric($movieId)) {
            return $this->app->response->redirect("movie/movie-edit/{$movieId}");
        }

        $sql = "SELECT id, title FROM movie;";
        $movies = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/movie-select", [ "movies" => $movies ]);

        return $this->app->page->render([ "title" => $title ]);
    }

    /**
     * This sample method action takes zero or one argument and you can use
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function movieEditAction($value = null) : object
    {
        // Deal with the action and return a response.
        $title = "Uppdatera film";

        $movieId = $value;
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear  = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");

        if ($this->app->request->getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            return $this->app->response->redirect("movie");
        }

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $this->app->db->executeFetchAll($sql, [$movieId]);

        $this->app->page->add("movie/movie-edit", [ "movie" => $movie[0] ]);

        return $this->app->page->render([ "title" => $title ]);
    }
}
