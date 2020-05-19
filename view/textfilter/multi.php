
<h1>Test multiple filters</h1>

<form method="get">
    <fieldset>
        <legend>Select your filters</legend>
        <?php foreach ($filters as $filter) : ?>
            <label for="<?= $filter ?>"><?= $filter ?>
                <input name="<?= $filter ?>" type="checkbox" value="<?= $filter ?>" <?= in_array($filter, $applied) ? "checked" : "" ?>>
            </label>
        <?php endforeach; ?>
        <input type="submit" value="Filter">
    </fieldset>
</form>

<pre><?= $html ?></pre>
