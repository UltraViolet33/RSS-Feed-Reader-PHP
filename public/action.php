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
RssLink::saveLink($url);
header('Location: index');
return;
