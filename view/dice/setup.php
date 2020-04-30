<?php

namespace Anax\View;

/**
 * Render content in dice 100
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Dice 100</h1>
<h3>Spelinställningar</h3>
<p>Ställ in grundinställningar för spelet</p>
<form class="stylechooser" action="dice/init" method="get">
    <fieldset>
        <label for="name">Ditt namn:</label>
        <input type="text" id="name" name="name">
        <br>
        <label for="numComp">Antal motspelare:</label>
        <input type="number" id="numComp" name="numComp" value=1>
        <br>
        <label for="dice">Antal tärningar:</label>
        <input type="number" id="dice" name="dice" value=2>
        <br>
        <input type="submit" name="init" value="Starta spelet">
    </fieldset>
</form>
