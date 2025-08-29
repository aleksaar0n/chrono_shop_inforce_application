<?php 

    # Provera da li je sesija vec pokrenuta
    if (session_status() == PHP_SESSION_NONE) {
               
        session_start();

    }

    # Ukoliko user nije admin, zabraniti pristup!
    if ($_SESSION['admin'] == 0)
    {

        header('Location: index.php');

    }

?>
<?php require_once "partials/head.php" ?>
<?php 
    $watches = fetch_all_watches_and_brands($pdo); 
    # Preuzimanje brendova iz baze podataka kako bismo mogli ga mogli dodati prilikom kreiranja novog sata
    $sql        = "SELECT * FROM brands";
    $statement  = $pdo->query($sql);
    $brands     = $statement->fetchAll();

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

    <div class="row">

        <div class="col-6 mt-5">

            <h3 class="text-center mb-5">Products List</h3>

            <ul class="list-group">

                <?php foreach($watches as $watch): ?>

                    <li class="list-group-item">
                        <b><?= $watch['brand_name']; ?></b> - 
                        <mark><?= $watch['model']; ?></mark> |
                        
                        <span class="badge <?= ($watch['stock'] < 1) ? "bg-danger" : "bg-primary" ?> rounded-pill"><?= $watch['stock']; ?></span>
                        <button class="btn btn-warning btn-sm float-end">Update</button>
                        <a href="delete-watch.php?id=<?= $watch['id'] ?>" class="btn btn-danger btn-sm float-end ml-s2">Delete</a>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>
        <div class="col-1">

        </div>

        <div class="col-5">

            <a class="btn btn-info form-control mt-5 mb-3" href="#">See All Orders</a>

            <hr>

            <h3 class="text-center mb-5">Add New Watch</h3>

                    <form action="add-watch-logic.php" method="POST" enctype="multipart/form-data">

                <label class="form-label"><b>Brand</b></label>
                <select name="brand" class="form-select mb-2">
                    
                    <!-- Generisanje svih brendova kroz PHP petlju -->
                    <?php foreach($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                    <?php endforeach; ?>

                </select>

                <label class="form-label"><b>Model</b></label>
                <input requred type="text" name="model" class="form-control mb-2" placeholder="Add Model">

                <label class="form-label"><b>Description</b></label>
                <textarea required name="description" class="form-control mb-2" placeholder="Add Description"></textarea>

                <label class="form-label"><b>Amount</b></label>
                <input required type="number" name="stock" class="form-control mb-2" placeholder="Add Amount">

                <label class="form-label"><b>Price</b></label>
                <input required type="number" name="price" class="form-control mb-2" placeholder="Add Price">

                <label class="form-label"><b>Picture</b></label>
                <input required type="file" name="picture" class="form-control mb-4">

                <button type="Submit" class="btn btn-warning form-control">Add</button>

            </form>

        </div>

    </div>

</div>

<?php require_once "partials/footer.php" ?>

  
