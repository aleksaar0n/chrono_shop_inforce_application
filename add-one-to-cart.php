<?php

    if (session_status() == PHP_SESSION_NONE) {
               
        session_start();

    }

    array_push($_SESSION['cart'],['watch_id' => $_GET['id'], 'user_id' => $_SESSION['id'], 'amount' => 1]);

    header('Location: index.php');