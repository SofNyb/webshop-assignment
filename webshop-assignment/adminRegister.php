<?php
session_start();
require_once "db.php";
include "includes/head.php";
/*
 * The following Condition checks whether a client requested the registerCustomer.php through
 * the POST method with the userName, userEmail and userPW
 *
 * userName, userEmail and userPW - You can also see these in the HTML Form (index.html) -
 * These are keys to access the actual data provided by a user.
 */

$productMessage = "";

if (isset($_POST['productName']) && isset($_POST['productColor']) && isset($_POST['productBrand']) && isset($_POST['productPrice'])) :

    # Assigning user data to variables for easy access later.
    $productName = $_POST['productName'];
    $productColor = $_POST['productColor'];
    $productBrand = $_POST['productBrand'];
    $productPrice = $_POST['productPrice'];
    $productType = $_POST['productType'];
    $productDesc = $_POST['productDesc'];

    $sql = "INSERT INTO `product` (`productName`, `productPrice`, `productColor`, `productBrand`, `productType`, `productDesc`) VALUES ('$productName', '$productPrice', '$productColor', '$productBrand', '$productType', '$productDesc')";

    $stmt = $handler->prepare($sql);
    $stmt->execute([$productName, $productPrice, $productColor, $productBrand, $productType, $productDesc]);

    if($stmt->rowCount() > 0){
        $productMessage = 'Produktet er nu tilføjet';
    } else {

        try {

            # Tjekker om forespørgslen blev udført korrekt
            if ($stmt->rowCount() > 0) {
                echo 'okay';
                /*$productMessage = 'Produktet er nu tilføjet';*/
            } else {
                echo 'ikke okay';
                /*$productMessage = "Der skete en fejl." . '<br>' . "Prøv igen.";*/
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
        }
        exit;
    }
endif;
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Tilføj produkter</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card p-3">
        <form action="adminRegister.php" method="post">

            <?php if (!empty($productMessage)) : ?>
                <div class="alert alert-info">
                    <?php echo $productMessage; ?>
                </div>
            <?php endif; ?>

            <div class="row mb-2">
                <label for="productName" class="col-form-label">Produktnavn</label>
                <div>
                    <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="productPrice" class="col-form-label">Produktets pris</label>
                <div>
                    <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productColor" class="col-form-label">Produktets farve</label>
                <div>
                    <input type="text" class="form-control" id="productColor" name="productColor" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productBrand" class="col-form-label">Tøjmærke</label>
                <div>
                    <input type="text" class="form-control" id="productBrand" name="productBrand" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productType" class="col-form-label">Produkttype</label>
                <div>
                    <input type="text" class="form-control" id="productType" name="productType" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productDesc" class="col-form-label">Produktbeskrivelse</label>
                <div>
                    <textarea rows="3" type="text" class="form-control" id="productDesc" name="productDesc" required></textarea>
                </div>
            </div>

            <div class="row text-center">
                <div class="col mt-2 mb-4">
                    <input type="submit" value="Opret produktet" class="btn btn-primary">
                </div>
            </div>

            <hr>

            <div class="row text-center mt-4 mb-3">
                <div class="col">
                    <a class="btn btn-success" href="products.php">Se produkterne</a>
                </div>
            </div>

        </form>

    </div>

<?php
include "includes/footer.php";
?>