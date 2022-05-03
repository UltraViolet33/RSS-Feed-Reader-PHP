<?php
require_once('./../app/config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <title>RSS Feed Reader - <?= $title ?></title>
</head>

<body>
    <nav>
        <div class="nav-center">
            <div class="nav-header">
                <button class="nav-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>RSS Reader</h1>
            </div>
            <ul class="links">
                <li>
                    <a href="index.php">RSS</a>
                </li>
                <li>
                    <a href="show.php">Tout les flux RSS</a>
                </li>
            </ul>
        </div>
    </nav>
    <div>