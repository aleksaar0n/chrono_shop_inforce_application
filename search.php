<?php require_once "partials/head.php" ?>
<?php 
    $search_term = $_GET['search'];
    $watches = search_by_brand_and_model($pdo, $search_term);

    # Provera da li ima trazenih satova - Ukoliko nema
    if (count($watches) < 1) 
    {

        $error = "No results found!";

    }

?>
<?php require_once "partials/navbar.php" ?>

<div class="container">

    <div class="row">

        <div class="col-10 offset-1">

            <?php if (isset($_GET['success'])): ?>
                
                <div class="alert alert-success text-center mt-5" role="alert">

                   <?= $_GET['success'] ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

    <?php if (isset($error)): ?>
        <h2 class="text-center mb-3 mt-3"><?= $error ?></h2>
    <?php else: ?>
        <h2 class="text-center mb-3 mt-3">All Watches</h2>
    <?php endif;  ?>

    <div class="row">

        <div class="col-10 offset-1">

            <?php foreach($watches as $watch): ?>

                <div class="card mt-3 mb-3" style="width: 100%;">

                    <div class="row g-0">

                        <div class="col-md-4">

                            <img src="assets/<?= $watch['picture'] ?>" style="height: 200px; cover;">

                        </div>
                        <div class="col-md-8">

                            <div class="card-body">

                                <h5 class="card-title"><?= $watch['brand_name'] ?> - <?= $watch['model'] ?></h5>

                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>

                                <button class="btn btn-danger btn-sm">€<?= $watch['price'] ?></button>

                                <a href="brand-watches.php?id=<?= $watch['brand_id'] ?>" class="btn btn-warning btn-sm"><?= $watch['brand_name'] ?></a>

                                <a href="watch.php?id=<?= $watch['id'] ?>" class="btn btn-primary btn-sm">See Details</a>

                                    <!-- Ukoliko je korisnik log-ovan, ima opciju dodavanja u korpu! -->
                                    <?php if(!isset($_SESSION['id'])): ?>
                                        <p class="text-success"><small>Please, login to add to cart</small></p>
                                    <?php else: ?>
                                        
                                    <!-- Ukoliko je korisnik Administrator, ne moze dodati proizvod u korpu -->  
                                        <?php if ($_SESSION['admin'] == 0):  ?>
                                            <!-- Proveravamo da li satova ima na stanju -->
                                            <?php if ($watch['stock'] > 0): ?>
                                                <a href="add-one-to-cart.php?id=<?= $watch['id'] ?>" class="btn btn-success btn-sm">
                                                    Add to Cart 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                                                        <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/>
                                                    </svg> 
                                                </a>
                                            <?php else: ?>
                                                <button disabled class="btn btn-sm btn-default">Nema na stanju</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>
   
        </div>

    </div>

<?php require_once "partials/footer.php" ?>

  
