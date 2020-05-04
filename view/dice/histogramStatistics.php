<?php

namespace Anax\View;

/**
 * Render histogram
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h3>Statistics</h3>
<p><?= $histogram->getStatistics() ?></p>
<hr>
<p>Average: <?= $histogram->getAverageRoll() ?></p>
