<?php

namespace Nihl\Content;


class Content
{
    /**
     * @var integer     $id         Id of content
     * @var string      $title      title of content
     * @var string      $type       Type of content, page or post
     * @var string      $path       Path to content
     * @var string      $slug       URL-slug to content
     * @var string      $data       Data in content
     * @var array       $filter     Filters applied to content
     * @var integer     $created    Datetime of creation
     * @var integer     $published  Datetime of publication
     * @var integer     $updated    Datetime of update
     * @var integer     $deleted    Datetime of deletion
     */
    public $id;
    public $title;
    public $type;
    public $path;
    public $slug;
    public $data;
    public $filter;
    public $created;
    public $published;
    public $updated;
    public $deleted;

    /**
     * Set
     */
    public function __set($name, $value) {
        $this[$name] = $value;
    }

    /**
     * posix_getgrgid
     */
    public function __get($name) {
        return $this[$name];
    }
}
