<?php

namespace Nihl\TextFilter;

use Michelf\MarkdownExtra;

//
// require __DIR__ . "/../../vendor/autoload.php";

/**
 * Filter and format text content.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class MyTextFilter
{
    /**
     * @var array $filters Supported filters with method names of
     *                     their respective handler.
     */
    private $filters = [
        "esc"       => "esc",
        "strip"     => "stripTags",
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br"
    ];



    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter)
    {
        foreach ($filter as $value) {
            $func = $this->filters[$value] ?? null;
            if (method_exists($this, $func)) {
                $text = call_user_func(array($this, $func), $text);
            }
        }
        return $text;
    }



    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function markdown($text)
    {
        return MarkdownExtra::defaultTransform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }



    /**
     * Strips HTML and PHP tags from text
     *
     * @param string $text the text that should be formatted.
     *
     * @return string the formatted text
     */
    public function stripTags($text)
    {
        return strip_tags($text);
    }



    /**
     * Sanitize the string by converting all applicable characters to HTML entities
     *
     * @param string $text the text that should be formatted.
     *
     * @return string the formatted text
     */
    public function esc($text)
    {
        return htmlentities($text);
    }

    /**
     * Return all available textfilters
     *
     *
     * @return array of available filters
     */
    public function fetchTextFilters()
    {

        return array_keys($this->filters);
    }
}
