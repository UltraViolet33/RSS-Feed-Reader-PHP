<?php
session_start();
require_once('./../app/classes/RssLink.php');

use App\RssLink;

if (!isset($_POST) || empty($_POST['url'])) {
    $_SESSION['error'] = "Veuillez indiquer une url <br>";
    header('Location: index');
    return;
}

$url = $_POST['url'];

$document = new RssLink();

$document->saveJSON($url);

header('Location: index');
die;
