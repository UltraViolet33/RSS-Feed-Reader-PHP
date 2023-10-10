<?php

$title = "Home";
require_once './../app/inc/header.php';
require_once './../app/classes/RssLink.php';

use App\RssLink;

$data = RssLink::getRSSlinks();
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
        <div class="row">
            <div class="error message">
                <p class="center">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) : ?>
        <div class="row">
            <div class="success message">
                <p class="center">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="container-links">
    <?php foreach ($data as $link) : ?>
        <?php require './../app/inc/link.php' ; ?>
    <?php endforeach; ?>
</div>
<?php require_once './../app/inc/footer.php'; ?>