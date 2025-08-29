<?php

require_once "database-connection.php";
require_once "functions.php";

### Zahtevi za upload fotografije ###
# Dozvoljenje ekstenzije (tip) fotografije
$allowed_extensions = ['png', 'jpeg', 'jpg'];
# Maksimalna dozvoljenja velicina
$max_size           = 55242880;
# Direktorijum za upload fotografija
$destination_directory = "assets/";


$picture        = $_FILES['picture'];
$brand          = $_POST['brand'];
$model          = $_POST['model'];
$description    = $_POST['description'];
$amount         = $_POST['stock'];
$price          = $_POST['price'];

# Ime dodate fotografije
$picture_name       = $picture['name'];
# Privremeno ime slike
$picture_tmp        = $picture['tmp_name'];
# Velicina fotografije
$picture_size       = $picture['size'];
# Greska prilikom dodavanja
$picture_error      = $picture['error'];
# Tip fotografije 
$picture_type       = $picture['type'];
# Ekstenzija fotografije
$picture_extension  = strtolower(explode('.', $picture_name)[1]);

# Provera ima li greske prilikom upload-a
if ($picture_error > 0)
{
    die("There was an error during upload");
}

# Provera formata unete fotografije
if (!in_array($picture_extension, $allowed_extensions))
{
    die("This file type is not allowed");
}

# Provera velicine fotografije
if ($picture_size > $max_size)
{
    die("You are not allowed to upload photo bigger than 5mb");
}   
    
$new_picture_name   = time() . "_" . $picture_name;
$destination_path = $destination_directory . $new_picture_name;
$moved = move_uploaded_file($picture_tmp, $destination_path);

# Ukoliko je sve u redu i fotografija sacuvana, upisujemo podatke u bazu.
if ($moved)
{
   
    $sql        = "INSERT INTO watches (brand_id, model, description, price, stock, picture) 
                   VALUES (:brand_id, :model, :description, :price, :stock, :picture)";
    
    $statement = $pdo->prepare($sql);

    $statement->execute([
        ':brand_id'   => $brand,     
        ':model'      => $model,
        ':description'=> $description,
        ':price'      => $price,
        ':stock'      => $amount,
        ':picture'    => $new_picture_name
    ]);

    header('Location: admin.php');

}




// echo '<pre>';
// var_dump($picture);
// echo '</pre>';