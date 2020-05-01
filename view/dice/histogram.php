<?php

namespace Anax\View;

/**
 * Render histogram
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h3>Earlier Rolls</h3>
<!-- <?= $histogram->getStatistics() ?> -->
<?= $histogram->getAsText() ?>
<hr>
