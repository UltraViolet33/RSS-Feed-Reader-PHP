<?php require_once('./inc/header.php'); ?>
<?php
require_once('./../app/classes/RssLink.php');
define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
use App\RssLink;

$test = new RssLink();
?>
<h1 class="center">Home page</h1>

<div class="form">
    <form action="http://<?= HTTP_PATH_ROOT ?>/action.php" method="POST">
        <label for="link">Ajouter un lien</label>
        <input type="text" name="url" required="required">
        <button type="submit">Valider</button>
    </form>
</div>


<?php require_once('./inc/footer.php'); ?>