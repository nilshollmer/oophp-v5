<form method="post">
    <fieldset>
    <legend>Select Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId" method="post">
            <option value="">Select movie...</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doAction" value="Add">
        <input type="submit" name="doAction" value="Edit">
        <input type="submit" name="doAction" value="Delete">
    </p>
    <p><a href="?">Show all</a></p>
    </fieldset>
</form>
