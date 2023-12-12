Add cats:
<?php foreach ($features as $cats => $cat) : ?>
    <input type=" checkbox" id="<?= $cat['id']; ?>" name="feature<?= $cat['id'] ?>"><?= $cat['feature_name']; ?></input>
<?php endforeach; ?>
<button type="submit" name="submit" method="POST" id="submit">Submit</button>
</form>