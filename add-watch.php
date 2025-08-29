<?php 

require_once "partials/head.php";
require_once "partials/navbar.php"; 

# Preuzimanje brendova iz baze podataka kako bismo mogli ga mogli dodati prilikom kreiranja novog sata
$sql        = "SELECT * FROM brands";
$statement  = $pdo->query($sql);
$brands     = $statement->fetchAll();

?>


<div class="container">

    <h3 class="text-center m-4">Add New Watch</h3>

    <div class="row">

        <div class="col-8 offset-2">

            <form action="add-watch-logic.php" method="POST" enctype="multipart/form-data">

                <label class="form-label"><b>Brand</b></label>
                <select name="brand" class="form-select mb-2">
                    
                    <!-- Generisanje svih brendova kroz PHP petlju -->
                    <?php foreach($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                    <?php endforeach; ?>

                </select>

                <label class="form-label"><b>Model</b></label>
                <input type="text" name="model" class="form-control mb-2" placeholder="Add Model">

                <label class="form-label"><b>Description</b></label>
                <textarea name="description" class="form-control mb-2" placeholder="Add Description"></textarea>

                <label class="form-label"><b>Amount</b></label>
                <input type="number" name="stock" class="form-control mb-2" placeholder="Add Amount">

                <label class="form-label"><b>Price</b></label>
                <input type="number" name="price" class="form-control mb-2" placeholder="Add Price">

                <label class="form-label"><b>Picture</b></label>
                <input type="file" name="picture" class="form-control mb-4">

                <button type="Submit" class="btn btn-warning form-control">Add</button>

            </form>

        </div>

    </div>

</div>

<?php require_once "partials/footer.php" ?>