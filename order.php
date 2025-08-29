<?php    
    if (session_status() == PHP_SESSION_NONE) {
               
        session_start();

    }
    
    require_once "database-connection.php";
    require_once "functions.php";

    # Kreiramo postavku za dodavanja vise elemenata iz korpe u bazu sa porudzbinama
    $sql = "INSERT INTO `orders` (watch_id, user_id, amount, completed) VALUES";

    # Ukoliko ima elemenata u korpi
    if (count($_SESSION['cart']) > 0) 
    {   

        foreach($_SESSION['cart'] as $item) 
        {   
            $user_id = $item['user_id'];
            $watch_id = $item['watch_id'];
            $amount = $item['amount'];
            $completed = 0;
            $sql .= " ($watch_id, $user_id, $amount, $completed),";
        }
        $sql_trimmed_comma = rtrim($sql, ',');

        // dd($sql_trimmed_comma);

        $success = $pdo->query($sql_trimmed_comma);

        if ($success)
        {
            
            unset($_SESSION['cart']);
            $_SESSION['cart'] = [];
            header('Location: index.php?success=Your order is complete!');
        }
    }