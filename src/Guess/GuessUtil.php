<?php

namespace Nihl\Guess;


/**
 * Useful functions for guessing game
 *
 */
class GuessUtil
{
    /**
     * Unset variables related to the guessing game
     *
     * @return void
     */
    public static function unsetGuess()
    {
        unset($_SESSION["game"]);
        unset($_SESSION["message"]);
        unset($_SESSION["cheat"]);
        var_dump("unsetting guess with class");
    }
}

function unsetGuess()
{
    unset($_SESSION["game"]);
    unset($_SESSION["message"]);
    unset($_SESSION["cheat"]);
    var_dump("unsetting guess as function");
}
