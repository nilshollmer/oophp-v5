<?php

namespace Anax\View;

/**
 * Render content in dice 100
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Dice 100</h1>
<h3>Scoreboard</h3>
<?php foreach ($game->getPlayers() as $player) { ?>
    <p><?= $player->getName()?> : <?= $player->getTotalPoints()?></p>
<?php } ?>

<div style="background-color: #eee;">
    <?php if (!$gamestate["hasWon"]) { ?>
        <h3><?= $gamestate["active"]->getName() ?>s Turn:</h3>

        <form class="" action="action" method="post">

            <?php if ($gamestate["turnIsOver"]) { ?>
                <input type="submit" name="action" value="Next Turn">

            <?php } elseif ($gamestate["active"]->getType() == "Computer") { ?>
                <input type="submit" name="action" value="Pass">

            <?php } elseif ($gamestate["active"]->getType() == "Player") {?>
                <input type="submit" name="action" value="Roll">
                <input type="submit" name="action" value="Hold">

            <?php } ?>
        </form>

        <p>Points: <?= $gamestate["currentPoints"] ?></p>
        <p class="dice-utf8">
            Rolls: <?= $gamestate["diceHand"] ?>
        </p>

    <?php } else {?>
        <h3><?= $gamestate["hasWon"]->getName() ?> HAS WON! </h3>
        <a href="/">New game</a>

    <?php }?>
</div>
