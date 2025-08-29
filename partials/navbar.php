<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <a href="../index.php" class="navbar-brand">Chrono Shop</a>
        <form action="search.php" method="GET" class="d-flex">
            <input name="search" class="form-control me-2" type="search" placeholder="Search by Brand or Model" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <?php 
            if(isset($_SESSION['id'])) 
            {
                require_once('navbar-logged.php');
            } else 
            {
                require_once('navbar-login.php');
            }
        ?>
    </div>
</nav>