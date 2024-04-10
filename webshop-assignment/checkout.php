<?php
session_start();
include_once "db.php";

//udskriver produkterne tilføjet til kurv fra session
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $checkouts = $_SESSION['cart'];

    try {
        // Der skal en streng med produktID til at håndtere SQL IN-operator
        $allProducts = implode(",", $checkouts);

        $sql = "SELECT * FROM product WHERE productID IN ($allProducts)";
        $stmt = $handler->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
}




include "includes/head.php";
?>
        <div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1>Din kurv</h1>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-8">

                    <?php if(isset($products) && !empty($products)) {
                        foreach ($products as $product) { ?>

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
                                            <h5 class="card-text">
                                                <?php echo $product['productPrice']; ?>kr.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <div class="col">
                <?php

                $totalPrice = 0;

                if (isset($products) && !empty($products)) {
                    foreach ($products as $product) {
                        $totalPrice += $product['productPrice'];
                    }
                }

                // Den samlede pris er nu gemt i totalPrice:
                echo '<h5>' . "Den samlede pris for varerne i kurven er: " . '<u>' . $totalPrice . " kr." . '</u>' . '</h5>';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
