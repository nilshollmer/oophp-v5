<?php
/**
* Set default error reporting
*/
error_reporting(-1);            // Report all errors
ini_set("display_error", 1);    // Display errors

/**
* Exception handler
*/
set_exception_handler(function ($e) {
    echo "<p>Anax: Uncaught exception:</p><p>Line "
       . $e->getLine()
       . " in file "
       . $e->getFile()
       . "</p><p><code>"
       . get_class($e)
       . "</code></p><p>"
       . $e->getMessage()
       . "</p><p>Code: "
       . $e->getCode()
       . "</p><pre>"
       . $e->getTraceAsString()
       . "</pre>";
});

/**
 * Start the session with name based on path of file
 */
$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();
