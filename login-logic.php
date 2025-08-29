 <?php


    require_once("database-connection.php");
    require_once("functions.php");

    $email          = $_POST['email'];
    $password       = $_POST['password'];

    log_user($pdo, $email, $password);