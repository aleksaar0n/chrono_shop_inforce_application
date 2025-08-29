<?php require_once "partials/head.php" ?>
<?php 

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    #########################################
    ### Provera unetih parametara u formu ###
    #########################################

    # Provera da li je uneto ime, bitno je da nije prazno polje
    if (!isset($_POST['first_name']) || empty($_POST['first_name']))
    {
        $errors["first_name_error"] = 'Please, enter a valid first name!';
    }
    
    # Provera da li je uneto prezime, bitno je da nije prazno polje
    if (!isset($_POST['last_name']) || empty($_POST['last_name']))
    {
        $errors["last_name_error"] = 'Please, enter a valid last name!';
    }

    # Provera da li je unet email i provera formata email adrese
    if (!isset($_POST['email']) || empty($_POST['email']))
    {
        $errors["email_error"] = 'Please enter an email!';

       
    } else {

         # Provera formata email adrese
        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) 
        {
            $errors["email_error"] = 'Please enter a valid email!';
        }

    }

    # Provera da li je password unesen i provera formata
    if (!isset($_POST['password']) || empty($_POST['password']))
    {
        $errors["password_error"] = 'Please, enter an password!';

    } else {

         # Provera da li je password manji od 7 karaktera
        if (strlen($_POST['password']) < 7)
        {
            $errors['password_error'] = 'Password must be minimum 7 characters long!';
        }

    }

    # Provera da li je ulica unesena 
    if (!isset($_POST['city']) || empty($_POST['city']))
    {
        $errors["city_error"] = 'Please, enter a street address!';

    }

    # Provera da li je ulica unesena 
    if (!isset($_POST['street']) || empty($_POST['street']))
    {
        $errors["street_error"] = 'Please, enter a street address!';

    }

    # Provera da li je broj ulice unesen i da li je broj 
    if (!isset($_POST['street_number']) || empty($_POST['street_number']))
    {
        $errors["street_number_error"] = 'Please, enter a street address!';

    } 

     # Provera da li je broj ulice unesen i da li je broj 
    if (!isset($_POST['phone_number']) || empty($_POST['phone_number']))
    {
        $errors["phone_number_error"] = 'Please, add a phone number!';

    } 

    # Implode kreira string od array-a, ukoliko je array prazan, znaci da nema gresaka
    if (!implode("", $errors))
    {   
        $first_name     = $_POST['first_name'];
        $last_name      = $_POST['last_name'];
        $email          = $_POST['email'];
        $password       = $_POST['password'];
        $city           = $_POST['city'];
        $street         = $_POST['street'];
        $street_number  = $_POST['street_number'];
        $phone_number   = $_POST['phone_number'];

        add_new_user(
            $pdo,
            $first_name,
            $last_name,
            $email, 
            $password, 
            $city,
            $street, 
            $street_number,
            $phone_number
        );

    } else {

        # Kreiramo query string od niz-a u kojem su greske, pa ih prosledjujemo na register.php da prosledimo greske
        // $query = 'register.php?' . http_build_query($errors);
        // header('Location: ' . $query);
    }

}

?>
<?php require_once "partials/navbar.php" ?>

<div class="container">

    <div class="row">

    <h3 class="text-center m-4">Register</h3>

    <div class="col-6 offset-3">

            <form action="register.php" method="POST" >

                <label class="form-label"><b>First Name</b></label>
                <br><small class="text-danger"><?= $errors['first_name_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['first_name'] ?? "")?>" type="text" name="first_name" class="form-control mb-2" placeholder="First Name">

                <label class="form-label"><b>Last Name</b></label>
                <br><small class="text-danger"><?= $errors['last_name_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['last_name'] ?? "")?>" type="text" name="last_name" class="form-control mb-2" placeholder="Last Name">

                <label class="form-label"><b>Email</b></label>
                <br><small class="text-danger"><?= $errors['email_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['email'] ?? "")?>" type="text" name="email" class="form-control mb-2" placeholder="Email">

                <label class="form-label"><b>Password</b></label>
                <br><small class="text-danger"><?= $errors['password_error'] ?? "" ?></small>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <label class="form-label"><b>Repeat Password</b></label>
                <input type="password" name="repeat_password" class="form-control mb-2" placeholder="Repeat Password">

                <label class="form-label"><b>City</b></label>
                <br><small class="text-danger"><?= $errors['city_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['city'] ?? "")?>" type="text" name="city" class="form-control mb-2" placeholder="City">

                <label class="form-label"><b>Street</b></label>
                <br><small class="text-danger"><?= $errors['street_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['street'] ?? "")?>" type="text" name="street" class="form-control mb-2" placeholder="Street">

                <label class="form-label"><b>Street Number</b></label>
                <br><small class="text-danger"><?= $errors['street_number_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['street_number'] ?? "")?>" type="text" name="street_number" class="form-control mb-2" placeholder="Street Number">

                <label class="form-label"><b>Phone Number</b></label>
                <br><small class="text-danger"><?= $errors['phone_number_error'] ?? "" ?></small>
                <input value="<?= htmlspecialchars($_POST['phone_number'] ?? "")?>" type="text" name="phone_number" class="form-control mb-2" placeholder="Phone Number">

                <button type="Submit" class="btn btn-success form-control">Register</button>

            </form>

    </div>

</div>

<?php require_once "partials/footer.php" ?>

  
