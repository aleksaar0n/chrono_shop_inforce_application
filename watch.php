<?php  

    # Provera da li je sesija vec pokrenuta
    if (session_status() == PHP_SESSION_NONE) {
               
        session_start();

    }

?>

<?php require_once "partials/head.php" ?>

<?php 

   $watch = get_watch_by_id($pdo, $_GET[ 'id']);

?>

<?php require_once "partials/navbar.php" ?>

<div class="container">

    <div class="row">

        <div class="col-8 offset-2">

            <div class="card mt-5">

                <img src="<?= 'assets/' . $watch['picture'] ?>" class="img-fluid">

                <div class="card-body">

                     <!-- Ukoliko je korisnik log-ovan, ima opciju dodavanja u korpu! -->
                                    <?php if(!isset($_SESSION['id'])): ?>
                                        <p class="text-success"><small>Please, login to add to cart</small></p>
                                    <?php else: ?>
                                        
                                    <!-- Ukoliko je korisnik Administrator, ne moze dodati proizvod u korpu -->  
                                        <?php if ($_SESSION['admin'] == 0):  ?>
                                            <!-- Proveravamo da li satova ima na stanju -->
                                            <?php if ($watch['stock'] > 0): ?>
                                                <a href="add-one-to-cart.php?id=<?= $watch['id'] ?>" class="btn btn-success btn-sm form-control mt-3 mb-3">
                                                    Add to Cart 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                                                        <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/>
                                                    </svg> 
                                                </a>
                                            <?php else: ?>
                                                <button disabled class="btn btn-sm btn-secondary form-control mb-3">Nema na stanju</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>


                    <h5 class="card-title"><?= $watch['brand_name'] . ' r- ' . $watch['model'] ?></h5>

                    <p class="card-text"><?= $watch['description'] ?></p>

                </div>
                
            </div>

        </div>

    </div>

</div>



<?php require_once "partials/footer.php" ?>

  
