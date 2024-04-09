<?php
session_start();
require_once "db.php";
include "includes/head.php";

$sql = 'SELECT * FROM product';

/*$products = $_GET['SELECT * FROM product'];*/

try {
    // Forbered og udfør forespørgslen
    $stmt = $handler->query($sql);

    // Hent alle rækker som et associativt array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Håndtering af databasefejl
    echo "Error: " . $e->getMessage();
}

?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Alle produkter</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
            <?php foreach ($products as $product) : ?>
        <div class="col-sm-6 col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                        <!--<img src="<?php /*echo $product['productPicture']; */?>" class="card-img-top" alt="<?php /*echo $product['productName']; */?>">-->
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">
                                <?php echo $product['productName']; ?>
                            </h5>
                        </div>
                    </div>
                    <p> - <?php echo $product['productType']; ?></p>
                    <p class="card-text">
                        <?php echo $product['productBrand']; ?>
                    </p>
                    <p class="card-text">
                        <?php echo $product['productColor']; ?>
                    </p>
                    <p class="card-text">
                        <?php echo $product['productType']; ?>
                    </p>
                </div>
            </div>

        </div>
            <?php endforeach; ?>
    </div>
</div>


<?php

include "includes/footer.php";