<?php
session_start();
require_once "db.php";
include "includes/head.php";

$sql = 'SELECT productID, productName, productPicture, productPrice FROM product';

try {
    // Forbered og udfør forespørgslen
    $stmt = $handler->query($sql);

    // Hent alle rækker som et associativt array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Håndtering af databasefejl
    echo "Error: " . $e->getMessage();
}
/*<a href="product.php?prodID=<?php /*echo $product['productID'] ?>">*/
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
                        <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">

                        <div class="card-text"></div>
                            <h5 class="card-title">
                                <?php echo $product['productName']; ?>
                            </h5>
                            <p class="card-subtitle text-muted">
                                <?php echo $product['productPrice']; ?>kr.
                            </p>
                            <div class="mt-3">
                                <a class="btn btn-primary" href="product.php?productID=<?php echo $product['productID'] ?>">
                                    Læs mere
                                </a>
                                <a class="btn btn-secondary" href="#">
                                    Tilføj til kurv
                                </a>
                            </div>
                    </div>

                </div>

        </div>

        <?php endforeach; ?>

    </div>
</div>


<?php

include "includes/footer.php";