<?php

namespace Nihl\Guess;


/**
 * Unset variables related to the guessing game
 *
 * @return void
 */
function unsetGuess() : void
{
    unset($_SESSION["game"], $_SESSION["message"], $_SESSION["cheat"]);
}
