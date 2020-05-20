<?php

namespace Nihl\Content;

/**
 * Functions for dealing with content
 */


class Content
{
    /**
     * Fetch all entries in $db
     *
     * @param Database  $db     Database to fetch from
     *
     * @return resultset
     */
    public static function contentFetchAll($db)
    {
        $sql = "SELECT * FROM content;";
        return $db->executeFetchAll($sql);
    }



    /**
     * Create new content and return its id
     *
     * @param Database  $db     Database to fetch from
     * @param String    $title  Title of new content
     *
     * @return integer id of last inserted content
     */
    public static function contentCreate($db, $title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($sql, [$title]);

        return $db->lastInsertId();
    }



    /**
     * Get content using id
     *
     * @param Database  $db     Database to fetch from
     * @param Integer   $id     Id of content to fetch
     *
     * @return resultset
     */
    public static function contentFetch($db, $id)
    {
        $sql = "SELECT * FROM content WHERE id = ?;";
        return $db->executeFetch($sql, [$id]);
    }



    /**
     *  Update content
     *
     * @param Database  $db     Database to fetch from
     * @param Array     $params Parameters to update with
     *
     * @return boolean
     */
    public static function contentUpdate($db, $params)
    {
        if (!$params["contentSlug"]) {
            $params["contentSlug"] = slugify($params["contentTitle"]);
        }

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }


        try {
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($params));
        } catch (\Exception $e) {
            throw $e;
        }
    }



    /**
     * Set content with id to deleted
     *
     * @param Database  $db     Database to fetch from
     * @param Integer   $id     Content to delete
     *
     * @return resultset
     */
    public static function contentDelete($db, $id)
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id = ?;";
        $db->execute($sql, [$id]);
    }



    /**
     * Fetch all content with type of page
     *
     * @param Database  $db     Database to fetch from
     *
     * @return resultset
     */
    public static function contentFetchAllPages($db)
    {
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        return $db->executeFetchAll($sql, ["page"]);
    }



    /**
     * Fetch all content with type of post
     *
     * @param Database  $db     Database to fetch from
     *
     * @return resultset
     */
    public static function contentFetchAllPosts($db)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        return $db->executeFetchAll($sql, ["post"]);
    }



    /**
     * Fetch blogpost using slug
     *
     * @param Database  $db     Database to fetch from
     * @param String    $slug   Slug to content to fetch
     *
     * @return resultset
     */
    public static function contentFetchBlogPost($db, $slug)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        return $db->executeFetch($sql, [$slug, "post"]);
    }

    /**
     * Fetch page using path
     *
     * @param Database  $db     Database to fetch from
     * @param String    $path   Path to content to fetch
     *
     * @return resultset
     */
    public static function contentFetchPage($db, $path)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        return $db->executeFetch($sql, [$path, "page"]);
    }
}
