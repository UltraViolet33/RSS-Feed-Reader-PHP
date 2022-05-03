<?php
session_start();
$title = "List RSS";
require_once('./../app/inc/header.php');
require_once('./../app/classes/RssLink.php');

use App\RssLink;

$data = RssLink::getJSON();
?>
<div class="container">
    <h1>Listes des flux RSS</h1>
    <table id="customers">
        <tr>
            <th>Websites</th>
            <th>Supprimer</th>
        </tr>
        <?php foreach ($data as $id => $link) : ?>
            <tr>
                <td><?= $link ?></td>
                <td>
                    <form onsubmit="return confirm('Voulez vous vraiment supprimer le lien ?')" method="POST" action="delete.php">
                        <input type="hidden" name="link" value="<?= $id ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <div class="row">
            <div class="error">
                <p class="center">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require_once('./../app/inc/footer.php'); ?>