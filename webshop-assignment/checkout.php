<?php
session_start();
include_once "db.php";
include "includes/head.php";

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

//fjerner produkterne fra kurven fra sessionen
if(isset($_POST['removeProduct'])) {
    $productIDToRemove = $_POST['removeProduct'];
    // Find og fjern produktet fra kurven
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $key => $product) {
            if($product === $productIDToRemove) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}
// Hvis et produkt skal fjernes fra kurven, bliver siden automatisk genindlæst
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeProduct'])) {
    header("Location: " . $_SERVER['REQUEST_URI']); // Omdiriger til den samme side
    exit(); // Stop yderligere udførelse af PHP-kode
}

//hvis betalingsknappen bliver trykket
if (isset($_POST['betaling'])) {
    echo
    '<div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1>Hej!</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Denne del af siden er stadig under udvikling.</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Derfor kan du desværre ikke foretage dit køb endnu.</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <h5>Tusinde tak for din støtte og forståelse!</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>
                            <a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-success">
                            Tryk her, for at komme tilbage</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>';
    include "includes/footer.php";
    exit;
}

?>
    <!--overskrift-->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Din kurv</h1>
        </div>
    </div>
</div>

    <!--indhold i kurv-->
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-8">

            <?php if(isset($products) && !empty($products)) {
                foreach ($products as $product) { ?>

                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">
                            </div>
                            <div class="col-md-8">
                                <a style="color: black; text-decoration: none;" href="product.php?productID=<?php echo $product['productID'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $product['productName']; ?>
                                        </h5>
                                        <p class="card-text">
                                            <?php echo $product['productPrice']; ?>kr.
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col text-end">
                                    <form action="" method="post">
                                        <input type="hidden" name="removeProduct" value="<?php echo $product['productID']; ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo '<div class="text-center mt-5">
                        <h5>Du har ikke noget i din kurv</h5>
                        <a href="products.php" class="btn btn-primary">Tryk her, for at komme til produktoversigten</a>
                    </div>';
            } ?>
        </div>

        <!--samlet pris-->
        <div class="col mb-5">
            <?php

            $totalPrice = 0;

            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    $totalPrice += $product['productPrice'];
                }
            }

            // Den samlede pris er nu gemt i totalPrice:
            echo '
                <p>Total (inkl. moms)
                    <hr>
                    <h4 class="text-end">' . $totalPrice . " kr." .
                    '</h4>
                </p>
                
                <!--betalingsknap-->
                <div class="row text-center mt-4 mb-5">
                        <form action="" enctype="multipart/form-data" method="post">
                            <input type="submit" value="Gå til betaling" class="btn btn-success" name="betaling">
                        </form>
                    </div>
                </div>
                ';
            ?>
        </div>
    </div>

</div>

<?php
include "includes/footer.php";
