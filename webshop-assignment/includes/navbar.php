<?php

/*// Start session:
session_start();*/

require_once "db.php";
require_once "login.php";

/*//hvis brugeren er logget ind, kan deres rolle hentes fra sessionen:
$userRole = isset($_SESSION['userRole']) ? $_SESSION['userRole'] : null;*/
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/products.php">Webshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/products.php">Produkter</a>

                <?php
                /*                //tjek for at se, om bruger er administrator:
                                    if($userRole == 1) {
                                        echo '<br><a class="nav-link" href="/adminRegister.php">Tilføj produkt</a>';
                                    }
                                */?>
                <a class="nav-link" href="#">Log ud</a>
            </div>
        </div>
    </div>
</nav>