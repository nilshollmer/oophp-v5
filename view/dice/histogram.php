<?php

namespace Anax\View;

/**
 * Render histogram
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<hr>
<pre>
    SESSION debug
    <?= var_dump($_SESSION) ?>
    POST debug
    <?= var_dump($_POST) ?>
    GET debug
    <?= var_dump($_GET) ?>
</pre>
<hr>
