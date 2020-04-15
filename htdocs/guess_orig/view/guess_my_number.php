<h1>Guess the Number</h1>
<p>The number is between 1 and 100. You have <?= $tries ?> tries left.</p>
<form class="" action="handle_post.php" method="post">
    <?php if ($tries) { ?>
        <label for="guess">Your guess: </label>
        <input type="text" name="guess" value="">
        <input type="submit" name="doGuess" value="Guess">
        <input type="submit" name="doCheat" value="Cheat">
    <?php } ?>
    <input type="submit" name="doInit" value="Reset">
</form>

<?php if (isset($_SESSION["message"])) {?>
    <h2><?= $_SESSION["message"]?></h2>
<?php }; ?>

<?php if (isset($_SESSION["cheat"]) ||  !$tries) {?>
    <h2>The number was <?= $_SESSION["game"]->number()?></h2>
<?php }; ?>
