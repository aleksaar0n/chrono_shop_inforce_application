<?php    
    if (session_status() == PHP_SESSION_NONE) {
               
        session_start();

    }
    
    require_once "database-connection.php";
    require_once "functions.php";

    $watch_id = $_GET['id'];

    $watch = get_watch_by_id($pdo, $watch_id);
    $full_path = "assets/" . $watch['picture'];

    # Proveravamo da li slika sata postoji
    if (file_exists($full_path))
    {
        # Ukoliko postoji, brisemo je sa servera.
        unlink($full_path);

        # Nakon toga brisemo i sat iz baze
        $sql = "DELETE FROM watches WHERE id = $watch_id";

        $success = $pdo->query($sql);

        if ($success) 
        {
            header("Location: admin.php?success= Watch with id of $watch_id is deleted!");
        }

    } 