<?php
session_start();
require_once "db.php";
include "includes/head.php";

// Check om der er modtaget et produkt-id fra en form eller andet sted
if(isset($_POST['productID'])) {
    $productID = $_POST['productID'];

    // Tilføj produkt-id til kurven i sessionen
    if(!isset($_SESSION['cart'])) {
        // Hvis kurven ikke findes i sessionen endnu, opret den som et tomt array
        $_SESSION['cart'] = array();
    }

    // Tilføj produkt-id til kurven
    $_SESSION['cart'][] = $productID;
}

if(isset($_GET["productID"])) {
    $productID = $_GET["productID"];

    try {
        // henter information fra product-tabel
        $sql_select = "SELECT * FROM product WHERE productID = '$productID'";
        $stmt = $handler->prepare($sql_select);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
}

if(isset($products) && !empty($products)) {
    foreach ($products as $product) { ?>
        <div class="container mt-2">
            <div class="row">
                <div class="col">
                    <!-- Tilføj en "Gå tilbage"-knap -->
                    <a href="javascript:history.go(-1)" class="text-secondary">
                        <i class="fa-solid fa-reply fa-xl"></i>
                    </a>
                </div>
            </div>
        </div>
            <!-- overskrift -->
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h1><?php echo $product['productName']; ?> - <?php echo $product['productBrand']; ?></h1>
                </div>
            </div>
        </div>

    <div class="container mt-5 pb-5">

        <div class="card mb-3">
            <div class="row g-0">

                <div class="col-md-4">
                    <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?php echo $product['productName']; ?>
                        </h4>
                        <p class="card-text text-muted">
                            <?php echo $product['productDesc']; ?>
                        </p>

                        <h4 class="card-text my-5">
                            Pris:
                            <?php echo $product['productPrice']; ?>kr.
                        </h4>

                        <div class="mt-3">
                            <form action="product.php?productID=<?php echo $product['productID'] ?>" method="post">
                                <input type="number" name="productAmount" value="1" min="1" placeholder="Antal" required>

                                <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">

                                <input type="submit" value="Tilføj til kurv" class="btn btn-primary">

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


<?php }
}else {
    echo "Fejl";
}

include "includes/footer.php";
