<?php
require_once('./../app/classes/RssLink.php');
use App\RssLink;
error_reporting(0);
    if(!isset($_POST) || empty($_POST['url'])){
        header('Location: index');
        return;
    }

    $url = $_POST['url'];
    $document = new RssLink();

    $links = $document->getLinks($url);

   