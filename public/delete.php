<?php

session_start();
require_once './../app/classes/RssLink.php';

use App\RssLink;

if (!is_numeric($_POST['link'])) {
    $_SESSION['error'] = "Erreur <br>";
    header('Location: show.php');
    return;
}

$id = (int) $_POST['link'];

RssLink::deleteLink($id);
header('Location: show.php');
return;
