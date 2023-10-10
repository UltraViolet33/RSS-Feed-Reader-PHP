<?php

session_start();
require_once './../app/classes/RssLink.php';

use App\RssLink;

if (empty($_POST['url'])) {
    $_SESSION['error'] = "Veuillez indiquer une url <br>";
    header('Location: index');
    return;
}

$url = $_POST['url'];
RssLink::saveLink($url);
if(!isset($_SESSION["error"]))
{
    $_SESSION["success"] = "Lien RSS ajouté ! <br>";
}
header('Location: index');
return;
