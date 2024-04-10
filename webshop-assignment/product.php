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

    // Redirect brugeren tilbage til den forrige side eller en anden side efter tilføjelsen
    /*header("Location: previous_page.php"); // Erstat "previous_page.php" med den ønskede destinations-side
    exit(); // Sørg for at afslutte scriptet efter omdirigering*/
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
        /*
            if (!empty($_POST)) {
                $checkoutAmount = $_POST["productAmount"];
                /* $productID = $_POST["productID"];
                *$productName = $_POST["productName"];
                 $productPicture = $_POST["productPicture"];
                 $productPrice = $_POST["productPrice"];

        // henter information fra produktet fra £product-array
        $checkoutName = $products[0]["productName"];
        $checkoutPicture = $products[0]["productPicture"];
        $checkoutPrice = $products[0]["productPrice"];

        $sql_insert = "INSERT INTO `checkout` (`productID`,`checkoutName`, `checkoutPicture`, `checkoutPrice`, `checkoutAmount`)
                        VALUES ('$productID', '$checkoutName', '$checkoutPicture', '$checkoutPrice', '$checkoutAmount')";

        try {
            $stmt = $handler->prepare($sql_insert);
            /*$stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
            $stmt->bindParam(':productPicture', $productPicture, PDO::PARAM_STR);
            $stmt->bindParam(':productPrice', $productPrice, PDO::PARAM_INT);
            $stmt->bindParam(':productAmount', $productAmount, PDO::PARAM_INT);
            $stmt->execute([$productID, $checkoutName, $checkoutPicture, $checkoutPrice, $checkoutAmount]);
        } catch(PDOException $e) {
            echo "Fejl: " . $e->getMessage();
        }

    }
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
    exit;*/
}

if(isset($products) && !empty($products)) {
    foreach ($products as $product) { ?>

        <div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1><?php echo $product['productName']; ?> - <?php echo $product['productBrand']; ?></h1>
                </div>
            </div>
        </div>

    <div class="container mt-5">

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
                        <p class="card-text">
                            <strong class="text-muted">Farve:</strong>
                            <?php echo $product['productColor']; ?>
                        </p>

                        <h5 class="card-text">
                            <?php echo $product['productPrice']; ?>kr.
                        </h5>

                        <div class="mt-3">
                            <form action="product.php?productID=<?php echo $product['productID'] ?>" method="post">
                                <input type="number" name="productAmount" value="1" min="1" placeholder="Antal" required>

                                <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">

                                <!--<input type="hidden" name="productName" value="<?php /*echo $product['productName']; */?>">
                                <input type="hidden" name="productPicture" value="<?php /*echo $product['productPicture']; */?>">
                                <input type="hidden" name="productPrice" value="<?php /*echo $product['productPrice']; */?>">-->

                                <input type="submit" value="Tilføj til kurv" class="btn btn-primary">

                                <!--<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Produkt tilføjet til kurv</h1>
                                                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn text-light btn-success" data-bs-dismiss="modal">
                                                    Fortsæt
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>-->
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

// Håndtering af indsættelse i checkout-tabellen
/*if (!empty($_POST['productID']) && !empty($_POST['productAmount'])) {
    $productID = $_POST['productID'];
    $productAmount = $_POST['productAmount'];

    try {
        $sql_insert = "INSERT INTO `checkout` (`productID`, `checkoutName`, `checkoutPicture`, `checkoutPrice`, `checkoutAmount`)
                        SELECT productID, productName, productPicture, productPrice, :productAmount 
                        FROM product WHERE productID = :productID";
        $stmt = $handler->prepare($sql_insert);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':productAmount', $productAmount, PDO::PARAM_INT);
        $stmt->execute();

    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
}*/

include "includes/footer.php";
