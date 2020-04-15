<?php

namespace Anax\View;

/**
 * Render content in guessing game
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Guess the Number</h1>
<p>The number is between 1 and 100. You have <?= $tries ?> tries left.</p>
<form class="" action="handle_post" method="post">
    <?php if ($tries) { ?>
        <label for="guess">Your guess: </label>
        <input type="text" name="guess" value="">
        <input type="submit" name="doGuess" value="Guess">
        <input type="submit" name="doCheat" value="Cheat">
    <?php } ?>
    <input type="submit" name="doInit" value="Reset">
</form>

<?php if ($msg) {?>
    <h2><?= $msg?></h2>
<?php }; ?>

<?php if ($answer) {?>
    <h2>The number is <?= $answer?></h2>
<?php }; ?>
