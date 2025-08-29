<?php require_once "partials/head.php" ?>
<?php 

    # Ukoliko je korisnik admin nema pristup ovoj stranici
    if(!isset($_SESSION['admin']) == 1)
    {
        header('Location: index.php');
    }

    # Ukoliko korisnik nije logovan, nema pristup ovoj stranici
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
    }

    $sum  = 0;
    $user = get_user_by_id($pdo, $_SESSION['id']);


?>
<?php require_once "partials/navbar.php" ?>

<div class="container">

    <div class="row">

        <div class="col-6 offset-3">

            <?php if (count($_SESSION['cart']) < 1): ?>

            <h3 class="text-center mt-5">Cart is empty <a href="index.php" class="text-center">Back home</a></h3>

            <?php else: ?>

                <h2 class="mt-5 mb-3 text-center">Cart (<a href="empty-cart.php">Empty Cart</a>)</h2>

                <ul class="list-group mt-5">

                    <?php foreach($_SESSION['cart'] as $item): ?>

                        <li class="list-group-item">
                            <?php $watch = get_watch_by_id($pdo, $item['watch_id']) ?> 
                            <?= $watch['brand_name'] . ' - ' .  $watch['model']?>
                            <span class="badge rounded-pill float-end bg-success"><?= $item['amount'] . ' x ' . $watch['price'] . ' = €' . ($item['amount'] * $watch['price'])?></span>
                            <?php 

                                $sum += $watch['price'];
                            
                            ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

                <br><hr><br>
                <h4 class="float-start">Summary: </h4>

                <button class="btn btn-danger float-end btn-sm">€ <?= $sum ?></button>

                <br><hr><br>

                <h5 class="float-start">Address: <?= $user['city'] .', '. $user['street'] . ' ' . $user['street_number']?> </h5>        

                <br><hr><br>

                <a href="order.php" class="btn btn-success float-end">Order</a>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php require_once "partials/footer.php" ?>

  
