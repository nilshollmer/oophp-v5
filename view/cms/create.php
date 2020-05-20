<?php

namespace Anax\View;

?>

<form action="<?= url("content/create") ?>" method="post">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="title" default="A Title"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
    </p>
    </fieldset>
</form>
