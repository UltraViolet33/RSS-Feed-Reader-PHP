<?php require_once('./inc/header.php');
session_start();

require_once('./../app/classes/RssLink.php');

use App\RssLink;

$doc = new RssLink();

$data = $doc->getRSSlinks();


?>

<div class="container">
    <form action="<?= ROOT ?>/action.php" method="POST">
        <div class="row">
            <div class="col-25 center">
                <label for="url">Ajouter un lien</label>
            </div>
            <div class="col-75">
                <input type="text" name="url" placeholder="Lien vers un site...">
            </div>
            <div class="col-15">
                <input type="submit" value="Valider">
            </div>
        </div>
    </form>
    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <div>
            <p class="center">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<div>
    <?php foreach ($data as $link) {
        require('./inc/link.php');
    }


    ?>

</div>
<?php require_once('./inc/footer.php'); ?>