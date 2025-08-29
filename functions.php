<?php 

    ###########################################
    ### Die and Dump funkcija za testiranje ###
    ###########################################

    function dd($value) 
    {

        echo "<pre>";
        die(var_dump($value));
        echo "</pre>";

    }

    ##########################################################
    ### Funkcija koja preuzima sve satove iz baze podataka ###
    ##########################################################

    function fetch_all_watches_and_brands($pdo) 
    {
        $statement  = $pdo->query("SELECT watches.id, watches.brand_id ,watches.model, watches.description, watches.price, watches.stock, watches.picture, brands.name AS brand_name
                                   FROM watches 
                                   INNER JOIN brands 
                                   ON watches.brand_id = brands.id");

        $watches    = $statement->fetchAll();
        return $watches;
    }

    #####################################
    ### Pretraga po modelu ili brendu ###
    #####################################

    function search_by_brand_and_model($pdo, $search_term) 
    {   
        $s = "%$search_term%";

        $sql = "SELECT w.id, w.brand_id, w.model, w.description, w.price, w.stock, w.picture, b.name as brand_name
                FROM watches AS w
                JOIN brands  AS b 
                ON w.brand_id = b.id
                WHERE w.model LIKE :search
                OR b.name LIKE :search2";
        
        $statement = $pdo->prepare($sql);
        $statement->execute([':search' => $s, 'search2' => $s]);

        $watches = $statement->fetchAll();

        return $watches;
    }

    #################################################
    ### Izlistavanje svih satova odredjenog brenda###
    #################################################

    function list_all_brand_watches($pdo, $brand_id) 
    {   

        $sql = "SELECT w.id, w.brand_id, w.model, w.description, w.price, w.stock, w.picture, b.name as brand_name
                FROM watches AS w
                JOIN brands  AS b 
                ON w.brand_id = b.id
                WHERE w.brand_id = :brand_id";
        
        $statement = $pdo->prepare($sql);
        $statement->execute([':brand_id' => $brand_id]);

        $watches = $statement->fetchAll();

        return $watches;

        dd($watches);
    }


    #################################################
    ### Dodavanje novog korisnika u bazu podataka ###
    #################################################

    function add_new_user(
        $pdo,
        $first_name, 
        $last_name,
        $email, 
        $password, 
        $city,
        $street, 
        $street_number,
        $phone_number)
        {   
            $admin = 0;

            # Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql        = "INSERT INTO users (first_name, last_name, email, password, city, street, street_number, phone_number, admin) 
                           VALUES (:first_name, :last_name, :email, :password, :city, :street, :street_number, :phone_number, :admin)";
            
            $statement  = $pdo->prepare($sql);

            $success    = $statement->execute([
                ":first_name"   => $first_name,
                ":last_name"    => $last_name,
                ":email"        => $email, 
                ":password"     => $hashed_password,
                ":city"         => $city,
                ":street"       => $street,
                ":street_number"=> $street_number,
                ":phone_number" => $phone_number,
                ":admin"        => $admin

            ]);

            # Provera da li je upis u bazu prosao bez problema
            if ($success) {
                # Ukoliko jeste redirektujemo se ka login stranici
                header('Location: login.php');
            } else {
                die('Something went wrong! Try Again');
            }
        }

    #############################################################    
    ### Provera da li korisnik postoji po unetoj email adresi ###
    #############################################################

    function user_exist($pdo, $email)
    {

        $sql        = "SELECT * FROM users WHERE email = :email";

        $statement  = $pdo->prepare($sql);

        $success    = $statement->execute([':email' => $email]);

        return $success;

    }
        
    ######################################
    ### Logovanje korisnika na vebsajt ###
    ######################################

    function log_user($pdo, $email, $password)
    {

        # Provera da li korisnik postoji
        # Ukoliko postoji
        if (user_exist($pdo, $email)) {

            # Selektujemo tog korisnika iz baze prvo
            $sql        = "SELECT * FROM users WHERE email = :email";

            $statement  = $pdo->prepare($sql);

            $statement->execute([':email' => $email]);

            $user       = $statement->fetch();

            # Proveravamo unetu lozinku
            $password_check = password_verify($password, $user['password']);

            if (!$password_check) {
                header('Location: login.php?login_error=error');
                exit;
            }

            # Korisnik postoji, pokrecemo sesiju!
            if (session_status() == PHP_SESSION_NONE) {
               
                session_start();

            }
            
            # Dodajemo ID korisnika u sesiju
            $_SESSION['id']         = $user['id'];

            # Dodajemo ime korisnika u sesiju, zbog imenovanja u navbar-u
            $_SESSION['first_name'] = $user['first_name'];

            # Dodajemo status admina. Da li je korisnik admin ili ne. 
            $_SESSION['admin']      = $user['admin'];

            # Kreiramo prazan niz za korisnika, koji predstavlja korpu.
            $_SESSION['cart']     = [];

            #Redirektujemo korsnika na pocetnu stranicu
            header('Location: index.php');
            

        } else {
            # Ukoliko ne postoji
           header('Location: login.php?login_error=error');
           exit;

        }

    }

    ####################################################  
    ### Preuzimanje sata iz baze podataka prema ID-u ###
    #####################################################

    function get_watch_by_id($pdo, $id)
    {

        $sql = "SELECT * ,brands.name AS brand_name
                                      FROM watches 
                                      INNER JOIN brands 
                                      ON watches.brand_id = brands.id
                                      WHERE watches.id = :id";
                                    
        $statement  = $pdo->prepare($sql);

        $statement->execute([':id' => $id]);

        $watch = $statement->fetch();

        return $watch;

    }

    ######################################################### 
    ### Preuzimanje korisnika iz baze podataka prema ID-u ###
    #########################################################

    function get_user_by_id($pdo, $id)
    {

        $sql = "SELECT * FROM users WHERE id = :id"; 
                                    
        $statement  = $pdo->prepare($sql);

        $statement->execute([':id' => $id]);

        $user = $statement->fetch();

        return $user;

    }