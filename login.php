<?php require_once "partials/head.php" ?>
<?php require_once "partials/navbar.php" ?>

<div class="container">

    <div class="row">

    <h3 class="text-center m-4">Login</h3>

    <div class="col-6 offset-3">

            <?php if (isset($_GET['login_error'])):  ?>
                <div class="alert alert-danger text-center" role="alert">
                
                    There is an error with login, please try again!

                </div>
            <?php endif; ?>

            <form action="login-logic.php" method="POST" >

                
                <label class="form-label" id="email"><b>Email</b></label>
                <input type="text" name="email" class="form-control mb-2" placeholder="Email" id="email">

                <label class="form-label"><b>Password</b></label>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <button type="Submit" class="btn btn-warning form-control">Login</button>

            </form>

    </div>

</div>

<?php require_once "partials/footer.php" ?>

  
