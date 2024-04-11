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
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-primary" href="product.php?productID=<?php echo $product['productID'] ?>">
                                                Læs mere
                                            </a>
                                        </div>
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
                    } ?>
                </div>
            </div>
        </div>

    <!--samlet pris-->
<div class="container mt-5">
    <div class="row">
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

    <!--betalingsknap-->
<div class="container">
    <div class="row text-center mt-4 mb-3">
        <div class="col">
            <form action="" enctype="multipart/form-data" method="post">
                <input type="submit" value="Gå til betaling" class="btn btn-success" name="betaling">
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
