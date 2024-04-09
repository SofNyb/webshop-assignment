<?php

require_once "db.php";
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="products.php">Webshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="products.php">Produkter</a>
                <a class="nav-link active" aria-current="page" href="profile.php">Profil</a>
                <a class="nav-link active" aria-current="page" href="adminRegister.php">Tilføj produkter</a>
            </div>
        </div>
    </div>
</nav>